<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use OpenAI;

class ChatGptController extends Controller
{

    public function index()
    {
        return Inertia::render('ChatWithGpt.jsx');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $resp = $client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant. In a forum chat, you should be friendly and helpful.'],
                ['role' => 'user', 'content' => $request->message],
            ],
        ]);

        return response()->json([
            'reply' => $resp->choices[0]->message->content,
        ]);
    }
}
