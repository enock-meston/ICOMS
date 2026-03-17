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

        @if(session('success'))
            <div class="alert alert-success text-bg-success alert-dismissible mt-2" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible mt-2" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')"
                            data-bs-toggle="modal" data-bs-target="#paymentModal"
                            class="btn btn-sm btn-primary">
                            Record Supplier Payment
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
                                    @forelse($Payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->contract_id }}</td>
                                            <td>{{ $payment->supplier_id }}</td>
                                            <td>{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>{{ $payment->channel }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($payment->status == 'COMPLETED') bg-success
                                                    @elseif($payment->status == 'FAILED') bg-danger
                                                    @elseif($payment->status == 'PENDING') bg-warning
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $payment->status }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-1">
                                                {{-- Edit --}}
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($payment) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#paymentModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                {{-- Delete --}}
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($payment) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#paymentModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No payments found.</td>
                                        </tr>
                                    @endforelse
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
                    <form method="POST" action="{{ route('supplier-payment.action') }}">
                        @csrf
                        <input type="hidden" name="id"     id="payment_id">
                        <input type="hidden" name="action" id="payment_action">

                        <div class="row g-3" id="paymentFields">
                            <div class="col-md-6">
                                <label class="form-label">Contract</label>
                                <select name="contract_id" id="contract_id" class="form-select">
                                    <option value="" disabled selected>Select Contract</option>
                                    {{-- populate when contracts module is ready --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select">
                                    <option value="" disabled selected>Select Supplier</option>
                                    @foreach($Suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->supplier_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Channel</label>
                                <select name="channel" id="payment_channel" class="form-select">
                                    <option value="BANK">Bank Transfer</option>
                                    <option value="CASH">Cash</option>
                                    <option value="MOBILE_MONEY">Mobile Money</option>
                                    <option value="CHEQUE">Cheque</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="payment_status" class="form-select">
                                    <option value="PENDING">PENDING</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="FAILED">FAILED</option>
                                </select>
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete this payment?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="paymentMainActionBtn" class="btn btn-primary">
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, payment = null) {
            const btn         = document.getElementById('paymentMainActionBtn');
            const actionInput = document.getElementById('payment_action');
            const title       = document.getElementById('paymentModalTitle');
            const fields      = document.getElementById('paymentFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#paymentModal form').reset();
                document.getElementById('payment_id').value = '';
                title.innerText = 'Record Supplier Payment';
                btn.innerText   = 'Record Payment';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && payment) {
                document.getElementById('payment_id').value       = payment.id;
                document.getElementById('contract_id').value      = payment.contract_id;
                document.getElementById('supplier_id').value      = payment.supplier_id;
                document.getElementById('amount').value           = payment.amount;
                document.getElementById('payment_date').value     = payment.payment_date ? payment.payment_date.substring(0, 10) : '';
                document.getElementById('payment_channel').value  = payment.channel;
                document.getElementById('payment_status').value   = payment.status;
                title.innerText = 'Edit Payment';
                btn.innerText   = 'Update Payment';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && payment) {
                document.getElementById('payment_id').value = payment.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                title.innerText = 'Delete Payment';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection