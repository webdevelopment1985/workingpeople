@extends('admin.layouts.master')

@section('page_title')
Transactions History
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-3">
                <h3 class="page-title">Transactions History</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('transactions.index') }}">Transactions</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                <div class="d-flex align-items-end txnfilter">
                    <div class="form-control-wrap">
                        <div class="input-daterange date-picker-range input-group align-items-center">
                            <input type="text" class="form-control" name="dates" id="dates" placeholder="Date Range..." />
                        </div>
                    </div> 
                    <div class="form-control-wrap">
                        <select class="form-control" name="status" id="status">
                            <option value="all">- Select Status-</option>
                            <option value="2">Pending</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <?php
                        $transType = config('params.trans_type');
                        ?>
                        <select class="form-control" name="trans_type" id="trans_type">
                            <option value="all">- Select Type-</option>
                            <?php
                            if($transType){
                                foreach($transType as $Key=>$Value){?>
                                    <option value="<?=$Key?>" <?=$Key == $flag ? "Selected=Selected" : "" ?>><?=$Value?></option>
                                <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <select name="mode" id="mode" class="form-control">
                            <option value="all">- Select Mode-</option>
                            <option value="credit">Credit</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="nk-tb-col">Sr No</th>
                            <th class="nk-tb-col">Date</th>
                            <th class="nk-tb-col">Username</th>
                            <th class="nk-tb-col">Txn ID</th>
                            <th class="nk-tb-col">Mode</th>
                            <th class="nk-tb-col">Type</th>
                            <th class="nk-tb-col">Amount</th>
                            <th class="nk-tb-col">Narration</th>
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
@endsection

@push('scripts')

<script>
    let simple;
    $(function() {
        simple = $('#table').DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            ordering: false,
            ajax: {
                "url": "{{ route('transactions.history') }}",
                "type": 'POST',
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.status = $("#status").val();
                    d.trans_type = $("#trans_type").val();
                    d.mode = $("#mode").val();
                    d.dates = $("#dates").val();
                    d.flag ="<?=$flag?>";
                }
            },
            "lengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            
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
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'txid',
                    name: 'txid'
                },
                {
                    data: 'type',
                    name: 'type',
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
                    data: 'narration',
                    name: 'narration',
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