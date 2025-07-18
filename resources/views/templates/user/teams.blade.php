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
                                                <h6 class="title">My Team</h6>
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
															<label class="overline-title overline-title-alt mb-2">Username</label>    
															<div class="input-group">            
																<input type="text" placeholder="Enter Username" id= "username" name= "username" class="form-control" />            
															</div>
														</div>
													</div>
												
													
                                                    <div class="col">
														<div class="form-group">
															<label for="trans_type" class="overline-title overline-title-alt mb-2">Level</label>
															<select class="form-select js-select2" name="trans_type" id="trans_type">
																
                                                            <?php foreach($groupedUsers as $levelCount): ?>
                                                                <option value="<?php echo $levelCount['level']?>">Level <?php echo $levelCount['level']?> (<?php echo $levelCount['user_count']?>)</option>
															<?php endforeach;?>
															
                                                        </select>
														</div>
													</div>
													<div class="col">
														<div class="form-group">
															<label for="status" class="overline-title overline-title-alt mb-2">User Type</label>
															<select class="form-select js-select2" name="paid_status" id="paid_status">
																<option value="all">All</option>
                                                                <option value="1">IB</option>
																<option value="0">User</option>
															</select>
														</div>
													</div>
												
													<div class="col">
														<div class="form-group">
															<button type="button" class="btn btn-primary" id="searchFilter" onclick="reload_table()">Search</button>
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
                                                            <th class="nk-tb-col">Username</th>
                                                            <th class="nk-tb-col">Email</th>
                                                            <th class="nk-tb-col">Name</th>
                                                            <th class="nk-tb-col">Total Investment</th>
                                                            <th class="nk-tb-col">Level Commission</th>
                                                            <th class="nk-tb-col">Total Deposit</th>
                                                            <th class="nk-tb-col">Joined On</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data rows will be populated here -->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                        <th class="nk-tb-col">Sr No</th>
                                                            <th class="nk-tb-col">Username</th>
                                                            <th class="nk-tb-col">Email</th>
                                                            <th class="nk-tb-col">Name</th>
                                                            <th class="nk-tb-col">Total Investment</th>
                                                            <th class="nk-tb-col">Level Commission</th>
                                                            <th class="nk-tb-col">Total Deposit</th>
                                                            <th class="nk-tb-col">Joined On</th>
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
        columnDefs: [
            { targets: [0, 4, 5], orderable: false },  // Disable sorting for the first (0) and fourth (3) columns
        ],
        "ajax": {
            "url": "{{ route('user.getTeams') }}",
            "type": "POST",
            "data": function(d) {
                d._token = '{{csrf_token()}}',
                    d.username = $('#username').val(),
                    d.trans_type = $('#trans_type').val(),
                    d.status = $('#paid_status').val()
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

function reload_table() {
    simple.ajax.reload();
}


function getTotalInvestment(obj,userId) {
    $.ajax({
        url: '/total-investment',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Ensure this token is being properly rendered by Blade
            user_id: userId
        },
        success: function(response) {
            // Assuming you have an element to display the result
            $(obj).text(response.total_investment);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function getTotalDeposit(obj,userId) {
    $.ajax({
        url: "{{ url('/total-deposit') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Ensure this token is being properly rendered by Blade
            user_id: userId
        },
        success: function(response) {
            // Assuming you have an element to display the result
            $(obj).text(response.total_investment);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function getTotalLevelIncome(obj,userId) {
    $.ajax({
        url: '/total-level-income',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Ensure this token is being properly rendered by Blade
            user_id: userId
        },
        success: function(response) {
            // Assuming you have an element to display the result
            $(obj).text(response.total_income);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

</script>
@endsection