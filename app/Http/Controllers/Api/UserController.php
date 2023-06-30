<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->unreadMessages = $user->messages->where('read', false)
                ->whereNull('channel_id')
                ->where('receiver_id', Auth()->id())
                ->count();
        }

        return response()->json($users);
    }
}
