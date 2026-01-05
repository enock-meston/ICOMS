@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">ICOMS</a></li>

                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form class="card border p-3">
                    <div class="row gap-3">
                        <!-- Search Input -->
                        <div class="col-lg-4">
                            <div class="app-search">
                                <input type="text" class="form-control" placeholder="Search contact name...">
                                <i data-lucide="search" class="app-search-icon text-muted"></i>
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-secondary">Apply</button>
                            </div>
                        </div>

                        <div class="col">
                            @if (!($currentUser && $currentUser->can('role-list')))
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <a href="{{ route('group.create') }}" class="btn btn-sm btn-primary btn-add-user">Bika
                                        Itsinda</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success text-bg-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            @foreach ($groups as $group)
                <!-- Profile Card 1: Sophia Carter -->
                <div class="col-md-4 col-xxl-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Name & Flag -->
                            <h5 class="mb-0 mt-2 d-flex align-items-center justify-content-center">
                                <a href="users-profile.html" class="link-reset">{{ $group->name }}</a>
                            </h5>
                            <!-- Designation & Badge -->
                            <span class="text-muted fs-xs">{{ $group->sector }}</span><br>

                            <span class="badge bg-secondary my-1">{{ $group->manager->full_name }}</span><br>


                            <!-- Buttons -->
                            <div class="mt-3">
                                <a href="{{ route('group.edit', $group->id) }}"
                                    class="btn btn-outline-secondary btn-sm me-1">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('group.destroy', $group->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to remove this user?');">
                                        Remove
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div> <!-- end row-->

    </div><!-- end row -->



    </div>

@endsection
