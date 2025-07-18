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

                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="card card-bordered mb-3">
                                <div class="card-inner-group">
                                    <div class="card-inner position-relative card-tools-toggle pb-3 pt-3">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">All Transactions</h6>
                                            </div>
                                            <!--card-title-->
                                        </div>
                                        <!--card-title-group-->
                                    </div>
                                    <!--card-inner-->
                                    <div class="card-inner">
                                        <div class="container my-4">
                                            <!-- Added container for padding and alignment -->
                                            <div class="mb-5">
                                                <form class="row g-2 align-items-end">
                                                    <div class="col-auto">
                                                        <div class="form-group">
                                                            <label class="overline-title overline-title-alt mb-2">Date
                                                                Range</label>
                                                            <div class="input-daterange date-picker-range input-group">
                                                                <input type="text" class="form-control" name="from_date"
                                                                    id="from_date" />
                                                                <div class="input-group-addon">TO</div>
                                                                <input type="text" class="form-control" name="to_date"
                                                                    id="to_date" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="type"
                                                                class="overline-title overline-title-alt mb-2">
                                                                Mode</label>
                                                            <select class="form-select js-select2" name="type"
                                                                id="type">
                                                                <option value="all">- Choose -</option>
                                                                <option value="credit">Credit</option>
                                                                <option value="debit">Debit</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="trans_type"
                                                                class="overline-title overline-title-alt mb-2">Type</label>
                                                            <select class="form-select js-select2" name="trans_type"
                                                                id="trans_type">
                                                                <?php
                                                                if($transaction_types){
                                                                    foreach($transaction_types as $key=>$value){?>
                                                                        <option value="<?=$key?>"><?=$value?></option>
                                                                    <?php 
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="status"
                                                                class="overline-title overline-title-alt mb-2">Status</label>
                                                            <select class="form-select js-select2" name="status"
                                                                id="status">
                                                                <option value="all">- Choose -</option>
                                                                <option value="0">Pending</option>
                                                                <option value="1">Completed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="txnId"
                                                                class="overline-title overline-title-alt mb-2">Transaction
                                                                ID</label>
                                                            <input type="text" class="form-control" id="txnId"
                                                                name="txnId" placeholder="TxnId">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" id=""
                                                                onClick="reload_table();">Search</button>
                                                        </div>
                                                    </div>
                                                    <!-- Optional search button -->
                                                </form>
                                            </div>

                                            <div class="table-responsive mt-4">
                                                <!-- Added table-responsive for better table handling on small screens -->
                                                <table id="transactionTable"
                                                    class="table table-bordered table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="nk-tb-col">Sr No</th>
                                                            <th class="nk-tb-col">Date</th>
                                                            <th class="nk-tb-col">Txn ID</th>
                                                            <th class="nk-tb-col">Mode</th>
                                                            <th class="nk-tb-col">Amount</th>
                                                            <th class="nk-tb-col">Type</th>
                                                            <th class="nk-tb-col">Narration</th>
                                                            <th class="nk-tb-col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="nk-tb-col">Sr No</th>
                                                            <th class="nk-tb-col">Date</th>
                                                            <th class="nk-tb-col">Txn ID</th>
                                                            <th class="nk-tb-col">Mode</th>
                                                            <th class="nk-tb-col">Amount</th>
                                                            <th class="nk-tb-col">Type</th>
                                                            <th class="nk-tb-col">Narration</th>
                                                            <th class="nk-tb-col">Status</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
    simple = $('#transactionTable').DataTable({
        createdRow: function(row, data, dataIndex) {

            $(row).find('td:eq(1)')
                .addClass('leadclass');
        },
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "ajax": {
            "url": "{{ route('user.getTransactions') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.from_date = $('#from_date').val(),
                    d.to_date = $('#to_date').val(),
                    d.type = $('#type').val(),
                    d.trans_type = $('#trans_type').val(),
                    d.status = $('#status').val(),
                    d.txnId = $('#txnId').val()
            }
        },
        "lengthMenu": [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        "pageLength": 25,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "dom": 'ftrip',
    });
});

function reload_table() {
    simple.ajax.reload();
}

$(function() {
    $('.conversion-usd').hide();
});



$(document).ready(function() {
    const $searchFilter = $("#searchFilter");
    $searchFilter.on("click", function() {
        reload_table();
    });
});


$(document).ready(function() {
    $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd', // Set your desired format
        autoclose: true, // Automatically close after selecting
        todayHighlight: true // Highlight today's date
    });
});
</script>
@endsection