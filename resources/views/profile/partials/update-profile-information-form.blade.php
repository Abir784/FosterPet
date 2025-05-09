<section class="bg-white rounded-lg shadow-lg p-6">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            <i class="fas fa-user me-2"></i>{{ __('Profile Information') }}
        </h2>
        <p class="text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name" class="form-label fw-bold mb-2">
                <i class="fas fa-user me-1"></i>{{ __('Name') }}
            </label>
            <input id="name" 
                   name="name" 
                   type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $user->name) }}" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label fw-bold mb-2">
                <i class="fas fa-envelope me-1"></i>{{ __('Email') }}
            </label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $user->email) }}" 
                   required 
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" 
                            class="btn btn-link text-warning p-0 ms-1 text-decoration-none border-bottom border-warning">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-2 alert alert-success mb-0">
                            <i class="fas fa-check me-2"></i>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-4 d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>{{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="ms-3 alert alert-success d-inline-flex align-items-center mb-0 py-2"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)">
                    <i class="fas fa-check me-2"></i>{{ __('Profile Updated Successfully!') }}
                </div>
            @endif
        </div>
    </form>
</section>
