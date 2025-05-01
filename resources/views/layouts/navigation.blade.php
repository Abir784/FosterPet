
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="text-white bg-dark sidebar position-fixed" id="sidebar-wrapper">
    <div class="py-4 text-center sidebar-heading fs-4 fw-bold border-bottom">FosterPet Admin</div>
    <div class="list-group list-group-flush sidebar-menu">
      <a href="#dashboard" class="text-white list-group-item list-group-item-action bg-dark">Dashboard</a>
      <a href="{{ route('pets.add_pets') }}" class="text-white list-group-item list-group-item-action bg-dark">Add Pets</a>
      <a href="{{ route('pets.update_form') }}" class="text-white list-group-item list-group-item-action bg-dark">Update Pets</a>
      <a href="{{ route('show.pets') }}" class="text-white list-group-item list-group-item-action bg-dark">See Pets Details</a>
      <a href="{{ route('track.requests') }}" class="text-white list-group-item list-group-item-action bg-dark"> See Pets Applications</a>
      <a href="#users" class="text-white list-group-item list-group-item-action bg-dark">Users</a>
      <a href="#messages" class="text-white list-group-item list-group-item-action bg-dark">Messages</a>
      <a href="#donations" class="text-white list-group-item list-group-item-action bg-dark">Donations</a>
      <a href="#settings" class="text-white list-group-item list-group-item-action bg-dark">Settings</a>

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
