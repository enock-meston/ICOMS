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

                    <button onclick="setAction('INSERT')" data-bs-toggle="modal" data-bs-target="#bidModal"
                        class="btn btn-sm btn-primary">
                        Add New Bid
                    </button>

                </div>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('success') }}
            </div>
        @endif
        <!-- ERRORS -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- TABLE -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Bids List</h4>
            </div>

            <div class="card-body">
                <table class="table table-striped align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tender</th>
                            <th>Supplier</th>
                            <th>Bid Amount</th>
                            <th>Technical</th>
                            <th>Financial</th>
                            <th>Overall</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($bids as $i => $bid)
                            <tr>

                                <td>{{ $i + 1 }}</td>

                                <td>{{ $bid->tender->title ?? 'N/A' }}</td>

                                <td>{{ $bid->supplier->name ?? 'N/A' }}</td>

                                <td>{{ $bid->bid_amount }}</td>

                                <td>{{ $bid->technical_score }}</td>

                                <td>{{ $bid->financial_score }}</td>

                                <td>{{ $bid->overall_score }}</td>

                                <td>{{ $bid->evaluation_result }}</td>

                                <td>{{ $bid->submitted_at }}</td>

                                <td>

                                    <!-- VIEW -->
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bidModal"
                                        onclick="setAction('VIEW',this)" data-id="{{ $bid->id }}"
                                        data-tender_id="{{ $bid->tender_id }}" data-supplier_id="{{ $bid->supplier_id }}"
                                        data-bid_amount="{{ $bid->bid_amount }}"
                                        data-technical_score="{{ $bid->technical_score }}"
                                        data-financial_score="{{ $bid->financial_score }}"
                                        data-overall_score="{{ $bid->overall_score }}"
                                        data-evaluation_result="{{ $bid->evaluation_result }}"
                                        data-recommendation="{{ $bid->recommendation }}"
                                        data-submitted_at="{{ $bid->submitted_at }}">

                                        View
                                    </button>

                                    <!-- UPDATE -->
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bidModal"
                                        onclick="setAction('UPDATE',this)" data-id="{{ $bid->id }}"
                                        data-tender_id="{{ $bid->tender_id }}" data-supplier_id="{{ $bid->supplier_id }}"
                                        data-bid_amount="{{ $bid->bid_amount }}"
                                        data-technical_score="{{ $bid->technical_score }}"
                                        data-financial_score="{{ $bid->financial_score }}"
                                        data-overall_score="{{ $bid->overall_score }}"
                                        data-evaluation_result="{{ $bid->evaluation_result }}"
                                        data-recommendation="{{ $bid->recommendation }}"
                                        data-submitted_at="{{ $bid->submitted_at }}">

                                        Edit
                                    </button>

                                    <!-- DELETE -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#bidModal"
                                        onclick="setAction('DELETE',this)" data-id="{{ $bid->id }}">

                                        Delete
                                    </button>

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    No bids found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- MODAL -->

    <div class="modal fade" id="bidModal">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="bidModalTitle">
                        Add New Bid
                    </h4>

                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form method="POST" action="{{ route('bid.store') }}">
                        @csrf

                        <input type="hidden" name="id" id="bid_id">
                        <input type="hidden" name="action" id="bid_action">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Tender</label>
                                <input type="number" name="tender_id" id="tender_id" class="form-control">

                                {{-- <select name="tender_id" id="tender_id" class="form-select">
                                    <option value="">Select Tender</option>
                                    @foreach ($tenders as $tender)
                                        <option value="{{ $tender->id }}">
                                            {{ $tender->title }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </div>


                            <div class="col-md-6">
                                <label>Supplier</label>
                                <input type="number" name="supplier_id" id="supplier_id" class="form-control">

                                {{-- <select name="supplier_id" id="supplier_id" class="form-select">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </div>


                            <div class="col-md-6">
                                <label>Bid Amount</label>
                                <input type="number" step="0.01" name="bid_amount" id="bid_amount" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <label>Technical Score</label>
                                <input type="number" name="technical_score" id="technical_score" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <label>Financial Score</label>
                                <input type="number" name="financial_score" id="financial_score" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <label>Overall Score</label>
                                <input type="number" name="overall_score" id="overall_score" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="evaluation_result" id="evaluation_result" class="form-select">

                                    <option value="PENDING">PENDING</option>
                                    <option value="SELECTED">SELECTED</option>
                                    <option value="REJECTED">REJECTED</option>

                                </select>
                            </div>


                            <div class="col-md-6">
                                <label>Submitted At</label>
                                <input type="date" name="submitted_at" id="submitted_at" class="form-control">
                            </div>


                            <div class="col-md-12">
                                <label>Recommendation</label>
                                <textarea name="recommendation" id="recommendation" class="form-control"></textarea>
                            </div>

                        </div>


                        <div class="mt-3 d-grid">
                            <button type="submit" id="bidMainActionBtn" class="btn btn-primary">

                                Save Bid

                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function setAction(action, el = null) {

            const btn = document.getElementById('bidMainActionBtn')
            const actionInput = document.getElementById('bid_action')
            const title = document.getElementById('bidModalTitle')

            actionInput.value = action

            btn.classList.remove(
                "btn-info",
                "btn-success",
                "btn-danger",
                "btn-primary"
            )


            if (action === "INSERT") {

                document.querySelector('#bidModal form').reset()

                document.getElementById('bid_id').value = ''

                btn.innerText = "Add Bid"

                title.innerText = "Add New Bid"

                btn.disabled = false

                btn.classList.add("btn-primary")

            }


            if (el) {

                document.getElementById('bid_id').value = el.dataset.id || ''

                document.getElementById('tender_id').value = el.dataset.tender_id || ''

                document.getElementById('supplier_id').value = el.dataset.supplier_id || ''

                document.getElementById('bid_amount').value = el.dataset.bid_amount || ''

                document.getElementById('technical_score').value = el.dataset.technical_score || ''

                document.getElementById('financial_score').value = el.dataset.financial_score || ''

                document.getElementById('overall_score').value = el.dataset.overall_score || ''

                document.getElementById('evaluation_result').value = el.dataset.evaluation_result || ''

                document.getElementById('recommendation').value = el.dataset.recommendation || ''

                document.getElementById('submitted_at').value = el.dataset.submitted_at || ''

            }


            if (action === "VIEW") {

                btn.innerText = "View Bid"

                title.innerText = "View Bid"

                btn.disabled = true

                btn.classList.add("btn-info")

            }


            if (action === "UPDATE") {

                btn.innerText = "Update Bid"

                title.innerText = "Update Bid"

                btn.disabled = false

                btn.classList.add("btn-success")

            }


            if (action === "DELETE") {

                btn.innerText = "Delete Bid"

                title.innerText = "Delete Bid"

                btn.disabled = false

                btn.classList.add("btn-danger")

            }

        }
    </script>
@endsection
