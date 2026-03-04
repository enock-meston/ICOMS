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
                            data-bs-target="#supplierModal"
                            class="btn btn-sm btn-primary">Add New Supplier
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Suppliers List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>TIN</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">No suppliers found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="supplierModalTitle">Add New Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="supplier_id">
                        <input type="hidden" name="action" id="supplier_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">TIN</label>
                                <input type="text" name="tin" id="tin" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bank Account</label>
                                <input type="text" name="bank_account" id="bank_account" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="supplierMainActionBtn" class="btn btn-primary" onclick="alert('Save action triggered')">Save Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('supplierMainActionBtn');
            const actionInput = document.getElementById("supplier_action");
            const title = document.getElementById('supplierModalTitle');
            const form = document.querySelector('#supplierModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('supplier_id').value = '';
                btn.innerText = 'Insert Supplier';
                btn.disabled = false;
                title.innerText = 'Add New Supplier';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
