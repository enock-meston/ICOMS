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
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Plan</th>
                                    <th>Activity Type</th>
                                    <th>Planned Date</th>
                                    <th>Actual Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($FieldActivities as $i => $activity)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $activity->plan_id }}</td>
                                        <td>{{ $activity->activity_type }}</td>
                                        <td>{{ $activity->planned_date }}</td>
                                        <td>{{ $activity->actual_date ?? '-' }}</td>
                                        <td>{{ $activity->status }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('VIEW', this)"
                                                data-id="{{ $activity->id }}" data-plan_id="{{ $activity->plan_id }}"
                                                data-activity_type="{{ $activity->activity_type }}"
                                                data-planned_date="{{ $activity->planned_date }}"
                                                data-actual_date="{{ $activity->actual_date }}"
                                                data-status="{{ $activity->status }}">
                                                View
                                            </button>

                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('UPDATE', this)"
                                                data-id="{{ $activity->id }}" data-plan_id="{{ $activity->plan_id }}"
                                                data-activity_type="{{ $activity->activity_type }}"
                                                data-planned_date="{{ $activity->planned_date }}"
                                                data-actual_date="{{ $activity->actual_date }}"
                                                data-status="{{ $activity->status }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#bs-example-modal-lg" onclick="setAction('DELETE', this)"
                                                data-id="{{ $activity->id }}" data-plan_id="{{ $activity->plan_id }}"
                                                data-activity_type="{{ $activity->activity_type }}"
                                                data-planned_date="{{ $activity->planned_date }}"
                                                data-actual_date="{{ $activity->actual_date }}"
                                                data-status="{{ $activity->status }}">
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
                    <h4 class="modal-title" id="departmentModalTitle">Add New Field Activity
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('field-activity.store') }}">
                        @csrf

                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" id="action">

                        <div class="mb-3">
                            <label class="form-label">Product Plan </label>

                            <Select class="form-control" name="plan_id" id="plan_id">
                                @foreach ($ProductPlan as $item)
                                    <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->group->name }}</option>
                                @endforeach
                            </Select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Activity Type</label>
                            <select class="form-select" name="activity_type" id="activity_type">
                                <option value="Land_Prep">Land_Prep</option>
                                <option value="Transplanting">Transplanting</option>
                                <option value="Weeding">Weeding</option>
                                <option value="Compost_Preparation">Compost_Preparation</option>
                                <option value="Compost_Turning">Compost_Turning</option>
                                <option value="Fertilizer_Application">Fertilizer_Application</option>
                                <option value="Harvest">Harvest</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Planned Date</label>
                            <input type="date" name="planned_date" id="planned_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Actual Date</label>
                            <input type="date" name="actual_date" id="actual_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="statuss" class="form-select">
                                <option value="PENDING">PENDING</option>
                                <option value="DONE">DONE</option>
                                <option value="DELAYED">DELAYED</option>
                                <option value="CANCELLED">CANCELLED</option>
                            </select>
                        </div>

                        <button type="submit" id="mainActionBtn" class="btn btn-primary w-100">
                            Save
                        </button>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function setAction(action, el = null) {
            document.getElementById('action').value = action;
            const btn = document.getElementById('mainActionBtn');
            const title = document.getElementById("departmentModalTitle");
             // title
            title.innerText = "";
            if (action === 'INSERT') {
                document.getElementById('id').value = '';
                document.querySelector('form').reset();
                btn.innerText = 'Insert Activity';
                btn.disabled = false;
                disableForm(false);
            }

            if (el) {
                document.getElementById('id').value = el.dataset.id || '';
                document.getElementById('plan_id').value = el.dataset.plan_id || '';
                document.getElementById('activity_type').value = el.dataset.activity_type || '';
                document.getElementById('planned_date').value = el.dataset.planned_date || '';
                document.getElementById('actual_date').value = el.dataset.actual_date || '';
                document.getElementById('statuss').value = el.dataset.status || '';
            }

            if (action === 'VIEW') {
                btn.innerText = 'View Activity';
                btn.classList.add("btn-info");
                 title.innerText = "View";
                btn.disabled = true;
                disableForm(true);
            }

            if (action === 'UPDATE') {
                btn.classList.add("btn-success");
                title.innerText = "Update";
                btn.innerText = 'Update Activity';
                btn.disabled = false;
                disableForm(false);
            }

            if (action === 'DELETE') {
                 btn.classList.add("btn-danger");
                title.innerText = "Delete";
                btn.innerText = 'Delete Activity';
                btn.disabled = false;
                disableForm(true);
            }
        }

        function disableForm(disabled) {
            // document.getElementById('plan_id').disabled = disabled;
            // document.getElementById('activity_type').disabled = disabled;
            // document.getElementById('planned_date').disabled = disabled;
            // document.getElementById('actual_date').disabled = disabled;
            // document.getElementById('status').disabled = disabled;
        }
    </script>



@endsection
