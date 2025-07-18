<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{url('/assets/images/favicon.png')}}">
    <!-- Page Title  -->
    <title>
        @yield('title') |
        <?=config('app.name', 'FinTradePool')?>
    </title>
    <!-- StyleSheets  -->  
   



    <link rel="stylesheet" href="{{ url('/assets/css/dashlite.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/theme.css') }}">
    <!-- <link rel="stylesheet" href="http://localhost/new_apps/assets/css/dashlite.css">
    <link rel="stylesheet" href="http://localhost/new_apps/assets/css/theme.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>



    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-91615293-4');
    </script>
    </script>
    </script>



    <link rel="stylesheet" href="{{ url('/assets/css/libs/fontawesome-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/libs/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/libs/bootstrap-icons.css') }}">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">




                @yield('content')
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <!-- JavaScript -->
   

    <script src="{{ url('/assets/js/bundle.js?ver=2.9.1') }}"></script>
    <script src="{{ url('/assets/js/scripts.js?ver=2.9.1') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</html>