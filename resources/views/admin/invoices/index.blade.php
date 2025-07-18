@extends('admin.layouts.master')

@section('page_title')
{{ __('invoice.index.title') }}
@endsection

@push('css')
<style>
    .table tr td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-4">
                <h3 class="page-title">{{__('Investments')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('invoices.index') }}">{{ __('Investments') }}</a>
                    </li>
                </ul>
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
                        <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-3">
                <div class="d-flex mt-2">
                    <div class="form-control-wrap w-100">
                        <select name="status" id="status" class="form-control">
                            <option value="1">Completed</option>
                            <option value="0">Pending</option>
                        </select>
                    </div>

                    <button type="submit" onclick="reload_table();" class="btn btn-success ml-2">Search</button>
                </div>
            </div> -->


            <!-- <div class="col-md-3">
                    <div class="create-btn pull-right">
                        <a href="{{ route('invoices.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button') }}</a>
                    </div>                 
                </div> -->
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
                            <th class="">{{ __('invoice.table.sl') }}</th>
                            <th class="">{{ __('Start Date') }}</th>
                            <th class="">User</th>
                            <th class="">{{ __('Email') }}</th>
                            <th class="">{{ __('Invest amount') }}</th>
                            <!-- <th class="">{{ __('invoice.table.tokens') }}</th> -->
                            <!-- <th class="">{{ __('invoice.table.receiving_address') }}</th> -->
                            <!-- <th class="">{{ __('Hash') }}</th> -->
                            <th class="">{{ __('Lockin Period(Month)') }}</th>
                            <th class="">{{ __('End Date') }}</th>
                            <!-- <th class="">{{ __('Distributed Month') }}</th> -->
                            
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
                "url": "{{ route('invoices.index') }}",
                "data": function(d) {
                    d.status = $("#status").val();
                    d.dates = $("#dates").val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'months',
                    name: 'months'
                },
                {
                    data: 'mature_date',
                    name: 'mature_date'
                },
                // {
                //     data: 'distributed_months',
                //     name: 'distributed_months'
                // }
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf',
            ],
            "lengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
        });
    });
</script>

<script type="text/javascript">
    function reload_table() {
        simple.draw();
    }
    $("body").on("click", ".remove-user", function() {
        var current_object = $(this);
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "error",
            showCancelButton: true,
            dangerMode: true,
            cancelButtonClass: '#DD6B55',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete!',
        }, function(result) {
            if (result) {
                var action = current_object.attr('data-action');
                var token = jQuery('meta[name="csrf-token"]').attr('content');
                var id = current_object.attr('data-id');

                $('body').html("<form class='form-inline remove-form' method='POST' action='" + action +
                    "'></form>");
                $('body').find('.remove-form').append(
                    '<input name="_method" type="hidden" value="post">');
                $('body').find('.remove-form').append('<input name="_token" type="hidden" value="' +
                    token + '">');
                $('body').find('.remove-form').append('<input name="id" type="hidden" value="' + id +
                    '">');
                $('body').find('.remove-form').submit();
            }
        });
    });
</script>

<script type="text/javascript">
    function changeInvoiceStatus(_this, id) {
        var status = $(_this).prop('checked') == true ? 1 : 0;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `{{ route('invoices.status_update') }}`,
            type: 'GET',
            data: {
                _token: _token,
                id: id,
                status: status
            },
            success: function(result) {
                if (status == 1) {
                    toastr.success(result.message);
                } else {
                    toastr.error(result.message);
                }
            }
        });
    }

    function syncBuy(trans, emailAddress = '') {

        $.ajax({
            type: 'POST',
            beforeSend: function() {
                $(this).attr('disabled', 'disabled').html('Syncing...');
            },
            url: "{{ route('invoices.sync') }}",
            data: {
                _token: '{{csrf_token()}}',
                trans: trans,
                emailAddress: emailAddress
            },
            dataType: 'json',
            success: function(data) {
                if (data.R) {
                    toastr.success(data.M);
                    reload_table();
                } else {
                    toastr.error(data.M);
                }
            }
        });
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