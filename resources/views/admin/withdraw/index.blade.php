@extends('admin.layouts.master')

@section('page_title')Withdraw
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-4">
                <h3 class="page-title">Withdraw</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('withdraw.index') }}">Withdraw</a>
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-3">
                <div class="create-btn pull-right">
                    <a href="{{ route('settings.create') }}" class="btn custom-create-btn">Create Settings</a>
                </div>                 
            </div> -->
            <div class="col-md-8">
                <div class="d-flex align-items-end txnfilter">
                    <div class="form-control-wrap">
                        <!-- <label class="overline-title overline-title-alt mb-2">Date</label> -->
                        <!-- <div class="input-daterange date-picker-range input-group align-items-center">
                            <input type="text" class="form-control" name="dates" id="dates" placeholder="Date Range..." />
                        </div> -->
                    </div> 
                    <div class="form-control-wrap">
                        <!-- <label for="trans_type" class="overline-title overline-title-alt mb-2">Status</label> -->
                        <select class="form-control" name="txn_status" id="txn_status">
                            <option value="">Select Status</option>
                            <option value="12">Processing</option>
                            <option value="4">Completed</option>
                            <option value="6">Rejected</option>
                            <option value="8">In Review</option>
                            <option value="13">Suspicious</option>
                            <option value="7">Error</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <!-- <label for="trans_type" class="overline-title overline-title-alt mb-2">Status</label> -->
                        <select class="form-control" name="search_by" id="search_by">
                            <option value="">Search By</option>
                            <option value="email">Email</option>
                            <option value="username">Username</option>
                            <option value="hash">Hash</option>
                            <option value="withdrawal_id">Withdrawal ID</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                    <input type="text" value="" class="form-control" name="search_value" id="search_value" placeholder="Enter search value">
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
                            <th class="">DateTime</th>
                            <th class="">Withdrawal ID</th>
                            <th class="">Hash</th>
                            <th class="">Username</th>
                            <th class="">Email</th>
                            <th class="">Currency</th>
                            <th class="">Amount</th>
                            <th class="">Fee</th>
                            <th class="">Amount Paid</th>
                            <th class="">Status</th>
                            <th class="">Address</th>
                            <th class="">{{ __('default.table.action') }}</th>                            
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
    var simple;
    $(function() {
        simple = $('#table').DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            order: [
                [0, 'desc']
            ],
            ajax: {
                "url": "{{ route('withdraw.allWithdrawals') }}",
                "type": 'POST',
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.currency = $('#currency').val();
                    d.txn_status = $('#txn_status').val();
                    d.search_by = $('#search_by').val();
                    d.search_value = $('#search_value').val();
                    // d.trans_type = $("#trans_type").val();
                    // d.mode = $("#mode").val();
                }
            },

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