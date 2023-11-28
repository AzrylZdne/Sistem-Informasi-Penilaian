@extends('main')

@section('content')
<div class="container-fluid">

    {{--
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div> --}}

    <!-- Content Row -->
    <div class="row">
        {{--
        <!-- Information User -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ Auth::user()->fullname }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->role }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Container for dashboard  -->
    <div class="row">

        <!-- Content for dashboard -->
        <div class="col-xl-12 col-lg-12">
            <div class="card border shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h2 mb-0 font-weight-bold text-gray-800 text-center">SELAMAT DATANG DI
                                PENILAIAN WEB UNPAK</div>
                            <div class="text-center">
                                <img src="{{ asset('assets/img/logo-unpak.png') }}" alt="Logo" style="width: 35%;"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection