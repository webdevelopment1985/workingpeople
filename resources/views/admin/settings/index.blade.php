@extends('admin.layouts.master')

@section('page_title')
{{ __('setting.index.title') }}
@endsection

@push('css')
<style>
    .table tr td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('setting.index.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('settings.index') }}">{{ __('setting.index.title') }}</a>
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-3">
                    <div class="create-btn pull-right">
                        <a href="{{ route('settings.create') }}" class="btn custom-create-btn">Create Settings</a>
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
                            <th class="">{{ __('default.table.sl') }}</th>
                            <th class="">Name</th>
                            <th class="">Value</th>
                            <!-- <th class="">{{ __('default.table.meta_key') }}</th>
                            <th class="">{{ __('default.table.meta_value') }}</th> -->
                            <!-- <th class="">{{ __('default.table.status') }}</th> -->
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
                <h5 class="modal-title" id="viewTitle">Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" name="value" class="form-control" id ="value" />
                <input type="hidden" name="id" class="form-control" id ="id" />
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" id="updatesettings" class="btn btn-primary">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    function editSettings(id,val){
        $("#id").val(id);
        $("#value").val(val);
        $("#viewBalancePopup").modal('show');
    }
</script>
<script type="text/javascript">
    $(document).on('click',"#updatesettings", function(e) {
        e.preventDefault();
        let _token = $('meta[name="csrf-token"]').attr('content');
        var id =  $("#id").val();
        var val =  $("#value").val();
        console.log(val);
        $('#updatesettings').html('Processing...').prop('disabled', true);
        $.ajax({
            url: `{{ route('settings.update') }}`,
            type: 'POST',
            data: {
                _token: _token,
                id: id,
                val: val
            },
            success: function(response) {
                console.log();
                // alert('Settings update successfully!');
                if(response.status == true){
                    $('#updatesettings').html('Save').prop('disabled', false);
                    $("#viewBalancePopup").modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                
            }
        });
    });
</script>  
<script>
    $(function() {
        $('#table').DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            order: [
                [0, 'desc']
            ],
            ajax: "{{ route('settings.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'meta_key',
                    name: 'meta_key'
                },
                {
                    data: 'meta_value',
                    name: 'meta_value'
                },
                // { data: 'status',  name: 'status'  },      
                { data: 'action', name: 'action', orderable: false, searchable: false}                 
            ],
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
    function changeSettingStatus(_this, id) {
        var status = $(_this).prop('checked') == true ? 1 : 0;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `{{ route('settings.status_update') }}`,
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
</script>
@endpush