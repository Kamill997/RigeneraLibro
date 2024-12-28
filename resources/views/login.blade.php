@extends('layouts.auth')

@section('title' ,'Login')

@section('script')
<script src="{{ asset('js/login.js') }} " defer></script>
@endsection

@section('content')

<form class="form" method="post" name="login">
  @csrf
  <h1 class="title">Login</h1>
  <div class="username">
    <div>
      <input type="text" class="login-input" name="username_or_email" placeholder="Username o Email" required>
    </div>
  </div>
  <div class="password">
    <div class="contenitore-password">
      <input type="password" class="login-input" name="password" id="password" placeholder="Password" required>
      <button type="button" id="showPassword" class="showPassword">
        <i class="fa fa-eye"></i>
      </button>
    </div>
  </div>
  <div class="submit">
    <div><input type="submit" value="Login" name="submit" /></div>
  </div>
  <p class="link">Non hai un account? <a href="{{ route('registration') }}">Registrati Adesso</a></p>
  <p class="link">Password dimenticata? <a href="{{ route('forget') }}">Resetta Password</a></p>
</form>
@endsection