@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
            <!-- Total Sales Widget -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                    <i class="ti ti-credit-card"></i>
                                </span>
                            </div>
                            <div class="text-end">
                                <h3 class="mb-2 fw-normal"><span>{{ $userCount }}</span></h3>
                                <p class="mb-0 text-muted"><span>Total Users</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <!-- Orders Placed Widget -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                            </div>
                            <div class="text-end">
                                <h3 class="mb-2 fw-normal"><span>{{ $allocatedRecord }}</span></h3>
                                <p class="mb-0 text-muted"><span>Input Allocations</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <!-- Active Customers Widget -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                            <div class="text-end">
                                <h3 class="mb-2 fw-normal"><span>{{ $memberCount }}</span></h3>
                                <p class="mb-0 text-muted"><span>Members</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <!-- Refund Requests Widget -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                                    <i class="ti ti-rotate-clockwise-2"></i>
                                </span>
                            </div>
                            <div class="text-end">
                                <h3 class="mb-2 fw-normal"><span>{{ $deliveredRecord }}</span></h3>
                                <p class="mb-0 text-muted"><span>Rice Deliveries</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->

    </div>
@endsection
