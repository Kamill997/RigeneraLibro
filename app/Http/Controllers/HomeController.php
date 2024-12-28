<?php

namespace App\Http\Controllers;

use App\Models\Immagine_Sito;
use App\Models\Contatto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(request $request)
    {
        if (!Auth::check())
            return view("home");
        else {
            $user = Auth::user();
            return redirect()->route("posts")->with("user", $user);
        }
    }

    public function pick()
    {
        $query = Immagine_Sito::whereIn('Tipo', ['Home', 'Background'])->get();
        return response()->json($query);
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);

        $create = Contatto::create([
            'Nome' => $request->name,
            'email' => $request->email,
            'messaggio' => $request->message
        ]);

        return response()->json(['success' => 'Grazie per averci contattato! La tua domanda verrà elaborata e a breve riceverei una risposta.']);
    }
}
