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
                        <div class="col">
                            @if (!($currentUser && $currentUser->can('role-list')))
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-lg"
                                        class="btn btn-sm btn-primary btn-add-user">Add plan
                                    </button>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h4 class="card-title"> List of Product Plan </h4>
                    </div>

                    <div class="card-body">
                        <table data-tables="export-data" class="table table-striped align-middle mt-2 mb-0">
                            <thead class="thead-sm text-uppercase fs-xxs">

                                <tr>
                                    <th>#</th>
                                    <th>Group</th>
                                    <th>Season</th>
                                    <th>planned area</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($ProductPlans as $ProductPlan)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $ProductPlan->group->name }}</td>
                                        <td>{{ $ProductPlan->season->name }}</td>
                                        <td>{{ $ProductPlan->planned_area_ha }}</td>
                                        <td>{{ $ProductPlan->status }}</td>
                                        <td>{{ $ProductPlan->created_at }}</td>
                                        <td>{{ $ProductPlan->updated_at }}</td>
                                        <td>

                                            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('VIEW', this)"
                                                data-id="{{ $ProductPlan->plan_id }}"
                                                data-group="{{ $ProductPlan->group_id }}"
                                                data-season="{{ $ProductPlan->season_id }}"
                                                data-planned_area_ha="{{ $ProductPlan->planned_area_ha }}"
                                                data-planned_yield_tons="{{ $ProductPlan->planned_yield_tons }}"
                                                data-planned_inputs_cost="{{ $ProductPlan->planned_inputs_cost }}"
                                                data-status_id="{{ $ProductPlan->status }}"
                                                data-created_by="{{ $ProductPlan->created_by }}"
                                                data-approved_by_manager="{{ $ProductPlan->approved_by_manager }}"
                                                data-approval_date="{{ $ProductPlan->approval_date }}">
                                                View
                                            </button>

                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('UPDATE', this)"
                                                data-id="{{ $ProductPlan->plan_id }}"
                                                data-group="{{ $ProductPlan->group_id }}"
                                                data-season="{{ $ProductPlan->season_id }}"
                                                data-planned_area_ha="{{ $ProductPlan->planned_area_ha }}"
                                                data-planned_yield_tons="{{ $ProductPlan->planned_yield_tons }}"
                                                data-planned_inputs_cost="{{ $ProductPlan->planned_inputs_cost }}"
                                                data-status="{{ $ProductPlan->status }}"
                                                data-created_by="{{ $ProductPlan->created_by }}"
                                                data-approved_by_manager="{{ $ProductPlan->approved_by_manager }}"
                                                data-approval_date="{{ $ProductPlan->approval_date }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('DELETE', this)"
                                                data-id="{{ $ProductPlan->plan_id }}"
                                                data-group="{{ $ProductPlan->group_id }}"
                                                data-season="{{ $ProductPlan->season_id }}"
                                                data-planned_area_ha="{{ $ProductPlan->planned_area_ha }}"
                                                data-planned_yield_tons="{{ $ProductPlan->planned_yield_tons }}"
                                                data-planned_inputs_cost="{{ $ProductPlan->planned_inputs_cost }}"
                                                data-status="{{ $ProductPlan->status }}"
                                                data-created_by="{{ $ProductPlan->created_by }}"
                                                data-approved_by_manager="{{ $ProductPlan->approved_by_manager }}"
                                                data-approval_date="{{ $ProductPlan->approval_date }}">
                                                Delete
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->


            </div>
        </div>
    </div><!-- end row -->
    </div>


    <!--  Modal content for the Large example -->
    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="departmentModalTitle">Add New Department
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('plan.store') }}" id="">
                        @csrf
                        <input type="hidden" name="plan_id" id="plan_id">
                        <input type="hidden" name="action" id="action">
                        <div class="row g-lg-12 g-2">

                            <div class="col-lg-6">
                                <label for="departmentName" class="form-label">Group<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    {{-- <input type="text" name="group_id" class="form-control" id="" required> --}}
                                    <select name="group_id" class="form-select" id="group_id" required>
                                        <option value="" selected>Select Group
                                        </option>
                                        @foreach ($Groups as $group)
                                            <option value="{{ $group->id }}">
                                                {{ $group->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="departmentName" class="form-label">Season<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    {{-- <input type="text" name="group_id" class="form-control" id="" required> --}}
                                    <select name="season_id" class="form-select" id="season_id" required>
                                        <option value="" selected>Select Season
                                        </option>
                                        @foreach ($Seasons as $season)
                                            <option value="{{ $season->id }}">
                                                {{ $season->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row g-lg-12 g-2">
                            <div class="col-lg-6">
                                <label for="" class="form-label">planned area H<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="planned_area_ha" class="form-control"
                                        id="planned_area_ha" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="" class="form-label">planned yield
                                    tons<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="planned_yield_tons" class="form-control"
                                        id="planned_yield_tons" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-lg-12 g-2">

                            <div class="col-lg-6">
                                <label for="" class="form-label">planned inputs
                                    cost<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="planned_inputs_cost" class="form-control"
                                        id="planned_inputs_cost" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="" class="form-label">status<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="status" class="form-control" id="status_id" required>
                                        <option selected disabled>Select Status</option>
                                        <option value="DRAFT">DRAFT</option>
                                        <option value="SUBMITTED">SUBMITTED</option>
                                        <option value="APPROVED">APPROVED</option>
                                        <option value="REJECTED">REJECTED</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row g-lg-12 g-2">
                            <div class="col-lg-6">
                                <label for="" class="form-label">created by<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="created_by" disabled class="form-control"
                                        id="created_by" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="" class="form-label">approved by manager<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="approved_by_manager" disabled class="form-control"
                                        id="approved_by_manager" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-lg-12 g-2 mb-3">
                            <div class="col-lg-6">
                                <label for="" class="form-label">approval date<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="date" name="approval_date" disabled class="form-control"
                                        id="approval_date" required>
                                </div>
                            </div>

                        </div>
                        <div class="d-grid">
                            <button type="submit" id="mainActionBtn" class="btn btn-primary fw-semibold py-2">Add
                                Plan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function setAction(action, el = null) {
            // console.log(el.dataset.id);
            // alert(el.dataset.id);
            const btn = document.getElementById("mainActionBtn");
            const actionInput = document.getElementById("action");
            const title = document.getElementById("departmentModalTitle");

            actionInput.value = action;

            // Reset button styles
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");

            // title
            title.innerText = "";
            // Clear form on INSERT
            if (action === "INSERT") {
                document.getElementById("plan_id").value = "";
                document.getElementById("departmentModalTitle").value = " Add New Plan";
                document.getElementById("planned_area_ha").value = "";
                document.getElementById("planned_yield_tons").value = "";
                document.getElementById("planned_inputs_cost").value = "";
                document.getElementById("status_id").value = "";
                document.getElementById("created_by").value = "";
                document.getElementById("approved_by_manager").value = "";
                document.getElementById("approval_date").value = "";
            }

            // Fill form for VIEW / UPDATE / DELETE
            if (el) {
                document.getElementById("plan_id").value = el.dataset.id;
                document.getElementById("group_id").value = el.dataset.group;
                document.getElementById("season_id").value = el.dataset.season;
                document.getElementById("planned_area_ha").value = el.dataset.planned_area_ha;
                document.getElementById("planned_yield_tons").value = el.dataset.planned_yield_tons;
                document.getElementById("planned_inputs_cost").value = el.dataset.planned_inputs_cost;
                document.getElementById("status_id").value = el.dataset.status;
                document.getElementById("created_by").value = el.dataset.created_by;
                document.getElementById("approved_by_manager").value = el.dataset.approved_by_manager
                document.getElementById("approval_date").value = el.dataset.approval_date;

            }

            // Button behaviour
            if (action === "VIEW") {
                btn.classList.add("btn-info");
                btn.innerText = "View Plan";
                btn.disabled = true; // prevent submit
                disableForm(true);
                title.innerText = "View Plan";
            } else if (action === "UPDATE") {
                btn.classList.add("btn-success");
                btn.innerText = "Update Plan";
                btn.disabled = false;
                disableForm(false);
                title.innerText = " Update Plan";
            } else if (action === "DELETE") {
                btn.classList.add("btn-danger");
                btn.innerText = "Delete Plan";
                btn.disabled = false;
                disableForm(true);
                title.innerText = " Delete Plan";
            } else if (action === "INSERT") {
                btn.classList.add("btn-primary");
                btn.innerText = "Insert Plan";
                btn.disabled = false;
                disableForm(false);
                title.innerText = " Add New Plan";

            }
        }

        function disableForm(disabled) {
            // document.getElementById("group_id").disabled = disabled;
            // document.getElementById("season_id").disabled = disabled;
        }
    </script>


@endsection
