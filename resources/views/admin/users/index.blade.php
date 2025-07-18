@extends('admin.layouts.master')
@section('title', 'Users')
@section('page_title')
{{ __('user.index.title') }}
@endsection

@push('css')
<style>
.table tr td {
    vertical-align: middle;
}

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
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-4">
                <h3 class="page-title">{{__('user.index.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('users.index') }}">{{ __('user.index.title') }}</a>
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
                        <select name="is_verified" id="is_verified" class="form-control">
                            <option value="">-All-</option>
                            <option value="1" <?=$flag == 2 ? 'Selected=Selected' : ''?>>Active</option>
                            <option value="0" <?=$flag == 3 ? 'Selected=Selected' : ''?>>Inactive</option>                            
                        </select>
                    </div>
                    <div class="form-control-wrap">
                        <button type="submit" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div>


            @if (Gate::check('user-create'))
            <div class="col-md-3">
                <div class="create-btn pull-right">
                    <a href="{{ route('users.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button')
                        }}</a>
                </div>
            </div>
            @endif
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
                            <th class="">{{ __('default.table.sl') }}</th>
                            <th class="">{{ __('JoinedOn') }}</th>
                            <th class="">{{ __('default.table.name') }}</th>
                            <th class="">{{ __('default.table.username') }}</th>
                            <th class="">{{ __('default.table.email') }}</th>
                            <th class="">{{ __('IB') }}</th>
                            <th class="">{{ __('Deposit Wallet') }}</th>
                            <th class="">{{ __('Income Wallet') }}</th>
                            <th class="">{{ __('default.table.status') }}</th>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="viewBalancePopup" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBalancePopupTitle"></h5>
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
@endsection


@push('scripts')
<script>
var simple;
$(function() {
    simple = $('#table').DataTable({
        processing: true,
        responsive: false,
        serverSide: true,
        "ordering": false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            "url": "{{ route('users.index') }}",
            "data": function(d) {
                d.is_verified = $("#is_verified").val(),
                d.flag = "<?=$flag?>",
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
                data: 'name',
                name: 'name'
            },

            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'is_paid',
                name: 'is_paid'
            },
            {
                data: 'wallet_amount',
                name: 'wallet_amount'
            },
            {
                data: 'withdrawable_amount',
                name: 'withdrawable_amount'
            },
            {
                data: 'is_verified',
                name: 'is_verified'
            },
            {
                data: 'action',
                name: 'action'
            }
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
function changeUserStatus(_this, id) {
    var status = $(_this).prop('checked') == true ? 1 : 0;
    let _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: `{{ route('users.status_update') }}`,
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

function changeUserVerifyStatus(_this, id) {
    var is_verified = $(_this).prop('checked') == true ? 1 : 0;
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: `{{ route('users.verify_status_update') }}`,
        type: 'GET',
        data: {
            _token: _token,
            id: id,
            is_verified: is_verified
        },
        success: function(result) {
            if (is_verified == 1) {
                toastr.success(result.message);
            } else {
                toastr.error(result.message);
            }
        }
    });
}

function viewUserBalance(_this, id, type) {
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: `{{ route('view-balance') }}`,
        type: 'POST',
        beforeSend: function() {
            showLoader();
        },
        data: {
            _token: _token,
            id: id,
            type: type
        },
        success: function(response) {
            let modalHtml = '';
            $("#viewBalancePopupTitle").text(type == 1 ? 'User Balances' : 'User Address');
            if (response.status) {
                if (type == 1) {
                    modalHtml +=
                        `<div id="usc"> USC Balance  : ${response.data.usc}</div>`;
                    modalHtml +=
                        `<div id="usdt"> USDT Balance  : ${response.data.usdt}</div>`;
                    modalHtml +=
                        `<div id="oldUbit"> Old Ubit Balance  : ${response.data.oldUbit}</div>`;
                } else {

                    modalHtml +=
                        `<div class="container-fluid">
                                <div class="row">
                                    <h5 class="title"> USDT Address :  <a href='https://bscscan.com/address/${response.data.usdt}' target='_blank'> ${response.data.usdt} </a></h5>
                                </div>
                                <div class="row">
                                    <h5 class="title"> Old Ubit Address :  <a href='https://ubitscan.com/address/${response.data.oldUbit}' target='_blank'> ${response.data.oldUbit} </a></h5>
                                </div>
                            </div>`;
                }
                $("#viewBalancePopup").find('.modal-body').html(modalHtml);
            } else {
                $("#viewBalancePopup").find('.modal-body').html(response.message);
            }
            $("#viewBalancePopup").modal('show')
        },
        complete: function() {
            hideLoader();
        },
    });
}

function showLoader() {
    $('.loaderring').show();
}

function hideLoader() {
    $('.loaderring').hide();
}

function reload_table() {
    simple.draw();
}

hideLoader();
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