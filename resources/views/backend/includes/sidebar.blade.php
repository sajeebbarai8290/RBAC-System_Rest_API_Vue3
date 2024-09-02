<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" style="text-decoration: none" class="brand-link">
      {{-- <img src="{{asset('img/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">Admin Logo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/profile.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" style="text-decoration: none" class="badge badge-secondary">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            @canany(['view-user'])
            <a class="nav-link" href="{{ route('user.profile') }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users Profile
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
            @endcanany
          </li>

          <li class="nav-item">
            @canany(['create-user', 'edit-user', 'delete-user'])
            <a class="nav-link" href="{{ route('users.index') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Users
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
            @endcanany
          </li>

          <li class="nav-item">
            @canany(['create-permission', 'edit-permission', 'delete-permission'])
              <a class="nav-link" href="{{ route('permissions.index') }}">
                <i class="nav-icon fas fa-lock-open"></i>
                <p>
                  Manage Permission
                  <span class="right badge badge-danger">New</span>
                </p>
              </a> 
            @endcanany
          </li>

          <li class="nav-item">
            @canany(['create-role', 'edit-role', 'delete-role'])
              <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                  Manage Role
                  <span class="right badge badge-danger">New</span>
                </p>
              </a> 
            @endcanany
          </li>
          
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>