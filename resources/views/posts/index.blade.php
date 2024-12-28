@extends('layouts.posts')

@section('css-script')
<title>Post</title>
<meta name="user-id" content="{{ Auth::id() }}">
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
<script src="{{ asset('js/posts.js') }}" defer></script>
@endsection

@section('Nav')
<form class="d-flex mx-auto" id="search-form">
    <input class="form-control me-2" type="search" id="search-input" placeholder="Cerca Post..." aria-label="Search">
    <button class="btn btn-outline-light" type="submit" id="search-button"><i class="fas fa-search"></i></button>
</form>
<ul class="navbar-nav ms-auto align-items-center">
    <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#createPostModal">Crea Post <i class="fas fa-plus-circle me-1"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('chats') }}">Messaggi <i class="fas fa-envelope me-1"></i> </a>
    </li>
    @section('Nav2')
    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Profilo</a></li>
    <li>
        <hr class="dropdown-divider">
    </li>
    @endsection
    @endsection

    @section('content')
    <main class="container-fluid mt-4">
        <div class="row">
            <aside class="col-md-3 mb-4" id="sidebar">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Filtra per Dipartimento</h5>
                    </div>
                    <div class="card-body p-3" id="faculty-filters">
                    </div>
                </div>
            </aside>

            <section class="col-md-9">
                <ul class="nav nav-tabs mb-4" id="postTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tutti-tab" data-bs-toggle="tab" data-bs-target="#tutti" type="button" role="tab" aria-controls="tutti" aria-selected="true">Tutti</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cerco-tab" data-bs-toggle="tab" data-bs-target="#cerco" type="button" role="tab" aria-controls="cerco" aria-selected="false">Cerco</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vendo-tab" data-bs-toggle="tab" data-bs-target="#vendo" type="button" role="tab" aria-controls="vendo" aria-selected="false">Vendo</button>
                    </li>
                </ul>
                <div class="tab-content" id="postTabContent">
                    <div class="tab-pane fade show active" id="tutti" role="tabpanel" aria-labelledby="tutti-tab">
                        <div class="post-container"></div>
                    </div>
                    <div class="tab-pane fade" id="cerco" role="tabpanel" aria-labelledby="cerco-tab">
                        <div class="post-container"></div>
                    </div>
                    <div class="tab-pane fade" id="vendo" role="tabpanel" aria-labelledby="vendo-tab">
                        <div class="post-container"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    @endsection