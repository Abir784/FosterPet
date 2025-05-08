<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Make a Donation - FosterPet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Georgia', serif;
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

    .card {
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border: none;
    }

    .card-header {
      background-color: #2c3e50;
      color: white;
    }

    .form-label {
      font-weight: 500;
    }

    .input-group-text {
      background-color: #2c3e50;
      color: white;
      border: none;
    }

    .form-control:focus {
      border-color: #2c3e50;
      box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    }
  </style>
</head>

<body>
  <section class="bg-light text-center py-5">
    <div class="container">
      <h2 class="section-title mb-4">Make a Donation</h2>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <h2 class="h4 mb-0">Donation Details</h2>
            </div>
            <div class="card-body">
              <form action="{{ route('donations.store') }}" method="POST" id="donationForm">
                @csrf

                <div class="mb-3">
                  <label for="pet_id" class="form-label">Donation For</label>
                  <select class="form-select" id="pet_id" name="pet_id">
                    <option value="">General Support (No Specific Pet)</option>
                    @foreach($pets as $petOption)
                      <option value="{{ $petOption->id }}">{{ $petOption->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="amount" class="form-label">Donation Amount</label>
                  @if ($errors->has('amount'))
                    <div class="alert alert-danger">
                        {{ $errors->first('amount') }}
                    </div>
                  @endif
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                           id="amount" name="amount" min="1" step="0.01" required 
                           value="{{ old('amount') }}">
                    @error('amount')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="mb-3">
                  <label for="donation_type" class="form-label">Donation Type</label>
                  @if ($errors->has('donation_type'))
                    <div class="alert alert-danger">
                        {{ $errors->first('donation_type') }}
                    </div>
                  @endif
                  <select class="form-select @error('donation_type') is-invalid @enderror" id="donation_type" name="donation_type" required>
                    <option value="one-time">One-time Donation</option>
                    <option value="monthly">Monthly Donation</option>
                  </select>
                </div>

                <div class="mb-3" id="monthlyDuration" style="display: none;">
                  <label for="duration" class="form-label">Duration (months)</label>
                  <select class="form-select" id="duration" name="duration">
                    <option value="1">1 month</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="12">12 months</option>
                  </select>
                </div>

                @if ($errors->has('purpose'))
                    <div class="alert alert-danger">
                        {{ $errors->first('purpose') }}
                    </div>
                @endif
                <div class="mb-3">
                  <label for="purpose" class="form-label">Purpose</label>
                  <select class="form-select @error('purpose') is-invalid @enderror" 
                          id="purpose" name="purpose" required>
                    <option value="">Select Purpose</option>
                    <option value="food" {{ old('purpose') == 'food' ? 'selected' : '' }}>Food</option>
                    <option value="medical" {{ old('purpose') == 'medical' ? 'selected' : '' }}>Medical Expenses</option>
                    <option value="general" {{ old('purpose') == 'general' ? 'selected' : '' }}>General Care</option>
                  </select>
                  @error('purpose')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                @if ($errors->has('payment_method'))
                    <div class="alert alert-danger">
                        {{ $errors->first('payment_method') }}
                    </div>
                @endif
                <div class="mb-3">
                  <label for="payment_method" class="form-label">Payment Method</label>
                  <select class="form-select @error('payment_method') is-invalid @enderror" 
                          id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="direct" {{ old('payment_method') == 'direct' ? 'selected' : '' }}>Direct</option>
                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                  </select>
                  @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                @if ($errors->has('donor_name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('donor_name') }}
                    </div>
                @endif
                <div class="mb-3">
                  <label for="donor_name" class="form-label">Your Name</label>
                  <input type="text" class="form-control @error('donor_name') is-invalid @enderror" 
                         id="donor_name" name="donor_name" required 
                         value="{{ old('donor_name') }}">
                  @error('donor_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                @if ($errors->has('donor_email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('donor_email') }}
                    </div>
                @endif
                <div class="mb-3">
                  <label for="donor_email" class="form-label">Your Email</label>
                  <input type="email" class="form-control @error('donor_email') is-invalid @enderror" 
                         id="donor_email" name="donor_email" required 
                         value="{{ old('donor_email') }}">
                  @error('donor_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-yellow">
                    <i class="fas fa-credit-card me-2"></i>Proceed to Payment
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle donation type change
      const donationTypeSelect = document.getElementById('donation_type');
      const monthlyDurationDiv = document.getElementById('monthlyDuration');

      donationTypeSelect.addEventListener('change', function() {
        if (this.value === 'monthly') {
          monthlyDurationDiv.style.display = 'block';
        } else {
          monthlyDurationDiv.style.display = 'none';
        }
      });

      // Initialize duration visibility based on initial value
      if (donationTypeSelect.value === 'monthly') {
        monthlyDurationDiv.style.display = 'block';
      }
    });
  </script>
</body>
</html>
