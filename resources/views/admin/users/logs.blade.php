@extends('admin.layouts.master')

@section('page_title')
    Logs
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">Users Logs</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        Users Logs
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-3">
                    <div class="create-btn pull-right">
                        <a href="{{ route('deposits.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button') }}</a>
                    </div>                 
                </div> -->
        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <table class="table table-hover table-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="">{{ __('deposit.table.sl') }}</th>
                            <th class="">{{ __('IP') }}</th>
                            <th class="">{{ __('Browser') }}</th>
                            <th class="">{{ __('Narrations') }}</th>
                            <th class="">{{ __('Type') }}</th>
                            <th class="">{{ __('Created On') }}</th>
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
            "lengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            ajax: {
                "url": "{{ route('users.logs') }}",
                "data": function(d) {
                    // d.subtype = $("#subtype").val();
                    // d.status = $("#status").val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false                 

                },
                {
                    data: 'ip',
                    name: 'ip',
                }, 
                {
                    data: 'agent',
                    name: 'agent',
                },
                {
                    data: 'naration',
                    name: 'naration'
                },
                {
                    data: 'type',
                    name: 'type',
                    
                },
                {
                    data: 'updated',
                    name: 'updated',
                    
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf',
            ],
            columnDefs: [
                {
                    targets: 2,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass('word-wrap');
                    }
                }
            ],
        });
    });

    function reload_table() {
        simple.draw();
    }
</script>
@endpush