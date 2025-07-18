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
                                    <form class="form-element p-2" id="buyPackageForm" name="buyPackageForm">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="fancy-border">

                                                    <div class="form-group">
                                                        <label class="form-label" for="amount">Enter Amount</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="amount"
                                                                id="amount" value="" placeholder="$ 0.00">
                                                            <small style="display:none;"
                                                                class="conversion-usd mt-1"></small>
                                                        </div>
                                                        <span class="err"></span>
                                                    </div>

                                                    <button type="button" class="btn btn-primary mt-3"
                                                        id="depBtn">Submit</button>
                                                </div>

                                            </div>
                                            <div class="col-md-5 offset-md-1">

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Your Current Balance</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark"
                                                            id="wallet_amount">{{ $wallet_amount }}</span>
                                                    </div>
                                                </div>

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Min Investment</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark">{{ $package_min_amount }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Max Investment</span>
                                                        <span>=</span>
                                                        <span class="w-40 text-right text-dark">No limit </span>
                                                    </div>
                                                </div>


                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Monthly Return (%)</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark">{{ $package_monthly_return }}
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="card badge-dim badge-info mt-1">
                                                    <div class="card-inner d-flex justify-content-between fw-bold h6">
                                                        <span class="w-40 text-dark">Lock-In period</span>
                                                        <span>=</span>
                                                        <span
                                                            class="w-40 text-right text-dark">{{ $package_lock_in_period }}
                                                            months </span>
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

                                            <table id="example1" class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>
                                                        <th class="nk-tb-col">Date</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Narration</th>
                                                        <th class="nk-tb-col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="nk-tb-col">SrNo</th>
                                                        <th class="nk-tb-col">Date</th>
                                                        <th class="nk-tb-col">Amount($)</th>
                                                        <th class="nk-tb-col">Narration</th>
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
    simple = $('#example1').DataTable({
        createdRow: function(row, data, dataIndex) {
            $(row).find('td:eq(1)')
                .addClass('leadclass');
        },
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": "{{ route('buy.getPurchase') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.type = 'purchase'
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


$("body").on("click", "#depBtn", function() {
    var current_object = $(this);
    if (parseFloat($('#amount').val()) <= 0) {
        iziToast.error({
            message: 'Please enter valid amount',
            position: 'topRight'
        });
        return;
    }
    Swal.fire({
        title: `Are you sure ?`,
        text: `Are you sure to invest this amount of ${$('#amount').val()} USDT ?`,
        showCancelButton: true,
        confirmButtonText: 'Yes, confirmed!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                beforeSubmit: function() {
                    $("#depBtn").attr('disabled', 'disabled').html('Please wait...');
                },
                url: $("#buyPackageForm").attr('action'),
                type: 'POST',
                data: $('#buyPackageForm').serialize(),
                success: function(response) {
                    if (response.R) {
                        iziToast.success({
                            message: response.M,
                            position: 'topRight'
                        });
                        if ('data' in response && 'wallet_amount' in response.data) {
                            $("#wallet_amount").html(response.data.wallet_amount);
                        }
                        reload_table();
                        $("#buyPackageForm")[0].reset();
                    } else {
                        iziToast.error({
                            message: '' + response.M,
                            position: 'topRight'
                        });
                    }
                },
                complete: function() {
                    $("#depBtn").removeAttr('disabled').html('Submit');
                }
            });
        }
    });
});

function reload_table() {
    simple.ajax.reload();
}

$(function() {
    $('.conversion-usd').hide();
});
</script>
@endsection