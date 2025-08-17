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
                                                <img src="{{url('/assets/images/nicon/USDT_Wallet4.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/total_deposit1.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/total_income5.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/total_purchase7.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/level_income2.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/ROI_income6.svg')}}" alt="">
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
                                                <img src="{{url('/assets/images/nicon/referral_bonus3.svg')}}" alt="">
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

                        <div class="col-md-4" style="display:block;">
                            <div class="card card-bordered card-full card-ico">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <div class="icon-sec">
                                                <img src="{{url('/assets/images/nicon/wallet_transfer8.svg')}}" alt="">
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

                    <div class="row g-gs" style="display:block">
                        <div class="col-md-12">
                            <div class="card card-bordered card-full card-ico referbox">
                                <div class="card-inner">

                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">

                                        </div>

                                    </div>

                                    <div class="card-inner px-0 pt-5 mt-0 text-left">

                                        <div class="lrbtn mb-3">


                                            <div class="table-responsive mt-4">
                                                <!-- Added table-responsive for better table handling on small screens -->
                                                <table id="transactionTable"
                                                    class="table table-bordered table-striped w-100 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="nk-tb-col">Sr No</th>
                                                            <th class="nk-tb-col">Date</th>
                                                            <th class="nk-tb-col">Txn ID</th>
                                                            <th class="nk-tb-col">Mode</th>
                                                            <th class="nk-tb-col">Amount</th>
                                                            <th class="nk-tb-col">Type</th>
                                                            <th class="nk-tb-col">Narration</th>
                                                            <th class="nk-tb-col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="nk-tb-col">Sr No</td>
                                                            <td class="nk-tb-col">Date</td>
                                                            <td class="nk-tb-col">Txn ID</td>
                                                            <td class="nk-tb-col">Mode</td>
                                                            <td class="nk-tb-col">Amount</td>
                                                            <td class="nk-tb-col">Type</td>
                                                            <td class="nk-tb-col">Narration</td>
                                                            <td class="nk-tb-col">Status</td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>

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