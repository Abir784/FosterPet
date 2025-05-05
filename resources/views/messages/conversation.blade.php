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
                    <!-- Messages Container -->
                    <div class="flex flex-col space-y-4 h-[60vh]">
                        <div class="flex-1 overflow-y-auto px-4 py-2" id="messages-container">
                            @foreach($messages as $message)
                                <div class="flex mb-4 {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="flex items-start {{ $message->sender_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-semibold text-gray-600">
                                                    {{ substr($message->sender_id === Auth::id() ? Auth::user()->name : $otherUser->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Message Bubble -->
                                        <div class="relative {{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-100' }} text-black rounded-lg px-4 py-2 max-w-sm group">
                                            <div class="flex justify-between items-start gap-4">
                                                <p class="text-sm">{{ $message->content }}</p>
                                                @if($message->sender_id !== Auth::id())
                                                    <button onclick="reportMessage('{{ $message->id }}')"
                                                            class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-xs text-gray-500 hover:text-red-600">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $message->created_at->format('g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Message Input -->
                        <div class="border-t pt-4">
                            <form action="{{ route('message.send') }}" method="POST" class="flex space-x-4">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                                <input type="text"
                                       name="message"
                                       class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="Type your message..."
                                       required
                                       autofocus>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 transition ease-in-out duration-150">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Report Message</h3>
                <form action="{{ route('message.report') }}" method="POST">
                    @csrf

                    <label for="me" class="block text-sm font-medium text-gray-700">Select Message</label>

                    <select name="message_id" id="reportMessageId"  required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" >
                        <option value="">--select message--</option>
                        @foreach ($messages as $message)
                            @if($message->sender_id !== Auth::id())
                            <option value="{{$message->id}}">{{Str::limit($message->content, 50)}}</option>
                            @endif
                        @endforeach
                    </select>

                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Report</label>
                        <select name="reason" id="reason" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select a reason</option>
                            <option value="harassment">Harassment</option>
                            <option value="inappropriate_content">Inappropriate Content</option>
                            <option value="spam">Spam</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Additional Details</label>
                        <textarea name="description" id="description"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  rows="3"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeReportModal()"
                                class="px-4 py-2 bg-black-300 text-black rounded-md hover:bg-gray-400">Cancel</button>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-black rounded-md hover:bg-red-700">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function reportMessage(messageId) {
            // Set the selected message in the dropdown
            const selectElement = document.getElementById('reportMessageId');
            selectElement.value = messageId;
            
            // Show the modal
            document.getElementById('reportModal').classList.remove('hidden');
        }

        function closeReportModal() {
            // Hide the modal
            document.getElementById('reportModal').classList.add('hidden');
            
            // Reset form fields
            document.getElementById('reportMessageId').value = '';
            document.getElementById('reason').value = '';
            document.getElementById('description').value = '';
        }
    </script>

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
