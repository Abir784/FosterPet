<section class="bg-white rounded-lg shadow-lg p-6">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            <i class="fas fa-key me-2"></i>{{ __('Update Password') }}
        </h2>
        <p class="text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label fw-bold mb-2">
                <i class="fas fa-lock me-1"></i>{{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" 
                   name="current_password" 
                   type="password" 
                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="current-password"
                   required>
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label fw-bold mb-2">
                <i class="fas fa-key me-1"></i>{{ __('New Password') }}
            </label>
            <input id="update_password_password" 
                   name="password" 
                   type="password" 
                   class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password"
                   required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="form-label fw-bold mb-2">
                <i class="fas fa-check-double me-1"></i>{{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password"
                   required>
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4 d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>{{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div class="ms-3 alert alert-success d-inline-flex align-items-center mb-0 py-2"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)">
                    <i class="fas fa-check me-2"></i>{{ __('Password Updated Successfully!') }}
                </div>
            @endif
        </div>
    </form>
</section>
