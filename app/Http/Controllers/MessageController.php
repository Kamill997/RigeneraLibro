<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messaggio;
use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    public function getUser()
    {
        $currentUser = Auth::user();

        return response()->json([
            'id' => $currentUser->id,
            'username' => $currentUser->username,
            'pic' => $currentUser->immagine_user->path
        ]);
    }

    public function index($username = null)
    {
        if (!Auth::check())
            return view("home");
        else {
            $userId = Auth::id();
            $currentUser = Auth::user();

            if ($username) {
                $user = User::where('username', $username)->first();

                if (!$user) {
                    return redirect()->route('chats')->with('error', 'Utente non trovato');
                }

                if ($user->id === $userId) {
                    return redirect()->route('chats')->with('error', 'Non puoi chattare con te stesso');
                }

                $exists = Messaggio::where(function ($query) use ($userId, $user) {
                    $query->where('id_mittente', $userId)->where('id_destinatario', $user->id)
                        ->orWhere('id_mittente', $user->id)->where('id_destinatario', $userId);
                })->exists();

                return view("chat", [
                    'lastChat' => $user->id,
                    'chatUsername' => $user->username,
                    'newChat' => !$exists,
                    'noChats' => !$exists
                ]);
            }

            $lastMessage = Messaggio::where('id_mittente', $userId)
                ->orWhere('id_destinatario', $userId)
                ->orderBy('creato', 'desc')
                ->first();

            if (!$lastMessage) {
                return view("chat", ['noChats' => true]);
            }

            $lastChat = $lastMessage->id_mittente === $userId ? $lastMessage->id_destinatario : $lastMessage->id_mittente;
            return view("chat", compact('lastChat'));
        }
    }


    public function getLastChat()
    {
        $userId = Auth::id();

        $lastMessage = Messaggio::where('id_mittente', $userId)
            ->orWhere('id_destinatario', $userId)
            ->orderBy('creato', 'desc')
            ->first();

        if ($lastMessage) {
            $otherUserId = $lastMessage->id_mittente === $userId ? $lastMessage->id_destinatario : $lastMessage->id_mittente;

            return $this->check(request(), User::find($otherUserId));
        } else {
            return response()->json(['error' => 'Nessuna chat trovata'], 404);
        }
    }


    public function check(User $user)
    {
        if (!Auth::check())
            return view("home");
        else {
            $userId = Auth::id();

            if ($user->id === $userId) {
                return redirect()->back()->with('error', 'Non puoi chattare con te stesso');
            }

            $messages = Messaggio::with(['mittente', 'destinatario'])
                ->where(function ($query) use ($userId, $user) {
                    $query->where('id_mittente', $userId)->where('id_destinatario', $user->id)
                        ->orWhere('id_mittente', $user->id)->where('id_destinatario', $userId);
                })
                ->orderBy('creato', 'asc')
                ->get();

            $otherUser = [
                'id' => $user->id,
                'username' => $user->username
            ];

            $formatted = $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'id_mittente' => $message->id_mittente,
                    'id_destinatario' => $message->id_destinatario,
                    'messaggio' => $message->messaggio,
                    'timestamp' => $message->creato,
                    'senderName' => $message->mittente->username,
                    'senderPic' => $message->mittente->immagine_user->path
                ];
            });

            return response()->json([
                'otherUser' => $otherUser,
                'messages' => $formatted
            ]);
        }
    }

    public function getAllChat()
    {
        if (!Auth::check())
            return view("home");
        else {
            $userId = Auth::id();

            $chats = Messaggio::where('id_mittente', $userId)
                ->orWhere('id_destinatario', $userId)
                ->with(['mittente', 'destinatario'])
                ->get()
                ->groupBy(function ($message) use ($userId) {

                    return $message->id_mittente === $userId ? $message->id_destinatario : $message->id_mittente;
                })
                ->map(function ($messages) {
                    $lastMessage = $messages->sortByDesc('creato')->first();
                    $otherUser = $lastMessage->id_mittente === Auth::id() ? $lastMessage->destinatario : $lastMessage->mittente;

                    return [
                        'userId' => $otherUser->id,
                        'username' => $otherUser->username,
                        'userAvatar' => $otherUser->immagine_user->path,
                        'lastMessage' => $lastMessage->messaggio,
                        'lastMessageTime' => $lastMessage->creato,
                        'lastSenderId' => $lastMessage->id_mittente,
                        'currentUser' => [
                            'id' => Auth::user()->id,
                            'username' => Auth::user()->username,
                            'pic' => Auth::user()->immagine_user->path
                        ]
                    ];
                })
                ->sortByDesc('lastMessageTime')
                ->values();

            return response()->json($chats);
        }
    }

    public function store(User $user, Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userId = Auth::id();

        $message = Messaggio::create([
            'id_mittente' => $userId,
            'id_destinatario' => $user->id,
            'messaggio' => $request->message
        ])->load('mittente');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(["status" => "Message Sent", "message" => $message, "timestamp" => $message->creato], 201);
    }
}
