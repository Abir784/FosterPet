
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="bg-dark text-white sidebar position-fixed" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 fs-4 fw-bold border-bottom">FosterPet Admin</div>
    <div class="list-group list-group-flush sidebar-menu">
      <a href="#dashboard" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
      <a href="#pets" class="list-group-item list-group-item-action bg-dark text-white">Manage Pets</a>
      <a href="{{ route('track.requests')}}" class="list-group-item list-group-item-action bg-dark text-white">See Applications</a>
      <a href="#users" class="list-group-item list-group-item-action bg-dark text-white">Users</a>
      <a href="#messages" class="list-group-item list-group-item-action bg-dark text-white">Messages</a>
      <a href="#donations" class="list-group-item list-group-item-action bg-dark text-white">Donations</a>
      <a href="#settings" class="list-group-item list-group-item-action bg-dark text-white">Settings</a>
      <a href="{{ route('applicant-types.create')}}" class="list-group-item list-group-item-action bg-dark text-white">Applications Type</a>

    </div>
  </div>

  <!-- Page Content -->
  <div id="page-content-wrapper" class="w-100" style="margin-left: 250px;">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-4">
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
