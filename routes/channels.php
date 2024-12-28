<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Messaggio;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{user1Id}.{user2Id}', function ($user, $user1Id, $user2Id) {
    return  $user->id == $user1Id || $user->id == $user2Id;
});
