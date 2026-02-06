<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct(private WalletService $walletService)
    {
    }

    public function index()
    {
        $wallet = $this->walletService->getUserWallet(Auth::user());
        $transactions = $this->walletService->getTransactionHistory($wallet);
        
        return view('wallet.index', compact('wallet', 'transactions'));
    }

    public function show(Wallet $wallet)
    {
        if ($wallet->owner_id !== Auth::id() || $wallet->owner_type !== User::class) {
            abort(403);
        }

        $transactions = $wallet->transactions()
                              ->orderBy('created_at', 'desc')
                              ->paginate(20);

        return view('wallet.show', compact('wallet', 'transactions'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $this->walletService->getWalletBalance($this->walletService->getUserWallet(Auth::user())),
            'description' => 'required|string|max:255',
        ]);

        $wallet = $this->walletService->getUserWallet(Auth::user());

        try {
            $transaction = $this->walletService->withdrawFromWallet(
                $wallet,
                $request->amount,
                $request->description
            );

            return back()->with('success', 'Withdrawal processed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Withdrawal failed: ' . $e->getMessage());
        }
    }

    public function adminDashboard()
    {
        $this->authorize('view_admin_dashboard');

        $adminWallet = $this->walletService->getAdminWallet();
        $commissionStats = $this->walletService->getCommissionStats(
            now()->subMonth(),
            now()
        );

        $recentCommissions = Transaction::where('wallet_id', $adminWallet->id)
                                       ->commissions()
                                       ->orderBy('created_at', 'desc')
                                       ->limit(10)
                                       ->get();

        return view('wallet.admin-dashboard', compact(
            'adminWallet',
            'commissionStats',
            'recentCommissions'
        ));
    }

    public function commissionSettings()
    {
        $this->authorize('manage_commissions');

        $settings = \App\Models\CommissionSetting::active()->get();

        return view('wallet.commission-settings', compact('settings'));
    }

    public function updateCommissionSettings(Request $request)
    {
        $this->authorize('manage_commissions');

        $request->validate([
            'subscription_commission' => 'required|numeric|min:0|max:100',
            'content_purchase_commission' => 'required|numeric|min:0|max:100',
        ]);

        // Update subscription commission
        $subscriptionCommission = \App\Models\CommissionSetting::getActiveByName('subscription_commission');
        if ($subscriptionCommission) {
            $subscriptionCommission->update(['rate' => $request->subscription_commission]);
        }

        // Update content purchase commission
        $contentCommission = \App\Models\CommissionSetting::getActiveByName('content_purchase_commission');
        if ($contentCommission) {
            $contentCommission->update(['rate' => $request->content_purchase_commission]);
        }

        return back()->with('success', 'Commission settings updated successfully.');
    }

    public function earningsReport(Request $request)
    {
        $wallet = $this->walletService->getUserWallet(Auth::user());
        
        $from = $request->get('from') ? new \DateTime($request->get('from')) : now()->subMonth();
        $to = $request->get('to') ? new \DateTime($request->get('to')) : now();

        $transactions = $wallet->transactions()
                              ->credits()
                              ->whereBetween('processed_at', [$from, $to])
                              ->orderBy('processed_at', 'desc')
                              ->get();

        $totalEarnings = $transactions->sum('amount');
        $totalCommissions = $transactions->sum('commission_amount');
        $netEarnings = $totalEarnings - $totalCommissions;

        return view('wallet.earnings-report', compact(
            'transactions',
            'totalEarnings',
            'totalCommissions',
            'netEarnings',
            'from',
            'to'
        ));
    }
}
