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
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary btn-add-user" data-bs-toggle="modal"
                                    data-bs-target="#bs-example-modal-lg">Add new User</button>
                            </div>
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
            @foreach ($users as $user)
                <!-- Profile Card 1: Sophia Carter -->
                <div class="col-md-4 col-xxl-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Name & Flag -->
                            <h5 class="mb-0 mt-2 d-flex align-items-center justify-content-center">
                                <a href="users-profile.html" class="link-reset">{{ $user->name }}</a>
                            </h5>
                            <!-- Designation & Badge -->
                            <span class="text-muted fs-xs">{{ $user->email }}</span><br>
                             @foreach ($user->roles as $role)
                                <span class="badge bg-secondary my-1">{{ $role->name }}</span><br>
                            @endforeach

                            <!-- Buttons -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary btn-sm me-1">View</button>
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm btn-edit-user"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-lg"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm"
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


    <!--  Modal content for the Large example -->
    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="userModalTitle">Add New User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('users.store') }}" id="userForm" aria-multiselectable="">
                        @csrf
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" id="userName"
                                    placeholder="Geneva K." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email address <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" id="userEmail"
                                    placeholder="you@example.com" required>
                            </div>
                        </div>
                         <div class="col-md-6 mb-3">
                                    <label for="userName" class="form-label">Role/Umurimo <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="roles[]" id="userRoles" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                        <div class="mb-3" data-password="bar">
                            <label for="userPassword" class="form-label" id="passwordLabel">Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="userPassword"
                                    placeholder="••••••••" required>
                            </div>
                            <div class="password-bar my-2"></div>
                            <p class="text-muted fs-xs mb-0">Use 8+ characters with letters, numbers & symbols.</p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2" id="userFormSubmit">Create Account</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    </div>
    <script>
        (function () {
            const userForm = document.getElementById('userForm');
            const modalTitle = document.getElementById('userModalTitle');
            const submitButton = document.getElementById('userFormSubmit');
            const nameInput = document.getElementById('userName');
            const emailInput = document.getElementById('userEmail');
            const passwordInput = document.getElementById('userPassword');
            const passwordLabel = document.getElementById('passwordLabel');
            const storeAction = "{{ route('users.store') }}";
            const usersBaseUrl = "{{ url('users') }}";
            let methodInput = null;

            // Add new user mode
            document.querySelectorAll('.btn-add-user').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    userForm.reset();
                    userForm.action = storeAction;

                    if (methodInput) {
                        methodInput.remove();
                        methodInput = null;
                    }

                    modalTitle.textContent = 'Add New User';
                    submitButton.textContent = 'Create Account';

                    passwordInput.required = true;
                    if (passwordLabel) {
                        passwordLabel.innerHTML = 'Password <span class="text-danger">*</span>';
                    }
                });
            });

            // Edit user mode
            document.querySelectorAll('.btn-edit-user').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-name');
                    const userEmail = this.getAttribute('data-email');

                    userForm.action = usersBaseUrl + '/' + userId;

                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        userForm.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    nameInput.value = userName || '';
                    emailInput.value = userEmail || '';
                    passwordInput.value = '';
                    passwordInput.required = false;

                    if (passwordLabel) {
                        passwordLabel.innerHTML = 'Password <span class="text-muted fs-xs">(leave blank to keep current)</span>';
                    }

                    modalTitle.textContent = 'Edit User';
                    submitButton.textContent = 'Update User';
                });
            });
        })();
    </script>
@endsection
