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
                                    <form class="form-element p-2" id="walletTransferForm" name="walletTransferForm">
                                        @csrf
                                        <input type="hidden" name="w_request_id" id="w_request_id" value="">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="fancy-border">
                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter Amount</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="amount"
                                                                id="amount" value="" placeholder="$ 0.00" required>

                                                        </div>
                                                        <span class="err"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter OTP</label>
                                                        <div class="form-control-wrap d-flex align-items-center">
                                                            <input type="text" class="form-control" name="otp" id="otp"
                                                                value="" placeholder="Enter Your OTP"
                                                                disabled="disabled" required>
                                                            <button onClick="sendOtpBtn();" data-type="1" type="button"
                                                                style="font-size: 0.8125rem;"
                                                                class="btn-darkblue btn btn-gray h-100 ml-2 btn-lg"
                                                                id="sendBtn">Send</button>
                                                        </div>

                                                    </div>

                                                    <button type="button" data-type="2" class="btn btn-primary mt-3"
                                                        id="transferBtn" disabled="disabled">Send Request</button>
                                                </div>

                                            </div>
                                            <div class="col-md-5 offset-md-1">

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Income Wallet Balance</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="wallet_amount">{{ $wallet_amount }}</span>
                                                    </div>
                                                </div>

                                              
                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Withdrawal Balance</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="withdraw_amount">{{ $withdrawal_amount }}</span>
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
                                                <h6 class="title">Wallet Transfer History</h6>
                                            </div>
                                            <!--card-title-->
                                        </div>
                                        <!--card-title-group-->
                                    </div>
                                    <!--card-inner-->
                                    <div class="card-inner">
                                        <div class="">

                                            <table id="walletTransferHistory"
                                                class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>                                                        
                                                        <th class="nk-tb-col">DateTime</th>
                                                        <th class="nk-tb-col">TxnId</th>
                                                        <th class="nk-tb-col">Narration</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Hash</th>
                                                        <th class="nk-tb-col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>                                                        
                                                        <th class="nk-tb-col">DateTime</th>
                                                        <th class="nk-tb-col">TxnId</th>
                                                        <th class="nk-tb-col">Narration</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Hash</th>
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
<script>
var simple;
$(document).ready(function() {
    simple = $('#walletTransferHistory').DataTable({
        createdRow: function(row, data, dataIndex) {
            $(row).find('td:eq(1)')
                .addClass('leadclass');
        },
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": "{{ route('user.walletTransferHistory') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.type = ''
            }
        },
        "order": [[ 1, 'desc' ]],
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


function reload_table() {
    simple.ajax.reload();
}

$(document).ready(function() {


    $(document).on("click", "#transferBtn", function() {
    var obj = $(this);
    let email = $("#email").val();
    let amount = $("#amount").val();
    let type = $('#transferBtn').attr('data-type');
    let otp = $("#otp").val();
    let w_request_id = $("#w_request_id").val();

    // Disable button and update text
    $("#transferBtn").html('Please wait...').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: "{{ route('user.walletTransfer') }}",
        data: {
            _token: '{{csrf_token()}}',
            email: email,
            amount: amount,
            type: 2,
            otp: otp,
            request_id: w_request_id
        },
        success: function(response) {
            if (response.status === 'success') {
                iziToast.success({
                    message: response.msg,
                    position: 'topRight'
                });
                $("#wallet_amount").html(response.wallet_amount);
                $("#withdraw_amount").html(response.withdraw_amount);
                reload_table();
                $("#walletTransferForm")[0].reset();
            } else {
                iziToast.error({
                    message: '' + response.msg,
                    position: 'topRight'
                });
            }
        },
        complete: function() {
            // Ensure to reset the button state on completion
            $("#transferBtn").html('Send Request').prop('disabled', false);
        },
        error: function() {
            // Handle any error in AJAX request
            iziToast.error({
                message: 'An error occurred while processing your request.',
                position: 'topRight'
            });
            // Re-enable the button and reset the text in case of failure
            $("#transferBtn").html('Send Request').prop('disabled', false);
        }
    });
});


    
});

function sendOtpBtn() {
    let amount = $("#amount").val();
    let type = $('#sendBtn').attr('data-type');

    // Disable the send OTP button and show sending text
    $("#sendBtn").attr('disabled', 'disabled').html('Sending...');

    $.ajax({
        type: 'POST',
        url: "{{ route('user.walletTransfer') }}",
        data: {
            _token: '{{csrf_token()}}',
            amount: amount,
            type: 1
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                iziToast.success({
                    message: response.msg,
                    position: 'topRight'
                });
                $('#w_request_id').val(response.data);
                $('#otp').removeAttr('disabled');
                $("#transferBtn").removeAttr('disabled').html('Send Request');
            } else {
                iziToast.error({
                    message: '' + response.msg,
                    position: 'topRight'
                });
            }
        },
        complete: function() {
            // Reset the OTP send button
            $("#sendBtn").removeAttr('disabled').html('Send');
        }
    });
}

</script>
@endsection
