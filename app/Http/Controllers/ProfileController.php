<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Preferito;
use App\Models\Immagine_Sito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function check()
    {
        if (!Auth::check())
            return view("home");
        else {
            $user = Auth::user();
            return view("posts.profile", compact('user'));
        }
    }

    public function retrieve(Request $request)
    {
        $userId = Auth::user();
        $user = User::with('immagine_user')->find($userId);
        $tab = $request->query('tab', 'miei-post');
        $page = $request->query('page', 1);
        $perPage = 4;

        $immagini_sito = Immagine_Sito::where('Tipo', 'Background')->get();

        if ($tab === 'miei-post') {
            $posts = Post::with(['user.immagine_user', 'corso', 'immagine_post'])
                ->where('id_user', $userId->id)
                ->orderBy('creato', 'desc')
                ->paginate($perPage);
        } else {
            $posts = Preferito::with(['post.user.immagine_user', 'post.corso', 'post.immagine_post'])
                ->select('preferito.*')
                ->selectRaw('(SELECT COUNT(*) FROM preferito AS p WHERE p.id_post = preferito.id_post AND p.id_user = ?) as favorite', [$userId->id])
                ->where('preferito.id_user', $userId->id)
                ->join('post', 'preferito.id_post', '=', 'post.id')
                ->orderBy('post.creato', 'desc')
                ->paginate($perPage);

            $posts->getCollection()->transform(function ($preferito) {
                $post = $preferito->post;
                $post->favorite = $preferito->favorite;
                return $post;
            });
        }

        return response()->json([
            'user' => $user,
            'posts' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'hasMore' => $posts->hasMorePages(),
            'immagini' => $immagini_sito
        ]);
    }
}
