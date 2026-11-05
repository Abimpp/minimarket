<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Chat::latest()->take(50)->get()->reverse()->values();
        return view('chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:50',
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create($validated);

        event(new MessageSent($chat));

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $chat->id,
                'sender_name' => $chat->sender_name,
                'message' => $chat->message,
                'created_at' => $chat->created_at ? $chat->created_at->format('H:i') : date('H:i'),
            ]
        ], 201);
    }

    public function clear()
    {
        Chat::truncate();
        return response()->json(['status' => 'cleared']);
    }
}

