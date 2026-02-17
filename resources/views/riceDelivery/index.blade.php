@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">ICOMS</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <!-- Add Delivery Button -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#deliveryModal"
                    class="btn btn-primary btn-sm">
                    Add Rice Delivery
                </button>
            </div>
        </div>

        <!-- Messages -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Deliveries Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Rice Deliveries</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member</th>
                                    <th>Season</th>
                                    <th>Delivery Date</th>
                                    <th>Quantity (KG)</th>
                                    <th>Grade</th>
                                    <th>Unit Price</th>
                                    <th>Net Payable</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($RiceDeliveries as $delivery)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $delivery->member->names ?? '-' }}</td>
                                        <td>{{ $delivery->season->name ?? '-' }}</td>
                                        <td>{{ $delivery->Delivery_Date }}</td>
                                        <td>{{ $delivery->Quantity_KG }}</td>
                                        <td>{{ $delivery->Quality_Grade }}</td>
                                        <td>{{ $delivery->Unit_Price }}</td>
                                        <td>{{ $delivery->Net_Payable }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deliveryModal" onclick="setAction('VIEW', this)"
                                                data-id="{{ $delivery->id }}" data-member_id="{{ $delivery->member_id }}"
                                                data-season_id="{{ $delivery->season_id }}"
                                                data-delivery_date="{{ $delivery->Delivery_Date }}"
                                                data-quantity="{{ $delivery->Quantity_KG }}"
                                                data-grade="{{ $delivery->Quality_Grade }}"
                                                data-unit_price="{{ $delivery->Unit_Price }}"
                                                data-gross="{{ $delivery->Gross_Value }}"
                                                data-loan="{{ $delivery->Loan_Deduction }}"
                                                data-other="{{ $delivery->Other_Deductions }}"
                                                data-net="{{ $delivery->Net_Payable }}">
                                                View
                                            </button>

                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deliveryModal" onclick="setAction('UPDATE', this)"
                                                data-id="{{ $delivery->id }}" data-member_id="{{ $delivery->member_id }}"
                                                data-season_id="{{ $delivery->season_id }}"
                                                data-delivery_date="{{ $delivery->Delivery_Date }}"
                                                data-quantity="{{ $delivery->Quantity_KG }}"
                                                data-grade="{{ $delivery->Quality_Grade }}"
                                                data-unit_price="{{ $delivery->Unit_Price }}"
                                                data-gross="{{ $delivery->Gross_Value }}"
                                                data-loan="{{ $delivery->Loan_Deduction }}"
                                                data-other="{{ $delivery->Other_Deductions }}"
                                                data-net="{{ $delivery->Net_Payable }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deliveryModal" onclick="setAction('DELETE', this)"
                                                data-id="{{ $delivery->id }}">
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

        <!-- Delivery Modal -->
        <div class="modal fade" id="deliveryModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deliveryModalTitle">Add Rice Delivery</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('riceDelivery.handleAction') }}">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Member</label>
                                    <select name="member_id" id="member_id" class="form-select" required>
                                        <option value="">Select Member</option>
                                        @foreach ($Members as $member)
                                            <option value="{{ $member->id }}">{{ $member->names }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Season</label>
                                    <select name="season_id" id="season_id" class="form-select" required>
                                        <option value="">Select Season</option>
                                        @foreach ($Seasons as $season)
                                            <option value="{{ $season->id }}">{{ $season->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Delivery Date</label>
                                    <input type="date" name="Delivery_Date" id="Delivery_Date" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Quantity (KG)</label>
                                    <input type="number" step="0.01" name="Quantity_KG" id="Quantity_KG"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Quality Grade</label>
                                    <input type="text" name="Quality_Grade" id="Quality_Grade" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Unit Price</label>
                                    <input type="number" step="0.01" name="Unit_Price" id="Unit_Price"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Gross Value</label>
                                    <input type="number" step="0.01" name="Gross_Value" id="Gross_Value"
                                        class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Loan Deduction</label>
                                    <input type="number" step="0.01" name="Loan_Deduction" id="Loan_Deduction"
                                        class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Other Deductions</label>
                                    <input type="number" step="0.01" name="Other_Deductions" id="Other_Deductions"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Net Payable</label>
                                    <input type="number" step="0.01" name="Net_Payable" id="Net_Payable"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="mt-3 d-grid">
                                <button type="submit" id="mainActionBtn" class="btn btn-primary">
                                    Save Delivery
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            function setAction(action, el = null) {
                const btn = document.getElementById("mainActionBtn");
                const actionInput = document.getElementById("action");
                const title = document.getElementById("deliveryModalTitle");

                actionInput.value = action;
                btn.disabled = false;

                if (action === "INSERT") {
                    document.querySelectorAll(
                        "#deliveryModal input:not([name=_token]):not([name=action]), #deliveryModal select"
                    ).forEach(el => el.value = "");
                }

                if (el) {
                    document.getElementById("id").value = el.dataset.id ?? "";
                    document.getElementById("member_id").value = el.dataset.member_id ?? "";
                    document.getElementById("season_id").value = el.dataset.season_id ?? "";
                    document.getElementById("Delivery_Date").value = el.dataset.delivery_date ?? "";
                    document.getElementById("Quantity_KG").value = el.dataset.quantity ?? "";
                    document.getElementById("Quality_Grade").value = el.dataset.grade ?? "";
                    document.getElementById("Unit_Price").value = el.dataset.unit_price ?? "";
                    document.getElementById("Gross_Value").value = el.dataset.gross ?? "";
                    document.getElementById("Loan_Deduction").value = el.dataset.loan ?? "";
                    document.getElementById("Other_Deductions").value = el.dataset.other ?? "";
                    document.getElementById("Net_Payable").value = el.dataset.net ?? "";
                }

                if (action === "VIEW") {
                    btn.innerText = "View Delivery";
                    btn.disabled = true;
                } else if (action === "UPDATE") {
                    btn.innerText = "Update Delivery";
                } else if (action === "DELETE") {
                    btn.innerText = "Delete Delivery";
                } else {
                    btn.innerText = "Add Delivery";
                }
            }
        </script>
    @endsection
