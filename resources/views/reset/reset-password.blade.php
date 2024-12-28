@extends('layouts.auth')

@section('title', 'Nuova Password')

@section('script')
<script src="{{ asset('js/login.js') }}" defer></script>
@endsection

@section('content')
<form class="form" method="POST" action="{{ route('reset.password.post') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <h1 class="title">Nuova Password</h1>
    <div class="password">
        <div><input type="password" class="login-input" name="password" placeholder="Nuova Password" required></div>
    </div>
    <div class="password">
        <div><input type="password" class="login-input" name="password_confirmation" placeholder="Conferma Password" required></div>
    </div>
    <div class="submit">
        <div><input type="submit" value="Salva Password" name="submit" /></div>
    </div>
    <p class="link"><a href="{{ route('login') }}">Torna al Login</a></p>
</form>
@endsection