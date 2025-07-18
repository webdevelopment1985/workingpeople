@extends('admin.layouts.master')

@section('page_title')
{{ __('User Details') }}
@endsection

@section('content')

<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('User Details')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        {{ __('User Details') }}
                    </li>
                </ul>
            </div>
            
        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="widget-container fluid-height">

               
                    <div class="heading tabs">
                        <!-- <i class="fa fa-sitemap"></i>Detail of user -->
                        <ul class="nav nav-tabs nav-tabs-solid" data-tabs="tabs" id="tabs">
                            @include('admin.users.user_info_tabs', ['userId'=>$user->id])
                        </ul>
                    </div>
                    <div class="tab-content padded" id="my-tab-content">
                        <div class="tab-pane active" id="tab1">
                            <!-- <h3> Base data </h3> -->
                            <div class="widget-container fluid-height clearfix">
                                <div class="widget-content padded clearfix">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td> Name </td>
                                                <td>{{$user->name}}</td>
                                            </tr>

                                            <tr>
                                                <td> Username </td>
                                                <td>{{$user->username}}</td>
                                            </tr>

                                            <tr>
                                                <td> Email </td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td> Sponsor username </td>
                                                <td>
                                                @if($sponsor && $sponsor->username)
                                                    {{ $sponsor->username }}
                                                @else
                                                    No Sponsor
                                                @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Is IB ?</td>
                                                <td>{{$user->is_paid == 0 ? 'NO' : 'YES'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Deposit Address</td>
                                                <td>{{ $deposit_address }}</td>
                                            </tr>

                                            <tr>
                                                <td>Deposit Wallet (USDT)</td>
                                                <td>{{ $user->wallet_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td> Income Wallet </td>
                                                <td> {{ $user->withdrawable_amount }} </td>
                                            </tr>
                                            <tr>
                                                <td> Status </td>
                                                <td>{{$user->is_verified == 1 ? 'Active' : 'In-Active'}}</td>
                                            </tr>
                                            <tr>
                                                <td> JoinedOn </td>
                                                <td>{{date('Y-m-d H:i:s',strtotime($user->created_at))}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
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