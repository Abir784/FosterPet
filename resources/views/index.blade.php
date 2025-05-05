<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FosterPet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
  </style>
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
          <li class="nav-item"><a class="nav-link" href="#fostering">Fostering</a></li>
          <li class="nav-item"><a class="nav-link" href="#pets">Pets</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

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

  <!-- Hero Section -->
  <section class="hero-section d-flex align-items-center">
    <div class="overlay"></div>
    <div class="container text-white hero-content">
      <h1 class="display-4 fw-bold">Give a Pet a Second Chance</h1>
      <p class="lead mt-3">Open your heart and home to a pet in need. Fostering saves lives and brings joy.</p>
      <a class="btn btn-outline-warning mt-3" href="#">Foster Now</a>
    </div>
  </section>

  <!-- About Us -->
  <section id="about" class="bg-light text-center">
    <div class="container">
      <h2 class="section-title">About Us</h2>
      <p class="lead">We’re dedicated to rescuing, fostering, and finding forever homes for abandoned animals. Join our mission to make tails wag again!</p>
    </div>
  </section>

  <!-- Adoption Process -->
  <section id="adoption" class="text-center">
    <div class="container">
      <h2 class="section-title">Adoption Process</h2>
      <div class="row">
        <div class="col-md-4">
          <h4>1. Meet</h4>
          <p>Visit pets in our care to find your match.</p>
        </div>
        <div class="col-md-4">
          <h4>2. Apply</h4>
          <p>Submit a simple form and let us guide you.</p>
        </div>
        <div class="col-md-4">
          <h4>3. Home Visit</h4>
          <p>We ensure your home is ready for your new friend.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Fostering Process -->
  <section id="fostering" class="bg-light text-center">
    <div class="container">
      <h2 class="section-title">Fostering Process</h2>
      <p class="lead">Foster a pet temporarily and change a life forever. We’ll support you every step of the way.</p>
      <a class="btn btn-yellow mt-3" href="#">Become a Foster</a>
    </div>
  </section>

  <!-- Featured Pets -->
  <section id="pets" class="text-center">
    <div class="container">
      <h2 class="section-title">Featured Pets</h2>
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="https://placekitten.com/400/250" class="card-img-top" alt="Cute cat" />
            <div class="card-body">
              <h5 class="card-title">Milo</h5>
              <p class="card-text">A playful 2-year-old tabby looking for a loving home.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="https://placedog.net/400/250?id=1" class="card-img-top" alt="Happy dog" />
            <div class="card-body">
              <h5 class="card-title">Bella</h5>
              <p class="card-text">A gentle Labrador who loves cuddles and walks.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="https://placekitten.com/400/251" class="card-img-top" alt="Another cat" />
            <div class="card-body">
              <h5 class="card-title">Luna</h5>
              <p class="card-text">Quiet and sweet, Luna is a perfect lap companion.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="bg-light text-center">
    <div class="container">
      <h2 class="section-title">What People Say</h2>
      <div class="row justify-content-center">
        <div class="col-md-6 testimonial">
          <p>“Fostering with FosterPet was a life-changing experience. They supported me from day one, and now I can’t imagine life without Max!”</p>
          <p><strong>- Sarah M.</strong></p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="text-center">
    <div class="container">
      <h2 class="section-title">Frequently Asked Questions</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer1">
              What’s the difference between fostering and adoption?
            </button>
          </h2>
          <div id="answer1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">Fostering is temporary care, while adoption is permanent. Both change lives!</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer2">
              Do I need pet experience to foster?
            </button>
          </h2>
          <div id="answer2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">Nope! We guide and support all our fosters, new or experienced.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-warning text-center text-dark">
    <div class="container">
      <h2 class="section-title">Stay in the Loop</h2>
      <p class="lead">Get updates on new pets, events, and tips. No spam, just cuteness.</p>
      <form class="row justify-content-center">
        <div class="col-md-4 mb-2">
          <input type="email" class="form-control" placeholder="Your Email" />
        </div>
        <div class="col-md-2 mb-2">
          <button type="submit" class="btn btn-dark w-100">Subscribe</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="text-center">
    <div class="container">
      <h2 class="section-title">Contact Us</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form>
            <input type="text" class="form-control mb-3" placeholder="Your Name" />
            <input type="email" class="form-control mb-3" placeholder="Your Email" />
            <textarea class="form-control mb-3" rows="4" placeholder="Your Message"></textarea>
            <button type="submit" class="btn btn-yellow">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center">
    <div class="container">
      <p>&copy; 2025 FosterPet. All rights reserved.</p>
      <a href="#" class="text-white me-3">Privacy Policy</a>
      <a href="#" class="text-white">Terms</a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
