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
                <form class="card border p-3">
                    <div class="row gap-3">
                        <div class="col">
                            @if (!($currentUser && $currentUser->can('role-list')))
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                                        data-bs-target="#memberModal"
                                        class="btn btn-sm btn-primary btn-add-user">Add Member
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </form>

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
                        <h4 class="card-title">Members List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Code</th>
                                    <th>Names</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Group</th>
                                    <th>National ID</th>
                                    <th>Join Date</th>
                                    <th>Shares</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($Members as $member)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $member->member_code }}</td>
                                        <td>{{ $member->names }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>{{ $member->gender }}</td>
                                        <td>{{ $member->group->name ?? '-' }}</td>
                                        <td>{{ $member->national_ID }}</td>
                                        <td>{{ $member->joinDate }}</td>
                                        <td>{{ $member->Shares }}</td>
                                        <td>{{ $member->status }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#memberModal" onclick="setAction('VIEW', this)"
                                                data-id="{{ $member->id }}"
                                                data-member_code="{{ $member->member_code }}"
                                                data-names="{{ $member->names }}"
                                                data-phone="{{ $member->phone }}"
                                                data-gender="{{ $member->gender }}"
                                                data-group_id="{{ $member->group_id }}"
                                                data-national_id="{{ $member->national_ID }}"
                                                data-joindate="{{ $member->joinDate }}"
                                                data-shares="{{ $member->Shares }}"
                                                data-status="{{ $member->status }}">
                                                View
                                            </button>

                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#memberModal" onclick="setAction('UPDATE', this)"
                                                data-id="{{ $member->id }}"
                                                data-member_code="{{ $member->member_code }}"
                                                data-names="{{ $member->names }}" data-phone="{{ $member->phone }}"
                                                data-gender="{{ $member->gender }}"
                                                data-group_id="{{ $member->group_id }}"
                                                data-national_id="{{ $member->national_ID }}"
                                                data-joindate="{{ $member->joinDate }}"
                                                data-shares="{{ $member->Shares }}"
                                                data-status="{{ $member->status }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#memberModal" onclick="setAction('DELETE', this)"
                                                data-id="{{ $member->id }}"
                                                data-member_code="{{ $member->member_code }}"
                                                data-names="{{ $member->names }}"
                                                data-phone="{{ $member->phone }}"
                                                data-gender="{{ $member->gender }}"
                                                data-group_id="{{ $member->group_id }}"
                                                data-national_id="{{ $member->national_ID }}"
                                                data-joindate="{{ $member->joinDate }}"
                                                data-shares="{{ $member->Shares }}"
                                                data-status="{{ $member->status }}">
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

    <!-- Member Modal -->
    <div class="modal
                                                fade" id="memberModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="memberModalTitle">Add New Member
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('members.handleAction') }}">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" id="action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Member Code</label>
                                <input type="text" name="member_code" id="member_code" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Names</label>
                                <input type="text" name="names" id="names" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="" disabled selected>Select
                                        Gender</option>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Group</label>
                                <select name="group_id" id="group_id" class="form-select" required>
                                    <option value="" disabled selected>Select
                                        Group</option>
                                    @foreach ($Groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">National ID</label>
                                <input type="text" name="national_ID" id="national_ID" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Join Date</label>
                                <input type="date" name="joinDate" id="joinDate" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Shares</label>
                                <input type="number" step="0.01" name="Shares" id="Shares" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="statuses" class="form-select" required>
                                    <option value="" disabled selected>Select
                                        Status</option>
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="INACTIVE">INACTIVE</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="mainActionBtn" class="btn btn-primary">Save Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('mainActionBtn');
            const actionInput = document.getElementById("action");
            const title = document.getElementById('memberModalTitle');

            actionInput.value = action;
            // Reset button styles
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");

            // title
            title.innerText = "";

            if (action === 'INSERT') {
                document.getElementById('id').value = '';
                document.querySelector('form').reset();
                btn.innerText = 'Insert Member';
                btn.disabled = false;
                title.innerText = 'Add New Member';
            }

            if (el) {
                document.getElementById('id').value = el.dataset.id;
                document.getElementById('member_code').value = el.dataset.member_code;
                document.getElementById('names').value = el.dataset.names;
                document.getElementById('phone').value = el.dataset.phone;
                document.getElementById('gender').value = el.dataset.gender;
                document.getElementById('group_id').value = el.dataset.group_id;
                document.getElementById('national_ID').value = el.dataset.national_id;
                document.getElementById('joinDate').value = el.dataset.joindate;
                document.getElementById('Shares').value = el.dataset.shares;
                document.getElementById('statuses').value = el.dataset.status;
            }

            if (action === 'VIEW') {
                btn.innerText = 'View Member';
                btn.disabled = true;
                disableForm(true);
                title.innerText = 'View Member';
                btn.classList.add("btn-info");
            } else if (action === 'UPDATE') {
                btn.innerText = 'Update Member';
                btn.disabled = false;
                disableForm(false);
                title.innerText = 'Update Member';
                btn.classList.add("btn-success");
            } else if (action === 'DELETE') {
                btn.innerText = 'Delete Member';
                btn.disabled = false;
                disableForm(true);
                title.innerText = 'Delete Member';
                btn.classList.add("btn-danger");
            } else if (action === 'INSERT') {
                btn.innerText = 'Insert Member';
                btn.disabled = false;
                disableForm(false);
                btn.classList.add("btn-primary");
            }
        }

        function disableForm(disabled) {
            // document.querySelectorAll('#memberModal input, #memberModal select').forEach(el => {
            //     if (el.id !== 'id' && el.id !== 'action') el.disabled = disabled;
            // });
        }
    </script>

@endsection
