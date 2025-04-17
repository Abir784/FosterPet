<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile | FosterPet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="assets/css/profile.css"/>
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <img src="https://via.placeholder.com/120" alt="profile" class="rounded-circle mb-3" />
          <h4 class="card-title mb-1">John Doe</h4>
          <p class="text-muted">Pet Adopter</p>
          <p><span class="badge bg-success">Active</span></p>
          <button class="btn btn-warning btn-sm">Edit Profile</button>
        </div>
      </div>
    </div>

    <!-- Profile Details -->
    <div class="col-md-8">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white">
          Personal Information
        </div>
        <div class="card-body">
          <p><strong>Email:</strong> johndoe@example.com</p>
          <p><strong>Phone:</strong> +1 (123) 456-7890</p>
          <p><strong>Address:</strong> 123 Pet Lane, Animal Town</p>
        </div>
      </div>

      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white">
          Adoption Activity
        </div>
        <div class="card-body">
          <p><strong>Applications Submitted:</strong> 3</p>
          <p><strong>Pets Adopted:</strong> 1</p>
          <p><strong>Status:</strong> <span class="text-success">Verified</span></p>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
          Security Settings
        </div>
        <div class="card-body">
          <button class="btn btn-outline-primary btn-sm">Change Password</button>
          <button class="btn btn-outline-danger btn-sm ms-2">Deactivate Account</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
