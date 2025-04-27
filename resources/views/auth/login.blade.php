<div class="login-container">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h2>Log In to FosterPet</h2>
    <form id="loginForm" action="{{ route('login') }}"  method="POST">

        @csrf
      <div class="form-group">
        <label for="email">Email Address:</label>
        <input  name="email" :value="old('email')" type="email" id="email"  required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"  required>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

      </div>
      <button type="submit" class="login-button">Log In</button>
    </form>
    <p class="forgot-password"><a href="{{ route('password.request') }}">Forgot your password?</a></p>
    <p class="register-link">Don't have an account? <a href="{{route('register')}}">Register here</a></p>
  </div>

  <style>
    body {
      font-family: 'Open Sans', sans-serif; /* Or Arial, Helvetica */
      background-color: #f8f8f8; /* Light grey background for the page */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .login-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 5px; /* Subtle rounded corners if desired */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
      width: 90%;
      max-width: 400px;
    }

    h2 {
      color: #333; /* Dark grey heading */
      text-align: center;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #555; /* Medium grey label text */
      font-weight: bold;
    }

    input[type="email"],
    input[type="password"] {
      width: calc(100% - 22px);
      padding: 10px;
      border: 1px solid #ccc; /* Light grey border */
      border-radius: 3px; /* Slight rounding */
      box-sizing: border-box;
      font-size: 16px;
    }

    .login-button {
      background-color: #ffc107; /* FosterPet yellow */
      color: #000; /* Black text */
      padding: 12px 20px;
      border: none;
      border-radius: 5px; /* Slight rounding */
      cursor: pointer;
      font-size: 18px;
      width: 100%;
      display: block;
      text-align: center;
    }

    .login-button:hover {
      background-color: #e0a800; /* Darker yellow on hover */
    }

    .register-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
      color: #777;
    }

    .forgot-password {
      text-align: center;
      margin-top: 10px;
      font-size: 0.9em;
      color: #007bff;
    }
  </style>
