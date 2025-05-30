<div class="registration-container">
    <h2>Create Your Account</h2>
    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

      <div class="form-group">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="name" :value="old('name')"  required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

      </div>
      <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="name" :value="old('email')"  required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword"  name="password_confirmation" required>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

      </div>
      <div class="form-group">
        <label for="type">Account Type (Optional):</label>
        <select name="type" id="type" class="custom-select">
          <option value="pet owner">Pet Owner</option>
          <option value="pet shelter">Pet Shelter</option>
        </select>
      </div>

      <div class="form-group">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the <a href="#" style="color: #007bff;">Terms and Conditions</a></label>
      </div>
      <button type="submit" class="register-button">Register</button>
    </form>
    <p class="login-link">Already have an account? <a href="#" style="color: #007bff;">Log in</a></p>
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

    .registration-container {
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

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      width: calc(100% - 22px);
      padding: 10px;
      border: 1px solid #ccc; /* Light grey border */
      border-radius: 3px; /* Slight rounding */
      box-sizing: border-box;
      font-size: 16px;
    }

    .register-button {
      background-color: #ffc107; /* FosterPet yellow */
      color: #000; /* Black text */
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 18px;
      width: 100%;
      display: block;
      text-align: center;
    }

    .register-button:hover {
      background-color: #e0a800; /* Darker yellow on hover */
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
      color: #777;
    }

    .custom-select {
  width: calc(100% - 22px);
  padding: 10px;
  border: 1px solid #ccc; /* Light grey border */
  border-radius: 3px; /* Slight rounding */
  box-sizing: border-box;
  font-size: 16px;
  background-color: #fff; /* White background for the dropdown */
  color: #333; /* Dark grey text */
  cursor: pointer;
  appearance: none; /* Remove default styling for consistency */
}

.custom-select:focus {
  outline: none; /* Remove default focus outline */
  border-color: #007bff; /* Highlight border on focus */
}

  </style>

