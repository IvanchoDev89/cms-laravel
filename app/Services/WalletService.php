<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\CommissionSetting;
use Exception;

class WalletService
{
    public function getUserWallet(User $user): Wallet
    {
        return Wallet::getOrCreateForOwner($user);
    }

    public function getAdminWallet(): Wallet
    {
        // Create a virtual admin user or use a dedicated admin wallet
        $admin = User::where('email', 'admin@system.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'System Admin',
                'email' => 'admin@system.com',
                'password' => bcrypt('system_admin_password'),
            ]);
        }
        
        return Wallet::getOrCreateForOwner($admin);
    }

    public function processPayment(Payment $payment): void
    {
        if ($payment->status !== 'completed') {
            return;
        }

        $userWallet = $this->getUserWallet($payment->user);
        $adminWallet = $this->getAdminWallet();

        // Calculate commission
        $commissionAmount = $this->calculateCommission($payment);

        // Net amount for user
        $netAmount = $payment->amount - $commissionAmount;

        // Credit user wallet
        $userTransaction = $userWallet->credit(
            $netAmount,
            "Payment received for {$payment->type}",
            [
                'payment_id' => $payment->id,
                'original_amount' => $payment->amount,
                'commission_deducted' => $commissionAmount,
            ]
        );

        // Credit admin wallet with commission
        if ($commissionAmount > 0) {
            $adminTransaction = $adminWallet->credit(
                $commissionAmount,
                "Commission from user payment",
                [
                    'payment_id' => $payment->id,
                    'user_id' => $payment->user_id,
                    'commission_rate' => $this->getCommissionRate($payment),
                ]
            );

            // Create commission transaction record
            Transaction::create([
                'wallet_id' => $adminWallet->id,
                'type' => 'commission',
                'amount' => $commissionAmount,
                'description' => "Commission from {$payment->user->name}'s payment",
                'reference_type' => 'payment',
                'reference_id' => $payment->id,
                'commission_rate' => $this->getCommissionRate($payment),
                'commission_amount' => $commissionAmount,
                'status' => 'completed',
                'processed_at' => now(),
                'metadata' => [
                    'user_transaction_id' => $userTransaction->id,
                    'original_payment_amount' => $payment->amount,
                ],
            ]);
        }

        // Update payment with transaction references
        $payment->update([
            'metadata' => array_merge($payment->metadata ?? [], [
                'user_wallet_transaction_id' => $userTransaction->id,
                'admin_commission' => $commissionAmount,
            ]),
        ]);
    }

    public function calculateCommission(Payment $payment): float
    {
        $commissionSetting = $this->getApplicableCommissionSetting($payment);
        
        if (!$commissionSetting) {
            return 0;
        }

        $plan = $payment->subscription?->plan;
        
        return $commissionSetting->calculateCommission($payment->amount, $plan);
    }

    public function getApplicableCommissionSetting(Payment $payment): ?CommissionSetting
    {
        $settings = CommissionSetting::active()->get();

        foreach ($settings as $setting) {
            if ($this->isSettingApplicable($setting, $payment)) {
                return $setting;
            }
        }

        return null;
    }

    private function isSettingApplicable(CommissionSetting $setting, Payment $payment): bool
    {
        return match($setting->applies_to) {
            'all_users' => true,
            'specific_plans' => $this->paymentMatchesPlan($setting, $payment),
            'content_creators' => $this->userIsContentCreator($payment->user),
            default => false,
        };
    }

    private function paymentMatchesPlan(CommissionSetting $setting, Payment $payment): bool
    {
        if (!$setting->applicable_plans) {
            return false;
        }

        $plan = $payment->subscription?->plan;
        
        return $plan && in_array($plan->id, $setting->applicable_plans);
    }

    private function userIsContentCreator(User $user): bool
    {
        // Check if user has content creator subscription or role
        $subscription = $user->subscriptions()->active()->first();
        
        return $subscription && $subscription->plan->can_create_private_content;
    }

    private function getCommissionRate(Payment $payment): ?float
    {
        $setting = $this->getApplicableCommissionSetting($payment);
        
        return $setting?->rate;
    }

    public function withdrawFromWallet(Wallet $wallet, float $amount, string $description): Transaction
    {
        return $wallet->debit($amount, $description);
    }

    public function getWalletBalance(Wallet $wallet): float
    {
        return $wallet->balance;
    }

    public function getTotalEarnings(Wallet $wallet): float
    {
        return $wallet->total_earned;
    }

    public function getTotalWithdrawn(Wallet $wallet): float
    {
        return $wallet->total_withdrawn;
    }

    public function getTransactionHistory(Wallet $wallet, int $limit = 50)
    {
        return $wallet->transactions()
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }

    public function getCommissionStats(\DateTime $from, \DateTime $to): array
    {
        $adminWallet = $this->getAdminWallet();
        
        $commissions = $adminWallet->transactions()
                                   ->commissions()
                                   ->whereBetween('processed_at', [$from, $to])
                                   ->get();

        return [
            'total_commissions' => $commissions->sum('amount'),
            'count' => $commissions->count(),
            'average_commission' => $commissions->avg('amount'),
            'by_month' => $commissions->groupBy(function ($transaction) {
                return $transaction->processed_at->format('Y-m');
            })->map(function ($monthCommissions) {
                return $monthCommissions->sum('amount');
            }),
        ];
    }
}
