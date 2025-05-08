<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Successful - Foster Pet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold text-success mb-8">Donation Successful!</h1>
                <div class="flex justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-lg mb-8">
                    <p class="mb-4">Your generous contribution of <span class="font-bold">${{ number_format($donation->amount, 2) }}</span> will help make a difference.</p>
                    @if($donation->pet_id)
                        <p class="mb-4">Your donation will support: <span class="font-bold">{{ $donation->pet->name }}</span></p>
                    @endif
                    <p class="mb-4">Transaction ID: <span class="font-bold">{{ $donation->transaction_id }}</span></p>
                    <p>A confirmation email has been sent to: <span class="font-bold">{{ $donation->donor_email }}</span></p>
                </div>
                <div class="alert alert-info mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Please keep this transaction ID for your records.</span>
                </div>
                <div class="flex justify-center gap-4">
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
