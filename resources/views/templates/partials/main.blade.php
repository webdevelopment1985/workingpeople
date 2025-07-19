<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="workingpeoples">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{url('/assets/images/favicon.png')}}">
    <!-- Page Title  -->
    <title>
        @yield('title') |
        <?= config('app.name', 'workingpeoples') ?>
    </title>

    <!-- StyleSheets  -->

    <link rel="stylesheet" href="{{url('/assets/css/dashlite.css')}}">
    <link id="skin-default" rel="stylesheet" href="{{url('/assets/css/theme.css')}}">

    <link rel="stylesheet" href="{{ url('/assets/css/libs/fontawesome-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/libs/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/libs/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    @yield('include_javascript')

    @yield('include_stylesheet')

    <script>
        function copytext(id) {
            var clipboard = new Clipboard('#' + id);
            clipboard.on('success', function(e) {
                e.clearSelection();
                $('#' + id).text('Copied');
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>

</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @if (!Request::routeIs('register') && !Request::routeIs('login'))
            @include('templates/partials/sidebar')
            @endif
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                @if (!Request::routeIs('register') && !Request::routeIs('login'))
                @include('templates/partials/header')
                @endif
                <!-- main header @e -->
                <!-- content @s -->
                @yield('content')
                <!-- content @e -->
                <!-- footer @s -->
                @if (!Request::routeIs('register') && !Request::routeIs('login'))
                @include('templates/partials/footer')
                @endif
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ url('/assets/js/bundle.js?ver=2.9.1') }}"></script>
    <script src="{{ url('/assets/js/scripts.js?ver=2.9.1') }}"></script>
    <script src="{{ url('/assets/js/libs/datatable-btns.js?ver=2.9.1') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        function disabledBtn() {
            iziToast.error({
                message: 'Temporarily Disabled Kindly Try After Sometime!!!',
                position: 'topRight'
            });
        }
    </script>

    @if(session('success'))
    <script>
        iziToast.success({
            message: '{{ session('
            success ') }}',
            position: 'topRight'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        iziToast.error({
            message: '{{ session('
            error ') }}',
            position: 'topRight'
        });
    </script>
    @endif

    <style>
        .disabledBtn {
            color: red;
            font-size: 11px;
        }
    </style>
</body>

</html>