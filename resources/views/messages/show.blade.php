<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chat with') }} {{ $otherUser->name }}
            </h2>
            <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900">
                Back to Messages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col h-[60vh]">
                        <!-- Messages Container -->
                        <div class="flex-1 overflow-y-auto mb-4 space-y-4" id="messages-container">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[70%] {{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-100' }} text-black rounded-lg px-4 py-2">
                                        <p class="text-sm">{{ $message->content }}</p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            {{ $message->created_at->format('M d, g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Message Input -->
                        <form action="{{ route('messages.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                            <div class="flex space-x-4">
                                <input type="text"
                                       name="content"
                                       class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="Type your message..."
                                       required>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Auto-refresh messages every 5 seconds
        setInterval(() => {
            window.location.reload();
        }, 5000);
    </script>
    @endpush
</x-app-layout>
