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
                            data-bs-toggle="modal" data-bs-target="#evaluationModal"
                            class="btn btn-sm btn-primary">
                            New Evaluation
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
                                    @forelse($Evaluations as $evaluation)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $evaluation->tender_id }}</td>
                                            <td>{{ $evaluation->committee_id }}</td>
                                            <td>{{ $evaluation->evaluation_date }}</td>
                                            <td>{{ $evaluation->recommended_supplier_id }}</td>
                                            <td>{{ number_format($evaluation->recommended_amount, 2) }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($evaluation->status == 'APPROVED') bg-success
                                                    @elseif($evaluation->status == 'REJECTED') bg-danger
                                                    @elseif($evaluation->status == 'PENDING') bg-warning
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $evaluation->status }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-1">
                                                {{-- Edit --}}
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($evaluation) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#evaluationModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                {{-- Delete --}}
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($evaluation) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#evaluationModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No evaluations found.</td>
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

    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="evaluationModalTitle">Add New Evaluation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tender-evaluation.action') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id"     id="evaluation_id">
                        <input type="hidden" name="action" id="evaluation_action">
                        <input type="hidden" name="status" id="evaluation_status" value="PENDING">

                        <div class="row g-3" id="evaluationFields">
                            <div class="col-md-6">
                                <label class="form-label">Tender</label>
                                <select name="tender_id" id="tender_id" class="form-select">
                                    <option value="" disabled selected>Select Tender</option>
                                    @foreach($Tenders as $tender)
                                        <option value="{{ $tender->id }}">
                                            {{ $tender->tender_ref_no }} - {{ $tender->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Committee</label>
                                <select name="committee_id" id="committee_id" class="form-select">
                                    <option value="" disabled selected>Select Committee</option>
                                    @foreach($Committees as $committee)
                                        <option value="{{ $committee->id }}">
                                            {{ $committee->committee_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Evaluation Date</label>
                                <input type="date" name="evaluation_date" id="evaluation_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Report File <small class="text-muted">(PDF/DOC)</small></label>
                                <input type="file" name="report_file" id="report_file"
                                    class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recommended Supplier</label>
                                <select name="recommended_supplier_id" id="recommended_supplier_id"
                                    class="form-select">
                                    <option value="" disabled selected>Select Supplier</option>
                                    @foreach($Suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->supplier_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recommended Amount</label>
                                <input type="number" name="recommended_amount" id="recommended_amount"
                                    class="form-control" step="0.01">
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete this evaluation?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="evaluationMainActionBtn" class="btn btn-primary">
                                Save Evaluation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, evaluation = null) {
            const btn         = document.getElementById('evaluationMainActionBtn');
            const actionInput = document.getElementById('evaluation_action');
            const title       = document.getElementById('evaluationModalTitle');
            const fields      = document.getElementById('evaluationFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#evaluationModal form').reset();
                document.getElementById('evaluation_id').value     = '';
                document.getElementById('evaluation_status').value = 'PENDING';
                title.innerText = 'Add New Evaluation';
                btn.innerText   = 'Save Evaluation';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && evaluation) {
                document.getElementById('evaluation_id').value              = evaluation.id;
                document.getElementById('tender_id').value                  = evaluation.tender_id;
                document.getElementById('committee_id').value               = evaluation.committee_id;
                document.getElementById('evaluation_date').value            = evaluation.evaluation_date ? evaluation.evaluation_date.substring(0, 10) : '';
                document.getElementById('recommended_supplier_id').value    = evaluation.recommended_supplier_id;
                document.getElementById('recommended_amount').value         = evaluation.recommended_amount;
                document.getElementById('evaluation_status').value          = evaluation.status;
                title.innerText = 'Edit Evaluation';
                btn.innerText   = 'Update Evaluation';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && evaluation) {
                document.getElementById('evaluation_id').value = evaluation.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                title.innerText = 'Delete Evaluation';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection