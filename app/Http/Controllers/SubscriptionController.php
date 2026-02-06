<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        $userSubscription = Auth::user()?->subscriptions()->active()->first();

        return view('subscriptions.index', compact('plans', 'userSubscription'));
    }

    public function show(SubscriptionPlan $plan)
    {
        $userSubscription = Auth::user()?->subscriptions()->active()->first();

        return view('subscriptions.show', compact('plan', 'userSubscription'));
    }

    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();

        // Check if user already has an active subscription
        if ($user->subscriptions()->active()->exists()) {
            return back()->with('error', 'You already have an active subscription.');
        }

        // Create subscription record
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
            'amount_paid' => $plan->price,
            'currency' => $plan->currency,
            'payment_method' => $request->payment_method,
            'transaction_id' => 'SUB-'.Str::random(10),
            'starts_at' => now(),
            'ends_at' => $plan->billing_cycle === 'lifetime' ? null : now()->addMonth(),
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'type' => 'subscription',
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'transaction_id' => 'PAY-'.Str::random(10),
        ]);

        // Redirect to appropriate payment gateway
        return match ($request->payment_method) {
            'paypal' => $this->redirectToPayPal($payment),
            'bitcoin' => $this->redirectToBitcoin($payment),
            default => back()->with('error', 'Invalid payment method selected.'),
        };
    }

    public function cancel(Subscription $subscription)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Subscription cancelled successfully.');
    }

    private function redirectToPayPal(Payment $payment)
    {
        // PayPal integration logic here
        // For now, return a mock response
        return redirect()->route('payments.process', [
            'payment' => $payment->id,
            'gateway' => 'paypal',
        ]);
    }

    private function redirectToBitcoin(Payment $payment)
    {
        // Bitcoin integration logic here
        // For now, return a mock response
        return redirect()->route('payments.process', [
            'payment' => $payment->id,
            'gateway' => 'bitcoin',
        ]);
    }
}
