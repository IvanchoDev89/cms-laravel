@extends('layouts.app')

@section('title', 'PayPal Payment - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.419c.12-.548.638-.919 1.2-.919h7.87c2.556 0 4.359 1.055 5.485 2.586.893 1.212 1.323 2.75 1.323 4.387 0 1.637-.43 3.175-1.323 4.387-1.126 1.531-2.929 2.586-5.485 2.586H8.534l-.632 2.895a.641.641 0 0 1-.626.498z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">PayPal Payment</h1>
            <p class="text-gray-600 dark:text-gray-400">Complete your subscription payment securely</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">Amount:</span>
                <span class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Currency:</span>
                <span class="text-gray-900 dark:text-white">{{ $payment->currency }}</span>
            </div>
        </div>

        <!-- PayPal Button Container -->
        <div id="paypal-button-container" class="mb-6">
            <!-- PayPal SDK will render buttons here -->
        </div>

        <!-- Mock PayPal Button for Development -->
        <div class="space-y-3">
            <button onclick="processMockPayment()" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.419c.12-.548.638-.919 1.2-.919h7.87c2.556 0 4.359 1.055 5.485 2.586.893 1.212 1.323 2.75 1.323 4.387 0 1.637-.43 3.175-1.323 4.387-1.126 1.531-2.929 2.586-5.485 2.586H8.534l-.632 2.895a.641.641 0 0 1-.626.498z"/>
                </svg>
                Pay with PayPal
            </button>
            
            <a href="{{ route('payments.cancel', ['payment_id' => $payment->id]) }}" 
               class="block w-full px-6 py-3 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-center font-medium">
                Cancel Payment
            </a>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-medium mb-1">Secure Payment</p>
                    <p>Your payment information is encrypted and secure. We never store your payment details.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency={{ $payment->currency }}"></script>
<script>
// Mock PayPal implementation for development
function processMockPayment() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
    
    // Simulate payment processing
    setTimeout(() => {
        window.location.href = '{{ route("payments.success", ["payment_id" => $payment->id, "transaction_id" => "PAYPAL_" . uniqid()]) }}';
    }, 2000);
}

// Real PayPal implementation (uncomment when you have PayPal credentials)
/*
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '{{ $payment->amount }}',
                    currency_code: '{{ $payment->currency }}'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            window.location.href = '{{ route("payments.success", ["payment_id" => $payment->id, "transaction_id" => ""]) }}' + details.id;
        });
    },
    onError: function(err) {
        alert('Payment failed. Please try again.');
    }
}).render('#paypal-button-container');
*/
</script>
@endsection
