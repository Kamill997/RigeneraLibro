<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Password_Reset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetController extends Controller
{
    public function forget()
    {
        if (Auth::check())
            return redirect()->route("posts");
        else
            return view('reset.forget-password');
    }

    public function forgetForm(Request $request)
    {
        if (Auth::check())
            return redirect()->route("posts");
        else {
            $request->validate([
                'email' => 'required|email|exists:user',
            ]);

            $token = Str::random(64);

            Password_Reset::create([
                'email' => $request->email,
                'token' => $token
            ]);

            Mail::send('reset.email-forget-password', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('message', 'Ti abbiamo inviato una email per resettare la password!');
        }
    }

    public function Reset($token)
    {
        if (Auth::check())
            return redirect()->route("posts");
        else {
            $passwordReset = Password_Reset::where('token', $token)->first();
            if (!$passwordReset) {
                return redirect()->route('login')->with('error', 'Token non valido!');
            }
            return view('reset.reset-password', ['token' => $token, 'email' => $passwordReset->email]);
        }
    }

    public function ResetForm(Request $request)
    {
        if (Auth::check())
            return redirect()->route("posts");
        else {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);

            $updatePassword = Password_Reset::where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', 'Token non valido!');
            }

            User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            Password_Reset::where(['email' => $request->email])->delete();

            return redirect('/login')->with('message', 'La tua password è stata cambiata!');
        }
    }
}
