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

        <!-- ADD BUTTON -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">

                    <button onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#deliveryModal"
                        class="btn btn-sm btn-primary">
                        Add New Delivery
                    </button>

                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Deliveries List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Contract</th>
                                <th>Delivery Date</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Value</th>
                                <th>Committee</th>
                                <th>GRN No</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deliveries as $i => $d)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $d->contract->title ?? 'N/A' }}</td>
                                    <td>{{ $d->delivery_date }}</td>
                                    <td>{{ $d->delivery_description }}</td>
                                    <td>{{ $d->quantity_received }}</td>
                                    <td>{{ $d->value_received }}</td>
                                    <td>{{ $d->receivingCommittee->name ?? 'N/A' }}</td>
                                    <td>{{ $d->grn_no }}</td>
                                    <td>{{ $d->conformity_status }}</td>
                                    <td>{{ $d->remarks }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deliveryModal" onclick="setAction('VIEW', this)"
                                            data-id="{{ $d->id }}" data-contract_id="{{ $d->contract_id }}"
                                            data-delivery_date="{{ $d->delivery_date }}"
                                            data-delivery_description="{{ $d->delivery_description }}"
                                            data-quantity_received="{{ $d->quantity_received }}"
                                            data-value_received="{{ $d->value_received }}"
                                            data-receiving_committee_id="{{ $d->receiving_committee_id }}"
                                            data-grn_no="{{ $d->grn_no }}"
                                            data-conformity_status="{{ $d->conformity_status }}"
                                            data-remarks="{{ $d->remarks }}">View</button>

                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deliveryModal" onclick="setAction('UPDATE', this)"
                                            data-id="{{ $d->id }}" data-contract_id="{{ $d->contract_id }}"
                                            data-delivery_date="{{ $d->delivery_date }}"
                                            data-delivery_description="{{ $d->delivery_description }}"
                                            data-quantity_received="{{ $d->quantity_received }}"
                                            data-value_received="{{ $d->value_received }}"
                                            data-receiving_committee_id="{{ $d->receiving_committee_id }}"
                                            data-grn_no="{{ $d->grn_no }}"
                                            data-conformity_status="{{ $d->conformity_status }}"
                                            data-remarks="{{ $d->remarks }}">Edit</button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deliveryModal" onclick="setAction('DELETE', this)"
                                            data-id="{{ $d->id }}">Delete</button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No deliveries found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL -->
    <div class="modal fade" id="deliveryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deliveryModalTitle">Add Delivery</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('delivery.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="delivery_id">
                        <input type="hidden" name="action" id="delivery_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Contract</label>
                                <select name="contract_id" id="contract_id" class="form-select">
                                    <option value="">Select Contract</option>
                                    @foreach ($contracts as $c)
                                        <option value="{{ $c->id }}">{{ $c->contract_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Receiving Committee</label>
                                <select name="receiving_committee_id" id="receiving_committee_id" class="form-select">
                                    <option value="">Select Committee</option>
                                    @foreach ($committees as $comm)
                                        <option value="{{ $comm->id }}">{{ $comm->committee_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Delivery Date</label>
                                <input type="date" name="delivery_date" id="delivery_date" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>GRN No</label>
                                <input type="text" name="grn_no" id="grn_no" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="delivery_description" id="delivery_description" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label>Quantity Received</label>
                                <input type="number" step="0.01" name="quantity_received" id="quantity_received"
                                    class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Value Received</label>
                                <input type="number" step="0.01" name="value_received" id="value_received"
                                    class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Conformity Status</label>
                                <input type="text" name="conformity_status" id="conformity_status"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="deliveryMainActionBtn" class="btn btn-primary">Save
                                Delivery</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('deliveryMainActionBtn');
            const actionInput = document.getElementById('delivery_action');
            const title = document.getElementById('deliveryModalTitle');
            const form = document.querySelector('#deliveryModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-danger", "btn-primary");

            if (action === 'INSERT') {
                form.reset();
                document.getElementById('delivery_id').value = '';
                btn.innerText = 'Add Delivery';
                btn.disabled = false;
                title.innerText = 'Add Delivery';
                btn.classList.add('btn-primary');
            }

            if (el) {
                document.getElementById('delivery_id').value = el.dataset.id || '';
                document.getElementById('contract_id').value = el.dataset.contract_id || '';
                document.getElementById('receiving_committee_id').value = el.dataset.receiving_committee_id || '';
                document.getElementById('delivery_date').value = el.dataset.delivery_date || '';
                document.getElementById('delivery_description').value = el.dataset.delivery_description || '';
                document.getElementById('quantity_received').value = el.dataset.quantity_received || '';
                document.getElementById('value_received').value = el.dataset.value_received || '';
                document.getElementById('grn_no').value = el.dataset.grn_no || '';
                document.getElementById('conformity_status').value = el.dataset.conformity_status || '';
                document.getElementById('remarks').value = el.dataset.remarks || '';
            }

            if (action === 'VIEW') {
                btn.innerText = 'View Delivery';
                btn.disabled = true;
                title.innerText = 'View Delivery';
                btn.classList.add('btn-info');
            } else if (action === 'UPDATE') {
                btn.innerText = 'Update Delivery';
                btn.disabled = false;
                title.innerText = 'Update Delivery';
                btn.classList.add('btn-success');
            } else if (action === 'DELETE') {
                btn.innerText = 'Delete Delivery';
                btn.disabled = false;
                title.innerText = 'Delete Delivery';
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection
