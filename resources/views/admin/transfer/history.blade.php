@extends('admin.layouts.master')

@section('page_title')
{{ __('Transfer History') }}
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
            <div class="col-md-6">
                <h3 class="page-title">{{__('Transfer History')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('transfer.history') }}">{{ __('Transfer History') }}</a>
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
                <table class="table table-hover table-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="">{{ __('invoice.table.sl') }}</th>
                            <th class="">{{ __('DateTime') }}</th>
                            <th class="">{{ __('TxId') }}</th>
                            <th class="">{{ __('FromUser') }}</th>
                            <th class="">{{ __('ToUser') }}</th>
                            <th class="">{{ __('Amount') }}</th>
                            <th class="">{{ __('Status') }}</th>                            
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
                "url": "{{ route('transfer.history') }}",
                "data": function(d) {
                    d.status = $("#status").val();
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
                    data: 'transactionId',
                    name: 'transactionId'
                },
                {
                    data: 'fromUser',
                    name: 'fromUser'
                },
                {
                    data: 'toUser',
                    name: 'toUser'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ],
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
@endpush