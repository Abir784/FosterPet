<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($users as $user)
                            <div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-xl font-semibold text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="unread-badge hidden px-2 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full">0</span>
                                        <a href="{{ route('message.conversation', $user->id) }}"
                                           class="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900">
                                            Message
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateUnreadCounts() {
            document.querySelectorAll('.unread-badge').forEach(badge => {
                badge.classList.add('hidden');
            });

            // You can implement the unread count logic here if needed
            // For now, we'll just show the basic UI
        }

        // Update the unread badges periodically if needed
        setInterval(updateUnreadCounts, 30000);
        updateUnreadCounts();
    </script>
    @endpush
</x-app-layout>
