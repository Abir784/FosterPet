
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="text-white bg-dark sidebar position-fixed" id="sidebar-wrapper">
    <a href="{{ route('index') }}" class="text-decoration-none text-white"><div class="py-4 text-center sidebar-heading fs-4 fw-bold border-bottom">FosterPet</div></a>
    <div class="list-group list-group-flush sidebar-menu">
      <a href="{{ route('dashboard')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
      @if(Auth::user()->role === 'admin')
        <a href="{{ route('users.manage') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-users me-2"></i> Manage Users</a>
        <a href="{{ route('pets.add_pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-plus me-2"></i> Add Pets</a>
        <a href="{{ route('show.pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-paw me-2"></i> My Pets</a>
        <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-clipboard-list me-2"></i> All Applications</a>
        <a href="{{ route('reports.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-flag me-2"></i> Reports</a>
        <a href="{{ route('donations.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-gift me-2"></i> Donations</a>
        <a href="{{ route('show.all.pets') }}" class="text-white list-group-item list-group-item-action bg-dark">See All Pets</a>

        @endif

        @if(Auth::user()->role === 'pet shelter')
        <a href="{{ route('pets.add_pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-plus me-2"></i> Add Pets</a>
        <a href="{{ route('show.pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-paw me-2"></i> My Pets</a>
        <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-clipboard-list me-2"></i> Adoption Requests</a>
        @endif

        @if(Auth::user()->role === 'adopter')
        <a href="{{ route('adoption.track') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-clipboard-check me-2"></i> My Applications</a>
        <a href="{{ route('documents.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-file me-2"></i> Documents</a>
        <a href="{{ route('applicant-types.create')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-file-alt me-2"></i> Application Types</a>
        <a href="{{ route('donations.user')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-hand-holding-heart me-2"></i> My Donations</a>
        @endif

      <!-- Common features for all roles -->
      <a href="{{ route('messages.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-envelope me-2"></i> Messages</a>
      <a href="{{ route('friends.index')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-user-friends me-2"></i> Friends</a>


    </div>
  </div>

  <!-- Page Content -->
  <div id="page-content-wrapper" class="w-100" style="margin-left: 250px;">
    <!-- Top Navbar -->
    <nav class="px-4 navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <span class="navbar-brand fw-semibold">
          @if(Auth::user()->role === 'pet shelter')
            Shelter Dashboard
          @elseif(Auth::user()->role === 'adopter')
            Adopter Dashboard
          @endif
        </span>
        <div class="d-flex align-items-center">
          <div class="dropdown me-3">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cog me-1"></i> Settings
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fas fa-user-edit me-2"></i> Edit Profile
              </a></li>
            </ul>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
              <i class="fas fa-sign-out-alt me-1"></i> Log Out
            </button>
          </form>
        </div>
      </div>
    </nav>
