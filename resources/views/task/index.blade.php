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
                            data-bs-target="#taskModal"
                            class="btn btn-sm btn-primary">Create New Task
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tasks List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Assigned To</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">No tasks found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="taskModalTitle">Create New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="task_id">
                        <input type="hidden" name="action" id="task_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Task Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Assigned To</label>
                                <select name="assigned_to" id="assigned_to" class="form-select">
                                    <option value="" disabled selected>Select User</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="LOW">LOW</option>
                                    <option value="MEDIUM">MEDIUM</option>
                                    <option value="HIGH">HIGH</option>
                                    <option value="URGENT">URGENT</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="TODO">TODO</option>
                                    <option value="IN_PROGRESS">IN_PROGRESS</option>
                                    <option value="REVIEW">REVIEW</option>
                                    <option value="DONE">DONE</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="taskMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('taskMainActionBtn');
            const actionInput = document.getElementById("task_action");
            const title = document.getElementById('taskModalTitle');
            const form = document.querySelector('#taskModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('task_id').value = '';
                btn.innerText = 'Create Task';
                btn.disabled = false;
                title.innerText = 'Create New Task';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
