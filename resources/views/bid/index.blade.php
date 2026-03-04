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
                            data-bs-target="#bidModal"
                            class="btn btn-sm btn-primary">Add New Bid
                        </button>
                    </div>
                </div>

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
                    <div class="card-header">
                        <h4 class="card-title">Bids List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tender</th>
                                        <th>Supplier</th>
                                        <th>Bid Amount</th>
                                        <th>Tech Score</th>
                                        <th>Fin Score</th>
                                        <th>Overall</th>
                                        <th>Result</th>
                                        <th>Submitted At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bids as $index => $bid)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $bid->tender->title ?? 'N/A' }}</td>
                                            <td>{{ $bid->supplier->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($bid->bid_amount, 2) }}</td>
                                            <td>{{ $bid->technical_score }}</td>
                                            <td>{{ $bid->financial_score }}</td>
                                            <td>{{ $bid->overall_score }}</td>
                                            <td>
                                                <span class="badge @if($bid->evaluation_result == 'SELECTED') bg-success @elseif($bid->evaluation_result == 'REJECTED') bg-danger @else bg-secondary @endif">
                                                    {{ $bid->evaluation_result }}
                                                </span>
                                            </td>
                                            <td>{{ $bid->submitted_at ? $bid->submitted_at->format('Y-m-d') : 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#bidModal" onclick="setAction('VIEW', this)"
                                                    data-id="{{ $bid->id }}"
                                                    data-tender_id="{{ $bid->tender_id }}"
                                                    data-supplier_id="{{ $bid->supplier_id }}"
                                                    data-bid_amount="{{ $bid->bid_amount }}"
                                                    data-technical_score="{{ $bid->technical_score }}"
                                                    data-financial_score="{{ $bid->financial_score }}"
                                                    data-overall_score="{{ $bid->overall_score }}"
                                                    data-evaluation_result="{{ $bid->evaluation_result }}"
                                                    data-recommendation="{{ $bid->recommendation }}"
                                                    data-submitted_at="{{ $bid->submitted_at ? $bid->submitted_at->format('Y-m-d') : '' }}">
                                                    View
                                                </button>

                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#bidModal" onclick="setAction('UPDATE', this)"
                                                    data-id="{{ $bid->id }}"
                                                    data-tender_id="{{ $bid->tender_id }}"
                                                    data-supplier_id="{{ $bid->supplier_id }}"
                                                    data-bid_amount="{{ $bid->bid_amount }}"
                                                    data-technical_score="{{ $bid->technical_score }}"
                                                    data-financial_score="{{ $bid->financial_score }}"
                                                    data-overall_score="{{ $bid->overall_score }}"
                                                    data-evaluation_result="{{ $bid->evaluation_result }}"
                                                    data-recommendation="{{ $bid->recommendation }}"
                                                    data-submitted_at="{{ $bid->submitted_at ? $bid->submitted_at->format('Y-m-d') : '' }}">
                                                    Edit
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
        </div>
    </div>

    <!-- Bid Modal -->
    <div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="bidModalTitle">Add New Bid</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="bid_id">
                        <input type="hidden" name="action" id="bid_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tender</label>
                                <select name="tender_id" id="tender_id" class="form-select" required>
                                    <option value="" disabled selected>Select Tender</option>
                                    @foreach ($tenders as $tender)
                                        <option value="{{ $tender->id }}">{{ $tender->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="" disabled selected>Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bid Amount</label>
                                <input type="number" step="0.01" name="bid_amount" id="bid_amount" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Technical Score</label>
                                <input type="number" step="0.01" name="technical_score" id="technical_score" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Financial Score</label>
                                <input type="number" step="0.01" name="financial_score" id="financial_score" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Overall Score</label>
                                <input type="number" step="0.01" name="overall_score" id="overall_score" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Evaluation Result</label>
                                <select name="evaluation_result" id="evaluation_result" class="form-select">
                                    <option value="PENDING">PENDING</option>
                                    <option value="SELECTED">SELECTED</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Submitted At</label>
                                <input type="date" name="submitted_at" id="submitted_at" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Recommendation</label>
                                <textarea name="recommendation" id="recommendation" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="bidMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Bid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('bidMainActionBtn');
            const actionInput = document.getElementById("bid_action");
            const title = document.getElementById('bidModalTitle');
            const form = document.querySelector('#bidModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('bid_id').value = '';
                btn.innerText = 'Insert Bid';
                btn.disabled = false;
                title.innerText = 'Add New Bid';
                btn.classList.add("btn-primary");
                enableFields(false);
            }

            if (el) {
                document.getElementById('bid_id').value = el.dataset.id;
                document.getElementById('tender_id').value = el.dataset.tender_id;
                document.getElementById('supplier_id').value = el.dataset.supplier_id;
                document.getElementById('bid_amount').value = el.dataset.bid_amount;
                document.getElementById('technical_score').value = el.dataset.technical_score;
                document.getElementById('financial_score').value = el.dataset.financial_score;
                document.getElementById('overall_score').value = el.dataset.overall_score;
                document.getElementById('evaluation_result').value = el.dataset.evaluation_result;
                document.getElementById('recommendation').value = el.dataset.recommendation;
                document.getElementById('submitted_at').value = el.dataset.submitted_at;
            }

            if (action === 'VIEW') {
                btn.innerText = 'View Bid';
                btn.disabled = true;
                title.innerText = 'View Bid';
                btn.classList.add("btn-info");
                enableFields(true);
            } else if (action === 'UPDATE') {
                btn.innerText = 'Update Bid';
                btn.disabled = false;
                title.innerText = 'Update Bid';
                btn.classList.add("btn-success");
                enableFields(false);
            }
        }

        function enableFields(disabled) {
            const fields = ['tender_id', 'supplier_id', 'bid_amount', 'technical_score', 'financial_score', 'overall_score', 'evaluation_result', 'recommendation', 'submitted_at'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.disabled = disabled;
            });
        }
    </script>
@endsection
