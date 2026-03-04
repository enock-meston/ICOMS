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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">System Reports</h4>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <div class="col">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ti ti-file-analytics fs-lg text-primary mb-3"></i>
                                        <h5 class="card-title">Procurement Report</h5>
                                        <p class="card-text text-muted">Summary of all tenders, bids, and contracts.</p>
                                        <button class="btn btn-primary btn-sm">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ti ti-cash fs-lg text-success mb-3"></i>
                                        <h5 class="card-title">Financial Report</h5>
                                        <p class="card-text text-muted">Overview of supplier and member payments.</p>
                                        <button class="btn btn-success btn-sm">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ti ti-plant fs-lg text-info mb-3"></i>
                                        <h5 class="card-title">Production Report</h5>
                                        <p class="card-text text-muted">Rice delivery and compost production status.</p>
                                        <button class="btn btn-info btn-sm">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
