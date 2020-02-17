<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ avatar_path(Auth::user()->image) }}" alt="profile image"> </div>
          <div class="text-wrapper">
            <p class="profile-name">{{ Auth::user()->name }}</p>
            <div>
              <small class="designation text-muted">{{ Auth::user()->roleUser->name }}</small>
              <span class="status-indicator online"></span>
            </div>
          </div>
        </div>
        {{-- <button class="btn btn-success btn-block">New Project
          <i class="mdi mdi-plus"></i>
        </button> --}}
      </div>
    </li>

    <li class="nav-item {{ active_path() }}">
      <a class="nav-link" href="{{ route('admin.index') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- User management -->
    <li class="nav-item {{ active_segment(2, 'users') }}">
      <a class="nav-link" data-toggle="collapse" href="#user-dropdown" aria-expanded="false" aria-controls="user-dropdown">
        <i class="menu-icon mdi mdi-account-group"></i>
        <span class="menu-title">Manage User</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_segment(2, 'users') }}" id="user-dropdown">
        <ul class="nav flex-column sub-menu">
          @if (auth()->user()->role_id === 1)

            <li class="nav-item">
              <a class="nav-link {{ active_path('users') }}" href="{{ route('admin.front_end_users.index') }}">Front-end User Lists</a>
            </li>

          @endif
          <li class="nav-item">
            <a class="nav-link {{ active_path('users') }}" href="{{ route('admin.users.index') }}">Back-end User Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ active_path('users/create') }}" href="{{ route('admin.users.create') }}">Add New User</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Rejection management -->
    <li class="nav-item {{ active_segment(2, 'blocks') }}">
      <a class="nav-link" data-toggle="collapse" href="#block-dropdown" aria-expanded="false" aria-controls="block-dropdown">
        <i class="menu-icon mdi mdi-lock"></i>
        <span class="menu-title">Manage Rejection</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_segment(2, 'blocks') }}" id="block-dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ active_path('blocks') }}" href="{{ route('admin.blocks.index') }}">Rejected Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ active_path('blocks/create') }}" href="{{ route('admin.blocks.create') }}">Add New Reject</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Token management -->
    @if (auth()->user()->role_id === 1)

    <li class="nav-item {{ active_segment(2, 'tokens') }}">
      <a class="nav-link" data-toggle="collapse" href="#token-dropdown" aria-expanded="false" aria-controls="token-dropdown">
        <i class="menu-icon mdi mdi-database"></i>
        <span class="menu-title">Manage Token Slot</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_segment(2, 'tokens') }}" id="token-dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ active_path('tokens') }}" href="{{ route('admin.tokens.index') }}">Avaliable Slot Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ active_path('tokens/create') }}" href="{{ route('admin.tokens.create') }}">Add Token Slot</a>
          </li>
        </ul>
      </div>
    </li>

    @endif
    <!-- Appointment Cancel -->
    <li class="nav-item {{ active_segment(2, 'cancelAppointment') }}">
      <a class="nav-link" data-toggle="collapse" href="#appcancel_dropdown" aria-expanded="false" aria-controls="token-dropdown">
        <i class="menu-icon mdi mdi-email"></i>
        <span class="menu-title">Appointment</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_segment(2, 'cancelAppointment') }}" id="appcancel_dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ active_path('tokens') }}" href="{{ route('appointment_list') }}">Appointment Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ active_path('tokens') }}" href="{{ route('appointment_cancel') }}">Appointment Cancel Lists</a>
          </li>
        </ul>
      </div>
    </li>

  </ul>
</nav>