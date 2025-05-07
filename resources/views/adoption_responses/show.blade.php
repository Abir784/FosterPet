<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adoption Request Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <a href="{{ route('adoption-responses.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            &larr; Back to All Requests
                        </a>
                    </div>

                    <!-- Pet and Adopter Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Pet Information</h3>
                            <div class="flex items-start">
                                @if($adoptionRequest->adoption->pet->image)
                                    <div class="flex-shrink-0 h-24 w-24 mr-4">
                                        <img class="h-24 w-24 rounded object-cover" src="{{ asset('storage/' . $adoptionRequest->adoption->pet->image) }}" alt="{{ $adoptionRequest->adoption->pet->name }}">
                                    </div>
                                @endif
                                <div>
                                    <p class="text-gray-900 font-medium">{{ $adoptionRequest->adoption->pet->name }}</p>
                                    <p class="text-gray-600">Breed: {{ $adoptionRequest->adoption->pet->breed }}</p>
                                    <p class="text-gray-600">Age: {{ $adoptionRequest->adoption->pet->age }}</p>
                                    <p class="text-gray-600">Owner: {{ $adoptionRequest->adoption->pet->owner->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Adopter Information</h3>
                            <p class="text-gray-900 font-medium">{{ $adoptionRequest->adopter->name }}</p>
                            <p class="text-gray-600">Email: {{ $adoptionRequest->adopter->email }}</p>
                            <p class="text-gray-600">Requested on: {{ $adoptionRequest->created_at->format('F d, Y') }}</p>
                            <p class="text-gray-600">Status: 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($adoptionRequest->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($adoptionRequest->status == 'Approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $adoptionRequest->status }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Community Response Summary -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Community Response Summary</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex flex-wrap gap-4">
                                <div class="flex-1 min-w-[150px]">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-green-600">{{ $adoptionRequest->support_count }}</div>
                                        <div class="text-sm text-gray-600">Support</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-[150px]">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-yellow-600">{{ $adoptionRequest->neutral_count }}</div>
                                        <div class="text-sm text-gray-600">Neutral</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-[150px]">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-red-600">{{ $adoptionRequest->oppose_count }}</div>
                                        <div class="text-sm text-gray-600">Oppose</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-[150px]">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-blue-600">{{ $adoptionRequest->responses->count() }}</div>
                                        <div class="text-sm text-gray-600">Total Responses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Your Response Form -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Your Response</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <form action="{{ route('adoption-responses.respond', $adoptionRequest->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                    <textarea id="comment" name="comment" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Share your thoughts on this adoption request...">{{ $userResponse->comment ?? old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Position</label>
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex items-center">
                                            <input id="support" name="response" type="radio" value="support" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ (isset($userResponse) && $userResponse->response == 'support') || old('response') == 'support' ? 'checked' : '' }}>
                                            <label for="support" class="ml-2 block text-sm text-gray-700">Support</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="neutral" name="response" type="radio" value="neutral" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ (isset($userResponse) && $userResponse->response == 'neutral') || old('response') == 'neutral' ? 'checked' : '' }}>
                                            <label for="neutral" class="ml-2 block text-sm text-gray-700">Neutral</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="oppose" name="response" type="radio" value="oppose" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ (isset($userResponse) && $userResponse->response == 'oppose') || old('response') == 'oppose' ? 'checked' : '' }}>
                                            <label for="oppose" class="ml-2 block text-sm text-gray-700">Oppose</label>
                                        </div>
                                    </div>
                                    @error('response')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ isset($userResponse) ? 'Update Response' : 'Submit Response' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Pet Owner Decision Section -->
                    @if($adoptionRequest->adoption->pet->owner_id == Auth::id() && $adoptionRequest->status == 'Pending')
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Make Your Decision</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="mb-4 text-sm text-gray-600">As the pet owner, you can make the final decision on this adoption request based on community feedback.</p>
                                <div class="flex gap-4">
                                    <form action="{{ route('adoption-responses.decision', $adoptionRequest->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="decision" value="Approved">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="return confirm('Are you sure you want to approve this adoption request?')">
                                            Approve Adoption
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('adoption-responses.decision', $adoptionRequest->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="decision" value="Rejected">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to reject this adoption request?')">
                                            Reject Adoption
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Community Responses -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Community Responses ({{ $adoptionRequest->responses->count() }})</h3>
                        
                        @if($adoptionRequest->responses->isEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-600">No responses yet. Be the first to share your thoughts!</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($adoptionRequest->responses as $response)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $response->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $response->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($response->response == 'support') bg-green-100 text-green-800
                                                @elseif($response->response == 'neutral') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($response->response) }}
                                            </span>
                                        </div>
                                        <div class="mt-2 text-gray-700">
                                            {{ $response->comment }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
