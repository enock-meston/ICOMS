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

        @if(session('success'))
            <div class="alert alert-success text-bg-success alert-dismissible mt-2" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible mt-2" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')"
                            data-bs-toggle="modal" data-bs-target="#supplierModal"
                            class="btn btn-sm btn-primary">
                            Add New Supplier
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
                                        <th>Bank Name</th>
                                        <th>Bank Account</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($suppliers as $index => $supplier)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $supplier->supplier_name }}</td>
                                            <td>{{ $supplier->tin }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>{{ $supplier->bank_name }}</td>
                                            <td>{{ $supplier->bank_account }}</td>
                                            <td class="d-flex gap-1">
                                                {{-- Edit --}}
                                                <button class="btn btn-sm btn-info"
                                                    onclick="setAction('UPDATE', {{ json_encode($supplier) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#supplierModal">
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
                                                {{-- Delete --}}
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="setAction('DELETE', {{ json_encode($supplier) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#supplierModal">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No suppliers found.</td>
                                        </tr>
                                    @endforelse
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
                    <form method="POST" action="{{ route('suppliers.action') }}">
                        @csrf
                        <input type="hidden" name="id"     id="supplier_id">
                        <input type="hidden" name="action" id="supplier_action">

                        <div class="row g-3" id="supplierFields">
                            <div class="col-md-6">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">TIN</label>
                                <input type="text" name="tin" id="tin"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" id="address"
                                    class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bank Account</label>
                                <input type="text" name="bank_account" id="bank_account"
                                    class="form-control">
                            </div>
                        </div>

                        {{-- Delete confirmation --}}
                        <div id="deleteConfirmMsg" class="alert alert-danger mt-3 d-none">
                            Are you sure you want to delete supplier
                            <strong id="deleteSupplierName"></strong>?
                            This action cannot be undone.
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="submit" id="supplierMainActionBtn" class="btn btn-primary">
                                Save Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAction(action, supplier = null) {
            const btn         = document.getElementById('supplierMainActionBtn');
            const actionInput = document.getElementById('supplier_action');
            const title       = document.getElementById('supplierModalTitle');
            const fields      = document.getElementById('supplierFields');
            const deleteMsg   = document.getElementById('deleteConfirmMsg');

            // Reset state
            btn.classList.remove('btn-info', 'btn-success', 'btn-primary', 'btn-danger');
            deleteMsg.classList.add('d-none');
            fields.classList.remove('d-none');
            actionInput.value = action;

            if (action === 'INSERT') {
                document.querySelector('#supplierModal form').reset();
                document.getElementById('supplier_id').value = '';
                title.innerText = 'Add New Supplier';
                btn.innerText   = 'Save Supplier';
                btn.disabled    = false;
                btn.classList.add('btn-primary');
            }

            else if (action === 'UPDATE' && supplier) {
                document.getElementById('supplier_id').value    = supplier.id;
                document.getElementById('supplier_name').value  = supplier.supplier_name;
                document.getElementById('tin').value            = supplier.tin;
                document.getElementById('phone').value          = supplier.phone;
                document.getElementById('email').value          = supplier.email;
                document.getElementById('address').value        = supplier.address;
                document.getElementById('bank_name').value      = supplier.bank_name;
                document.getElementById('bank_account').value   = supplier.bank_account;
                title.innerText = 'Edit Supplier';
                btn.innerText   = 'Update Supplier';
                btn.disabled    = false;
                btn.classList.add('btn-info');
            }

            else if (action === 'DELETE' && supplier) {
                document.getElementById('supplier_id').value          = supplier.id;
                fields.classList.add('d-none');
                deleteMsg.classList.remove('d-none');
                document.getElementById('deleteSupplierName').innerText = supplier.supplier_name;
                title.innerText = 'Delete Supplier';
                btn.innerText   = 'Yes, Delete';
                btn.disabled    = false;
                btn.classList.add('btn-danger');
            }
        }
    </script>
@endsection