@extends('admin.layouts.master')

@section('page_title')
{{ __('deposit.index.title') }}
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
                <h3 class="page-title">{{__('deposit.index.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('deposits.index') }}">{{ __('deposit.index.title') }}</a>
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-3">
                    <div class="create-btn pull-right">
                        <a href="{{ route('deposits.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button') }}</a>
                    </div>                 
                </div> -->
            <div class="col-md-8">
                <div class="d-flex align-items-end txnfilter">
                    <div class="form-control-wrap">
                        <!-- <label class="overline-title overline-title-alt mb-2">Date</label> -->
                        <div class="input-daterange date-picker-range input-group align-items-center">
                            <input type="text" class="form-control" name="dates" id="dates" placeholder="Date Range..." />
                        </div>
                    </div> 
                    <div class="form-control-wrap">
                        <select name="subtype" id="subtype" class="form-control">
                            <!-- <option value="uscnew">USC</option> -->
                            <option value="bep20">USDT</option>
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <select name="status" id="status" class="form-control">
                            <option value="1">Completed</option>
                            <option value="0">Pending</option>
                        </select>
                    </div>
                    
                    <div class="form-control-wrap">
                        <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <table class="table table-hover table-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="">{{ __('deposit.table.sl') }}</th>
                            <th class="">{{ __('DateTime') }}</th>
                            <th class="">{{ __('deposit.table.txid') }}</th>
                            <th class="">User</th>
                            <th class="">{{ __('deposit.table.email') }}</th>
                            <th class="">{{ __('deposit.table.amount') }}</th>
                            <th class="">{{ __('Narration') }}</th>
                            <th class="">{{ __('deposit.table.status') }}</th>
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
    function copyToClipboard(element) {
        var contentToCopy = document.getElementById(element).value;
        window.navigator.clipboard.writeText(contentToCopy).then(function() {}, function(err) {
            console.error('Unable to copy with async ', err);
        });
    }
</script>
<script>
    var simple;
    $(function() {
        simple = $('#table').DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            ordering: false,
            ajax: {
                "url": "{{ route('deposits.index') }}",
                "data": function(d) {
                    d.subtype = $("#subtype").val();
                    d.status = $("#status").val();
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
                    data: 'added_on',
                    name: 'added_on',
                    orderable: false,
                    searchable: false
                }, 
                {
                    data: 'txid',
                    name: 'txid',
                    
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    searchable: false  
                },
                {
                    data: 'naration',
                    name: 'naration',
                    orderable: false,
                    searchable: false
                },               
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
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

<script type="text/javascript">
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
    function changeSettingStatus(_this, id) {
        var status = $(_this).prop('checked') == true ? 1 : 0;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `{{ route('deposits.status_update') }}`,
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