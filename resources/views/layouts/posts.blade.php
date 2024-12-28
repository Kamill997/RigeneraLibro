<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/post_layout.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @yield('css-script')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark w-100">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('posts') }}">RigeneraLibro</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    @yield('Nav')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @yield('Nav2')
                            <li><a class="dropdown-item" href="#" id="logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Crea Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" id="createPostForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Stai cercando dei libri o vuoi vendere?</label>
                            <select name="tipo" id="tipo" class="form-select" onchange="VendoCerco()">
                                <option value="cerco">Cerco</option>
                                <option value="vendo">Vendo</option>
                            </select>
                        </div>

                        <div class="mb-3 titolo ">
                            <label class="form-label">Inserisci il titolo del tuo post:</label>
                            <div class="d-flex"><span></span></div>
                            <input type="text" class="form-control" id="titolo" name="titolo" placeholder="Sono alla ricerca di questo libro...">
                        </div>

                        <div class="mb-3 descrizione ">
                            <label class="form-label">Inserisci una descrizione per il tuo post:</label>
                            <div class="d-flex"><span></span></div>
                            <textarea class="form-control errore" id="descrizione" name="descrizione" rows="3" placeholder="Cerco il seguente libro per il mio corso..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Inserisci per quale corso di studi</label>
                            <select name="id_corso" id="id_corso" class="form-select">
                            </select>
                        </div>

                        <div id="vendita" class="d-none">
                            <div class="mb-3 immagini ">
                                <label class="form-label">Inserisci un'immagine del tuo prodotto:</label>
                                <div class="d-flex"><span></span></div>
                                <input type="file" class="form-control" id="immagini" name="immagini[]" multiple required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Inserisci in che condizioni si trova il prodotto:</label>
                                <select name="condizione" id="condizione" class="form-select">
                                    <option value="Nuovo">Nuovo</option>
                                    <option value="Buone Condizioni">Buone Condizioni</option>
                                    <option value="Poco Usato">Poco Usato</option>
                                    <option value="Pessime Condizioni">Pessime Condizioni</option>
                                </select>
                            </div>

                            <div class="mb-3 prezzo ">
                                <label class="form-label">Inserisci il prezzo del prodotto:</label>
                                <div class="d-flex"><span></span></div>
                                <input type="text" class="form-control" id="prezzo" name="prezzo" placeholder="Es. €12">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            <button type="submit" class="btn btn-primary">Pubblica Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>