<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{

    private function getFriends($userId)
{
    // Fetch all accepted friend requests where the current user is either sender or receiver
    $accepted = FriendRequest::where(function ($query) use ($userId) {
        $query->where('sender_id', $userId)
        
              ->orWhere('receiver_id', $userId);
    })->where('status', 'accepted')->get();

    // Extract the IDs of the accepted friends by checking who is the opposite party
    $friendIds = $accepted->map(function ($request) use ($userId) {
        return $request->sender_id == $userId ? $request->receiver_id : $request->sender_id;
    });

    // Return the User models corresponding to the friend IDs
    return User::whereIn('id', $friendIds)->get();
}


    public function index()
    {
        $user = Auth::user();
        $friendRequests = FriendRequest::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender')
            ->get();
            $users = User::where('id', '!=', $user->id) // Exclude the current user
            ->where('role', '!=', 'admin') // Exclude admin users
            ->whereDoesntHave('sentRequests', function ($query) use ($user) {
                $query->where('receiver_id', $user->id)
                      ->whereIn('status', ['pending', 'accepted']);
            })
            ->whereDoesntHave('receivedRequests', function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->whereIn('status', ['pending', 'accepted']);
            })
            ->get();

        // return response()->json($friendRequests);

        return view('friend_requests', [
            'users' => $users,
            'receivedRequests' => FriendRequest::where('receiver_id', $user->id)->where('status', 'pending')->get(),
            'sentRequests' => FriendRequest::where('sender_id', $user->id)->get(),
            'friends' => $this->getFriends($user->id),
        ]);
    }
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $exists = FriendRequest::where('sender_id', Auth::id())
            ->where('receiver_id', $request->receiver_id)
            ->where('status', 'pending')
            ->first();

        if ($exists) {
            return back()->with('success', 'Friend request already sent.');
        }

        FriendRequest::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
        ]);

        return back()->with('success', 'Friend request sent successfully!');

    }

    public function accept($id)
    {
        $request = FriendRequest::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $request->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted successfully!');
    }

    public function decline($id)
    {
        $request = FriendRequest::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $request->update(['status' => 'declined']);

        return back()->with('success', 'Friend request declined successfully!');
    }


}
