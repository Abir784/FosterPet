
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="text-white bg-dark sidebar position-fixed" id="sidebar-wrapper">
    <div class="py-4 text-center sidebar-heading fs-4 fw-bold border-bottom">FosterPet </div>
    <div class="list-group list-group-flush sidebar-menu">
      <a href="{{ route('dashboard')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
      {{-- @php
        $user = Auth::user();
        if ($user->role == 'admin') {
            echo '<a href="' . route('users.index') . '" class="text-white list-group-item list-group-item-action bg-dark">Users</a>';
        } elseif ($user->role == 'adopter') {
            echo '<a href="' . route('adopter.index') . '" class="text-white list-group-item list-group-item-action bg-dark">Adopters</a>';
        } elseif ($user->role == 'foster') {
            echo '<a href="' . route('foster.index') . '" class="text-white list-group-item list-group-item-action bg-dark">Fosters</a>';
        }
      @endphp --}}
      <a href="{{ route('pets.add_pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-plus me-2"></i> Add Pets</a>
      <a href="{{ route('show.pets') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-paw me-2"></i> See Pets Details</a>
      @php
        $user = Auth::user();
        if ($user->role == 'adopter') {
            echo '<a href="' . route('adoption.track') . '" class="text-white list-group-item list-group-item-action bg-dark">Track My Requests</a>';
        }

      @endphp

      <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"> See Pets Applications</a>
      <a href="{{ route('adoption-responses.index') }}" class="text-white list-group-item list-group-item-action bg-dark">Community Adoption Responses</a>
      <a href="{{ route('applicant-types.create')}}" class="list-group-item list-group-item-action bg-dark text-white">Applications Type</a>

      <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-clipboard-list me-2"></i> See Pets Applications</a>
      <a href="{{ route('applicant-types.create')}}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-file-alt me-2"></i> Applications Type</a>



      <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"> See Pets Applications</a>
      <a href="{{ route('adoption-responses.index') }}" class="text-white list-group-item list-group-item-action bg-dark">Community Adoption Responses</a>
      <a href="{{ route('applicant-types.create')}}" class="list-group-item list-group-item-action bg-dark text-white">Applications Type</a>

      <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-clipboard-list me-2"></i> See Pets Applications</a>
      <a href="{{ route('applicant-types.create')}}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-file-alt me-2"></i> Applications Type</a>


      <a href="{{ route('friends.index')}}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-user-friends me-2"></i> Friend Requests</a>
      <a href="{{ route('donations.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-gift me-2"></i> Donations</a>
      <a href="{{ route('donations.user') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-hand-holding-usd me-2"></i> My Donations</a>
      <a href="{{ route('documents.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-file me-2"></i> Documents</a>
      <a href="{{ route('messages.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-envelope me-2"></i> Messages</a>
      @if(Auth::user()->role === 'admin')
      <a href="{{ route('reports.index') }}" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-flag me-2"></i> Reports</a>
      @endif
      <a href="#settings" class="text-white list-group-item list-group-item-action bg-dark"><i class="fas fa-cog me-2"></i> Settings</a>


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
