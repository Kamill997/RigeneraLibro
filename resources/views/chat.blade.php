@extends('layouts.posts')

<title>Messaggi</title>
<meta name="user-id" content="{{ Auth::id() }}">
@section('css-script')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@vite(['resources/js/app.js'])
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('Nav')
<ul class="navbar-nav ms-auto align-items-center">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('posts') }}">Torna ai Post <i class="fas fa-arrow-circle-left"></i></a>
    </li>
    @section('Nav2')
    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Profilo</a></li>
    <li>
        <hr class="dropdown-divider">
    </li>
    @endsection
    @endsection

    @section('content')
    <section>
        <div class="chat-container">
            <div class="row g-0">
                <div class="col-md-4 col-lg-3 chat-sidebar">
                    <div class="p-3">
                        <h4>Chats</h4>
                    </div>
                    <div class="chat-list" id="chat-list">

                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="chat-header">
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="chat-messages" id="messages" data-receiver-id="{{ $lastChat ?? '' }}" data-chat-username="{{ $chatUsername ?? '' }}"
                        data-is-new-chat="{{ $newchat ?? 'false' }}"
                        data-no-chats="{{ $noChats ?? 'false' }}">

                    </div>
                    <div class="chat-input">
                        <form id="message-form">
                            <div class="input-group">
                                <input type="text" id="messageInput" name="message" class="form-control" placeholder="Scrivi un messaggio..." required>
                                <button class="btn btn-primary" type="submit" id="send">Invia</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection