<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Immagine_Sito;
use App\Models\Facolta;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //REGISTRAZIONE 
    public function register(request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|max:255',
            'id_facolta' => 'required|string|max:255',
        ]);

        $user = User::Create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_facolta' => $request->id_facolta
        ]);

        if ($user) {
            if ($request->hasFile('pic')) {
                $path = $request->file('pic')->store('img/profile/', 'public');
                $user->immagine_user()->create(['path' => '/storage/' . $path]);
            } else {
                $user->immagine_user()->create(['path' => '/storage/img/profile/default.png']);
            }
            Auth::login($user);
            return redirect()->route("posts")->with('message', 'Account registrato correttamente!');
        } else {
            return redirect("registration")
                ->withInput($request->except('password'))->with('message', 'Account non registrato!');
        }
    }

    public function pick()
    {
        $query = Immagine_Sito::whereIn('Tipo', ['Auth', 'Home'])->get();
        return response()->json($query);
    }

    public function check()
    {
        if (!Auth::check())
            return view("registration");
        else
            return redirect()->route('posts');
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');

        if (!$username) {
            return response()->json(['exists' => false, 'errore' => 'Il campo username è obbligatorio.'], 400);
        }

        $query = User::where('Username', $username)->exists();
        return response()->json(['exists' => $query]);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['exists' => false, 'errore' => 'Il campo email è obbligatorio.'], 400);
        }

        $query = User::where('Email', $email)->exists();
        return response()->json(['exists' => $query]);
    }

    //LOGIN
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route("posts");
        } else {
            return view('login')
                ->with('csrf_token', csrf_token());
        }
    }

    public function checklogin(Request $request)
    {
        $request->validate([
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ]);

        $input = $request->input('username_or_email');

        $password = $request->input('password');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $utente = User::where('email', $input)->first();
        } else {
            $utente = User::where('username', $input)->first();
        }

        if ($utente && Hash::check($password, $utente->password)) {
            Auth::login($utente);
            return redirect()->route('posts');
        } else {
            return redirect('login')->withInput($request->except('password'))->withErrors(['login' => 'Credenziali non valide.']);
        }
    }

    //LOGOUT
    public function logout(request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('home');
    }
}
