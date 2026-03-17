@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

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

        <div class="card border p-3 mb-3">
            <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#contractModal"
                class="btn btn-primary btn-sm">Add New Contract</button>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
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
                                <th>Tender</th>
                                <th>Supplier</th>
                                <th>Contract No</th>
                                <th>Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $index => $contract)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $contract->tender->title ?? 'N/A' }}</td>
                                    <td>{{ $contract->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $contract->contract_no }}</td>
                                    <td>{{ number_format($contract->contract_amount, 2) }}</td>
                                    <td>{{ $contract->start_date }}</td>
                                    <td>{{ $contract->end_date }}</td>
                                    <td>{{ $contract->status }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#contractModal" onclick="setAction('VIEW', this)"
                                            data-id="{{ $contract->id }}" data-tender_id="{{ $contract->tender_id }}"
                                            data-supplier_id="{{ $contract->supplier_id }}"
                                            data-contract_no="{{ $contract->contract_no }}"
                                            data-description="{{ $contract->description }}"
                                            data-contract_amount="{{ $contract->contract_amount }}"
                                            data-start_date="{{ $contract->start_date }}"
                                            data-end_date="{{ $contract->end_date }}"
                                            data-signed_by_manager="{{ $contract->signed_by_manager }}"
                                            data-signed_at="{{ $contract->signed_at }}"
                                            data-status="{{ $contract->status }}">
                                            View
                                        </button>

                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#contractModal" onclick="setAction('UPDATE', this)"
                                            data-id="{{ $contract->id }}" data-tender_id="{{ $contract->tender_id }}"
                                            data-supplier_id="{{ $contract->supplier_id }}"
                                            data-contract_no="{{ $contract->contract_no }}"
                                            data-description="{{ $contract->description }}"
                                            data-contract_amount="{{ $contract->contract_amount }}"
                                            data-start_date="{{ $contract->start_date }}"
                                            data-end_date="{{ $contract->end_date }}"
                                            data-signed_by_manager="{{ $contract->signed_by_manager }}"
                                            data-signed_at="{{ $contract->signed_at }}"
                                            data-status="{{ $contract->status }}">
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#contractModal" onclick="setAction('DELETE', this)"
                                            data-id="{{ $contract->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="contractModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="contractModalTitle">Add Contract</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('contract.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="contract_id">
                        <input type="hidden" name="action" id="contract_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Tender</label>
                                <select name="tender_id" id="tender_id" class="form-select" required>
                                    <option value="">Select Tender</option>
                                    @foreach ($tenders as $tender)
                                        <option value="{{ $tender->id }}">{{ $tender->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Contract No</label>
                                <input type="text" name="contract_no" id="contract_no" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Contract Amount</label>
                                <input type="number" step="0.01" name="contract_amount" id="contract_amount"
                                    class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Signed By Manager</label>
                                <input type="number" name="signed_by_manager" id="signed_by_manager"
                                    class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Signed At</label>
                                <input type="date" name="signed_at" id="signed_at" class="form-control">
                            </div>

                            <div class="col-12">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>

                            <div class="col-12">
                                <label>Status</label>
                                <input type="text" name="status" id="status" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="contractMainActionBtn" class="btn btn-primary">Save
                                Contract</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('contractMainActionBtn');
            const actionInput = document.getElementById('contract_action');
            const title = document.getElementById('contractModalTitle');

            actionInput.value = action;
            btn.classList.remove("btn-primary", "btn-info", "btn-success", "btn-danger");

            if (action === "INSERT") {
                document.querySelector('#contractModal form').reset();
                document.getElementById('contract_id').value = '';
                btn.innerText = 'Insert Contract';
                title.innerText = 'Add Contract';
                btn.disabled = false;
                btn.classList.add("btn-primary");
            }

            if (el) {
                document.getElementById('contract_id').value = el.dataset.id || '';
                document.getElementById('tender_id').value = el.dataset.tender_id || '';
                document.getElementById('supplier_id').value = el.dataset.supplier_id || '';
                document.getElementById('contract_no').value = el.dataset.contract_no || '';
                document.getElementById('contract_amount').value = el.dataset.contract_amount || '';
                document.getElementById('start_date').value = el.dataset.start_date || '';
                document.getElementById('end_date').value = el.dataset.end_date || '';
                document.getElementById('signed_by_manager').value = el.dataset.signed_by_manager || '';
                document.getElementById('signed_at').value = el.dataset.signed_at || '';
                document.getElementById('description').value = el.dataset.description || '';
                document.getElementById('status').value = el.dataset.status || '';
            }

            if (action === "VIEW") {
                btn.innerText = "View Contract";
                title.innerText = "View Contract";
                btn.disabled = true;
                enableFields(true);
                btn.classList.add("btn-info");
            } else if (action === "UPDATE") {
                btn.innerText = "Update Contract";
                title.innerText = "Update Contract";
                btn.disabled = false;
                enableFields(false);
                btn.classList.add("btn-success");
            } else if (action === "DELETE") {
                btn.innerText = "Delete Contract";
                title.innerText = "Delete Contract";
                btn.disabled = false;
                enableFields(false);
                btn.classList.add("btn-danger");
            }
        }

        function enableFields(disabled) {
            const fields = ['tender_id', 'supplier_id', 'contract_no', 'contract_amount', 'start_date', 'end_date',
                'signed_by_manager', 'signed_at', 'description', 'status'
            ];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.disabled = disabled;
            });
        }
    </script>
@endsection
