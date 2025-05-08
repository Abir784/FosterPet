<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>FosterPet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Georgia', serif;
    }

    .hero-section {
      background: url('https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=1600&q=80') no-repeat center center/cover;
      height: 100vh;
      position: relative;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      top: 50%;
      transform: translateY(-50%);
    }

    .btn-yellow {
      background-color: #FFD700;
      color: black;
      font-weight: 600;
    }

    .btn-yellow:hover {
      background-color: #e6c200;
    }

    section {
      padding: 80px 0;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 30px;
    }

    footer {
      background: #222;
      color: #fff;
      padding: 30px 0;
    }

    .testimonial {
      font-style: italic;
      background-color: #f9f9f9;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    /* Enhanced card styles */
    .allocation-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .allocation-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .allocation-card .card-body {
      padding: 1.25rem;
      background: linear-gradient(to right bottom, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
    }

    /* Progress bar animations */
    .progress-bar-animated {
      animation: progress-bar-stripes 1s linear infinite;
    }

    .progress-bar-custom {
      animation: growWidth 1.5s ease-out forwards;
      transform-origin: left;
    }

    @keyframes growWidth {
      from { width: 0; }
      to { width: var(--final-width); }
    }

    /* Donation impact section */
    .donation-impact-section {
      position: relative;
      padding: 2rem 0;
    }

    .donation-impact-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(240,240,240,0.6) 0%, rgba(255,255,255,0.9) 100%);
      z-index: -1;
    }

    .chart-container {
      position: relative;
      margin: 0 auto;
      height: 250px;
      width: 250px;
    }

    /* Type icons */
    .type-icon {
      font-size: 1.5rem;
      margin-right: 0.5rem;
      opacity: 0.8;
    }

    /* Pet cards animation */
    .card {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s ease;
    }

    .card.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get all pet cards
      const cards = document.querySelectorAll('.card');

      // Function to check if element is in viewport
      function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
          rect.top >= 0 &&
          rect.left >= 0 &&
          rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
          rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
      }

      // Function to handle scroll
      function handleScroll() {
        cards.forEach(card => {
          if (isInViewport(card)) {
            card.classList.add('visible');
          }
        });
      }

      // Initial check
      handleScroll();

      // Add scroll event listener
      window.addEventListener('scroll', handleScroll);
    });
  </script>
</head>
<body>



  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark bg-opacity-50">
    <div class="container">
      <a class="navbar-brand" href="#">Foster<span style="font-style: italic;">Pet</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="#adoption">Adoption</a></li>
          <li class="nav-item">
            <a class="nav-link" href="#fostering">Fostering</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#donations"><i class="fas fa-gift"></i> Donations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pets">Pets</a></li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>

            <li class="nav-item">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="btn btn-yellow"   >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}" class="btn btn-yellow"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="btn btn-yellow">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
      </li>
        </ul>
      </div>
    </div>
  </nav>
<br>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 mb-0">Pet Details</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Pet Image -->
                            <div class="col-md-4">
                                @if($pet->image)
                                    <img src="{{ asset($pet->image) }}"
                                         alt="{{ $pet->name }}"
                                         class="img-fluid rounded mb-3"
                                         style="max-height: 400px; object-fit: contain;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                        <i class="fas fa-paw fa-5x text-secondary"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Pet Information -->
                            <div class="col-md-8">
                                <h3 class="h4 mb-4">{{ $pet->name }}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Breed:</strong> {{ $pet->breed }}</li>
                                            <li class="list-group-item"><strong>Age:</strong> {{ $pet->age }} years</li>
                                            <li class="list-group-item"><strong>Gender:</strong> {{ $pet->gender }}</li>
                                            <li class="list-group-item"><strong>Type:</strong> {{ $pet->type }}</li>
                                            <li class="list-group-item"><strong>Location:</strong> {{ $pet->location }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Color:</strong> {{ $pet->color }}</li>
                                            <li class="list-group-item"><strong>Health Condition:</strong> {{ $pet->health_condition }}</li>
                                            <li class="list-group-item"><strong>Temperament:</strong> {{ $pet->temperament }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($pet->description)
                                    <div class="mt-4">
                                        <h4>Description</h4>
                                        <p>{{ $pet->description }}</p>
                                    </div>
                                @endif

                                <!-- Adoption Button -->
                                @auth
                                    @if(auth()->user()->role === 'adopter')
                                        <div class="d-grid gap-2">
                                            <form action="{{ route('adoption.request', $pet->id) }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="adoption_id" value="{{ $pet->adoption->id }}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paw me-2"></i> Request to Adopt
                                                </button>
                                            </form>
                                            <a href="{{ route('donations.create', $pet) }}" class="btn btn-success">
                                                <i class="fas fa-heart me-2"></i> Sponsor This Pet
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                                @guest
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('login') }}" class="btn btn-secondary">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login to Adopt
                                        </a>

                                        <a href="{{ url('/') }}" class="btn btn-primary">
                                             Back to Home
                                        </a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
