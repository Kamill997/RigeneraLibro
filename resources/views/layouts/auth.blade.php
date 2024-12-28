<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel='stylesheet' href="{{ asset('css/registration.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</head>

<body>
    <article class="Contenitore">
        <section class="pick">
        </section>

        <section class="Credenziali">
            @yield('content')
        </section>
    </article>
</body>

</html>