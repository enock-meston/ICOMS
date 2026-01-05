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
                                <input type="text" class="form-control" placeholder="Search department name...">
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
                               @if($currentUser && $currentUser->can('department-create'))
                                    <button type="button" class="btn btn-sm btn-primary btn-add-department"
                                        data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">Ongeramo</button>
                                @endcan

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
            @foreach ($departments as $department)
                <!-- Department Card -->
                <div class="col-md-4 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <!-- Department Name -->
                            <h5 class="mb-2">
                                <a href="javascript:void(0);" class="link-reset">{{ $department->name }}</a>
                            </h5>
                            <!-- Description -->
                            <p class="text-muted fs-xs mb-3">{{ $department->description ?? 'No description' }}</p>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                @if($currentUser && $currentUser->can('department-edit'))
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-edit-department"
                                    data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg"
                                    data-id="{{ $department->id }}" data-name="{{ $department->name }}"
                                    data-description="{{ $department->description ?? '' }}">
                                    Edit
                                </button>
                                @endcan

                                @if($currentUser && $currentUser->can('department-delete'))
                                    <form method="POST" action="{{ route('department.destroy', $department->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to remove this department?');">
                                        Remove
                                    </button>
                                </form>
                                @endcan

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
                    <h4 class="modal-title" id="departmentModalTitle">Add New Department</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('department.store') }}" id="departmentForm">
                        @csrf
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" id="departmentName"
                                    placeholder="e.g., Finance, IT, HR" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="departmentDescription" class="form-label">Description</label>
                            <div class="input-group">
                                <textarea name="description" class="form-control" id="departmentDescription" rows="3"
                                    placeholder="Enter department description..."></textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2"
                                id="departmentFormSubmit">Create Department</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    </div>
    <script>
        (function() {
            const departmentForm = document.getElementById('departmentForm');
            const modalTitle = document.getElementById('departmentModalTitle');
            const submitButton = document.getElementById('departmentFormSubmit');
            const nameInput = document.getElementById('departmentName');
            const descriptionInput = document.getElementById('departmentDescription');
            const storeAction = "{{ route('department.store') }}";
            const departmentsBaseUrl = "{{ url('department') }}";
            let methodInput = null;

            // Add new department mode
            document.querySelectorAll('.btn-add-department').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    departmentForm.reset();
                    departmentForm.action = storeAction;

                    if (methodInput) {
                        methodInput.remove();
                        methodInput = null;
                    }

                    modalTitle.textContent = 'Add New Department';
                    submitButton.textContent = 'Create Department';
                });
            });

            // Edit department mode
            document.querySelectorAll('.btn-edit-department').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const departmentId = this.getAttribute('data-id');
                    const departmentName = this.getAttribute('data-name');
                    const departmentDescription = this.getAttribute('data-description');

                    departmentForm.action = departmentsBaseUrl + '/' + departmentId;

                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        departmentForm.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    nameInput.value = departmentName || '';
                    descriptionInput.value = departmentDescription || '';

                    modalTitle.textContent = 'Edit Department';
                    submitButton.textContent = 'Update Department';
                });
            });
        })();
    </script>
@endsection
