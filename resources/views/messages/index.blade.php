@extends('layouts.app')

@section('title', 'Messages - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h1>
                    <p class="text-gray-600 dark:text-gray-400">Communicate with other users</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search conversations..." 
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button onclick="showNewMessageModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversations List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @forelse($conversations as $userId => $messages)
            @php
                $lastMessage = $messages->first();
                $otherUser = $lastMessage->sender_id === auth()->id() ? $lastMessage->receiver : $lastMessage->sender;
                $unreadCount = $messages->where('receiver_id', auth()->id())->where('is_read', false)->count();
            @endphp
            
            <a href="{{ route('messages.show', $otherUser) }}" 
               class="block bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow mb-4">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- User Avatar -->
                            <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium">{{ substr($otherUser->name, 0, 1) }}</span>
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $otherUser->name }}</h3>
                                    @if($unreadCount > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                    @if($lastMessage->sender_id === auth()->id())
                                        You: {{ $lastMessage->content }}
                                    @else
                                        {{ $lastMessage->content }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Message Meta -->
                        <div class="text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $lastMessage->created_at->diffForHumans() }}
                            </p>
                            @if($lastMessage->hasAttachments())
                                <div class="flex items-center justify-end mt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    <span class="text-xs text-gray-400 ml-1">{{ $lastMessage->attachment_count }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No conversations yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Start a conversation with another user</p>
                <button onclick="showNewMessageModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Send First Message
                </button>
            </div>
        @endforelse
    </div>
</div>

<!-- New Message Modal -->
<div id="newMessageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">New Message</h3>
            <form id="newMessageForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recipient</label>
                    <select name="user_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select a user...</option>
                        @php
                            $allUsers = \App\Models\User::where('id', '!=', auth()->id())->get();
                        @endphp
                        @foreach($allUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                    <textarea name="content" rows="4" required 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideNewMessageModal()"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showNewMessageModal() {
    document.getElementById('newMessageModal').classList.remove('hidden');
}

function hideNewMessageModal() {
    document.getElementById('newMessageModal').classList.add('hidden');
}

document.getElementById('newMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const userId = formData.get('user_id');
    
    if (userId) {
        window.location.href = `/messages/${userId}`;
    }
});

// Auto-refresh for new messages
setInterval(() => {
    fetch('/messages/unread-count')
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                // Update UI to show new messages
                location.reload();
            }
        });
}, 30000); // Check every 30 seconds
</script>
@endsection
