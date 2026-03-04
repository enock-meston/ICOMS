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
                            data-bs-target="#evaluationModal"
                            class="btn btn-sm btn-primary">New Evaluation
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tender Evaluations List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tender</th>
                                        <th>Committee</th>
                                        <th>Evaluation Date</th>
                                        <th>Recommended Supplier</th>
                                        <th>Recommended Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">No evaluations found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="evaluationModalTitle">Add New Evaluation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="evaluation_id">
                        <input type="hidden" name="action" id="evaluation_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tender</label>
                                <select name="tender_id" id="tender_id" class="form-select" required>
                                    <option value="" disabled selected>Select Tender</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Committee</label>
                                <select name="committee_id" id="committee_id" class="form-select" required>
                                    <option value="" disabled selected>Select Committee</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Evaluation Date</label>
                                <input type="date" name="evaluation_date" id="evaluation_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Report File</label>
                                <input type="file" name="report_file" id="report_file" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recommended Supplier</label>
                                <select name="recommended_supplier_id" id="recommended_supplier_id" class="form-select">
                                    <option value="" disabled selected>Select Supplier</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recommended Amount</label>
                                <input type="number" name="recommended_amount" id="recommended_amount" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="evaluationMainActionBtn" class="btn btn-primary" onclick="alert('Save action triggered')">Save Evaluation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('evaluationMainActionBtn');
            const actionInput = document.getElementById("evaluation_action");
            const title = document.getElementById('evaluationModalTitle');
            const form = document.querySelector('#evaluationModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('evaluation_id').value = '';
                btn.innerText = 'Insert Evaluation';
                btn.disabled = false;
                title.innerText = 'Add New Evaluation';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
