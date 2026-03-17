@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
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
        <!-- Add Button -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#taskModal" class="btn btn-sm btn-primary">
                            Create New Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Success -->
        @if (session('success'))
            <div class="alert alert-success text-bg-success alert-dismissible">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                {{ session('success') }}
            </div>
        @endif
        <!-- Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tasks List</h4>
                    </div>
                    <div class="card-body">
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
                                @forelse($Tasks as $i => $task)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->manager->full_name ?? '-' }}</td>
                                        <td>{{ $task->priority }}</td>
                                        <td>{{ $task->due_date }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>
                                            <!-- VIEW -->
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#taskModal" onclick="setAction('VIEW',this)"
                                                data-id="{{ $task->id }}" data-title="{{ $task->title }}"
                                                data-description="{{ $task->description }}"
                                                data-assigned_to="{{ $task->assigned_to }}"
                                                data-priority="{{ $task->priority }}"
                                                data-start_date="{{ $task->start_date }}"
                                                data-due_date="{{ $task->due_date }}" data-status="{{ $task->status }}">
                                                View
                                            </button>
                                            <!-- UPDATE -->
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#taskModal" onclick="setAction('UPDATE',this)"
                                                data-id="{{ $task->id }}" data-title="{{ $task->title }}"
                                                data-description="{{ $task->description }}"
                                                data-assigned_to="{{ $task->assigned_to }}"
                                                data-priority="{{ $task->priority }}"
                                                data-start_date="{{ $task->start_date }}"
                                                data-due_date="{{ $task->due_date }}" data-status="{{ $task->status }}">
                                                Edit
                                            </button>
                                            <!-- DELETE -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#taskModal" onclick="setAction('DELETE',this)"
                                                data-id="{{ $task->id }}" data-title="{{ $task->title }}"
                                                data-description="{{ $task->description }}"
                                                data-assigned_to="{{ $task->assigned_to }}"
                                                data-priority="{{ $task->priority }}"
                                                data-start_date="{{ $task->start_date }}"
                                                data-due_date="{{ $task->due_date }}" data-status="{{ $task->status }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No tasks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TASK MODAL -->
    <div class="modal fade" id="taskModal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="taskModalTitle">
                        Create Task
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('task.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="task_id">
                        <input type="hidden" name="action" id="task_action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Task Title</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Assigned To</label>
                                <select name="assigned_to" id="assigned_to" class="form-select">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Priority</label>
                                {{-- 'HIGH','MEDIUM','LOW' --}}
                                <select name="priority" id="priority" class="form-select">
                                    <option value="LOW">LOW</option>
                                    <option value="MEDIUM">MEDIUM</option>
                                    <option value="HIGH">HIGH</option>
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
                                {{-- 'OPEN','IN_PROGRESS','COMPLETED','CANCELLED' --}}
                                <select name="status" id="statuss" class="form-select">
                                    <option value="OPEN">OPEN</option>
                                    <option value="IN_PROGRESS">IN_PROGRESS</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                    <option value="CANCELLED">CANCELLED</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-grid mb-4">
                            <button type="submit" id="taskMainActionBtn" class="btn btn-primary">
                                Save Task
                            </button>
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
            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-danger", "btn-primary");
            if (action === 'INSERT') {
                document.querySelector('#taskModal form').reset();
                document.getElementById('task_id').value = '';
                btn.innerText = "Create Task";
                title.innerText = "Create New Task";
                btn.disabled = false;
                disableForm(false);
                btn.classList.add("btn-primary");
            }
            if (el) {

                document.getElementById('task_id').value = el.dataset.id || '';
                document.getElementById('title').value = el.dataset.title || '';
                document.getElementById('description').value = el.dataset.description || '';
                document.getElementById('assigned_to').value = el.dataset.assigned_to || '';
                document.getElementById('priority').value = el.dataset.priority || '';
                document.getElementById('start_date').value = el.dataset.start_date || '';
                document.getElementById('due_date').value = el.dataset.due_date || '';
                document.getElementById('statuss').value = el.dataset.status || '';
            }

            if (action === 'VIEW') {
                btn.innerText = "View Task";
                title.innerText = "View Task";
                btn.disabled = true;
                disableForm(true);
                btn.classList.add("btn-info");
            }
            if (action === 'UPDATE') {
                btn.innerText = "Update Task";
                title.innerText = "Update Task";
                btn.disabled = false;
                disableForm(false);
                btn.classList.add("btn-success");
            }

            if (action === 'DELETE') {
                btn.innerText = "Delete Task";
                title.innerText = "Delete Task";
                btn.disabled = false;
                disableForm(true);
                btn.classList.add("btn-danger");
            }
        }
        function disableForm(disabled) {
            document.getElementById('title').disabled = disabled;
            document.getElementById('description').disabled = disabled;
            document.getElementById('assigned_to').disabled = disabled;
            document.getElementById('priority').disabled = disabled;
            document.getElementById('start_date').disabled = disabled;
            document.getElementById('due_date').disabled = disabled;
            document.getElementById('statuss').disabled = disabled;

        }
    </script>
@endsection
