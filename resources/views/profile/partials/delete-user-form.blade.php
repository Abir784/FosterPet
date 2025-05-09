<section class="bg-white rounded-lg shadow-lg p-6 border-start border-5 border-danger">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-danger mb-2 d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Delete Account') }}
        </h2>
        <p class="text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" 
           class="btn btn-danger d-flex align-items-center"
           data-bs-toggle="modal" 
           data-bs-target="#confirmUserDeletion">
        <i class="fas fa-trash-alt me-2"></i>{{ __('Delete Account') }}
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Confirm Account Deletion') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-circle text-danger fa-3x mb-3"></i>
                            <h4 class="text-danger">{{ __('Are you sure you want to delete your account?') }}</h4>
                            <p class="text-muted">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-lock me-1"></i>{{ __('Confirm Password') }}
                            </label>
                            <input type="password" 
                                   id="password"
                                   name="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   required
                                   placeholder="{{ __('Enter your current password') }}">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>{{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>{{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
