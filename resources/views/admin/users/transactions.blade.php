@extends('admin.layouts.master')

@section('page_title')
{{ __('User Details') }}
@endsection

@section('content')

<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-4">
                <h3 class="page-title">{{__('Transactions Details')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        {{ __('Transactions Details') }}
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-8">
                <div class="d-flex align-items-end txnfilter">
                    <div class="form-control-wrap">
                        <label class="overline-title overline-title-alt mb-2">Date</label>
                        <div class="input-daterange date-picker-range input-group align-items-center">
                            <input type="text" class="form-control" name="dates" id="dates" placeholder="Date Range..." />
                        </div>
                    </div> 
                    <div class="form-control-wrap">
                    <label for="trans_type" class="overline-title overline-title-alt mb-2">Type</label>
                        <select class="form-control" name="trans_type" id="trans_type">
                            <option value="all">- Select -</option>
                            <option value="deposit">Deposit</option>
                            <option value="purchase">Purchase</option>
                            <option value="roi-income">ROI Income</option>
                            <option value="level-income">Level Income</option>
                            <option value="internal-transfer">Transfer</option>
                            <option value="withdraw">Withdrawal</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div> -->
        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="widget-container fluid-height">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="heading tabs">
                                <ul class="nav nav-tabs nav-tabs-solid" data-tabs="tabs" id="tabs">
                                    @include('admin.users.user_info_tabs', ['userId'=>$userId])
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-end txnfilter">
                                <div class="form-control-wrap">
                                    <!-- <label class="overline-title overline-title-alt mb-2">Date</label> -->
                                    <div class="input-daterange date-picker-range input-group align-items-center">
                                        <input type="text" class="form-control" name="dates" id="dates" placeholder="Date Range..." />
                                    </div>
                                </div> 
                                <div class="form-control-wrap">
                                <!-- <label for="trans_type" class="overline-title overline-title-alt mb-2">Type</label> -->
                                    <select class="form-control" name="trans_type" id="trans_type">
                                        <option value="all">-Select Type -</option>
                                        <option value="deposit">Deposit</option>
                                        <option value="purchase">Purchase</option>
                                        <option value="roi-income">ROI Income</option>
                                        <option value="level-income">Level Income</option>
                                        <option value="internal-transfer">Transfer</option>
                                        <option value="withdraw">Withdrawal</option>
                                    </select>
                                </div>
                                <div class="form-control-wrap">
                                    <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content padded" id="my-tab-content">
                        <div class="tab-pane active" id="tab1">
                            <!-- <h3> Transactions </h3> -->
                            <table class="table table-hover table-center mb-0" id="table">
                                <thead>
                                    <tr>
                                        <th class="nk-tb-col">Sr No</th>
                                        <th class="nk-tb-col">Date</th>
                                        <th class="nk-tb-col">Txn ID</th>
                                        <th class="nk-tb-col">Narration</th>
                                        <th class="nk-tb-col">Type</th>
                                        <th class="nk-tb-col">Amount</th>
                                        <th class="nk-tb-col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    var simple;
    $(function() {
        simple = $('#table').DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            ordering: false,
            ajax: {
                "url": "{{ route('users.transactions',$userId) }}",
                "data": function(d) {
                    d.user_id = '<?=$userId?>';
                    d.status = $("#status").val();
                    d.trans_type = $("#trans_type").val();
                    d.mode = $("#mode").val();
                    d.dates = $("#dates").val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false                 

                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'txid',
                    name: 'txid'
                },
                {
                    data: 'narration',
                    name: 'narration',
                },
                {
                    data: 'trans_type',
                    name: 'trans_type',
                    
                },
                {
                    data: 'amount',
                    name: 'amount',
                },
                {
                    data: 'status',
                    name: 'status',
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf',
            ],
            "lengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
        });
    });
    function reload_table() {
        simple.draw();
    }
</script>
<script>
    $(function() {
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
        });

        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });

        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endpush