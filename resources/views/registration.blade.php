@extends('layouts.auth')

@section('title', 'Registrati')

@section('script')
<script src="{{ asset('js/registration.js') }}" defer></script>
@endsection


@section('content')

<form class='form' method='post' action="{{ route('registration') }}" enctype="multipart/form-data">
    @csrf
    <h1 class="title">Registrazione</h1>
    <div class="Nomi">
        <div class="Nome @error('Nome') errore @enderror">
            <span>Inserisci Nome</span>
            <div><input type="text" class="login-input" name="name" placeholder="Nome" value="{{ old('name') }}" required></div>
        </div>
        <div class="Cognome @error('Cognome') errore @enderror">
            <span>Inserisci Cognome</span>
            <div><input type="text" class="login-input" name="lastName" placeholder="Cognome" value="{{ old('lastName') }}" required></div>
        </div>
    </div>
    <div class="Username @error('Username') errore @enderror">
        <span>@error('Username') {{ $message }} @enderror</span>
        <div><input type="text" class="login-input" name="username" placeholder="Username" value="{{ old('username') }}" required></div>
    </div>
    <div class="Email @error('Email') errore @enderror">
        <span>@error('Email') {{ $message }} @enderror</span>
        <div><input type="text" class="login-input" name="email" placeholder="Email" value="{{ old('email') }}" required></div>
    </div>
    <div class="Password @error('Password') errore @enderror">
        <span>@error('Password') {{ $message }} @enderror</span>
        <div><input type="password" class="login-input" name="password" placeholder="Password" required></div>
    </div>
    <div class="Facolta @error('facolta') errore @enderror">
        <div>
            <label>Scegli un corso</label>
        </div>
        <div>
            <select name="id_facolta" class="login-input">
            </select>
        </div>
    </div>
    <div class="Pic @error('Pic') errore @enderror">
        <div>
            <label>Scegli la tua immagine profilo</label>
        </div>
        <span>@error('Pic') {{ $message }} @enderror</span>
        <div><input type="file" id="pic" class="login-input" name="pic" accept='.jpg, .jpeg, image/png'></div>
    </div>
    <div class="submit">
        <input type="submit" id="submit" name="submit" value="Registrati">
    </div>
    <p class="link">Hai già un account? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection