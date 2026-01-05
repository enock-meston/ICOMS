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
            <div class="col-12">

                <div class="d-flex align-items-sm-center flex-sm-row flex-column my-3">


                    <div class="text-end">
                        <a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                            class="btn btn-success">
                            <i class="ti ti-plus me-1"></i> Add New Permission
                        </a>
                    </div>
                </div>


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
                                            <th data-table-sort data-column="roles">guard Name</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Row 1 -->
                                        @foreach ($permissions as $permission)
<tr>
                                            <td class="ps-3"><input
                                                    class="form-check-input form-check-input-light fs-14 file-item-check mt-0"
                                                    type="checkbox" value="option"></td>
                                            <td>
                                                <h5 class="m-0"><a href="#" class="link-reset">{{ $permission->id }}</a>
                                                </h5>
                                            </td>

                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="#" class="btn btn-default btn-icon btn-sm"><i
                                                            class="ti ti-eye fs-lg"></i></a>
                                                    <a href="#" class="btn btn-default btn-icon btn-sm"><i
                                                            class="ti ti-edit fs-lg"></i></a>
                                                    <a href="#" data-table-delete-row
                                                        class="btn btn-default btn-icon btn-sm"><i
                                                            class="ti ti-trash fs-lg"></i></a>
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
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="addRoleForm">
                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="roleName" name="name" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" id="roleName"
                                        placeholder="e.g. Developer, Project Manager" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="roleDescription" name="guard_name" class="form-label">guard_name</label>
                                    <input type="text" class="form-control" value="guard_name" id="roleDescription"
                                        placeholder="guard_name" required>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Permission</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>



    </div><!-- end row -->


    </div>
@endsection
