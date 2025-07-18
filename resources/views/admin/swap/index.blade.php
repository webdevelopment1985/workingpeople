@extends('admin.layouts.master')

@section('page_title')
{{ __('swap.index.title') }}
@endsection

@push('css')
<style>
    .table tr td {
        vertical-align: middle;
    }
</style>

<style>
    .tri-ring {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: #6576ff;
        animation: spin 2s linear infinite;
        position: absolute;
        left: 50%;
        right: 0;
        top: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
    }

    @keyframes spin {
        0% {
            -webkit-transform: rotate(0);
            -ms-transform: rotate(0);
            transform: rotate(0)
        }

        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    .tri-ring:after {
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-top-color: #1f2b3a;
        animation: spin 1.5s linear infinite;
    }

    .tri-ring:after,
    .tri-ring:before {
        content: "";
        position: absolute;
        border-radius: 50%;
        border: 3px solid transparent;
    }

    .tri-ring:before {
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-top-color: #09c2de;
        animation: spin 3s linear infinite;
    }

    .loaderring {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgb(255 255 255 / 90%);
        z-index: 9;
    }
</style>


@endpush

@section('content')


<!-- Modal -->
<div class="modal fade" id="viewAddressPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewAddressPopupTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('swap.index.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('users.index') }}">{{ __('swap.index.title') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="create-btn pull-right">
                    <a href="{{ route('swap.export_csv') }}" class="btn custom-create-btn">{{ __('Export CSV Report')
                        }}</a>
                </div>
            </div>



            <div class="col-md-3">
                <div class="d-flex mt-2">
                    <div class="form-control-wrap w-100">
                        <select name="status" id="status" class="form-control">
                            <option value="1">Approved</option>
                            <option value="0">Pending</option>
                            <option value="2">Rejected</option>
                        </select>
                    </div>

                    <button type="submit" onclick="reload_table();" class="btn btn-success ml-2">Search</button>
                </div>
            </div>



        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="loaderring">
                <div class="tri-ring"></div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="">{{ __('swap.table.sl') }}</th>
                            <th class="">{{ __('swap.table.name') }}</th>
                            <th class="">{{ __('swap.table.email') }}</th>
                            <th class="">{{ __('swap.table.payment_id') }}</th>
                            <th class="">{{ __('swap.table.rec_address') }}</th>
                            <th class="">{{ __('swap.table.txid') }}</th>
                            <th class="">{{ __('swap.table.amount') }}</th>
                            <th class="">{{ __('swap.table.added') }}</th>
                            <th class="">{{ __('swap.table.view_address') }}</th>
                            <th class="">{{ __('swap.table.action') }}</th>
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
            ordering: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                "url": "{{ route('swap.index') }}",
                "data": function(d) {
                    d.status = $("#status").val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_name',
                    name: 'user_name',
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'payment_id',
                    name: 'payment_id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rec_address',
                    name: 'rec_address',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'txid',
                    name: 'txid'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'added',
                    name: 'added',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'view_address',
                    name: 'view_address',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    });
</script>

<script type="text/javascript">
    $("body").on("click", ".remove-swap", function() {
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
    function changeSwapStatus(_this, id, status) {
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: `{{ route('swap.status_update') }}`,
            type: 'POST',
            beforeSend: function() {
                $('.loaderring').show();
            },
            data: {
                _token: _token,
                id: id,
                status: status
            },
            success: function(response) {
                setTimeout(() => {
                    if (response.status) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                    reload_table();
                }, 10000);

            },
            complete: function() {
                setTimeout(() => {
                    $('.loaderring').hide();
                }, 10000);
            },
        });
    }

    function reload_table() {
        simple.ajax.reload(null, false);
    }

    function viewTransId(_this, id) {
        let _token = $('meta[name="csrf-token"]').attr('content');
        let balanceHtml = '';
        $.ajax({
            url: `{{ route('swap.view_transid') }}`,
            type: 'POST',
            beforeSend: function() {
                $('.loaderring').show();
            },
            data: {
                _token: _token,
                id: id
            },
            success: function(response) {
                $("#viewAddressPopupTitle").text('Old Ubit Address');
                if (response.status) {
                    if (response.data.address != '') {
                        balanceHtml +=
                            `<h5 class="title" id="address_input"><a href='https://ubitscan.com/address/` +
                            response.data.address + `' target='_blank'>` +
                            response.data.address +
                            `</a></h5>`;
                    } else {
                        balanceHtml +=
                            `<h5 class="title" id="address_input">Address not found</h5>`;
                    }

                    $("#viewAddressPopup").find('.modal-body').html(balanceHtml);
                } else {
                    $("#viewAddressPopup").find('.modal-body').html(response.message);
                }
                $("#viewAddressPopup").modal('show')
            },
            complete: function() {
                $('.loaderring').hide();
            },
        });
    }


    $('.loaderring').hide();
</script>
@endpush