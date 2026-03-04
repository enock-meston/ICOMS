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
                            data-bs-target="#meetingModal"
                            class="btn btn-sm btn-primary">Schedule Meeting
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
                                    <tr>
                                        <td colspan="7" class="text-center">No meetings found.</td>
                                    </tr>
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
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="meeting_id">
                        <input type="hidden" name="action" id="meeting_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Meeting Type</label>
                                <select name="meeting_type" id="meeting_type" class="form-select" required>
                                    <option value="General Assembly">General Assembly</option>
                                    <option value="Board Meeting">Board Meeting</option>
                                    <option value="Committee Meeting">Committee Meeting</option>
                                    <option value="Evaluation Meeting">Evaluation Meeting</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="datetime-local" name="date" id="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Called By</label>
                                <select name="called_by" id="called_by" class="form-select" required>
                                    <option value="" disabled selected>Select Manager</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Minutes File (PDF)</label>
                                <input type="file" name="minutes_file" id="minutes_file" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="meetingMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Meeting</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('meetingMainActionBtn');
            const actionInput = document.getElementById("meeting_action");
            const title = document.getElementById('meetingModalTitle');
            const form = document.querySelector('#meetingModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('meeting_id').value = '';
                btn.innerText = 'Schedule Meeting';
                btn.disabled = false;
                title.innerText = 'Schedule Meeting';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
