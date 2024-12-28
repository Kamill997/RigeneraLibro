<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>RigeneraLibro - Compravendita di libri universitari</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link href="{{ asset('css/home.css') }}" rel="stylesheet">
	<script src="{{ asset('js/index.js') }}" defer></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<a class="navbar-brand" href="#">

			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Nav" aria-controls="Nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="Nav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="#comeFunziona">Come funziona</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#contact">Contatti</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-primary text-white ms-2" href="{{ route('login') }}">Accedi/Registrati</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="side-btn">
		<a href="#" class="text-white">Inizia ora</a>
	</div>
	<header class="hero-section text-white text-center">
		<video autoplay muted loop id="hero-video">

		</video>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="hero-content">
						<h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Rigenera i tuoi libri universitari</h1>
						<p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Compra e vendi libri universitari usati in modo semplice e conveniente.</p>
						<div data-aos="fade-up" data-aos-delay="200">
							<a href="#" class="btn btn-primary btn-lg me-2">Inizia ora</a>
							<a href="#comeFunziona" class="btn btn-outline-light btn-lg">Scopri di più</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section id="features" class="py-5 my-5">
		<div class="container">
			<h2 class="text-center mb-5">Caratteristiche principali</h2>
			<div class="row">
				<div class="col-md-4 mb-4" data-aos="fade-up">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body text-center">
							<i class="bi bi-search text-primary display-4 mb-3"></i>
							<h3 class="h5 card-title">Ricerca facile</h3>
							<p class="card-text">Trova rapidamente i libri di cui hai bisogno filtrando i post per corso o utilizzando la barra di ricerca.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body text-center">
							<i class="bi bi-cash-coin text-primary display-4 mb-3"></i>
							<h3 class="h5 card-title">Risparmia denaro</h3>
							<p class="card-text">Acquista libri usati a prezzi convenienti e risparmia più del triplo rispetto al prezzo di listino.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body text-center">
							<i class="bi bi-shield-check text-primary display-4 mb-3"></i>
							<h3 class="h5 card-title">Transazioni sicure</h3>
							<p class="card-text">Effettua acquisti e vendite in tutta sicurezza organizzandoti con il venditore e programmando il ritiro a mano.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="comeFunziona" class="py-5 my-5 bg-light">
		<div class="container">
			<h2 class="text-center mb-5">Come funziona</h2>
			<div class="row">
				<div class="col-md-6 mb-4" data-aos="fade-right">

				</div>
				<div class="col-md-6" data-aos="fade-left">
					<div class="accordion" id="comeFunzionaStep">
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									1. Registrati gratuitamente
								</button>
							</h2>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#comeFunzionaStep">
								<div class="accordion-body">
									Crea un account gratuito su RigeneraLibro in pochi semplici passaggi.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									2. Cerca o inserisci annunci
								</button>
							</h2>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#comeFunzionaStep">
								<div class="accordion-body">
									Cerca i libri di cui hai bisogno o inserisci annunci per vendere i tuoi libri usati.
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									3. Concludi la transazione
								</button>
							</h2>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#comeFunzionaStep">
								<div class="accordion-body">
									Contatta il venditore o l'acquirente, organizza lo scambio e completa la transazione in sicurezza.
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="stats" class="py-5 my-5 bg-dark text-white">
		<div class="container">
			<h2 class="text-center mb-5">I nostri numeri</h2>
			<div class="row text-center">
				<div class="col-md-4 mb-4">
					<i class="bi bi-people display-4 mb-3"></i>
					<h3 class="counter" data-target="5000">0</h3>
					<p>Utenti attivi</p>
				</div>
				<div class="col-md-4 mb-4">
					<i class="bi bi-book display-4 mb-3"></i>
					<h3 class="counter" data-target="10000">0</h3>
					<p>Libri scambiati</p>
				</div>
				<div class="col-md-4 mb-4">
					<i class="bi bi-currency-euro display-4 mb-3"></i>
					<h3 class="counter" data-target="50000">0</h3>
					<p>Euro risparmiati</p>
				</div>
			</div>
		</div>
	</section>

	<section id="contact" class="py-5 my-5">
		<div class="container">
			<h2 class="text-center mb-5">Contattaci</h2>
			<div id="Message" class="mt-3 d-flex justify-content-center"></div>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<form action=" {{ route('contact') }}" method="POST" id="contact" data-aos="fade-up">
						@csrf
						<div class="mb-3">
							<label for="name" class="form-label">Nome</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
						<div class="mb-3">
							<label for="message" class="form-label">Messaggio</label>
							<textarea class="form-control" id="message" name="message" rows="5" required></textarea>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg">Invia messaggio</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<footer class="bg-dark text-light py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-4 mb-3">
					<h5>RigeneraLibro</h5>
					<p>Il tuo marketplace per la compravendita di libri universitari.</p>
				</div>
				<div class="col-md-4 mb-3">
					<h5>Link utili</h5>
					<ul class="list-unstyled">
						<li><a href="#" class="text-light">Chi siamo</a></li>
						<li><a href="#" class="text-light">FAQ</a></li>
						<li><a href="#" class="text-light">Termini e condizioni</a></li>
						<li><a href="#" class="text-light">Privacy Policy</a></li>
					</ul>
				</div>
				<div class="col-md-4 mb-3">
					<h5>Seguici</h5>
					<a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
					<a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
					<a href="#" class="text-light me-2"><i class="bi bi-twitter"></i></a>
					<a href="#" class="text-light"><i class="bi bi-linkedin"></i></a>
				</div>
			</div>
			<hr class="mt-4 mb-3">
			<p class="text-center mb-0">&copy; {{ date('Y') }} RigeneraLibro. Tutti i diritti riservati.</p>
		</div>
	</footer>
</body>

</html>