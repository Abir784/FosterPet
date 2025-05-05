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
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.index', compact('users'));
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
