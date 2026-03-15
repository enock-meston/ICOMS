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
                    <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#usageModal"
                        class="btn btn-sm btn-primary">
                        Add Compost Usage
                    </button>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#usageModal" class="btn btn-sm btn-primary">
                            Compost Usage
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Compost Usage List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Compost</th>
                                    <th>Member</th>
                                    <th>Qty Used</th>
                                    <th>Price/Kg</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($CompostUsage as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item->compost->group->name ?? '-' }}</td>
                                        <td>{{ $item->member->names ?? '-' }}</td>
                                        <td>{{ $item->qty_used_kg }}</td>
                                        <td>{{ $item->price_per_kg }}</td>
                                        <td>{{ $item->total_amount }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#usageModal" onclick="setAction('VIEW',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-member_id="{{ $item->member_id }}"
                                                data-qty_used_kg="{{ $item->qty_used_kg }}"
                                                data-price_per_kg="{{ $item->price_per_kg }}"
                                                data-total_amount="{{ $item->total_amount }}"
                                                data-payment_type="{{ $item->payment_type }}"
                                                data-status="{{ $item->status }}">
                                                View
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#usageModal" onclick="setAction('UPDATE',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-member_id="{{ $item->member_id }}"
                                                data-qty_used_kg="{{ $item->qty_used_kg }}"
                                                data-price_per_kg="{{ $item->price_per_kg }}"
                                                data-total_amount="{{ $item->total_amount }}"
                                                data-payment_type="{{ $item->payment_type }}"
                                                data-status="{{ $item->status }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#usageModal" onclick="setAction('DELETE',this)"
                                                data-id="{{ $item->id }}" data-compost_id="{{ $item->compost_id }}"
                                                data-member_id="{{ $item->member_id }}"
                                                data-qty_used_kg="{{ $item->qty_used_kg }}"
                                                data-price_per_kg="{{ $item->price_per_kg }}"
                                                data-total_amount="{{ $item->total_amount }}"
                                                data-payment_type="{{ $item->payment_type }}"
                                                data-status="{{ $item->status }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No compost usage records found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="usageModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="usageModalTitle">Add Compost Usage</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('compost-usage.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="usage_id">
                        <input type="hidden" name="action" id="usage_action">
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
                                <label>Member</label>
                                <select name="member_id" id="member_id" class="form-select">
                                    @foreach ($Members as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->names }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Qty Used (Kg)</label>
                                <input type="number" name="qty_used_kg" id="qty_used_kg" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Price Per Kg</label>
                                <input type="number" name="price_per_kg" id="price_per_kg" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Total Amount</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Payment Type</label>
                                <select name="payment_type" id="payment_type" class="form-select">
                                    <option value="CASH">CASH</option>
                                    <option value="CREDIT">CREDIT</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" id="status1" class="form-select">
                                    <option value="PAID">PAID</option>
                                    <option value="PENDING">PENDING</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button type="submit" id="usageMainActionBtn" class="btn btn-primary">
                                Save Usage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('usageMainActionBtn');
            const title = document.getElementById('usageModalTitle');
            document.getElementById('usage_action').value = action;
            btn.classList.remove("btn-primary", "btn-success", "btn-danger", "btn-info");
            if (action === 'INSERT') {
                document.querySelector('#usageModal form').reset();
                document.getElementById('usage_id').value = '';
                btn.innerText = "Add Usage";
                title.innerText = "Add Compost Usage";
                btn.disabled = false;
                btn.classList.add("btn-primary");
            }

            if (el) {
                document.getElementById('usage_id').value = el.dataset.id || '';
                document.getElementById('compost_id').value = el.dataset.compost_id || '';
                document.getElementById('member_id').value = el.dataset.member_id || '';
                document.getElementById('qty_used_kg').value = el.dataset.qty_used_kg || '';
                document.getElementById('price_per_kg').value = el.dataset.price_per_kg || '';
                document.getElementById('total_amount').value = el.dataset.total_amount || '';
                document.getElementById('payment_type').value = el.dataset.payment_type || '';
                document.getElementById('status1').value = el.dataset.status || '';
            }

            if (action === 'VIEW') {
                btn.innerText = "View Usage";
                title.innerText = "View Compost Usage";
                btn.disabled = true;
                btn.classList.add("btn-info");
            }
            if (action === 'UPDATE') {
                btn.innerText = "Update Usage";
                title.innerText = "Update Compost Usage";
                btn.disabled = false;
                btn.classList.add("btn-success");
            }

            if (action === 'DELETE') {

                btn.innerText = "Delete Usage";
                title.innerText = "Delete Compost Usage";
                btn.disabled = false;
                btn.classList.add("btn-danger");
            }

        }
    </script>
@endsection
