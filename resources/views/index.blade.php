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

  <!-- Hero Section -->
  <section class="hero-section d-flex align-items-center">
    <div class="overlay"></div>
    <div class="container text-white hero-content">
      <h1 class="display-4 fw-bold">Give a Pet a Second Chance</h1>
      <p class="lead mt-3">Open your heart and home to a pet in need. Fostering saves lives and brings joy.</p>
    </div>
  </section>
  <!-- About Us -->
  <section id="about" class="bg-light text-center">
    <div class="container">
      <h2 class="section-title">About Us</h2>
      <p class="lead">We’re dedicated to rescuing, fostering, and finding forever homes for abandoned animals. Join our mission to make tails wag again!</p>
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

  <!-- Featured Pets Section -->
  <section id="featured-pets" class="text-center">
    <div class="container">
      <h2 class="section-title">Featured Pets</h2>
      <div class="row">
        @foreach($pets as $pet)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              @if($pet->image)
                <img src="{{ asset($pet->image) }}" class="card-img-top" alt="{{ $pet->name }}" style="height: 200px; object-fit: cover;">
              @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                  <i class="fas fa-paw fa-3x text-secondary"></i>
                </div>
              @endif
              <div class="card-body">
                <h5 class="card-title"><a href="{{ route('pet.show', $pet->id) }}" class="text-dark text-decoration-none">{{ $pet->name }}</a></h5>
                <p class="card-text">
                  <strong>Breed:</strong> {{ $pet->breed }}<br>
                  <strong>Age:</strong> {{ $pet->age }} years<br>
                  <strong>Location:</strong> {{ $pet->location }}
                </p>
                <a href="{{ route('pet.show', $pet->id) }}" class="btn btn-outline-primary w-100 mb-2">
                  <i class="fas fa-info-circle me-2"></i> View Details
                </a>
                @auth
                  @if(auth()->user()->role === 'adopter')
                    <form action="{{ route('adoption.request', $pet->id) }}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="adoption_id" value="{{ $pet->adoption->id }}">
                      <button type="submit" class="btn btn-primary">Request to Adopt</button>
                    </form>
                  @endif
                @endauth
                @guest
                  <a href="{{ route('login') }}" class="btn btn-secondary">Login to Adopt</a>
                @endguest
              </div>
            </div>
          </div>
        @endforeach
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
  <!-- Donation Section -->
  <section id="donations" class="bg-light text-center py-5">
    <div class="container">
      <h2 class="section-title mb-4">Support Our Mission</h2>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="mb-4">Make a Donation</h3>
                  <p class="lead mb-4">Your support helps us provide better care for our furry friends. Every donation makes a difference!</p>
                  <div class="d-grid gap-3">
                    <a href="{{ route('donations.create') }}" class="btn btn-yellow btn-lg">
                      <i class="fas fa-heart me-2"></i>Make a Donation
                    </a>
                    <a href="{{ route('donations.create') }}" class="btn btn-outline-warning btn-lg">
                      <i class="fas fa-paw me-2"></i>Sponsor a Pet
                    </a>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="donation-stats text-center">
                    <div class="row">
                      <div class="col-4">
                        <div class="stat-item">
                          <i class="fas fa-dollar-sign text-warning mb-2"></i>
                          <h3>{{ number_format($totalDonations) }}</h3>
                          <p class="text-muted mb-0">Total Donated</p>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="stat-item">
                          <i class="fas fa-paw text-warning mb-2"></i>
                          <h3>{{ number_format($totalAllocations) }}</h3>
                          <p class="text-muted mb-0">Allocated Funds</p>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="stat-item">
                          <i class="fas fa-chart-pie text-warning mb-2"></i>
                          <h3>{{ count($allocationTypes) }}</h3>
                          <p class="text-muted mb-0">Allocation Types</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>
  <section id="donations" class="text-center donation-impact-section">
    <div class="container">
      <h2 class="section-title">Donation Impact</h2>
      <div class="row justify-content-center mb-5">
        <div class="col-md-8">
          <p class="lead">Your generosity helps us provide better care for our furry friends.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm allocation-card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-gift fa-3x text-primary"></i>
              </div>
              <h3 class="card-title h4">Total Donations</h3>
              <div class="display-4 fw-bold text-success mb-3">
                ${{ number_format($totalDonations, 2) }}
              </div>
              <p class="card-text text-muted">Received from our generous supporters</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm allocation-card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-chart-pie fa-3x text-primary"></i>
              </div>
              <h3 class="card-title h4">Allocated Funds</h3>
              <div class="display-4 fw-bold text-success mb-3">
                ${{ number_format($totalAllocations, 2) }}
              </div>
              <p class="card-text text-muted">Distributed to various pet care needs</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Donation Allocation Visualization -->
      <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
          <div class="card border-0 shadow-sm allocation-card">
            <div class="card-body">
              <h4 class="mb-4">Donation Allocation Visualization</h4>

              <div class="row align-items-center">
                <!-- Donut Chart -->
                <div class="col-md-5">
                  <div class="chart-container">
                    <canvas id="donationChart"></canvas>
                  </div>
                </div>

                <!-- Overall Progress -->
                <div class="col-md-7 text-start">
                  <h5 class="mb-3">Overall Allocation Progress</h5>
                  <div class="progress mb-3" style="height: 25px;">
                    @php
                      $percentage = $totalDonations > 0 ? ($totalAllocations / $totalDonations) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         style="width: {{ $percentage }}%"
                         aria-valuenow="{{ $percentage }}"
                         aria-valuemin="0"
                         aria-valuemax="100">
                      {{ number_format($percentage, 1) }}% Allocated
                    </div>
                  </div>
                  <p class="text-muted">We strive to allocate all donations efficiently to help as many animals as possible.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Allocation Types Breakdown -->
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card border-0 shadow-sm allocation-card">
            <div class="card-body">
              <h4 class="mb-4">Allocation Breakdown</h4>
              <div class="row">
                @forelse($allocationTypes as $type => $amount)
                  @php
                    // Determine icon and color based on allocation type
                    $icon = 'paw';
                    $color = 'primary';

                    if (strpos($type, 'medical') !== false || strpos($type, 'health') !== false) {
                      $icon = 'stethoscope';
                      $color = 'danger';
                    } elseif (strpos($type, 'food') !== false || strpos($type, 'nutrition') !== false) {
                      $icon = 'utensils';
                      $color = 'success';
                    } elseif (strpos($type, 'shelter') !== false || strpos($type, 'housing') !== false) {
                      $icon = 'home';
                      $color = 'info';
                    } elseif (strpos($type, 'rescue') !== false) {
                      $icon = 'life-ring';
                      $color = 'warning';
                    } elseif (strpos($type, 'training') !== false || strpos($type, 'education') !== false) {
                      $icon = 'graduation-cap';
                      $color = 'secondary';
                    } elseif (strpos($type, 'transport') !== false) {
                      $icon = 'truck';
                      $color = 'dark';
                    }

                    $typePercentage = $totalAllocations > 0 ? ($amount / $totalAllocations) * 100 : 0;
                  @endphp
                  <div class="col-md-6 mb-3">
                    <div class="card border-0 allocation-card">
                      <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <div>
                            <i class="fas fa-{{ $icon }} type-icon text-{{ $color }}"></i>
                            <span class="fw-bold text-capitalize">{{ str_replace('_', ' ', $type) }}</span>
                          </div>
                          <span class="badge bg-{{ $color }} px-3 py-2">${{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                          <div class="progress-bar progress-bar-custom bg-{{ $color }}" role="progressbar"
                               style="--final-width: {{ $typePercentage }}%;"
                               aria-valuenow="{{ $typePercentage }}"
                               aria-valuemin="0"
                               aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                          <small class="text-muted">{{ number_format($typePercentage, 1) }}% of total allocations</small>
                          <small class="text-{{ $color }}"><i class="fas fa-chart-line"></i></small>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="col-12 text-center">
                    <p class="text-muted">No allocations have been made yet.</p>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Initialization Script -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get allocation data from PHP
        const allocationData = {
          @foreach($allocationTypes as $type => $amount)
            '{{ str_replace('_', ' ', $type) }}': {{ $amount }},
          @endforeach
        };

        // Set up colors for chart
        const backgroundColors = [
          '#dc3545', // danger
          '#28a745', // success
          '#17a2b8', // info
          '#ffc107', // warning
          '#6c757d', // secondary
          '#343a40', // dark
          '#007bff'  // primary
        ];

        // Create the chart
        const ctx = document.getElementById('donationChart').getContext('2d');
        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: Object.keys(allocationData),
            datasets: [{
              data: Object.values(allocationData),
              backgroundColor: backgroundColors,
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right',
                labels: {
                  boxWidth: 15,
                  font: {
                    size: 12
                  }
                }
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const label = context.label || '';
                    const value = context.raw;
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = Math.round((value / total) * 100);
                    return `${label}: $${value.toFixed(2)} (${percentage}%)`;
                  }
                }
              }
            },
            cutout: '70%',
            animation: {
              animateScale: true,
              animateRotate: true
            }
          }
        });
      });
    </script>
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

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
