<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start" style="z-index: 99"
    id="sidenav-main">
    <div class="sidenav-header flex">
        {{-- <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i> --}}
        <a class=" justify-content-center" href="/">
            <img src="{{ asset('assets/img/logos/eventhublogo.png') }}" alt="main_logo"
                class="w-100 h-100 object-contain ">
            {{-- <span class="ms-1 font-weight-bold">Event Hub</span> --}}
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height: auto !important;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'Dashboard') active @endif" href="{{ '#' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Users & Management</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'Users') active @endif"
                    href="{{ route('list-user', ['page' => 1]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'Bookings') active @endif" href="{{ route('bookings') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bookings</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Event Management</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'Event Categories') active @endif"
                    href="{{ route('list-event-categories') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Event Categories</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'Events') active @endif"
                    href="{{ route('event.index', ['page' => 1]) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Events</span>
                </a>
            </li>
            {{-- 
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Destinations & Content</h6>
      </li>
      
      <li class="nav-item">
        <a class="nav-link @if ($activePage == 'Blogs') active @endif"
          href="{{ route('list-blogs') }}">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Blogs</span>
        </a>
      </li> --}}

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Communication & Support</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($activePage == 'contacts') active @endif" href="{{ route('contacts') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 icon-color text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Contacts</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
