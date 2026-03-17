@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item">ICOMS</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-12">
            <div class="card border p-3">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button"
                        onclick="setAction('INSERT')"
                        data-bs-toggle="modal"
                        data-bs-target="#planModal"
                        class="btn btn-sm btn-primary">Add Procurement Plan</button>
                </div>
            </div>
        </div>
    </div>
        <!-- SUCCESS MESSAGE -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button class="btn-close" data-bs-dismiss="alert"></button>
        {{ session('success') }}
    </div>
    @endif
    <!-- ERRORS -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button class="btn-close" data-bs-dismiss="alert"></button>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Procurement Plans</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fiscal Year</th>
                            <th>Prepared By</th>
                            <th>Manager Approval</th>
                            <th>Board Approval</th>
                            <th>Approval Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $i => $plan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $plan->fiscal_year }}</td>
                                <td>{{ $plan->prepared_by }}</td>
                                <td>{{ $plan->approved_by_manager }}</td>
                                <td>{{ $plan->approved_by_board }}</td>
                                <td>{{ $plan->approval_date }}</td>
                                <td>{{ $plan->status }}</td>
                                <td>
                                    <!-- VIEW -->
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#planModal"
                                        onclick="setAction('VIEW',this)" data-id="{{ $plan->id }}"
                                        data-fiscal_year="{{ $plan->fiscal_year }}"
                                        data-prepared_by="{{ $plan->prepared_by }}"
                                        data-approved_by_manager="{{ $plan->approved_by_manager }}"
                                        data-approved_by_board="{{ $plan->approved_by_board }}"
                                        data-approval_date="{{ $plan->approval_date }}"
                                        data-status="{{ $plan->status }}">View</button>
                                    <!-- UPDATE -->
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#planModal" onclick="setAction('UPDATE',this)"
                                        data-id="{{ $plan->id }}" data-fiscal_year="{{ $plan->fiscal_year }}"
                                        data-prepared_by="{{ $plan->prepared_by }}"
                                        data-approved_by_manager="{{ $plan->approved_by_manager }}"
                                        data-approved_by_board="{{ $plan->approved_by_board }}"
                                        data-approval_date="{{ $plan->approval_date }}"
                                        data-status="{{ $plan->status }}">Edit</button>
                                    <!-- DELETE -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#planModal"
                                        onclick="setAction('DELETE',this)" data-id="{{ $plan->id }}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    No plans found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- MODAL -->
    <div class="modal fade" id="planModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="planModalTitle">Create Plan</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('procurementPlan.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="plan_id">
                        <input type="hidden" name="action" id="plan_action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Fiscal Year</label>
                                <input type="text" name="fiscal_year" id="fiscal_year" class="form-control">
                            </div>
                           
                            <div class="col-md-6">
                                <label>Approved By Manager</label>
                                <select name="approved_by_manager" id="approved_by_manager" class="form-select">
                                    @foreach ($Users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Approved By Board</label>
                                <select name="approved_by_board" id="approved_by_board" class="form-select">
                                     @foreach ($Users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Approval Date</label>
                                <input type="date" name="approval_date" id="approval_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" id="statuss" class="form-select">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="UNDER_REVIEW">UNDER_REVIEW</option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="ARCHIVED">ARCHIVED</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button type="submit" id="planMainActionBtn" class="btn btn-primary">
                                Save Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('planMainActionBtn')
            const actionInput = document.getElementById('plan_action')
            const title = document.getElementById('planModalTitle')
            actionInput.value = action
            btn.classList.remove("btn-info", "btn-success", "btn-danger", "btn-primary")
            if (action === "INSERT") {
                document.querySelector('#planModal form').reset()
                document.getElementById('plan_id').value = ''
                btn.innerText = "Create Plan"
                title.innerText = "Create Procurement Plan"
                btn.disabled = false
                btn.classList.add("btn-primary")
            }
            if (el) {
                document.getElementById('plan_id').value = el.dataset.id || ''
                document.getElementById('fiscal_year').value = el.dataset.fiscal_year || ''
                document.getElementById('prepared_by').value = el.dataset.prepared_by || ''
                document.getElementById('approved_by_manager').value = el.dataset.approved_by_manager || ''
                document.getElementById('approved_by_board').value = el.dataset.approved_by_board || ''
                document.getElementById('approval_date').value = el.dataset.approval_date || ''
                document.getElementById('statuss').value = el.dataset.status || ''
            }
            if (action === "VIEW") {
                btn.innerText = "View Plan"
                title.innerText = "View Plan"
                btn.disabled = true
                btn.classList.add("btn-info")
            }
            if (action === "UPDATE") {
                btn.innerText = "Update Plan"
                title.innerText = "Update Plan"
                btn.disabled = false
                btn.classList.add("btn-success")
            }
            if (action === "DELETE") {
                btn.innerText = "Delete Plan"
                title.innerText = "Delete Plan"
                btn.disabled = false
                btn.classList.add("btn-danger")
            }

        }
    </script>
@endsection
