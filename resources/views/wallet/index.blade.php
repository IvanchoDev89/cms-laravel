@extends('layouts.app')

@section('title', 'Wallet - Enterprise Financial Management')

@push('styles')
<style>
/* Enterprise Wallet Styles */
.wallet-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.wallet-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.balance-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.balance-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.payment-method-card {
    background: linear-gradient(145deg, #f8fafc, #e2e8f0);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.payment-method-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}

.payment-method-card:hover::before {
    left: 100%;
}

.payment-method-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.transaction-table {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modal-overlay {
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.btn-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.dark .balance-card {
    background: rgba(30, 41, 59, 0.95);
    border: 1px solid rgba(71, 85, 105, 0.3);
}

.dark .payment-method-card {
    background: linear-gradient(145deg, #1e293b, #334155);
    border: 1px solid rgba(71, 85, 105, 0.3);
}

.dark .transaction-table {
    background: rgba(30, 41, 59, 0.98);
}

.dark .modal-content {
    background: linear-gradient(145deg, #1e293b, #0f172a);
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="wallet-hero relative">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 to-blue-600/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-4 tracking-tight">
                Enterprise Wallet
            </h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                Advanced financial management platform with real-time analytics and secure payment processing
            </p>
        </div>
    </div>
</div>

<!-- Balance Overview -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Current Balance -->
        <div class="balance-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                    💰
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Available Balance</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $wallet->formatted_balance }}</p>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-600 font-medium">+12.5%</span> from last month
            </div>
        </div>

        <!-- Total Earned -->
        <div class="balance-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon bg-gradient-to-br from-green-500 to-green-600 text-white">
                    📈
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Earned</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $wallet->formatted_total_earned }}</p>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-600 font-medium">+8.2%</span> growth rate
            </div>
        </div>

        <!-- Total Withdrawn -->
        <div class="balance-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon bg-gradient-to-br from-purple-500 to-purple-600 text-white">
                    💳
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Withdrawn</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $wallet->formatted_total_withdrawn }}</p>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-blue-600 font-medium">Last: 2 days ago</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-4 mb-8">
        <button onclick="showAddFundsModal()" class="btn-primary px-8 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Funds
            </span>
        </button>
        <button onclick="showWithdrawModal()" class="btn-secondary px-8 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
                Withdraw
            </span>
        </button>
        <a href="{{ route('wallet.earnings') }}" class="btn-success px-8 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            View Analytics
        </a>
    </div>

    <!-- Payment Methods -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Methods</h2>
            <button onclick="showAddPaymentMethodModal()" class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Method
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- PayPal -->
            <div class="payment-method-card rounded-xl p-6 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">P</span>
                    </div>
                    <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">PayPal</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">admin@example.com</p>
            </div>

            <!-- Credit Card -->
            <div class="payment-method-card rounded-xl p-6 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">💳</span>
                    </div>
                    <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Credit Card</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">•••• •••• •••• 4242</p>
            </div>

            <!-- Bitcoin -->
            <div class="payment-method-card rounded-xl p-6 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">₿</span>
                    </div>
                    <span class="status-badge bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Setup</span>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Bitcoin</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Not configured</p>
            </div>
        </div>
    </div>

    <!-- Transactions -->
    <div class="transaction-table rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transaction History</h2>
                <div class="flex items-center space-x-4">
                    <select class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>All Transactions</option>
                        <option>Deposits</option>
                        <option>Withdrawals</option>
                        <option>Transfers</option>
                    </select>
                    <button class="text-blue-600 hover:text-blue-700 font-medium">Export</button>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Transaction</th>
                        <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-8 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                        @if($transaction->isCredit())
                                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $transaction->description }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($transaction->type) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $transaction->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-8 py-4">
                                @if($transaction->isCompleted())
                                    <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                                @elseif($transaction->isPending())
                                    <span class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                @else
                                    <span class="status-badge bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Failed</span>
                                @endif
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="font-semibold {{ $transaction->isCredit() ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->isCredit() ? '+' : '-' }}{{ $transaction->formatted_amount }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">No transactions yet</p>
                                    <p class="text-gray-600 dark:text-gray-400">Your transaction history will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div id="addFundsModal" class="modal-overlay fixed inset-0 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content rounded-2xl max-w-md w-full p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Add Funds</h3>
                <button onclick="hideAddFundsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form action="#" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500 text-lg">$</span>
                        <input type="number" name="amount" step="0.01" min="1" max="10000" required
                               class="w-full pl-8 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Min: $1, Max: $10,000</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="payment_method" value="paypal" checked class="mr-3">
                            <div class="flex items-center flex-1">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">P</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">PayPal</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Fast and secure</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="payment_method" value="credit_card" class="mr-3">
                            <div class="flex items-center flex-1">
                                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">💳</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Credit Card</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Visa, Mastercard, Amex</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="hideAddFundsModal()" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 btn-primary px-6 py-3 rounded-xl text-white font-medium">
                        Add Funds
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Payment Method Modal -->
<div id="addPaymentMethodModal" class="modal-overlay fixed inset-0 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content rounded-2xl max-w-md w-full p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Add Payment Method</h3>
                <button onclick="hideAddPaymentMethodModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Type</label>
                    <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Credit Card</option>
                        <option>Debit Card</option>
                        <option>Bank Account</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Card Number</label>
                    <input type="text" placeholder="1234 5678 9012 3456" required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiry Date</label>
                        <input type="text" placeholder="MM/YY" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CVV</label>
                        <input type="text" placeholder="123" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="hideAddPaymentMethodModal()" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 btn-primary px-6 py-3 rounded-xl text-white font-medium">
                        Add Method
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showAddFundsModal() {
    document.getElementById('addFundsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideAddFundsModal() {
    document.getElementById('addFundsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showAddPaymentMethodModal() {
    document.getElementById('addPaymentMethodModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideAddPaymentMethodModal() {
    document.getElementById('addPaymentMethodModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideAddFundsModal();
        hideAddPaymentMethodModal();
    }
});

// Close modals on background click
document.getElementById('addFundsModal').addEventListener('click', function(event) {
    if (event.target === this) {
        hideAddFundsModal();
    }
});

document.getElementById('addPaymentMethodModal').addEventListener('click', function(event) {
    if (event.target === this) {
        hideAddPaymentMethodModal();
    }
});
</script>
@endsection
