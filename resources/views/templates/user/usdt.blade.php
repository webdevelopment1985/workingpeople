@extends('templates.partials.main')
@section('title', 'Deposit USDT')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Deposit USDT</h3>
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
                                    <?php
                
                                    if(isset($deposit_address)) {?>
                                    <div class="">
                                        <center>
                                            <div class="mb-4 mt-3">
                                                <div class="mb-3"><img width="150"
                                                        src="<?=getQRCodeUrl($deposit_address)?>">
                                                </div>
                                                <h5 class="title" id="address_input">
                                                    <?php echo $deposit_address?>
                                                </h5>
                                                <p>Note: This address is USDT(BEP20) Address</p>
                                                <a class="btn btn-success mt-0" data-clipboard-target="#address_input"
                                                    href="javascript:void(0)" onclick="copytext('BTC_copy')"
                                                    id="BTC_copy"><em class="icon ni ni-copy mr-1"
                                                        style="font-size: 1.1em;"></em> Copy </a><br>
                                            </div>


                                            <form class='form-element' name='depositForm' id="depositForm">
                                                <div
                                                    class="alert alert-danger alert-icon alert-dismissible d-flex flex-wrap justify-content-between align-items-center px-4 py-2 btnalert">
                                                    <p class="mb-0"><strong>Note:-</strong> Scan above QR code to
                                                        transfer funds to your {{env('PROJECT_NAME')}} wallet and sync
                                                        request.</p> <button type="button" class="btn btn-primary"
                                                        id="depBtn" onclick="syncTransaction(1);">Sync Request</button>
                                                </div>
                                            </form>

                                        </center>
                                    </div>
                                    <?php
                                    }
                                    
                                    
									?>

                                </div>
                            </div>
                        </div>
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

                                            <table id="usdtDeposit" class="datatable nowrap table"
                                                data-export-title="Export">
                                                <thead>
                                                    <tr>
                                                        <th>SrNo</th>
                                                        <th>DateTime</th>
                                                        <th>Txn ID</th>
                                                        <th>Amount</th>
                                                        <th>Hash</th>
                                                        <th>Narration</th>
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


<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>

<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
<script>
var simple;
$(document).ready(function() {
    simple = $('#usdtDeposit').DataTable({
        serverSide: true,
        processing: true,
        "ajax": {
            "url": "{{ route('deposit.records') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.method = 'bep20'
            }
        },
    });
});

$("#depositForm").ajaxForm({
    beforeSend: function() {
        $("#depBtn").attr('disabled', 'disabled').html('Please wait...');
    },
    url: $("#depositForm").attr('action'),
    dataType: 'json',
    type: "POST",
    data: {
        _token: '{{csrf_token()}}'
    },
    success: function(data) {
        $("#depBtn").removeAttr('disabled').html('Sync Request');
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
        $("#depBtn").removeAttr('disabled').html('Sync Request');

    }
});



function syncTransaction(type){
    $.ajax({
        beforeSend: function() {
            if(type){
                $("#depBtn").attr('disabled', 'disabled').html('Please wait...');
            }            
        },
        url: $("#depositForm").attr('action'),
        dataType: 'json',
        type: "POST",
        data: {
            _token: '{{csrf_token()}}'
        },
        success: function(data) {
            if(type){
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
            }            
        },
        complete: function() {
            if(type){
                $("#depBtn").removeAttr('disabled').html('Sync Request');
            }
        }
    });
}

function reload_table() {
    simple.ajax.reload();
}


// Function to enable right-click inside the specific text box
function enableRightClick(event) {
    event.stopPropagation();
}

$(window).on('load', function() {
    autoSyncTransactions();
});

setInterval(function() {
    autoSyncTransactions();
}, 10000);

function autoSyncTransactions(){
    syncTransaction(0);
    reload_table();
}

</script>

@endsection