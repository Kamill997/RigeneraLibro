<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Facolta;
use App\Models\Immagine_Sito;
use App\Models\Preferito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function check()
    {
        if (!Auth::check())
            return view("home");
        else
            return view("posts.index");
    }

    public function retrieve(Request $request)
    {
        $userId = Auth::user();
        $user = User::with('immagine_user')->find($userId);

        $tab = $request->input('tab', 'tutti');

        $facolta = Facolta::with('corso')->get();

        $immagini_sito = Immagine_Sito::where('Tipo', 'Background')->get();

        $facoltaUser = $userId->id_facolta;

        $posts = Post::with(['user.immagine_user', 'corso', 'immagine_post'])
            ->withCount(['preferito as favorite' => function ($query) use ($userId) {
                $query->where('id_user', $userId->id);
            }])
            ->when($tab !== 'tutti', function ($query) use ($tab) {
                $query->where('tipo', $tab);
            })
            ->join('corso', 'post.id_corso', '=', 'corso.id')
            ->orderByRaw("CASE WHEN corso.id_facolta = ? THEN 0 ELSE 1 END", [$facoltaUser])
            ->orderBy('post.creato', 'desc')
            ->paginate(8);

        return response()->json([
            'immagini' => $immagini_sito,
            'user' => $user,
            'facolta' => $facolta,
            'posts' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage()
        ]);
    }

    public function searchPost($query)
    {
        $user = Auth::user();
        $immagini_sito = Immagine_Sito::where('Tipo', 'Background')->get();

        $posts = Post::with(['user.immagine_user', 'corso.facolta', 'immagine_post'])
            ->where(function ($q) use ($query) {
                $q->where('titolo', 'LIKE', "%{$query}%")
                    ->orWhere('descrizione', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('username', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('corso', function ($q) use ($query) {
                        $q->where('Nome', 'LIKE', "%{$query}%")
                            ->orWhereHas('facolta', function ($q) use ($query) {
                                $q->where('Nome', 'LIKE', "%{$query}%");
                            });
                    });
            })
            ->orderBy('creato', 'desc')
            ->paginate(8);

        $posts->getCollection()->transform(function ($post) use ($user) {
            $post->favorite = Preferito::where('id_post', $post->id)
                ->where('id_user', $user->id)
                ->count();
            return $post;
        });

        return response()->json([
            'user' => $user,
            'immagini' => $immagini_sito,
            'posts' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage()
        ]);
    }

    public function filterCorso($course)
    {
        $user = Auth::user();

        $posts = Post::with(['user.immagine_user', 'corso', 'immagine_post'])
            ->where('id_corso', $course)
            ->orderBy('creato', 'desc')
            ->paginate(8);

        $immagini_sito = Immagine_Sito::where('Tipo', 'Background')->get();

        $posts->getCollection()->transform(function ($post) use ($user) {
            $post->favorite = Preferito::where('id_post', $post->id)
                ->where('id_user', $user->id)
                ->count();
            return $post;
        });

        return response()->json([
            'immagini' => $immagini_sito,
            'posts' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage()
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'required|string|max:255',
            'tipo' => 'required|in:cerco,vendo',
            'id_corso' => 'required'
        ]);


        if ($request->tipo == 'cerco') {
            $post = Post::create([
                'id_user' => $user->id,
                'titolo' => $request->titolo,
                'descrizione' => $request->descrizione,
                'tipo' => $request->tipo,
                'id_corso' => $request->id_corso
            ]);

            if ($post)
                return response()->json(['success' => true]);
            else
                return response()->json(["failed" => false]);
        } else {
            $request->validate([
                'prezzo' => 'required|numeric',
                'condizione' => 'required|string',
                'immagini' => 'required|array',
                'immagini.*' => 'image|mimes:jpeg,png,jpg|max:1500'
            ]);

            $post = Post::create([
                'id_user' => $user->id,
                'titolo' => $request->titolo,
                'descrizione' => $request->descrizione,
                'condizione' => $request->condizione,
                'prezzo' => $request->prezzo,
                'tipo' => $request->tipo,
                'id_corso' => $request->id_corso
            ]);

            if ($post) {
                if ($request->hasFile('immagini')) {
                    foreach ($request->file('immagini') as $immagine) {
                        $path = $immagine->store('img/post/' . $user->username, 'public');
                        $post->immagine_post()->create(['path' => '/storage/' . $path]);
                    }
                }
                return response()->json(['success' => true]);
            } else
                return response()->json(["failed" => false]);
        }
    }

    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);

        $user = Auth::user();

        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'required|string',
            'id_corso' => 'required|exists:corso,id',
            'tipo' => 'required|in:vendo,cerco',
            'condizione' => $request->tipo === 'vendo' ? 'required|string' : 'nullable',
            'prezzo' => $request->tipo === 'vendo' ? 'required|numeric|min:0' : 'nullable',
            'immagini.*' => $request->tipo === 'vendo' ? 'sometimes|image|mimes:jpeg,png,jpg|max:2048' : 'nullable'
        ]);

        $post->update([
            'titolo' => $request->titolo,
            'descrizione' => $request->descrizione,
            'id_corso' => $request->id_corso,
            'tipo' => $request->tipo,
            'condizione' => $request->condizione,
            'prezzo' => $request->prezzo
        ]);


        if ($request->hasFile('immagini') && $request->tipo === 'vendo') {
            foreach ($request->file('immagini') as $image) {
                $path = $image->store('img/post/' . $user->username, 'public');
                $post->immagine_post()->create(['path' => '/storage/' . $path]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Post aggiornato con successo']);
    }

    public function edit($id)
    {
        $post = Post::with(['immagine_post'])->findOrFail($id);

        $user = Auth::user();

        if ($post->id_user !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'post' => $post
        ]);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json(['success' => true]);
    }

    public function toggleFavorite(Post $post)
    {
        $user = Auth::user();

        $esiste = Preferito::where('id_user', $user->id)->where('id_post', $post->id)->first();

        if ($esiste) {
            $esiste->delete();
            return response()->json(['status' => 'removed', 'favorite' => false]);
        } else {
            Preferito::create([
                'id_user' => $user->id,
                'id_post' => $post->id
            ]);
            return response()->json(['status' => 'added', 'favorite' => true]);
        }
    }
}
