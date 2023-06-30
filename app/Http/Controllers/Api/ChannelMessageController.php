<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChannelMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($channel_id): JsonResponse
    {
        $messages = Message::query()
            ->with('sender')
            ->where('channel_id', $channel_id)
            ->where('first', true)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($channel_id, Request $request)
    {
        $data = $request->validate([
            'message' => ['required'],
        ]);

        $users = User::all();
        $uuid = Str::uuid()->toString();
        $counter = 0;

        foreach($users as $user) {
            if ($user->id != Auth::id()) {
                $is_first = $counter == 0 ? true : false;
                $message = Message::create([
                    'channel_id' => $channel_id,
                    'receiver_id' => $user->id,
                    'sender_id' => Auth::id(),
                    'message' => $data['message'],
                    'read' => false,
                    'uuid' => $uuid,
                    'first' => $is_first,
                ]);
                $counter++;
                broadcast(new MessageCreated($message, 'channel'))->toOthers();
            }
        }

        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
