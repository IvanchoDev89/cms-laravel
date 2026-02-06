@extends('layouts.app')

@section('title', 'Chat with ' . $user->name . ' - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">
    <!-- Chat Header -->
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('messages.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-medium">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 overflow-y-auto">
        <div class="space-y-4">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-lg">
                        <div class="flex items-end space-x-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <!-- Avatar -->
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-sm font-medium">
                                    {{ substr($message->sender->name, 0, 1) }}
                                </span>
                            </div>
                            
                            <!-- Message Bubble -->
                            <div class="px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() 
                                ? 'bg-indigo-600 text-white' 
                                : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                                <p class="text-sm">{{ $message->content }}</p>
                                
                                <!-- Attachments -->
                                @if($message->hasAttachments())
                                    <div class="mt-2 space-y-1">
                                        @foreach($message->attachments as $attachment)
                                            <div class="flex items-center space-x-2 text-xs {{ $message->sender_id === auth()->id() ? 'text-indigo-100' : 'text-gray-600 dark:text-gray-400' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                <span>{{ $attachment['name'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Message Meta -->
                        <div class="flex items-center mt-1 space-x-2 {{ $message->sender_id === auth()->id() ? 'justify-end' : '' }}">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->created_at->format('g:i A') }}
                            </span>
                            @if($message->sender_id === auth()->id())
                                <span class="text-xs {{ $message->is_read ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $message->is_read ? 'Read' : 'Sent' }}
                                </span>
                            @endif
                            @if($message->edited_at)
                                <span class="text-xs text-gray-500 dark:text-gray-400">Edited</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Start the conversation</h3>
                    <p class="text-gray-600 dark:text-gray-400">Send your first message to {{ $user->name }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Input -->
    <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('messages.store', $user) }}" method="POST" id="messageForm" class="flex items-end space-x-4">
                @csrf
                <div class="flex-1">
                    <div class="relative">
                        <textarea name="content" 
                                  placeholder="Type your message..." 
                                  rows="1"
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                                  onkeydown="handleKeyPress(event)"></textarea>
                        
                        <!-- Attachment Button -->
                        <button type="button" onclick="document.getElementById('fileInput').click()" 
                                class="absolute right-2 bottom-2 p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        <input type="file" id="fileInput" name="attachments[]" multiple class="hidden" onchange="handleFileSelect(event)">
                    </div>
                </div>
                
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send
                </button>
            </form>
            
            <!-- File Preview -->
            <div id="filePreview" class="hidden mt-2 flex flex-wrap gap-2"></div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom on page load
window.addEventListener('load', function() {
    scrollToBottom();
});

// Auto-scroll to bottom when new messages are added
function scrollToBottom() {
    const container = document.querySelector('.overflow-y-auto');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Handle Enter key for sending messages
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        document.getElementById('messageForm').submit();
    }
}

// Handle file selection
function handleFileSelect(event) {
    const files = event.target.files;
    const preview = document.getElementById('filePreview');
    preview.innerHTML = '';
    
    if (files.length > 0) {
        preview.classList.remove('hidden');
        for (let file of files) {
            const fileDiv = document.createElement('div');
            fileDiv.className = 'flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded px-3 py-1';
            fileDiv.innerHTML = `
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm text-gray-700 dark:text-gray-300">${file.name}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            preview.appendChild(fileDiv);
        }
    } else {
        preview.classList.add('hidden');
    }
}

// Auto-refresh for new messages
setInterval(() => {
    fetch(`/messages/${{ $user->id }}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Check if there are new messages by comparing content
        const currentMessages = document.querySelector('.space-y-4').innerHTML;
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const newMessages = tempDiv.querySelector('.space-y-4').innerHTML;
        
        if (currentMessages !== newMessages) {
            location.reload();
        }
    });
}, 10000); // Check every 10 seconds

// Auto-resize textarea
document.querySelector('textarea').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endsection
