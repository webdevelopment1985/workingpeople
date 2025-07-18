@extends('templates.partials.main')
@section('title', $title)
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">
                                <?=$title?>
                            </h3>
                        </div>
                        <!--nk-block-head-content-->
                    </div>
                    <!--nk-block-between-->
                </div>
                <!--nk-block-head-->
                <div class="nk-block depamtblock">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="card-head">
                                        <h6 class="card-title">
                                            <?=$title?>
                                        </h6>
                                    </div>
                                    <hr>
                                    <form class="form-element p-2" id="withdrawForm" name="withdrawForm">
                                        @csrf
                                        <input type="hidden" name="w_request_id" id="w_request_id" value="">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="fancy-border">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address"> Receiving Address
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="address"
                                                                id="address" placeholder="0x-----" value="">
                                                        </div>
                                                        <span class="err"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter Amount</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="amount"
                                                                id="amount" value="" placeholder="$ 0.00">

                                                        </div>
                                                        <span class="err"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter OTP</label>
                                                        <div class="form-control-wrap d-flex align-items-center">
                                                            <input type="text" class="form-control" name="otp" id="otp"
                                                                value="" placeholder="Enter Your OTP"
                                                                disabled="disabled">
                                                            <button onClick="sendOtpBtn();" data-type="1" type="button"
                                                                style="font-size: 0.8125rem;"
                                                                class="btn-darkblue btn btn-gray h-100 ml-2 btn-lg"
                                                                id="sendBtn">Send</button>
                                                        </div>

                                                    </div>

                                                    <button type="button" data-type="2" class="btn btn-primary mt-3"
                                                        id="withdrawBtn" disabled="disabled">Send Request</button>
                                                </div>

                                            </div>
                                            <div class="col-md-5 offset-md-1">

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Your withdrawable Balance</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="withdrawable_amount">{{ $withdrawable_amount }}</span>
                                                    </div>
                                                </div>

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Min withdraw amount</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="">{{ $minimum_withdraw }}</span>
                                                    </div>
                                                </div>


                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Withdraw fee</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="">{{ $withdraw_fee }} %</span>
                                                    </div>
                                                </div>


                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">You will receive </span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="receivable_amount">0.00</span>
                                                    </div>
                                                </div>



                                            </div>


                                        </div>
                                        <!--d-flex-->
                                    </form>
                                </div>
                                <!--card-inner-->
                            </div>
                            <!--card-->
                        </div>
                        <!--col-md-9-->
                    </div>
                    <!--row-->
                </div>
                <!--nk-block-->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="card card-bordered mb-3">
                                <div class="card-inner-group">
                                    <div class="card-inner position-relative card-tools-toggle pb-3 pt-3">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Withdrawal Transactions</h6>
                                            </div>
                                            <!--card-title-->
                                        </div>
                                        <!--card-title-group-->
                                    </div>
                                    <!--card-inner-->
                                    <div class="card-inner">
                                        <div class="">

                                            <table id="withdrawalHistory"
                                                class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>
                                                        <th class="nk-tb-col">DateTime</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Fee($)</th>
                                                        <th class="nk-tb-col">Amount Paid($)</th>
                                                        <th class="nk-tb-col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>
                                                        <th class="nk-tb-col">DateTime</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Fee($)</th>
                                                        <th class="nk-tb-col">Amount Paid($)</th>
                                                        <th class="nk-tb-col">Status</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!--table-responsive-->
                                    </div>
                                    <!--card-inner-->
                                </div>
                                <!--card-inner-group-->
                            </div>
                            <!--card-->
                        </div>
                        <!--col-md-12-->
                    </div>
                    <!--row g-gs-->
                </div>
                <!--nk-block-->
            </div>
            <!--nk-content-body-->
        </div>
        <!--nk-content-inner-->
    </div>
    <!--container-fluid-->
</div>
<!--nk-content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
<script>
var simple;
$(document).ready(function() {
    simple = $('#withdrawalHistory').DataTable({
        createdRow: function(row, data, dataIndex) {
            $(row).find('td:eq(1)')
                .addClass('leadclass');
        },
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": "{{ route('user.getWithdrawHistory') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.type = ''
            }
        },
        "lengthMenu": [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        "pageLength": 10,

        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "dom": 'ftrip',
    });
});

$("body").on("click", "#withdrawBtn", function() {
    let address = $("#address").val();
    let amount = $("#amount").val();
    let type = $('#withdrawBtn').attr('data-type');
    let otp = $("#otp").val();
    let w_request_id = $("#w_request_id").val();

    $.ajax({
        beforeSubmit: function() {
            $("#withdrawBtn").attr('disabled', 'disabled').html('Please wait...');
        },
        type: 'POST',
        url: "{{ route('user.withdrawrequest') }}",
        data: {
            _token: '{{csrf_token()}}',
            address: address,
            amount: amount,
            type: type,
            otp: otp,
            request_id: w_request_id
        },
        success: function(response) {
            if (response.R) {
                iziToast.success({
                    message: response.M,
                    position: 'topRight'
                });
                if ('data' in response && 'withdrawable_amount' in response.data) {
                    $("#withdrawable_amount").html(response.data
                        .withdrawable_amount);
                }
                reload_table();
                $("#withdrawForm")[0].reset();
                $("#withdrawBtn").attr('disabled', 'disabled');
            } else {
                iziToast.error({
                    message: '' + response.M,
                    position: 'topRight'
                });
            }
        },
        complete: function() {
            $("#withdrawBtn").removeAttr('disabled').html('Send Request');
        }
    });
});



function sendOtpBtn() {
    let address = $("#address").val();
    let amount = $("#amount").val();
    let type = $('#sendBtn').attr('data-type');
    $.ajax({
        type: 'POST',
        beforeSend: function() {
            $("#sendBtn").attr('disabled', 'disabled').html('Sending...');
        },
        url: "{{ route('user.withdrawrequest') }}",
        data: {
            _token: '{{csrf_token()}}',
            address: address,
            amount: amount,
            type: type
        },
        dataType: 'json',
        success: function(response) {
            $("#sendBtn").removeAttr('disabled').html('Send');
            if (response.R) {
                iziToast.success({
                    message: response.M,
                    position: 'topRight'
                });
                $('#w_request_id').val(response.data);
                $('#otp').removeAttr('disabled');
                $("#withdrawBtn").removeAttr('disabled').html('Send Request');
            } else {
                iziToast.error({
                    message: '' + response.M,
                    position: 'topRight'
                });
            }
        }
    });
}

function reload_table() {
    simple.ajax.reload();
}

$(document).ready(function() {
    const feePercent = "{{ $withdraw_fee }}";
    const $amountInput = $("#amount");
    const $receivableAmount = $("#receivable_amount");

    $amountInput.on("keyup change", function() {
        let amount = parseFloat(this.value);
        if (isNaN(amount) || amount < 0) {
            $receivableAmount.text("0");
            return;
        }
        let feeAmount = amount * (feePercent / 100);
        let receivableAmount = amount - feeAmount;
        $receivableAmount.text(receivableAmount.toFixed(2));
    });
});
</script>
@endsection