@extends('layouts.auth')

@section('title', 'Reset Password')

@section('script')
<script src="{{ asset('js/login.js') }}" defer></script>
@endsection

@section('content')
<form class="form" method="POST" action="{{ route('forget.password.post') }}">
    @csrf
    <h1 class="title">Reset Password</h1>
    <div class="username">
        <div><input type="email" class="login-input" name="email" placeholder="Email" required></div>
    </div>
    <div class="submit">
        <div><input type="submit" value="Invia Link Reset" name="submit" /></div>
    </div>
    <p class="link"><a href="{{ route('login') }}">Torna al Login</a></p>
</form>
@endsection