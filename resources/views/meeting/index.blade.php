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
                            data-bs-toggle="modal" data-bs-target="#meetingModal"
                            class="btn btn-sm btn-primary">
                            Schedule Meeting
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Meetings List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Called By</th>
                                        <th>Minutes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($Meetings as $meeting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $meeting->meeting_type }}</td>
                                            <td>{{ $meeting->date }}</td>
                                            <td>{{ $meeting->location }}</td>
                                            <td>
                                                {{-- Show user name instead of just ID --}}
                                                @foreach($Users as $user)
                                                    @if($user->id == $meeting->called_by)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($meeting->minutes_file)
                                                    <a href="{{ asset('storage/' . $meeting->minutes_file) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        <i class="ri-file-pdf-line"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td class="d-flex gap-1">
                                                {{-- Edit --}}
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($meeting) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#meetingModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                {{-- Delete --}}
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($meeting) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#meetingModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No meetings found.</td>
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

    <!-- Meeting Modal -->
    <div class="modal fade" id="meetingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="meetingModalTitle">Schedule Meeting</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meeting.action') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id"     id="meeting_id">
                        <input type="hidden" name="action" id="meeting_action">

                        <div class="row g-3" id="meetingFields">
                            <div class="col-md-6">
                                <label class="form-label">Meeting Type</label>
                                {{-- ✅ Match your DB ENUM values --}}
                                <select name="meeting_type" id="meeting_type" class="form-select">
                                    <option value="General Assembly">General Assembly</option>
                                    <option value="Board Meeting">Board Meeting</option>
                                    <option value="Committee Meeting">Committee Meeting</option>
                                    <option value="Evaluation Meeting">Evaluation Meeting</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" id="meeting_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" id="location"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Called By</label>
                                <select name="called_by" id="called_by" class="form-select">
                                    <option value="" disabled selected>Select User</option>
                                    @foreach($Users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Minutes File <small class="text-muted">(PDF/DOC)</small></label>
                                <input type="file" name="minutes_file" id="minutes_file"
                                    class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete this meeting?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="meetingMainActionBtn" class="btn btn-primary">
                                Save Meeting
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, meeting = null) {
            const btn         = document.getElementById('meetingMainActionBtn');
            const actionInput = document.getElementById('meeting_action');
            const title       = document.getElementById('meetingModalTitle');
            const fields      = document.getElementById('meetingFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#meetingModal form').reset();
                document.getElementById('meeting_id').value = '';
                title.innerText = 'Schedule Meeting';
                btn.innerText   = 'Save Meeting';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && meeting) {
                document.getElementById('meeting_id').value    = meeting.id;
                document.getElementById('meeting_type').value  = meeting.meeting_type;
                // ✅ Fix date format
                document.getElementById('meeting_date').value  = meeting.date ? meeting.date.substring(0, 10) : '';
                document.getElementById('location').value      = meeting.location;
                document.getElementById('called_by').value     = meeting.called_by;
                title.innerText = 'Edit Meeting';
                btn.innerText   = 'Update Meeting';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && meeting) {
                document.getElementById('meeting_id').value = meeting.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                title.innerText = 'Delete Meeting';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection