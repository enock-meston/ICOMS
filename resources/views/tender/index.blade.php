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
                        <button type="button" onclick="setAction('INSERT')"
                            data-bs-toggle="modal" data-bs-target="#tenderModal"
                            class="btn btn-sm btn-primary">
                            Add New Tender
                        </button>
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
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tenders List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ref No</th>
                                        <th>Title</th>
                                        <th>Method</th>
                                        <th>Publish Date</th>
                                        <th>Closing Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tenders as $index => $tender)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $tender->tender_ref_no }}</td>
                                            <td>{{ $tender->title }}</td>
                                            <td>{{ $tender->procurement_method }}</td>
                                            <td>{{ $tender->publish_date }}</td>
                                            <td>{{ $tender->closing_date }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($tender->status == 'PUBLISHED') bg-success
                                                    @elseif($tender->status == 'CLOSED') bg-danger
                                                    @elseif($tender->status == 'UNDER_EVALUATION') bg-warning
                                                    @elseif($tender->status == 'AWARDED') bg-info
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $tender->status }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-1">
                                                {{-- View button commented out as requested --}}
                                                {{-- 
                                                <button class="btn btn-info btn-sm"
                                                    onclick="setAction('VIEW', {{ json_encode($tender) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tenderModal">
                                                    <i class="ri-eye-line"></i> View
                                                </button>
                                                --}}

                                                {{-- Edit --}}
                                                <button class="btn btn-success btn-sm"
                                                    onclick="setAction('UPDATE', {{ json_encode($tender) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tenderModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>

                                                {{-- Delete --}}
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="setAction('DELETE', {{ json_encode($tender) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tenderModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No tenders found.</td>
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

    <!-- Tender Modal -->
    <div class="modal fade" id="tenderModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tenderModalTitle">Add New Tender</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tenders.action') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id"     id="tender_id">
                        <input type="hidden" name="action" id="tender_action">

                        <div class="row g-3" id="tenderFields">
                            <div class="col-md-6">
                                <label class="form-label">Reference No</label>
                                <input type="text" name="tender_ref_no" id="tender_ref_no"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" id="title"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Procurement Method</label>
                                <select name="procurement_method" id="procurement_method" class="form-select">
                                    <option value="OPEN_TENDER">Open Tender</option>
                                    <option value="RFQ">Request for Quotation (RFQ)</option>
                                    <option value="DIRECT">Direct</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Publish Date</label>
                                <input type="date" name="publish_date" id="publish_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Closing Date</label>
                                <input type="date" name="closing_date" id="closing_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="tender_status" class="form-select">
                                    <option value="PLANNED">Planned</option>
                                    <option value="PUBLISHED">Published</option>
                                    <option value="UNDER_EVALUATION">Under Evaluation</option>
                                    <option value="CLOSED">Closed</option>
                                    <option value="AWARDED">Awarded</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Notice File <small class="text-muted">(PDF/DOC)</small></label>
                                <input type="file" name="notice_file" id="notice_file"
                                    class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete tender
                            <strong id="deleteTenderName"></strong>?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="tenderMainActionBtn" class="btn btn-success">
                                Save Tender
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, tender = null) {
            const btn         = document.getElementById('tenderMainActionBtn');
            const actionInput = document.getElementById('tender_action');
            const title       = document.getElementById('tenderModalTitle');
            const fields      = document.getElementById('tenderFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;
            enableFields(false);

            if (action === 'INSERT') {
                document.querySelector('#tenderModal form').reset();
                document.getElementById('tender_id').value = '';
                title.innerText = 'Add New Tender';
                btn.innerText   = 'Save Tender';
                btn.disabled    = false;
                btn.classList.add('btn-success');
            }

            // ✅ Removed item_id reference — it no longer exists in the form
            if (tender) {
                document.getElementById('tender_id').value          = tender.id;
                document.getElementById('tender_ref_no').value      = tender.tender_ref_no;
                document.getElementById('title').value              = tender.title;
                document.getElementById('procurement_method').value = tender.procurement_method;
                document.getElementById('publish_date').value       = tender.publish_date ? tender.publish_date.substring(0, 10) : '';
                document.getElementById('closing_date').value       = tender.closing_date ? tender.closing_date.substring(0, 10) : '';
                document.getElementById('tender_status').value      = tender.status;
            }

            if (action === 'VIEW') {
                title.innerText = 'View Tender';
                btn.innerText   = 'Close';
                btn.disabled    = true;
                btn.classList.add('btn-info');
                enableFields(true);
            } else if (action === 'UPDATE') {
                title.innerText = 'Edit Tender';
                btn.innerText   = 'Update Tender';
                btn.disabled    = false;
                btn.classList.add('btn-success');
            } else if (action === 'DELETE' && tender) {
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                document.getElementById('deleteTenderName').innerText = tender.title;
                title.innerText = 'Delete Tender';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }

        function enableFields(disabled) {
            const ids = [
                'tender_ref_no', 'title',
                'procurement_method', 'publish_date',
                'closing_date', 'tender_status', 'notice_file'
            ];
            ids.forEach(id => {
                document.getElementById(id).disabled = disabled;
            });
        }
    </script>
@endsection