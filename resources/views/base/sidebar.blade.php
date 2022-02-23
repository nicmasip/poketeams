@extends('base.base')

@section('sidebar-content')
      <aside
        class="sidebar-left border-right bg-white shadow"
        id="leftSidebar"
        data-simplebar
      >
        <a
          href="#"
          class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3"
          data-toggle="toggle"
        >
          <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
          <!-- nav bar -->
          <div class="w-100 mb-4 d-flex">
            <a
              class="mt-4 navbar-brand mx-auto mt-2 flex-fill text-center"
              href="{{ route('home') }}"
            >
              <img style="width:50px;" src="{{ url('assets/assets/images/pngegg.png') }}"></img>
            </a>
          </div>
          <p class="text-muted nav-heading mt-2 mb-1">
            @if(auth()->user()->role == 'admin')
              <span>Admin Area</span>
            @elseif(auth()->user()->role == 'advanced')
              <span>Advanced User</span>
            @else
              <span>Basic User</span>
            @endif
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('home') }}"
                    >
                      <i class="fe fe-home fe-16"></i>
                      <span class="ml-1 item-text">Home</span></a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('user.useredit') }}"
                    >
                      <i class="fe fe-edit fe-16"></i>
                      <span class="ml-1 item-text">Edit Profile</span></a
                  >
                </li>
                @if(auth()->user()->role == 'admin')
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('user.index') }}"
                    >
                      <i class="fe fe-users fe-16"></i>
                      <span class="ml-1 item-text">Manage Users</span></a
                  >
                </li>
                @endif
          </ul>
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Pages</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('viewteams.index') }}"
                    >
                      <i class="fe fe-eye fe-16"></i>
                      <span class="ml-1 item-text">View Teams</span></a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('team.index') }}"
                    >
                      <i class="fe fe-plus-square fe-16"></i>
                      <span class="ml-1 item-text">Team Builder</span></a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('pokemon.index') }}"
                    >
                      <i class="fe fe-book-open fe-16"></i>
                      <span class="ml-1 item-text">Pokédex</span></a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('ability.index') }}"
                    >
                      <i class="fe fe-zap fe-16"></i>
                      <span class="ml-1 item-text">Abilitydex</span></a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="{{ route('item.index') }}"
                    >
                      <i class="fe fe-briefcase fe-16"></i>
                      <span class="ml-1 item-text">Itemdex</span></a
                  >
                </li>
          </ul>
        </nav>
      </aside>
@endsection