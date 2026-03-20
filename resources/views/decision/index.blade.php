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
                            data-bs-toggle="modal" data-bs-target="#decisionModal"
                            class="btn btn-sm btn-primary">
                            Record New Decision
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Decisions List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Meeting</th>
                                        <th>Title</th>
                                        <th>Responsible</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($Decisions as $decision)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{-- Show meeting date instead of just ID --}}
                                                @foreach($Meetings as $meeting)
                                                    @if($meeting->id == $decision->meeting_id)
                                                        {{ $meeting->meeting_type }} - {{ $meeting->date }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $decision->title }}</td>
                                            <td>
                                                {{-- Show user name instead of just ID --}}
                                                @foreach($Users as $user)
                                                    @if($user->id == $decision->responsible_user_id)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $decision->due_date }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($decision->status == 'COMPLETED') bg-success
                                                    @elseif($decision->status == 'CANCELLED') bg-dark
                                                    @elseif($decision->status == 'IN_PROGRESS') bg-warning
                                                    @elseif($decision->status == 'OPEN') bg-secondary
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $decision->status }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-1">
                                                {{-- Edit --}}
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($decision) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#decisionModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                {{-- Delete --}}
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($decision) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#decisionModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No decisions found.</td>
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

    <!-- Decision Modal -->
    <div class="modal fade" id="decisionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="decisionModalTitle">Record New Decision</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('decision.action') }}">
                        @csrf
                        <input type="hidden" name="id"     id="decision_id">
                        <input type="hidden" name="action" id="decision_action">

                        <div class="row g-3" id="decisionFields">
                            <div class="col-md-6">
                                <label class="form-label">Meeting</label>
                                <select name="meeting_id" id="meeting_id" class="form-select">
                                    <option value="" disabled selected>Select Meeting</option>
                                    @foreach($Meetings as $meeting)
                                        <option value="{{ $meeting->id }}">
                                            {{ $meeting->meeting_type }} - {{ $meeting->date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" id="decision_title"
                                    class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Responsible User</label>
                                <select name="responsible_user_id" id="responsible_user_id"
                                    class="form-select">
                                    <option value="" disabled selected>Select User</option>
                                    @foreach($Users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="decision_status" class="form-select">
                                    <option value="OPEN">OPEN</option>
                                    <option value="IN_PROGRESS">IN PROGRESS</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="CANCELLED">CANCELLED</option>
                                </select>
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete decision
                            <strong id="deleteDecisionName"></strong>?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="decisionMainActionBtn" class="btn btn-primary">
                                Record Decision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, decision = null) {
            const btn         = document.getElementById('decisionMainActionBtn');
            const actionInput = document.getElementById('decision_action');
            const title       = document.getElementById('decisionModalTitle');
            const fields      = document.getElementById('decisionFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#decisionModal form').reset();
                document.getElementById('decision_id').value = '';
                title.innerText = 'Record New Decision';
                btn.innerText   = 'Record Decision';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && decision) {
                document.getElementById('decision_id').value            = decision.id;
                document.getElementById('meeting_id').value             = decision.meeting_id;
                document.getElementById('decision_title').value         = decision.title;
                document.getElementById('description').value            = decision.description;
                document.getElementById('responsible_user_id').value    = decision.responsible_user_id;
                document.getElementById('due_date').value               = decision.due_date ? decision.due_date.substring(0, 10) : '';
                document.getElementById('decision_status').value        = decision.status;
                title.innerText = 'Edit Decision';
                btn.innerText   = 'Update Decision';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && decision) {
                document.getElementById('decision_id').value          = decision.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                document.getElementById('deleteDecisionName').innerText = decision.title;
                title.innerText = 'Delete Decision';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection