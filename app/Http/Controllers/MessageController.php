<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all users who are friends with the current user
        // Get friend IDs for both sides of the relationship
        $userId = $user->id;
        
        // We need to get friend information with the relationship creation timestamp
        $sentFriends = \App\Models\FriendRequest::where('sender_id', $userId)
            ->where('status', 'accepted')
            ->with('receiver')
            ->get()
            ->map(function($request) {
                return [
                    'user' => $request->receiver,
                    'created_at' => $request->created_at
                ];
            });
            
        $receivedFriends = \App\Models\FriendRequest::where('receiver_id', $userId)
            ->where('status', 'accepted')
            ->with('sender')
            ->get()
            ->map(function($request) {
                return [
                    'user' => $request->sender,
                    'created_at' => $request->created_at
                ];
            });
            
        // Merge both collections
        $allFriends = $sentFriends->concat($receivedFriends);
        
        // Sort by created_at
        $sortedFriends = $allFriends->sortByDesc('created_at')->map(function($item) {
            return $item['user'];
        });
            
        return view('messages.index', ['friends' => $sortedFriends]);
    }

    public function conversation($userId)
    {
        $otherUser = User::findOrFail($userId);
        
        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);

        // Get messages between the two users
        $messages = Message::where(function($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.conversation', compact('messages', 'otherUser'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->message,
            'read' => false
        ]);

        return back()->with('success', 'Message sent successfully');
    }
}
