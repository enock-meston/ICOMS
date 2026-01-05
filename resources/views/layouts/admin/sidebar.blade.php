<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" style="width: 180px; height:60px"
                    alt="logo"></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo.png') }}" alt="small logo"></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo"></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo.png') }}" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar>
        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title" data-lang="apps-title">Account Management</li>
            @if ($currentUser && $currentUser->can('role-list'))
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarUsersR" aria-expanded="false"
                        aria-controls="sidebarUsersR" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="users"></i></span>
                        <span class="menu-text" data-lang="users"> Roles </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUsersR">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('roles.index') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="roles">Roles</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('roles.create') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="permissions">Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if ($currentUser && $currentUser->can('user-list'))
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false" aria-controls="sidebarUsers"
                        class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="users"></i></span>
                        <span class="menu-text" data-lang="users"> Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUsers">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('users.index') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="roles">System Users</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('cooperative.user') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="roles">Co-op Users</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if ($currentUser && $currentUser->can('department-list'))
                <li class="side-nav-item">
                    <a href="{{ route('department.index') }}" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="book"></i></span>
                        <span class="menu-text" data-lang="book"> Department </span>
                    </a>
                </li>
            @endif
            <li class="side-nav-item">
                <a href="{{ route('group.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="book"></i></span>
                    <span class="menu-text" data-lang="book"> Group/Itsinda </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('season.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="book"></i></span>
                    <span class="menu-text" data-lang="book"> Season </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('plan.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="book"></i></span>
                    <span class="menu-text" data-lang="book"> Plan </span>
                </a>
            </li>

            {{-- field activity --}}
            <li class="side-nav-item">
                <a href="{{ route('field-activity.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="book"></i></span>
                    <span class="menu-text" data-lang="book"> Field Activity </span>
                </a>
            </li>
            {{-- member --}}
            <li class="side-nav-item">
                <a href="{{ route('field-activity.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="book"></i></span>
                    <span class="menu-text" data-lang="book"> Member </span>
                </a>
            </li>

        </ul>
    </div>
</div>
