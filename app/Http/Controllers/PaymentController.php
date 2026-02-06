<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function process(Request $request, Payment $payment, string $gateway)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return match ($gateway) {
            'paypal' => $this->processPayPal($payment),
            'bitcoin' => $this->processBitcoin($payment),
            default => back()->with('error', 'Invalid payment gateway.'),
        };
    }

    public function success(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $payment = Payment::findOrFail($paymentId);

        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        // Update payment status
        $payment->update([
            'status' => 'completed',
            'processed_at' => now(),
            'gateway_transaction_id' => $request->get('transaction_id'),
        ]);

        // Activate subscription
        if ($payment->subscription) {
            $payment->subscription->update([
                'status' => 'active',
            ]);
        }

        // Process wallet transactions
        app(\App\Services\WalletService::class)->processPayment($payment);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Payment completed successfully!');
    }

    public function cancel(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $payment = Payment::findOrFail($paymentId);

        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->update(['status' => 'failed']);

        return redirect()->route('subscriptions.index')
            ->with('error', 'Payment was cancelled.');
    }

    private function processPayPal(Payment $payment)
    {
        // Mock PayPal payment processing
        // In real implementation, you would integrate PayPal SDK

        return view('payments.paypal', compact('payment'));
    }

    private function processBitcoin(Payment $payment)
    {
        // Mock Bitcoin payment processing
        // In real implementation, you would integrate Bitcoin payment processor

        $bitcoinAddress = 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh'; // Mock address
        $amount = $payment->amount;

        return view('payments.bitcoin', compact('payment', 'bitcoinAddress', 'amount'));
    }

    public function webhook(Request $request, string $gateway)
    {
        // Handle webhooks from payment gateways
        // This would verify the webhook signature and update payment status

        return response()->json(['status' => 'received']);
    }
}
