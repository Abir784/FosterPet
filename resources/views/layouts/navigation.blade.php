
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="text-white bg-dark sidebar position-fixed" id="sidebar-wrapper">
    <div class="py-4 text-center sidebar-heading fs-4 fw-bold border-bottom">FosterPet </div>
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

        @if(Auth::user()->role === 'pet foster')
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
        <span class="navbar-brand fw-semibold">Admin Dashboard</span>
        <div class="d-flex">
          <a href="#settings" class="btn btn-outline-secondary me-2">Settings</a>
          {{-- <a href="#logout" class="btn btn-outline-danger">Logout</a> --}}
          <form method="POST" action="{{ route('logout') }} ">
            @csrf

            <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();"  class="btn btn-outline-danger">
                {{('Log Out') }}
            </x-responsive-nav-link>
        </form>
        </div>
      </div>
    </nav>
