@extends('layouts.app')

@section('title', 'Bitcoin Payment - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full mb-4">
                <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.577 12.309l.894-4.024c1.329.295 2.144.295 2.144.295 1.329 0 1.933-.594 1.933-1.485 0-1.189-1.034-1.485-2.66-1.485H12.48l-.894 4.024h-1.034l.894-4.024h-1.034l.894-4.024h1.034l-.894 4.024h1.034l.894-4.024h1.034l-.894 4.024h1.034l-.894 4.024h-1.034l-.894 4.024h-1.034l.894-4.024h-1.034zm-1.034 4.024l.894-4.024h1.034l-.894 4.024h-1.034z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Bitcoin Payment</h1>
            <p class="text-gray-600 dark:text-gray-400">Complete your subscription with cryptocurrency</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">Amount:</span>
                <span class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($amount, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">BTC Equivalent:</span>
                <span class="text-lg font-mono text-gray-900 dark:text-white" id="btc-amount">0.00000000</span>
            </div>
        </div>

        <!-- QR Code -->
        <div class="text-center mb-6">
            <div class="inline-block p-4 bg-white rounded-lg border-2 border-gray-200">
                <div id="qrcode" class="w-48 h-48 bg-gray-100 flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm12-2h2v2h-2v-2zm0 4h2v2h-2v-2zm-2-4h2v2h-2v-2zm0 4h2v2h-2v-2zm-2-4h2v2h-2v-2zm0 4h2v2h-2v-2zm-2-4h2v2h-2v-2zm0 4h2v2h-2v-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Scan QR code or copy address below</p>
        </div>

        <!-- Bitcoin Address -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bitcoin Address</label>
            <div class="flex">
                <input type="text" value="{{ $bitcoinAddress }}" readonly 
                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm">
                <button onclick="copyAddress()" 
                        class="px-3 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Payment Status -->
        <div id="payment-status" class="mb-6">
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="animate-spin h-5 w-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Waiting for Payment</p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400">Send the exact amount to complete payment</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button onclick="checkPayment()" class="w-full px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium">
                Check Payment Status
            </button>
            
            <a href="{{ route('payments.cancel', ['payment_id' => $payment->id]) }}" 
               class="block w-full px-6 py-3 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-center font-medium">
                Cancel Payment
            </a>
        </div>

        <!-- Instructions -->
        <div class="mt-6 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-orange-800 dark:text-orange-200">
                    <p class="font-medium mb-1">Payment Instructions</p>
                    <ul class="text-xs space-y-1">
                        <li>• Send the exact BTC amount to the address above</li>
                        <li>• Payment confirmation may take 10-30 minutes</li>
                        <li>• Keep your transaction hash for reference</li>
                        <li>• Contact support if payment is not confirmed within 1 hour</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mock Bitcoin price (in production, fetch from real API)
const btcPrice = 45000; // $45,000 per BTC
const usdAmount = {{ $amount }};
const btcAmount = (usdAmount / btcPrice).toFixed(8);

document.getElementById('btc-amount').textContent = btcAmount;

function copyAddress() {
    const address = '{{ $bitcoinAddress }}';
    navigator.clipboard.writeText(address).then(() => {
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    });
}

function checkPayment() {
    const statusDiv = document.getElementById('payment-status');
    const button = event.target;
    
    button.disabled = true;
    button.textContent = 'Checking...';
    
    // Simulate payment checking
    setTimeout(() => {
        // Mock successful payment for development
        statusDiv.innerHTML = `
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">Payment Confirmed!</p>
                        <p class="text-xs text-green-600 dark:text-green-400">Redirecting to your dashboard...</p>
                    </div>
                </div>
            </div>
        `;
        
        setTimeout(() => {
            window.location.href = '{{ route("payments.success", ["payment_id" => $payment->id, "transaction_id" => "BTC_" . uniqid()]) }}';
        }, 2000);
    }, 2000);
}

// Generate QR code (in production, use a real QR code library)
function generateQRCode(text) {
    // This is a placeholder - in production, use a library like qrcode.js
    const qrDiv = document.getElementById('qrcode');
    qrDiv.innerHTML = `
        <div class="text-xs text-gray-500 p-2">
            QR Code for:<br>
            <span class="font-mono">${text.substring(0, 20)}...</span>
        </div>
    `;
}

// Initialize QR code
generateQRCode('{{ $bitcoinAddress }}');
</script>
@endsection
