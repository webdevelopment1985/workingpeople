@php
//$setting = \App\Models\Setting::find(1);
$APP_ENV = env('APP_URL');
@endphp

<!DOCTYPE html>
<html dir="ltr" lang="{{ Session::get('locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin | @yield('page_title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="{{ Session::get('locale') }}">


    <!-- jQuery -->
    <script src="{{ asset($APP_ENV.'/assets/admin/js/jquery-3.2.1.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/font-awesome.min.css') }}">
    <!-- toastr CSS -->
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/toastr.min.css') }}">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/feathericon.min.css') }}">
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/plugins/morris/morris.css') }}">

    <!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap4.min.css" /> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}/"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($APP_ENV.'/assets/admin/css/custom.css') }}">

   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    
    @stack('css')


     <!-- DataTables and Buttons CSS -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- DataTables and Buttons JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> -->

</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                @yield('content')
            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    <!-- Bootstrap Core JS -->
    <script src="{{ asset($APP_ENV.'/assets/admin/js/popper.min.js') }}"></script>
    <script src="{{ asset($APP_ENV.'/assets/admin/js/bootstrap.min.js') }}"></script>

    <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/hacu5s8ld7b5xx9hdo1laufa5yvhr6s48c38wigwc3gfarik/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset($APP_ENV.'/assets/admin/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset($APP_ENV.'/assets/admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset($APP_ENV.'/assets/admin/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset($APP_ENV.'/assets/admin/js/chart.morris.js') }}"></script>

    <!-- toastr JS -->
    <script src="{{ asset($APP_ENV.'/assets/admin/js/toastr.min.js') }}"></script>
    <?php /* {!! Toastr::message() !!} */ ?>


    <!-- Custom JS -->
    <script src="{{ asset($APP_ENV.'/assets/admin/js/script.js') }}"></script>
    <script src="{{ asset($APP_ENV.'/assets/admin/js/feather.min.js') }}"></script>
    <!-- <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script> -->

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>

    <script>
        feather.replace()
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').select2();
        });
    </script>


    @stack('scripts')

</body>

</html>