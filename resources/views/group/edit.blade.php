@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">ICOMS</a></li>

                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success text-bg-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-xxl-3">
                <div class="card">
                    <div class="card-body text-center">

                        <form method="POST" action="{{ route('group.update', $group->id) }}" id="userForm"
                            aria-multiselectable="">
                            @csrf
                            @method('PUT')
                            <div class="row g-3row g-3">
                                <div class=" col-md-6 mb-3">
                                    <label for="userName" class="form-label">Izina <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control" id="userName"
                                            value="{{ old('name', $group->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="userEmail" class="form-label">Umurenge <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="Sector" class="form-control" id="userEmail"
                                            placeholder="you@example.com" value="{{ old('Sector', $group->Sector) }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="row g-3row g-3">
                                <div class=" col-md-6 mb-3">
                                    <label for="userPhone" class="form-label">Akagali <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="cell" class="form-control" id="userPhone"
                                            value="{{ old('cell', $group->cell) }}" required>
                                    </div>
                                </div>

                                <div class=" col-md-6 mb-3">
                                    <label for="userUsername" class="form-label">Umudugudu <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="village" class="form-control" id="userUsername"
                                            placeholder="username" value="{{ old('village', $group->village) }}" required>
                                    </div>
                                </div>
                            </div>


                            @if (!($currentUser && $currentUser->can('role-list')))
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success fw-semibold py-2"
                                        id="userFormSubmit">Hindura</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end row-->

    </div><!-- end row -->



    </div>

@endsection
