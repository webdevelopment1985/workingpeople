@extends('admin.layouts.master')
@section('page_title')
{{__('dashboard.title')}}
@endsection

@push('css')
<style>

</style>
@endpush

@section('content')


<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('dashboard.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                {{-- <div class="create-btn pull-right">
                    <a href="{{ route('users.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button')
                        }}</a>
            </div> --}}
        </div>
    </div>
</div><!-- /card finish -->
</div><!-- /Page Header -->

<div class="row">
    
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('users.index',1)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3><?=$total_users?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Users</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
   
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('users.index',2)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3><?=$total_users_verified?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Active Users</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('users.index',3)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3><?=$total_users_not_verified?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Inactive Users</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('users.index',4)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-info border-info">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3><?=$total_ib?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total IB Users</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>



</div>

<div class="row">

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
            <a href="{{route('deposits.index')}}">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-success border-success">
                        <i class="fe fe-money"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$total_bep20_usdt}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">

                    <h6 class="text-muted">Total USDT Deposit</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success w-50"></div>
                    </div>
                </div>
            </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('invoices.index')}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success border-success">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_purchase}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Investment</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('transactions.index','roi-income')}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success border-success">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_roi_distributed}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total ROI Distributed</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('transactions.index','level-income')}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success border-success">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_level_distributed}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Level Distributed</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <!-- <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('withdraw.index',1)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_withdrawal_pending}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Withdraw Pending</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> -->


    <!-- <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('withdraw.index',2)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success border-success">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_withdrawal_approved}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Withdraw Approved</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> -->


    <!-- <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('withdraw.index',3)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_withdrawal_rejected}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Withdraw Rejected</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> -->

    <!-- <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('withdraw.index',4)}}">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-secondary border-secondary">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_withdrawal_cancelled}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Total Withdraw Cancelled</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary w-50"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> -->

</div>






@endsection




@push('css')

{{--
<link rel="stylesheet" href="{{ asset('assets/css/c3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/chartist.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/chartist.min.css') }}" /> --}}
<style type="text/css">
.card {
    background-color: #fff;
}
</style>
@endpush

@push('scripts')

@endpush