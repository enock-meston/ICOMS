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
                            data-bs-target="#tenderModal"
                            class="btn btn-sm btn-primary">Add New Tender
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
                                        <th>Item</th>
                                        <th>Method</th>
                                        <th>Publish Date</th>
                                        <th>Closing Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenders as $index => $tender)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $tender->tender_ref_no }}</td>
                                            <td>{{ $tender->title }}</td>
                                            <td>{{ $tender->item->description ?? 'N/A' }}</td>
                                            <td>{{ $tender->procurement_method }}</td>
                                            <td>{{ $tender->publish_date }}</td>
                                            <td>{{ $tender->closing_date }}</td>
                                            <td>
                                                <span class="badge @if($tender->status == 'PUBLISHED') bg-success @elseif($tender->status == 'CLOSED') bg-danger @else bg-secondary @endif">
                                                    {{ $tender->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#tenderModal" onclick="setAction('VIEW', this)"
                                                    data-id="{{ $tender->id }}"
                                                    data-tender_ref_no="{{ $tender->tender_ref_no }}"
                                                    data-title="{{ $tender->title }}"
                                                    data-item_id="{{ $tender->item_id }}"
                                                    data-procurement_method="{{ $tender->procurement_method }}"
                                                    data-publish_date="{{ $tender->publish_date }}"
                                                    data-closing_date="{{ $tender->closing_date }}"
                                                    data-status="{{ $tender->status }}">
                                                    View
                                                </button>

                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#tenderModal" onclick="setAction('UPDATE', this)"
                                                    data-id="{{ $tender->id }}"
                                                    data-tender_ref_no="{{ $tender->tender_ref_no }}"
                                                    data-title="{{ $tender->title }}"
                                                    data-item_id="{{ $tender->item_id }}"
                                                    data-procurement_method="{{ $tender->procurement_method }}"
                                                    data-publish_date="{{ $tender->publish_date }}"
                                                    data-closing_date="{{ $tender->closing_date }}"
                                                    data-status="{{ $tender->status }}">
                                                    Edit
                                                </button>

                                                <button class="btn btn-danger btn-sm" onclick="alert('Delete action triggered for ID: {{ $tender->id }}')">
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
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="tender_id">
                        <input type="hidden" name="action" id="tender_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Reference No</label>
                                <input type="text" name="tender_ref_no" id="tender_ref_no" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Procurement Item</label>
                                <select name="item_id" id="item_id" class="form-select" required>
                                    <option value="" disabled selected>Select Item</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Procurement Method</label>
                                <select name="procurement_method" id="procurement_method" class="form-select" required>
                                    <option value="Open Tender">Open Tender</option>
                                    <option value="Restricted Tender">Restricted Tender</option>
                                    <option value="Request for Quotation">Request for Quotation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Publish Date</label>
                                <input type="date" name="publish_date" id="publish_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Closing Date</label>
                                <input type="date" name="closing_date" id="closing_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="PUBLISHED">PUBLISHED</option>
                                    <option value="CLOSED">CLOSED</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="tenderMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Tender</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('tenderMainActionBtn');
            const actionInput = document.getElementById("tender_action");
            const title = document.getElementById('tenderModalTitle');
            const form = document.querySelector('#tenderModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('tender_id').value = '';
                btn.innerText = 'Insert Tender';
                btn.disabled = false;
                title.innerText = 'Add New Tender';
                btn.classList.add("btn-primary");
                enableFields(false);
            }

            if (el) {
                document.getElementById('tender_id').value = el.dataset.id;
                document.getElementById('tender_ref_no').value = el.dataset.tender_ref_no;
                document.getElementById('title').value = el.dataset.title;
                document.getElementById('item_id').value = el.dataset.item_id;
                document.getElementById('procurement_method').value = el.dataset.procurement_method;
                document.getElementById('publish_date').value = el.dataset.publish_date;
                document.getElementById('closing_date').value = el.dataset.closing_date;
                document.getElementById('status').value = el.dataset.status;
            }

            if (action === 'VIEW') {
                btn.innerText = 'View Tender';
                btn.disabled = true;
                title.innerText = 'View Tender';
                btn.classList.add("btn-info");
                enableFields(true);
            } else if (action === 'UPDATE') {
                btn.innerText = 'Update Tender';
                btn.disabled = false;
                title.innerText = 'Update Tender';
                btn.classList.add("btn-success");
                enableFields(false);
            }
        }

        function enableFields(disabled) {
            const fields = ['tender_ref_no', 'title', 'item_id', 'procurement_method', 'publish_date', 'closing_date', 'status'];
            fields.forEach(id => {
                document.getElementById(id).disabled = disabled;
            });
        }
    </script>
@endsection
