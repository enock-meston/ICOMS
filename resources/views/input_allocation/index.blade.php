@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript:void(0)">ICOMS</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <!-- Add Allocation Button -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                data-bs-target="#allocationModal" class="btn btn-primary btn-sm">Add Allocation</button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Allocation Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Allocations</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Season</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Value</th>
                                <th>Status</th>
                                <th>Approval Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @foreach($InputAllocations as $allocation)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $allocation->member->names ?? '-' }}</td>
                                    <td>{{ $allocation->season->name ?? '-' }}</td>
                                    <td>{{ $allocation->Type_ }}</td>
                                    <td>{{ $allocation->Quantity }}</td>
                                    <td>{{ $allocation->Unit_Cost }}</td>
                                    <td>{{ $allocation->Total_Value }}</td>
                                    <td>{{ $allocation->Status }}</td>
                                    <td>{{ $allocation->Approval_Date }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#allocationModal" onclick="setAction('VIEW', this)"
                                            data-id="{{ $allocation->id }}"
                                            data-member_id="{{ $allocation->member_id }}"
                                            data-season_id="{{ $allocation->season_id }}"
                                            data-type_="{{ $allocation->Type_ }}"
                                            data-quantity="{{ $allocation->Quantity }}"
                                            data-unit_cost="{{ $allocation->Unit_Cost }}"
                                            data-status="{{ $allocation->Status }}"
                                            {{-- data-approved_by_manager="{{ $allocation->approved_by_manager }}"
                                            data-Approval_Date="{{ $allocation->Approval_Date }}" --}}
                                            >
                                            View
                                        </button>

                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#allocationModal" onclick="setAction('UPDATE', this)"
                                            data-id="{{ $allocation->id }}"
                                            data-member_id="{{ $allocation->member_id }}"
                                            data-season_id="{{ $allocation->season_id }}"
                                            data-type_="{{ $allocation->Type_ }}"
                                            data-quantity="{{ $allocation->Quantity }}"
                                            data-unit_cost="{{ $allocation->Unit_Cost }}"
                                            data-status="{{ $allocation->Status }}"
                                            {{-- data-approved_by_manager="{{ $allocation->approved_by_manager }}"
                                            data-Approval_Date="{{ $allocation->Approval_Date }}" --}}
                                            >
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#allocationModal" onclick="setAction('DELETE', this)"
                                            data-id="{{ $allocation->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Allocation Modal -->
    <div class="modal fade" id="allocationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="allocationModalTitle">Add New Allocation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('allocation.handleAction') }}">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" id="action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Member</label>
                                <select name="member_id" id="member_id" class="form-select" required>
                                    <option value="">Select Member</option>
                                    @foreach($Members as $member)
                                        <option value="{{ $member->id }}">{{ $member->names }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Season</label>
                                <select name="season_id" id="season_id" class="form-select" required>
                                    <option value="">Select Season</option>
                                    @foreach($Seasons as $season)
                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Type (SEED / FERTILIZER / PESTICIDE / CASH / OTHER)</label>
                                {{-- <input type="text" name="Type_" id="Type_" class="form-control" required> --}}
                                <select name="Type_" id="Type_" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="SEED">SEED</option>
                                    <option value="FERTILIZER">FERTILIZER</option>
                                    <option value="PESTICIDE">PESTICIDE</option>
                                    <option value="CASH">CASH</option>
                                    <option value="OTHER">OTHER</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" step="0.01" name="Quantity" id="Quantity" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Unit Cost</label>
                                <input type="number" step="0.01" name="Unit_Cost" id="Unit_Cost" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" id="Status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="SUBMITTED">SUBMITTED</option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </div>

                            {{-- <div class="col-md-6">
                                <label class="form-label">Approved By Manager</label>
                                <input type="text" name="approved_by_manager" id="approved_by_manager" class="form-control">
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <label class="form-label">Approval Date</label>
                                <input type="date" name="Approval_Date" id="Approval_Date" class="form-control">
                            </div> --}}
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="mainActionBtn" class="btn btn-primary">Save Allocation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById("mainActionBtn");
            const actionInput = document.getElementById("action");
            const title = document.getElementById("allocationModalTitle");

            actionInput.value = action;

            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            title.innerText = "";

            // Clear form on INSERT
            if(action === "INSERT"){
                document.getElementById("id").value = "";
                document.getElementById("member_id").value = "";
                document.getElementById("season_id").value = "";
                document.getElementById("Type_").value = "";
                document.getElementById("Quantity").value = "";
                document.getElementById("Unit_Cost").value = "";
                document.getElementById("Status").value = "";
                // document.getElementById("approved_by_manager").value = "";
                // document.getElementById("Approval_Date").value = "";
            }

            // Fill form for VIEW / UPDATE / DELETE
            if(el){
                document.getElementById("id").value = el.dataset.id;
                document.getElementById("member_id").value = el.dataset.member_id;
                document.getElementById("season_id").value = el.dataset.season_id;
                document.getElementById("Type_").value = el.dataset.type_;
                document.getElementById("Quantity").value = el.dataset.quantity;
                document.getElementById("Unit_Cost").value = el.dataset.unit_cost;
                document.getElementById("Status").value = el.dataset.status;
                // document.getElementById("approved_by_manager").value = el.dataset.approved_by_manager;
                // document.getElementById("Approval_Date").value = el.dataset.Approval_Date;
            }

            if(action === "VIEW"){
                btn.classList.add("btn-info");
                btn.innerText = "View Allocation";
                btn.disabled = true;
            } else if(action === "UPDATE"){
                btn.classList.add("btn-success");
                btn.innerText = "Update Allocation";
                btn.disabled = false;
            } else if(action === "DELETE"){
                btn.classList.add("btn-danger");
                btn.innerText = "Delete Allocation";
                btn.disabled = false;
            } else if(action === "INSERT"){
                btn.classList.add("btn-primary");
                btn.innerText = "Add Allocation";
                btn.disabled = false;
            }
        }
    </script>

    {{--  --}}

    
@endsection
