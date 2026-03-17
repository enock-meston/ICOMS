@extends('layouts.admin.app')
@section('content')
    @php $Committees = $Committees ?? []; @endphp
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

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')"
                            data-bs-toggle="modal" data-bs-target="#committeeModal"
                            class="btn btn-sm btn-primary">
                            Add New Committee
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Committees List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($Committees as $committee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $committee->committee_name }}</td>
                                            <td>{{ $committee->committee_type }}</td>
                                            <td>{{ $committee->start_date }}</td>
                                            <td>{{ $committee->end_date }}</td>
                                            <td>
                                                <span class="badge {{ $committee->status == 'ACTIVE' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $committee->status }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-1">
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($committee) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#committeeModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($committee) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#committeeModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No committees found.</td>
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

    <!-- Committee Modal -->
    <div class="modal fade" id="committeeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="committeeModalTitle">Add New Committee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('committees.action') }}">
                        @csrf
                        <input type="hidden" name="id"     id="committee_id">
                        <input type="hidden" name="action" id="committee_action">

                        <div class="row g-3" id="committeeFields">
                            <div class="col-md-6">
                                <label class="form-label">Committee Name</label>
                                {{-- ✅ removed required --}}
                                <input type="text" name="committee_name" id="committee_name"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Committee Type</label>
                                {{-- ✅ removed required --}}
                                <select name="committee_type" id="committee_type" class="form-select">
                                    <option value="TENDER">Tender</option>
                                    <option value="RECEIVING">Receiving</option>
                                    <option value="OTHERS">Others</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                {{-- ✅ removed required --}}
                                <select name="status" id="committee_status" class="form-select">
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="INACTIVE">INACTIVE</option>
                                </select>
                            </div>
                        </div>

                        {{-- Delete confirmation message --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete
                            <strong id="deleteCommitteeName"></strong>?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="committeeMainActionBtn" class="btn btn-primary">
                                Save Committee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, committee = null) {
            const btn         = document.getElementById('committeeMainActionBtn');
            const actionInput = document.getElementById('committee_action');
            const title       = document.getElementById('committeeModalTitle');
            const fields      = document.getElementById('committeeFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#committeeModal form').reset();
                document.getElementById('committee_id').value = '';
                title.innerText = 'Add New Committee';
                btn.innerText   = 'Save Committee';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && committee) {
                document.getElementById('committee_id').value     = committee.id;
                document.getElementById('committee_name').value   = committee.committee_name;
                document.getElementById('committee_type').value   = committee.committee_type;
                document.getElementById('start_date').value       = committee.start_date;
                document.getElementById('end_date').value         = committee.end_date;
                document.getElementById('committee_status').value = committee.status;
                title.innerText = 'Edit Committee';
                btn.innerText   = 'Update Committee';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && committee) {
                document.getElementById('committee_id').value            = committee.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                document.getElementById('deleteCommitteeName').innerText = committee.committee_name;
                title.innerText = 'Delete Committee';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection