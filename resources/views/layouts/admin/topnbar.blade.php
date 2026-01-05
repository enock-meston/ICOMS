 <header class="app-topbar">
     <div class="container-fluid topbar-menu">
         <div class="d-flex align-items-center gap-2">
             <!-- Topbar Brand Logo -->
             <div class="logo-topbar">
                 <!-- Logo light -->
                 <a href="#" class="logo-light">
                     <span class="logo-lg">
                         <img src="assets/images/logo.png" alt="logo">
                     </span>
                     <span class="logo-sm">
                         <img src="assets/images/logo.png" alt="small logo">
                     </span>
                 </a>

                 <!-- Logo Dark -->
                 <a href="#" class="logo-dark">
                     <span class="logo-lg">
                         <img src="assets/images/logo-black.png" alt="dark logo">
                     </span>
                     <span class="logo-sm">
                         <img src="assets/images/logo.png" alt="small logo">
                     </span>
                 </a>
             </div>

             <!-- Sidebar Menu Toggle Button -->
             <button class="sidenav-toggle-button btn btn-default btn-icon">
                 <i class="ti ti-menu-4 fs-22"></i>
             </button>

             <!-- Horizontal Menu Toggle Button -->
             <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                 <i class="ti ti-menu-4 fs-22"></i>
             </button>



         </div> <!-- .d-flex-->

         <div class="d-flex align-items-center gap-2">

             <!-- Search -->
             <div class="app-search d-none d-xl-flex me-2">
                 <input type="search" class="form-control topbar-search rounded-pill" name="search"
                     placeholder="Quick Search...">
                 <i data-lucide="search" class="app-search-icon text-muted"></i>
             </div>

             <!-- Theme Mode Dropdown -->
             <div class="topbar-item">
                 <div class="dropdown">
                     <button class="topbar-link" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button"
                         aria-haspopup="false" aria-expanded="false">
                         <i data-lucide="layout-grid" class="fs-xxl"></i>
                     </button>



                 </div> <!-- end dropdown-->
             </div> <!-- end topbar item-->

             <!-- Theme Mode Dropdown -->
             <div class="topbar-item">
                 <div class="dropdown">
                     <button class="topbar-link" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button"
                         aria-haspopup="false" aria-expanded="false">
                         <i data-lucide="sun" class="fs-xxl"></i>
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end thememode-dropdown">

                         <li>
                             <label class="dropdown-item">
                                 <i data-lucide="sun" class="align-middle me-1 fs-16"></i>
                                 <span class="align-middle">Light</span>
                                 <input class="form-check-input" type="radio" name="data-bs-theme" value="light">
                             </label>
                         </li>

                         <li>
                             <label class="dropdown-item">
                                 <i data-lucide="moon" class="align-middle me-1 fs-16"></i>
                                 <span class="align-middle">Dark</span>
                                 <input class="form-check-input" type="radio" name="data-bs-theme" value="dark">
                             </label>
                         </li>

                         <li>
                             <label class="dropdown-item">
                                 <i data-lucide="monitor-cog" class="align-middle me-1 fs-16"></i>
                                 <span class="align-middle">System</span>
                                 <input class="form-check-input" type="radio" name="data-bs-theme" value="system">
                             </label>
                         </li>

                     </ul> <!-- end dropdown-menu-->
                 </div> <!-- end dropdown-->
             </div> <!-- end topbar item-->

             <!-- FullScreen -->
             <div class="topbar-item d-none d-sm-flex">
                 <button class="topbar-link" type="button" data-toggle="fullscreen">
                     <i data-lucide="maximize" class="fs-xxl fullscreen-off"></i>
                     <i data-lucide="minimize" class="fs-xxl fullscreen-on"></i>
                 </button>
             </div>

             <!-- Light/Dark Mode Button -->
             <div class="topbar-item d-none">
                 <button class="topbar-link" id="light-dark-mode" type="button">
                     <i data-lucide="moon" class="fs-xxl mode-light-moon"></i>
                 </button>
             </div>

             <!-- Monocrome Mode Button -->
             <div class="topbar-item d-none d-sm-flex">
                 <button class="topbar-link" type="button" id="monochrome-mode">
                     <i data-lucide="palette" class="fs-xxl"></i>
                 </button>
             </div>

             <!-- User Dropdown -->
             <div class="topbar-item nav-user">
                 <div class="dropdown">
                     <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                         data-bs-offset="0,19" href="#!" aria-haspopup="false" aria-expanded="false">
                         <img src="{{ asset('assets/images/logo.png') }}" width="32"
                             class="rounded-circle me-lg-2 d-flex" alt="user-image">
                         <div class="d-lg-flex align-items-center gap-1 d-none">
                            <h5 class="my-0">
                                @if($currentUser)
                                    {{ $currentUser->name ?? $currentUser->full_name ?? 'User' }}
                                @else
                                    Guest
                                @endif
                            </h5>
                             <i class="ti ti-chevron-down align-middle"></i>
                         </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end">
                         <!-- Header -->
                         <div class="dropdown-header noti-title">
                             <h6 class="text-overflow m-0">Welcome back 👋!</h6>
                         </div>

                         <!-- My Profile -->
                         <a href="#" class="dropdown-item">
                             <i class="ti ti-user-circle me-1 fs-17 align-middle"></i>
                             <span class="align-middle">Profile</span>
                         </a>
                         <!-- Divider -->
                         <div class="dropdown-divider"></div>

                         <form method="POST" action="{{ route('logout') }}">
                             @csrf
                             <button type="submit" class="dropdown-item fw-semibold">
                                 <i class="ti ti-logout-2 me-1 fs-17 align-middle"></i>
                                 Log Out
                             </button>
                         </form>

                     </div>

                 </div>
             </div>

         </div>
     </div>
 </header>
