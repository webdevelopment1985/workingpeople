@extends('templates.partials.main')
@section('title', $pageTitle)
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">
                                <?=$pageHeading?>
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
                                            <?=$pageHeading?>
                                        </h6>
                                        <center class="error">*** After raising a swap request, it may take up to 24
                                            hours to process. Thank you for your cooperation.</center>
                                    </div>
                                    <hr>
                                    <form class="form-element p-2" id="depositForm" name="depositForm">
                                        @csrf
                                        <input type="hidden" name="type" value="5">
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
                                                        <label class="form-label" for="amount">Amount</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="amount"
                                                                id="amount" value="" placeholder="0.00">
                                                            <small style="display:none;"
                                                                class="conversion-usd mt-1"><strong>Live
                                                                    Rate:-</strong>1 USD ~ <span
                                                                    id="livePrice">3.67</span> AED</small>
                                                        </div>
                                                        <span class="err"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter OTP</label>
                                                        <div class="form-control-wrap d-flex align-items-center">
                                                            <input type="text" class="form-control" name="otp" id="otp"
                                                                value="" placeholder="Enter Your OTP">
                                                            <button onClick="sendOtpBtn();" type="submit"
                                                                style="font-size: 0.8125rem;"
                                                                class="btn btn-gray h-100 ml-2 btn-lg"
                                                                id="sendBtn">Send</button>
                                                        </div>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3"
                                                        disabled="disabled" id="depBtn">Send
                                                        Request</button>
                                                </div>

                                            </div>
                                            <div class="col-md-5 offset-md-1">
                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Total Balance</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark">{{auth()->user()->getBalance('oldCoinBalance')}}
                                                            Ubit</span>
                                                    </div>
                                                </div>

                                                <div class="card badge-dim badge-gray mt-2">
                                                    <div
                                                        class="card-inner d-flex justify-content-between fw-bold  py-3">
                                                        <span class="w-40 text-dark">Fee</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark">1
                                                            USDT</span>
                                                    </div>
                                                </div>


                                                <!-- <div class="card badge-dim badge-gray mt-2">
                                                    <div
                                                        class="card-inner d-flex justify-content-between fw-bold  py-3">
                                                        <span class="w-40 text-dark">1 USC</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark"><?=$base_price?>
                                                Ubit</span>
                                            </div>
                                        </div> -->
                                                <!-- <div class="card badge-dim badge-gray mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold py-3">
                                                        <span class="w-40 text-dark">Fees</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark"><?//=$fee?>
                                                USDT</span>
                                            </div>
                                        </div> -->

                                                <div class="card badge-dim badge-gray mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold py-3">
                                                        <span class="w-40 text-dark">Ubit Receivable</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark" id="usdt_receivable"> 0
                                                        </span>Ubit
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
                                                <h6 class="title">Recent Transactions</h6>
                                            </div>
                                            <!--card-title-->
                                        </div>
                                        <!--card-title-group-->
                                    </div>
                                    <!--card-inner-->
                                    <div class="card-inner">
                                        <div class="">
                                            <table id="example1" class="datatable nowrap table"
                                                data-export-title="Export">
                                                <thead>
                                                    <tr>
                                                        <th>Receiving Address</th>
                                                        <th>USC</th>
                                                        <th>Ubit</th>
                                                        <th>Txn Fees</th>
                                                        <th>Txn Hash</th>
                                                        <th>Time</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
var simple;
$(document).ready(function() {
    simple = $('#example1').DataTable({
        createdRow: function(row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(1)')
                .addClass('leadclass');
            //$( row ).addClass('leadclass');
        },
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": "",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.show_flag = '2'
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


$("#depositForm").ajaxForm({
    beforeSubmit: function() {
        $("#depBtn").attr('disabled', 'disabled').html('Please wait...');
    },
    url: $("#depositForm").attr('action'),
    dataType: 'json',
    type: "POST",
    data: {
        _token: '{{csrf_token()}}'
    },
    success: function(data) {
        if (data.R) {
            iziToast.success({
                message: data.M,
                position: 'topRight'
            });
            reload_table();
            $("#depositForm")[0].reset();
        } else {
            iziToast.error({
                message: '' + data.M,
                position: 'topRight'
            });
        }
    },
    complete: function() {
        $("#depBtn").removeAttr('disabled').html('Send Request');

    }
});



function syncSwap(trans) {

    $.ajax({
        type: 'POST',
        beforeSend: function() {
            $(this).attr('disabled', 'disabled').html('Syncing...');
        },
        url: "{{ route('swap.sync') }}",
        data: {
            _token: '{{csrf_token()}}',
            trans: trans
        },
        dataType: 'json',
        success: function(data) {
            // $(this).removeAttr('disabled').html('Check Status');
            if (data.R) {
                iziToast.success({
                    message: data.M,
                    position: 'topRight'
                });
                reload_table();

            } else {
                iziToast.error({
                    message: '' + data.M,
                    position: 'topRight'
                });
            }
        }
    });
}

function sendOtpBtn() {
    let address = $("#address").val();
    let amount = $("#amount").val();
    $.ajax({
        type: 'POST',
        beforeSend: function() {
            $("#sendBtn").attr('disabled', 'disabled').html('Sending...');
        },
        url: "",
        data: {
            _token: '{{csrf_token()}}',
            address: address,
            amount: amount,
            type: 5
        },
        dataType: 'json',
        success: function(data) {
            $("#sendBtn").removeAttr('disabled').html('Send');
            if (data.R) {
                iziToast.success({
                    message: data.M,
                    position: 'topRight'
                });
                $("#depBtn").removeAttr('disabled').html('Send Request');
            } else {
                iziToast.error({
                    message: '' + data.M,
                    position: 'topRight'
                });
            }
        }
    });
}

function reload_table() {
    simple.ajax.reload();
}

$("#amount").on("keyup change", function(e) {
    let value = this.value;
    let converion = "1";
    let fee = "{{ $fee }}";
    value = value * converion - fee;
    console.log(value);
    $("#usdt_receivable").text(value);
})
$(function() {
    $('.conversion-usd').hide();
    $('#currency_id').change(function() {
        if ($('#currency_id').val() == '4') {
            $('.conversion-usd').show();
        } else {
            $('.conversion-usd').hide();
        }
    });
});
</script>
@endsection