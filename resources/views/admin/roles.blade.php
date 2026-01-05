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

        <!-- View Role Modal -->
        <div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewRoleModalLabel">Role Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-1 fw-semibold">Role Name</p>
                        <p id="viewRoleName" class="mb-3"></p>

                        <p class="mb-1 fw-semibold">Guard Name</p>
                        <p id="viewRoleGuard" class="mb-3"></p>

                        <p class="mb-1 fw-semibold">Permissions</p>
                        <ul id="viewRolePermissions" class="mb-0 ps-3"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editRoleForm" method="POST"
                        data-action-template="{{ route('roles.update', ['role' => '__ID__']) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="editRoleName" class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control" id="editRoleName" required>

                                    <label for="editRoleGuard" class="form-label mt-3">Guard Name</label>
                                    <select name="guard_name" class="form-select" id="editRoleGuard" required>
                                        <option value="web">Web (Admin Users)</option>
                                        <option value="cooperative">Cooperative (Manager Users)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="fs-6 mb-2">Permissions:</h3>
                                    <div id="editPermissionsContainer">
                                        <!-- Permissions will be dynamically loaded based on guard_name -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const viewRoleName = document.getElementById('viewRoleName');
                const viewRoleGuard = document.getElementById('viewRoleGuard');
                const viewRolePermissions = document.getElementById('viewRolePermissions');
                document.querySelectorAll('.view-role-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        viewRoleName.textContent = btn.dataset.roleName || '';
                        viewRoleGuard.textContent = btn.dataset.roleGuard || '';
                        viewRolePermissions.innerHTML = '';
                        const perms = (btn.dataset.rolePermissions || '').split(',').map(p => p.trim()).filter(Boolean);
                        if (perms.length === 0) {
                            viewRolePermissions.innerHTML = '<li class="text-muted">No permissions assigned</li>';
                            return;
                        }
                        perms.forEach(p => {
                            const li = document.createElement('li');
                            li.textContent = p;
                            viewRolePermissions.appendChild(li);
                        });
                    });
                });

                const editForm = document.getElementById('editRoleForm');
                const actionTemplate = editForm.dataset.actionTemplate;
                const editRoleName = document.getElementById('editRoleName');
                const editRoleGuard = document.getElementById('editRoleGuard');
                const editPermissionsContainer = document.getElementById('editPermissionsContainer');

                // Store permissions by guard
                const permissionsByGuard = {
                    web: @json($webPermissions ?? []),
                    cooperative: @json($cooperativePermissions ?? [])
                };

                function loadPermissionsForGuard(guardName) {
                    const permissions = permissionsByGuard[guardName] || [];
                    editPermissionsContainer.innerHTML = '';

                    permissions.forEach(permission => {
                        const label = document.createElement('label');
                        label.className = 'form-label fw-normal d-block';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.className = 'edit-permission-check';
                        checkbox.name = `permissions[${permission.name}]`;
                        checkbox.value = permission.name;

                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(' ' + permission.name));
                        editPermissionsContainer.appendChild(label);
                        editPermissionsContainer.appendChild(document.createElement('br'));
                    });
                }

                // Load permissions when guard changes
                editRoleGuard.addEventListener('change', function() {
                    loadPermissionsForGuard(this.value);
                });

                document.querySelectorAll('.edit-role-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        editForm.action = actionTemplate.replace('__ID__', btn.dataset.roleId);
                        editRoleName.value = btn.dataset.roleName || '';
                        editRoleGuard.value = btn.dataset.roleGuard || 'web';

                        // Load permissions for the selected guard
                        loadPermissionsForGuard(editRoleGuard.value);

                        // Check the permissions after a short delay to ensure checkboxes are rendered
                        setTimeout(() => {
                            const perms = (btn.dataset.rolePermissions || '').split(',').map(p => p.trim()).filter(Boolean);
                            const editPermissionChecks = Array.from(document.querySelectorAll('.edit-permission-check'));
                            editPermissionChecks.forEach(chk => {
                                chk.checked = perms.includes(chk.value);
                            });
                        }, 100);
                    });
                });
            });

            // Handle add role form guard change
            const addRoleGuard = document.getElementById('roleGuard');
            const addPermissionsContainer = document.getElementById('addPermissionsContainer');
            const addPermissionsByGuard = {
                web: @json($webPermissions ?? []),
                cooperative: @json($cooperativePermissions ?? [])
            };

            function loadAddPermissionsForGuard(guardName) {
                const permissions = addPermissionsByGuard[guardName] || [];
                addPermissionsContainer.innerHTML = '';

                permissions.forEach(permission => {
                    const label = document.createElement('label');
                    label.className = 'form-label fw-normal d-block';

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = `permissions[${permission.name}]`;
                    checkbox.value = permission.name;

                    label.appendChild(checkbox);
                    label.appendChild(document.createTextNode(' ' + permission.name));
                    addPermissionsContainer.appendChild(label);
                    addPermissionsContainer.appendChild(document.createElement('br'));
                });
            }

            // Load initial permissions for default guard (web)
            loadAddPermissionsForGuard('web');

            // Load permissions when guard changes
            addRoleGuard.addEventListener('change', function() {
                loadAddPermissionsForGuard(this.value);
            });
        </script>

        <div class="row">
            <div class="col-12">

                <div class="d-flex align-items-sm-center flex-sm-row flex-column my-3">


                    <div class="text-end">
                        <a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                            class="btn btn-success">
                            <i class="ti ti-plus me-1"></i> Add New Role
                        </a>
                    </div>
                </div>
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

                <div class="row">
                    <div class="col-12">
                        <div data-table data-table-rows-per-page="8" class="card">
                            <div class="card-header border-light justify-content-between">

                                <div class="d-flex gap-2">
                                    <div class="app-search">
                                        <input data-table-search type="search" class="form-control"
                                            placeholder="Search Role...">
                                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                                    </div>
                                    <button data-table-delete-selected class="btn btn-danger d-none">Delete</button>
                                </div>


                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-select table-hover w-100 mb-0">
                                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                        <tr class="text-uppercase fs-xxs">
                                            <th class="ps-3" style="width: 1%;">
                                                <input data-table-select-all
                                                    class="form-check-input form-check-input-light fs-14 mt-0"
                                                    type="checkbox" id="select-all-files" value="option">
                                            </th>
                                            <th data-table-sort>ID</th>
                                            <th data-table-sort data-column="roles">Role</th>
                                            <th data-table-sort>Guard Name</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Row 1 -->
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td class="ps-3"><input
                                                        class="form-check-input form-check-input-light fs-14 file-item-check mt-0"
                                                        type="checkbox" value="option"></td>
                                                <td>
                                                    <h5 class="m-0"><a href="#" class="link-reset">{{ $role->id }}</a>
                                                    </h5>
                                                </td>

                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $role->guard_name === 'web' ? 'primary' : 'success' }}">
                                                        {{ $role->guard_name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button"
                                                            class="btn btn-default btn-icon btn-sm view-role-btn"
                                                            data-bs-toggle="modal" data-bs-target="#viewRoleModal"
                                                            data-role-name="{{ $role->name }}"
                                                            data-role-guard="{{ $role->guard_name }}"
                                                            data-role-permissions="{{ $role->permissions->pluck('name')->join(',') }}">
                                                            <i class="ti ti-eye fs-lg"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-default btn-icon btn-sm edit-role-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                                            data-role-id="{{ $role->id }}"
                                                            data-role-name="{{ $role->name }}"
                                                            data-role-guard="{{ $role->guard_name }}"
                                                            data-role-permissions="{{ $role->permissions->pluck('name')->join(',') }}">
                                                            <i class="ti ti-edit fs-lg"></i>
                                                        </button>
                                                        <form class="d-inline"
                                                            action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                            onsubmit="return confirm('Delete this role?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-default btn-icon btn-sm">
                                                                <i class="ti ti-trash fs-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div data-table-pagination-info="roles"></div>
                                    <div data-table-pagination></div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

            </div> <!-- end col-->
        </div> <!-- end row-->


        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="addRoleForm" method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="roleName" class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control" id="roleName" required>

                                    <label for="roleGuard" class="form-label mt-3">Guard Name</label>
                                    <select name="guard_name" class="form-select" id="roleGuard" required>
                                        <option value="web">Web (Admin Users)</option>
                                        <option value="cooperative">Cooperative (Manager Users)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <h3 class="fs-6 mb-2">Permissions:</h3>
                                    <div id="addPermissionsContainer">
                                        <!-- Permissions will be dynamically loaded based on guard_name -->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Role</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>



    </div><!-- end row -->


    </div>
@endsection
