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
                            data-bs-target="#paymentModal"
                            class="btn btn-sm btn-primary">Record Supplier Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Supplier Payments List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Contract</th>
                                        <th>Supplier</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Channel</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">No payments found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="paymentModalTitle">Record Supplier Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="payment_id">
                        <input type="hidden" name="action" id="payment_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Contract</label>
                                <select name="contract_id" id="contract_id" class="form-select" required>
                                    <option value="" disabled selected>Select Contract</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="" disabled selected>Select Supplier</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Channel</label>
                                <select name="channel" id="channel" class="form-select" required>
                                    <option value="BANK">Bank Transfer</option>
                                    <option value="CASH">Cash</option>
                                    <option value="MOBILE_MONEY">Mobile Money</option>
                                    <option value="CHEQUE">Cheque</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="PENDING">PENDING</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="FAILED">FAILED</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="paymentMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Record Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('paymentMainActionBtn');
            const actionInput = document.getElementById("payment_action");
            const title = document.getElementById('paymentModalTitle');
            const form = document.querySelector('#paymentModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('payment_id').value = '';
                btn.innerText = 'Record Payment';
                btn.disabled = false;
                title.innerText = 'Record Supplier Payment';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
