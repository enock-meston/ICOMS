@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">ICOMS</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#planModal"
                            class="btn btn-sm btn-primary">Add New Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Procurement Plans List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fiscal Year</th>
                                        <th>Prepared By</th>
                                        <th>Approval Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">No plans found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Modal -->
    <div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="planModalTitle">Add New Plan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="plan_id">
                        <input type="hidden" name="action" id="plan_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Fiscal Year</label>
                                <input type="text" name="fiscal_year" id="fiscal_year" class="form-control" placeholder="e.g. 2025-2026" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prepared By</label>
                                <select name="prepared_by" id="prepared_by" class="form-select" required>
                                    <option value="" disabled selected>Select User</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="SUBMITTED">SUBMITTED</option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>Plan Items</h5>
                            <button type="button" class="btn btn-sm btn-info mb-2">Add Item</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Unit Cost</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">No items added.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="planMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Plan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('planMainActionBtn');
            const actionInput = document.getElementById("plan_action");
            const title = document.getElementById('planModalTitle');
            const form = document.querySelector('#planModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('plan_id').value = '';
                btn.innerText = 'Insert Plan';
                btn.disabled = false;
                title.innerText = 'Add New Plan';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
