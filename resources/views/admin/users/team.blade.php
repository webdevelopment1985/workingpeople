@extends('admin.layouts.master')

@section('page_title')
{{ __('User Details') }}
@endsection

@section('content')

<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">

            <div class="col-md-4">
                <h3 class="page-title">{{__('User Team')}} - {{ $userInfo->username }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        {{ __('User Team') }}
                    </li>
                </ul>
            </div>

            <div class="col-md-8">
                <div class="d-flex align-items-end txnfilter">
                    <div class="form-control-wrap">
                        <select name="level_no" id="level_no" class="form-control">
                        <option value=""> -All -</option>
                        <?php
                        foreach($groupedUsers as $levelCount): ?>
                            <option value="<?php echo $levelCount['level']?>">Level <?php echo $levelCount['level']?> (<?php echo $levelCount['user_count']?>)</option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    
                    <div class="form-control-wrap">
                        <button type="button" onclick="reload_table();" class="btn btn-primary ml-2">Search</button>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="widget-container fluid-height">
                    <div class="heading tabs">
                        <ul class="nav nav-tabs nav-tabs-solid" data-tabs="tabs" id="tabs">
                            @include('admin.users.user_info_tabs', ['userId'=>$userInfo->id])
                        </ul>
                    </div>

                    <div class="tab-content padded" id="my-tab-content">
                        <div class="tab-pane active" id="tab1">
                            <!-- <h3> Team </h3> -->
                            <table class="table table-hover table-center mb-0" id="teams">
                                <thead>
                                    <tr>
                                    <th class="">{{ __('default.table.sl') }}</th>
                                    <th class="">{{ __('Level') }}</th>
                                    <th class="">{{ __('Username') }}</th>
                                    <th class="">{{ __('Total Deposit') }} (+)</th>
                                    <th class="">{{ __('Total Received') }} (+)</th>
                                    <th class="">{{ __('Total Sent') }} (-)</th>
                                    <th class="">{{ __('Total Invest') }} (-)</th>
                                    <th class="">{{ __('Roi Income') }} (+)</th>
                                    <th class="">{{ __('Level Income') }} (+)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
var simple;
$(function() {
    
    simple = $('#teams').DataTable({
    "processing": true,
    "serverSide": true,
    "searching": false,
    "responsive": true,
    columnDefs: [
        { targets: [0,1,3,4,5,6,7,8], orderable: false },
    ],
    "ajax": {
        "url": "{{ route('users.team',$userId) }}",
        "type": "POST",
        "data": function(d) {
            d._token = '{{ csrf_token() }}',
            d.level_no = $('#level_no').val()
        }
    },
    "lengthMenu": [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    "pageLength": 10,
    dom: 'lBfrtip',
    buttons: [
        'csv', 'excel', 'pdf',
    ],
});



});

function reload_table() {
    simple.draw();
}

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


$('.reload_table').on('click keyup change', function(event) {
    reload_table();
});

    

</script>
@endpush