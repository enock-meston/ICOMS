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
                            data-bs-target="#contractModal"
                            class="btn btn-sm btn-primary">Add New Contract
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contracts List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Contract No</th>
                                        <th>Supplier</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">No contracts found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contract Modal -->
    <div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="contractModalTitle">Add New Contract</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="contract_id">
                        <input type="hidden" name="action" id="contract_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Contract No</label>
                                <input type="text" name="contract_no" id="contract_no" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tender</label>
                                <select name="tender_id" id="tender_id" class="form-select" required>
                                    <option value="" disabled selected>Select Tender</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="" disabled selected>Select Supplier</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contract Amount</label>
                                <input type="number" name="contract_amount" id="contract_amount" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="TERMINATED">TERMINATED</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="contractMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Contract</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('contractMainActionBtn');
            const actionInput = document.getElementById("contract_action");
            const title = document.getElementById('contractModalTitle');
            const form = document.querySelector('#contractModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('contract_id').value = '';
                btn.innerText = 'Insert Contract';
                btn.disabled = false;
                title.innerText = 'Add New Contract';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
