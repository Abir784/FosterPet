
<x-app-layout>
<div class="container">
    <h2 class="mb-4">Friend Requests</h2>



    {{-- Toast for success message --}}
    @if (session('success'))
        <div id="toast" style="position: fixed; top: 20px; right: 20px; background-color: #38c172; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
            {{ session('success') }}
        </div>

        <script>
            // Hide the toast after 3 seconds
            setTimeout(() => {
                document.getElementById('toast').style.display = 'none';
            }, 3000);
        </script>
    @endif
    <!-- Send Friend Request -->
    <form action="{{ route('friends.send') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <select name="receiver_id" class="form-select" required>
                <option value="">Select a user</option>
                @foreach(App\Models\User::all() as $user)
                    @if($user->id !== auth()->id())
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Send Request</button>
        </div>
    </form>

    <!-- Received Requests -->
    <h4>Received Requests</h4>
    <ul class="list-group mb-4">
        @forelse($receivedRequests as $request)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $request->sender->name }}
                <div>
                    <form action="{{ route('friends.accept', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('POST')
                        <button class="btn btn-success btn-sm" style="display:inline">Accept</button>
                    </form>
                    <form action="{{ route('friends.reject', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('POST')
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item">No requests.</li>
        @endforelse
    </ul>

    <!-- Sent Requests -->
    <h4>Sent Requests</h4>
    <ul class="list-group mb-4">
        @forelse($sentRequests as $request)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $request->receiver->name }}
                <span class="badge bg-warning">{{ ucfirst($request->status) }}</span>
            </li>
        @empty
            <li class="list-group-item">No requests.</li>
        @endforelse
    </ul>

    <!-- Friends List -->
    <h4>Your Friends</h4>
    <ul class="list-group">
        @forelse($friends as $friend)
            <li class="list-group-item">{{ $friend->name }}</li>
        @empty
            <li class="list-group-item">No friends yet.</li>
        @endforelse
    </ul>
</div>
</x-app-layout>
