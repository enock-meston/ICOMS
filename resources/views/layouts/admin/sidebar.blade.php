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
                    <span class="menu-icon"><i data-lucide="calendar"></i></span>
                    <span class="menu-text" data-lang="book"> Production Plan </span>
                </a>
            </li>

            {{-- field activity --}}
            <li class="side-nav-item">
                <a href="{{ route('field-activity.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="activity"></i></span>
                    <span class="menu-text" data-lang="book"> Field Activity </span>
                </a>
            </li>

            {{-- <li class="side-nav-item">
                <a href="{{ route('compost.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="leaf"></i></span>
                    <span class="menu-text" data-lang="book"> Compost </span>
                </a>
            </li> --}}


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCompost" aria-expanded="false"
                    aria-controls="sidebarCompost" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="leaf"></i></span>
                    <span class="menu-text" data-lang="compost"> Compost </span>
                    <span class="menu-arrow"></span>
                </a>

                <div class="collapse" id="sidebarCompost">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('compost.index') }}" class="side-nav-link">
                                <span class="menu-text">Group Compost</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('compostInput.index') }}" class="side-nav-link">
                                <span class="menu-text">Compost Input</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('compostUsage.index') }}" class="side-nav-link">
                                <span class="menu-text">Compost Usage</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('task.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="check-square"></i></span>
                    <span class="menu-text" data-lang="book"> Tasks </span>
                </a>
            </li>

            <li class="side-nav-title" data-lang="apps-title">Operations</li>

            {{-- member --}}
            <li class="side-nav-item">
                <a href="{{ route('member.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text" data-lang="book"> Member </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('member-payment.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="credit-card"></i></span>
                    <span class="menu-text" data-lang="book"> Member Payment </span>
                </a>
            </li>

            {{-- input allocation --}}
            <li class="side-nav-item">
                <a href="{{ route('allocation.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="package"></i></span>
                    <span class="menu-text" data-lang="book"> Input Allocation </span>
                </a>
            </li>
            {{-- // rice delivery --}}
            <li class="side-nav-item">
                <a href="{{ route('riceDelivery.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="truck"></i></span>
                    <span class="menu-text" data-lang="book"> Rice Delivery </span>
                </a>
            </li>

            <li class="side-nav-title" data-lang="apps-title">Procurement</li>

            <li class="side-nav-item">
                <a href="{{ route('procurement-plan.index') }}" class="side-nav-link">
                    {{-- <a href="" class="side-nav-link"> --}}
                    <span class="menu-icon"><i data-lucide="file-text"></i></span>
                    <span class="menu-text" data-lang="book"> Procurement Plan </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('procurement-item.index') }}" class="side-nav-link">
                    {{-- <a href="" class="side-nav-link"> --}}
                    <span class="menu-icon"><i data-lucide="file-text"></i></span>
                    <span class="menu-text" data-lang="book"> Procurement Item </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('tender.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                    <span class="menu-text" data-lang="book"> Tenders </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('bid.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="gavel"></i></span>
                    <span class="menu-text" data-lang="book"> Bids </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('deliveries.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="truck"></i></span>
                    <span class="menu-text" data-lang="book"> Deliverie </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('supplier.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="truck"></i></span>
                    <span class="menu-text" data-lang="book"> Suppliers </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('supplier-payment.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="credit-card"></i></span>
                    <span class="menu-text" data-lang="book"> Supplier Payment </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('committee.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text" data-lang="book"> Committees </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('tender-evaluation.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="check-circle"></i></span>
                    <span class="menu-text" data-lang="book"> Tender Evaluation </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('contract.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="file-signature"></i></span>
                    <span class="menu-text" data-lang="book"> Contracts </span>
                </a>
            </li>

            <li class="side-nav-title" data-lang="apps-title">Administration</li>

            <li class="side-nav-item">
                <a href="{{ route('meeting.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text" data-lang="book"> Meetings </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('decision.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="alert-circle"></i></span>
                    <span class="menu-text" data-lang="book"> Decisions </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('report.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="bar-chart"></i></span>
                    <span class="menu-text" data-lang="book"> Reports </span>
                </a>
            </li>
        </ul>
    </div>
</div>
