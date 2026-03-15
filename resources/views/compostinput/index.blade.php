@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
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
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <button class="btn btn-primary btn-sm" onclick="setAction('INSERT')" data-bs-toggle="modal"
                        data-bs-target="#expenseModal">
                        Add Expense
                    </button>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#expenseModal" class="btn btn-sm btn-primary">
                            Add New 
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Compost Expense List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Compost</th>
                                    <th>Expense Type</th>
                                    <th>Amount</th>
                                    <th>Provided By</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($CompostInput as $i=>$item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item->compost_id }}</td>
                                        <td>{{ $item->expense_type }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->provided_by }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#expenseModal" onclick="setAction('VIEW',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-expense_type="{{ $item->expense_type }}"
                                                data-amount="{{ $item->amount }}"
                                                data-provided_by="{{ $item->provided_by }}"
                                                data-date="{{ $item->date }}">
                                                View
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#expenseModal" onclick="setAction('UPDATE',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-expense_type="{{ $item->expense_type }}"
                                                data-amount="{{ $item->amount }}"
                                                data-provided_by="{{ $item->provided_by }}"
                                                data-date="{{ $item->date }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#expenseModal" onclick="setAction('DELETE',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-expense_type="{{ $item->expense_type }}"
                                                data-amount="{{ $item->amount }}"
                                                data-provided_by="{{ $item->provided_by }}"
                                                data-date="{{ $item->date }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No expenses found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Expense Modal -->
    <div class="modal fade" id="expenseModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="expenseModalTitle">Add Expense</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('compostInput.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="expense_id">
                        <input type="hidden" name="action" id="expense_action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Compost</label>
                                <select name="compost_id" id="compost_id" class="form-select">
                                    @foreach ($Compostgroups as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->group->name ?? '-' }} - {{ $item->season->name ?? '-' }} - {{ $item->material_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Expense Type</label>
                                {{-- <input type="text" name="expense_type" id="expense_type" class="form-control"> --}}
                                <select name="expense_type" id="expense_type" class="form-select">
                                    <option value="Seed_Capital">Seed Capital</option>
                                    <option value="Tools">Tools</option>
                                    <option value="Labor">Labor</option>
                                    <option value="Transport">Transport</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Provided By</label>
                                {{-- <input type="text" name="provided_by" id="provided_by" class="form-control"> --}}
                                <select name="provided_by" id="provided_by" class="form-select">
                                    <option value="COOPERATIVE">COOPERATIVE</option>
                                    <option value="GROUP">GROUP</option>
                                    <option value="DONOR">DONOR</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button type="submit" id="expenseMainActionBtn" class="btn btn-primary">
                                Save Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('expenseMainActionBtn');
            const title = document.getElementById('expenseModalTitle');
            document.getElementById('expense_action').value = action;
            btn.classList.remove("btn-primary", "btn-info", "btn-success", "btn-danger");
            if (action === 'INSERT') {
                document.querySelector('#expenseModal form').reset();
                document.getElementById('expense_id').value = '';
                btn.innerText = "Add Expense";
                title.innerText = "Add Expense";
                btn.disabled = false;
                btn.classList.add("btn-primary");
            }
            if (el) {
                document.getElementById('expense_id').value = el.dataset.id || '';
                document.getElementById('compost_id').value = el.dataset.compost_id || '';
                document.getElementById('expense_type').value = el.dataset.expense_type || '';
                document.getElementById('amount').value = el.dataset.amount || '';
                document.getElementById('provided_by').value = el.dataset.provided_by || '';
                document.getElementById('date').value = el.dataset.date || '';
            }
            if (action === 'VIEW') {
                btn.innerText = "View Expense";
                title.innerText = "View Expense";
                btn.disabled = true;
                btn.classList.add("btn-info");
            }
            if (action === 'UPDATE') {
                btn.innerText = "Update Expense";
                title.innerText = "Update Expense";
                btn.disabled = false;
                btn.classList.add("btn-success");
            }
            if (action === 'DELETE') {
                btn.innerText = "Delete Expense";
                title.innerText = "Delete Expense";
                btn.disabled = false;
                btn.classList.add("btn-danger");
            }
        }
    </script>
@endsection
