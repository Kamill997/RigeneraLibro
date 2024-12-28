@extends('layouts.posts')

@section('css-script')
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<script src="{{ asset('js/profile.js') }}" defer></script>
<style>

</style>
@endsection

@section('Nav')
<ul class="navbar-nav ms-auto align-items-center">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('posts') }}">Torna ai Post <i class="fas fa-arrow-circle-left"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('chats') }}">Messaggi <i class="fas fa-envelope me-1"></i></a>
    </li>
    @endsection

    @section('content')
    <div class="container ">
        <div class="profile-container">
            <div class="row" id="profile">
                <div class="col-md-4 text-center profile-info" id="info">
                    <div class="profile-img-container">
                        <img src="{{ $user->immagine_user->path }}"
                            alt="Profile img"
                            class="profile-img"
                            id="profile_img">
                    </div>
                    <div class="username">{{ $user->username }}</div>
                </div>
                <div class="col-md-8 profile-info">
                    <div class="user-data-header">
                        <h2 class="profile-header text-center">Dati Utente</h2>
                    </div>
                    <div id="userDataDisplay" class="profile-info-grid">
                        <div class="info-item text-center">
                            <label>Nome</label>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-item text-center mt-4">
                            <label>Cognome</label>
                            <div class="info-value">{{ $user->lastName }}</div>
                        </div>
                        <div class="info-item text-center mt-4">
                            <label>Email</label>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>
                    <form id="userDataForm" style="display: none;">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="{{ $user->lastName }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nuova Password (lascia vuoto se non vuoi cambiarla)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Aggiorna informazioni</button>
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">Annulla</button>
                    </form>
                </div>
            </div>
            <div class="row" id="show-post">
                <div class="col-12 mb-3">
                    <ul class="nav nav-tabs" id="tab">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-tab="miei-post" id="miei-post">Miei Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-tab="salvati" id="salvati">Salvati <i class='fas fa-bookmark'></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="row post-container" id="posts-container">

                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button id="load-more" class="btn btn-primary">Carica altri</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection