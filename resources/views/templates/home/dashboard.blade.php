@extends('templates.partials.main')
@section('title', 'Dashboard')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico liveprice">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/favicon.png')}}" alt="Investment">
                                            </div>
                                            <h6 class="title">
                                                Investment Plan
                                            </h6>
                                            <p> Investment start with </p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left"
                                                title="Investment start with {{$package_min_price}}"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100">

                                            {{ number_format($package_min_price, 0, '.', ',')}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                    <div class="invest-data ">
                                        <div class="invest-data-amount g-2 justify-content-center">
                                            <!-- <a href="#" class="btn btn-primary">Deposit</a> -->
                                            <a href="{{route('buy.package')}}" class="btn btn-primary	">Invest Now</a>
                                        </div>

                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/usdt_wallet.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Deposit Wallet</h6>
                                            <p>Deposit USDT balance</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="usdt balance"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$usdBalance}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                </div>
                            </div><!-- .card -->
                        </div>


                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/total_income.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Income Wallet</h6>
                                            <p>Income wallet</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Income wallet balance"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$incomeBalance}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/total_deposit.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Total Deposits</h6>
                                            <p>USDT deposit</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="USDT deposit"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$total_deposit_usdt}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                    <div class="invest-data ">
                                        <div class="invest-data-amount g-2 justify-content-center">
                                            <a href="{{route('deposit.usdt')}}" class="btn btn-primary">Deposit More</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/total_purchase.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Total Investment</h6>
                                            <p>Total Investment</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Total Investment"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$total_purchase}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                    <div class="invest-data ">
                                        <div class="invest-data-amount g-2 justify-content-center">
                                            <a href="{{route('buy.package')}}" class="btn btn-primary">Purchase
                                                More</a>

                                        </div>

                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/level_income.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Level Income</h6>
                                            <p>Total Level income</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Total Level Income"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$total_level_income}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>

                                    </div>
                                    <hr>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/roi_income.svg')}}" alt="">
                                            </div>
                                            <h6 class="title">Roi Income</h6>
                                            <p>Total Roi Income</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Total Roi Income"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100"> {{$total_roi_income}}<span
                                                class="currency currency-usd text-dark fw-normal"> $</span>
                                        </span>
                                    </div>
                                    <hr>
                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-8" style="display:block;">
                            <div class="card card-bordered card-full card-ico referbox">
                                <div class="card-inner">
                                    <div class="img-refer"><img src="{{url('/assets/images/new/referral.webp')}}"
                                            alt="referral"> </div>
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/new/referral.png')}}" alt="">
                                            </div>
                                            <h6 class="title">Referral Link</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Referral Link"></em>
                                        </div>
                                    </div>

                                    <div class="card-inner px-0 pt-5 mt-0 pb-0 text-left">

                                        <div class="lrbtn mb-4">
                                            <label class="textToBeCopied fw-bold mb-0"
                                                id="referral_link"><?= $referral_link ?></label>
                                        </div>
                                        <div class="invest-data ">
                                            <div class="invest-data-amount g-2 justify-content-start">



                                                <a class="btn btn-primary mt-0" data-clipboard-target="#referral_link"
                                                    href="javascript:void(0)" onclick="copytext('Copy_referral')"
                                                    id="Copy_referral"><em class="icon ni ni-copy mr-1"
                                                        style="font-size: 1.1em;"></em> Copy </a>

                                            </div>

                                        </div>
                                    </div>



                                </div>
                            </div><!-- .card -->
                        </div>

                        <div class="col-md-4" style="display:none;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/global-binary.png')}}" alt="">
                                            </div>
                                            <h6 class="title">Wallet Transfer</h6>
                                            <p>Transfer your funds into withdraw wallet</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                data-placement="left" title="Wallet Transfer"></em>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-amount mt-1 text-center">
                                        <span class="amount text-dark fw-bold w-100">
                                            0
                                            <span class="currency currency-usd text-dark fw-normal">$</span>
                                        </span>

                                    </div>
                                    <hr>
                                    <div class="invest-data ">
                                        <div class="invest-data-amount g-2 justify-content-between">

                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div>


                    </div><!-- .row -->

                    <div class="row g-gs" style="display:none">
                        <div class="col-md-12">
                            <div class="card card-bordered card-full card-ico referbox">
                                <div class="card-inner">

                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">

                                        </div>

                                    </div>

                                    <div class="card-inner px-0 pt-5 mt-0 text-left">

                                        <div class="lrbtn mb-3">


                                            <table class="table table-bordered table-hover table-striped">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Min. Amount</th>
                                                        <th>Max Amount</th>
                                                        <th>Monthly Return (%)</th>
                                                        <th>Lock Period (months)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>



                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->

                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>

@endsection