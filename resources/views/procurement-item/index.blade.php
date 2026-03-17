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
                    <button onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#itemModal"
                        class="btn btn-sm btn-primary">
                        Add Procurement Item
                    </button>
                </div>
            </div>
        </div>
        <!-- TABLE -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Procurement Items List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Cost</th>
                            <th>Total Cost</th>
                            <th>Method</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ProcuItem as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->estimated_unit_cost }}</td>
                                <td>{{ $item->estimated_total_cost }}</td>
                                <td>{{ $item->procurement_method }}</td>
                                <td>{{ $item->priority }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <!-- VIEW -->
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#itemModal"
                                        onclick="setAction('VIEW',this)" data-id="{{ $item->id }}"
                                        data-procu_plan_id="{{ $item->Procu_plan_id }}"
                                        data-department_id="{{ $item->department_id }}"
                                        data-description="{{ $item->description }}" data-quantity="{{ $item->quantity }}"
                                        data-unit_of_measure="{{ $item->unit_of_measure }}"
                                        data-estimated_unit_cost="{{ $item->estimated_unit_cost }}"
                                        data-estimated_total_cost="{{ $item->estimated_total_cost }}"
                                        data-procurement_method="{{ $item->procurement_method }}"
                                        data-priority="{{ $item->priority }}"
                                        data-planned_tender_date="{{ $item->planned_tender_date }}"
                                        data-status="{{ $item->status }}">View</button>
                                    <!-- UPDATE -->
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#itemModal" onclick="setAction('UPDATE',this)"
                                        data-id="{{ $item->id }}" data-procu_plan_id="{{ $item->Procu_plan_id }}"
                                        data-department_id="{{ $item->department_id }}"
                                        data-description="{{ $item->description }}" data-quantity="{{ $item->quantity }}"
                                        data-unit_of_measure="{{ $item->unit_of_measure }}"
                                        data-estimated_unit_cost="{{ $item->estimated_unit_cost }}"
                                        data-estimated_total_cost="{{ $item->estimated_total_cost }}"
                                        data-procurement_method="{{ $item->procurement_method }}"
                                        data-priority="{{ $item->priority }}"
                                        data-planned_tender_date="{{ $item->planned_tender_date }}"
                                        data-status="{{ $item->status }}">Edit</button>
                                    <!-- DELETE -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#itemModal"
                                        onclick="setAction('DELETE',this)" data-id="{{ $item->id }}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- MODAL -->
    <div class="modal fade" id="itemModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="itemModalTitle">
                        Add Procurement Item
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('procurementItem.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="item_id">
                        <input type="hidden" name="action" id="item_action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Procurement Plan</label>
                                <select name="Procu_plan_id" id="Procu_plan_id" class="form-select">
                                    <option value="">Select Plan</option>
                                    @foreach ($ProcuPlan as $plan)
                                        <option value="{{ $plan->id }}">
                                            {{ $plan->fiscal_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Department</label>
                                <select name="department_id" id="department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $dep)
                                        <option value="{{ $dep->id }}">
                                            {{ $dep->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Unit Of Measure</label>
                                <input type="text" name="unit_of_measure" id="unit_of_measure" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Estimated Unit Cost</label>
                                <input type="number" name="estimated_unit_cost" id="estimated_unit_cost"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Estimated Total Cost</label>
                                <input type="number" name="estimated_total_cost" id="estimated_total_cost"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Procurement Method</label>
                                <input type="text" name="procurement_method" id="procurement_method"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Priority</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="LOW">LOW</option>
                                    <option value="MEDIUM">MEDIUM</option>
                                    <option value="HIGH">HIGH</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Planned Tender Date</label>
                                <input type="date" name="planned_tender_date" id="planned_tender_date"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="PENDING">PENDING</option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button type="submit" id="itemMainActionBtn" class="btn btn-primary">
                                Save Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('itemMainActionBtn')
            const actionInput = document.getElementById('item_action')
            const title = document.getElementById('itemModalTitle')
            actionInput.value = action
            btn.classList.remove("btn-info", "btn-success", "btn-danger", "btn-primary")
            if (action === "INSERT") {
                document.querySelector('#itemModal form').reset()
                document.getElementById('item_id').value = ''
                btn.innerText = "Add Item"
                title.innerText = "Add Procurement Item"
                btn.disabled = false
                btn.classList.add("btn-primary")
            }
            if (el) {
                document.getElementById('item_id').value = el.dataset.id || ''
                document.getElementById('Procu_plan_id').value = el.dataset.procu_plan_id || ''
                document.getElementById('department_id').value = el.dataset.department_id || ''
                document.getElementById('description').value = el.dataset.description || ''
                document.getElementById('quantity').value = el.dataset.quantity || ''
                document.getElementById('unit_of_measure').value = el.dataset.unit_of_measure || ''
                document.getElementById('estimated_unit_cost').value = el.dataset.estimated_unit_cost || ''
                document.getElementById('estimated_total_cost').value = el.dataset.estimated_total_cost || ''
                document.getElementById('procurement_method').value = el.dataset.procurement_method || ''
                document.getElementById('priority').value = el.dataset.priority || ''
                document.getElementById('planned_tender_date').value = el.dataset.planned_tender_date || ''
                document.getElementById('status').value = el.dataset.status || ''
            }
            if (action === "VIEW") {
                btn.innerText = "View Item"
                title.innerText = "View Item"
                btn.disabled = true
                btn.classList.add("btn-info")
            }
            if (action === "UPDATE") {
                btn.innerText = "Update Item"
                title.innerText = "Update Item"
                btn.disabled = false
                btn.classList.add("btn-success")
            }
            if (action === "DELETE") {
                btn.innerText = "Delete Item"
                title.innerText = "Delete Item"
                btn.disabled = false
                btn.classList.add("btn-danger")
            }

        }
    </script>
@endsection
