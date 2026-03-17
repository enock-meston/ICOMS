@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <!-- PAGE TITLE -->
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
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button"
                        onclick="setAction('INSERT')"
                        data-bs-toggle="modal"
                        data-bs-target="#memberPaymentModal"
                        class="btn btn-sm btn-primary">

                        Record Member Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Member Payments List</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Delivery</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $i => $pay)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $pay->member->names ?? '-' }}</td>
                                <td>{{ $pay->delivery->Delivery_Date ?? '-' }}</td>
                                <td>{{ $pay->amount }}</td>
                                <td>{{ $pay->payment_Date }}</td>
                                <td>{{ $pay->status }}</td>
                                <td>
                                    <!-- VIEW -->
                                    <button
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#memberPaymentModal"
                                        onclick="setAction('VIEW',this)"
                                        data-id="{{ $pay->id }}"
                                        data-member_id="{{ $pay->member_id }}"
                                        data-delivery_id="{{ $pay->delivery_id }}"
                                        data-amount="{{ $pay->amount }}"
                                        data-payment_Date="{{ $pay->payment_Date }}"
                                        data-status="{{ $pay->status }}"
                                    >
                                        View
                                    </button>
                                    <!-- UPDATE -->
                                    <button
                                        class="btn btn-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#memberPaymentModal"
                                        onclick="setAction('UPDATE',this)"
                                        data-id="{{ $pay->id }}"
                                        data-member_id="{{ $pay->member_id }}"
                                        data-delivery_id="{{ $pay->delivery_id }}"
                                        data-amount="{{ $pay->amount }}"
                                        data-payment_Date="{{ $pay->payment_Date }}"
                                        data-status="{{ $pay->status }}"
                                    >
                                        Edit
                                    </button>
                                    <!-- DELETE -->
                                    <button
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#memberPaymentModal"
                                        onclick="setAction('DELETE',this)"
                                        data-id="{{ $pay->id }}"
                                        data-member_id="{{ $pay->member_id }}"
                                        data-delivery_id="{{ $pay->delivery_id }}"
                                        data-amount="{{ $pay->amount }}"
                                        data-payment_Date="{{ $pay->payment_Date }}"
                                        data-status="{{ $pay->status }}"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No payments found
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
<!-- MODAL -->
<div class="modal fade" id="memberPaymentModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="memberPaymentModalTitle">
                    Record Payment
                </h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('member-payment.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="member_payment_id">
                    <input type="hidden" name="action" id="member_payment_action">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Member</label>
                            <select name="member_id" id="member_id" class="form-select">
                                <option value="">Select Member</option>
                                @foreach($members as $m)
                                <option value="{{ $m->id }}">
                                    {{ $m->names }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Delivery</label>
                            <select name="delivery_id" id="delivery_id" class="form-select">
                                <option value="">Select Delivery</option>
                                @foreach($deliveries as $d)
                                <option value="{{ $d->id }}">
                                    Delivery #{{ $d->id }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount</label>
                            <input type="number"
                                name="amount"
                                id="amount"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Date</label>
                            <input type="date"
                                name="payment_Date"
                                id="payment_Date"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="PENDING">PENDING</option>
                                <option value="PAID">PAID</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 d-grid mb-4">
                        <button type="submit"
                            id="memberPaymentMainActionBtn"
                            class="btn btn-primary">
                            Save Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function setAction(action, el=null){
    const btn=document.getElementById('memberPaymentMainActionBtn')
    const actionInput=document.getElementById('member_payment_action')
    const title=document.getElementById('memberPaymentModalTitle')
    actionInput.value=action
    btn.classList.remove("btn-info","btn-success","btn-danger","btn-primary")
    if(action==="INSERT"){
        document.querySelector('#memberPaymentModal form').reset()
        document.getElementById('member_payment_id').value=''
        btn.innerText="Record Payment"
        title.innerText="Record Member Payment"
        btn.disabled=false
        disableForm(false)
        btn.classList.add("btn-primary")
    }
    if(el){
        document.getElementById('member_payment_id').value=el.dataset.id||''
        document.getElementById('member_id').value=el.dataset.member_id||''
        document.getElementById('delivery_id').value=el.dataset.delivery_id||''
        document.getElementById('amount').value=el.dataset.amount||''
        document.getElementById('payment_Date').value=el.dataset.payment_date||''
        document.getElementById('status').value=el.dataset.status||''
    }
    if(action==="VIEW"){
        btn.innerText="View Payment"
        title.innerText="View Payment"
        btn.disabled=true
        disableForm(true)
        btn.classList.add("btn-info")
    }
    if(action==="UPDATE"){
        btn.innerText="Update Payment"
        title.innerText="Update Payment"
        btn.disabled=false
        disableForm(false)
        btn.classList.add("btn-success")
    }
    if(action==="DELETE"){
        btn.innerText="Delete Payment"
        title.innerText="Delete Payment"
        btn.disabled=false
        disableForm(true)
        btn.classList.add("btn-danger")
    }
}
function disableForm(disabled){
    document.getElementById('member_id').disabled=disabled
    document.getElementById('delivery_id').disabled=disabled
    document.getElementById('amount').disabled=disabled
    document.getElementById('payment_Date').disabled=disabled
    document.getElementById('status').disabled=disabled
}
</script>
@endsection