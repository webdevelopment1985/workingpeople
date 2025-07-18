<!doctype html>
<html class="no-js" lang="zxx">

 <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        @yield('title') |
        <?=config('app.name', 'FinTradePool')?>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/images/logo/favicon.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/main.css') }}">

    <!-- Google Analytics -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-91615293-4');
    </script>
</head>


    <!-- Page content here -->

    <!-- Scripts -->
   

    @yield('content')
    <script src="{{ url('/assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ url('/assets/js/vendor/waypoints.js') }}"></script>
    <script src="{{ url('/assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ url('/assets/js/meanmenu.js') }}"></script>
    <script src="{{ url('/assets/js/swiper-bundle.js') }}"></script>
    <script src="{{ url('/assets/js/slick.js') }}"></script>
    <script src="{{ url('/assets/js/jquery-appear.js') }}"></script>
    <script src="{{ url('/assets/js/jquery-knob.js') }}"></script>
    <script src="{{ url('/assets/js/magnific-popup.js') }}"></script>
    <script src="{{ url('/assets/js/nice-select.js') }}"></script>
    <script src="{{ url('/assets/js/purecounter.js') }}"></script>
    <script src="{{ url('/assets/js/countdown.js') }}"></script>
    <script src="{{ url('/assets/js/wow.js') }}"></script>
    <script src="{{ url('/assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ url('/assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ url('/assets/js/ajax-form.js') }}"></script>
    <script src="{{ url('/assets/js/main.js') }}"></script>

    <script>
		document.querySelectorAll('#togglePassword, #togglePasswordSlash').forEach(icon => {
    icon.addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const isPassword = passwordInput.type === 'password';

        // Toggle input type
        passwordInput.type = isPassword ? 'text' : 'password';

        // Toggle icons
        document.getElementById('togglePassword').style.display = isPassword ? 'none' : 'inline';
        document.getElementById('togglePasswordSlash').style.display = isPassword ? 'inline' : 'none';
    });
});
	  
$(document).ready(function () {
    $('#contact-form11').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting normally
        var submitButton = $('button[type="submit"]');
       
        var formData = {
            name: $('input[name="name"]').val(),
            email: $('input[name="email"]').val(),
            message: $('textarea[name="message"]').val(),
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        };

        // Show confirmation alert
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to send this email?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, send it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
               submitButton.text('Submitting...').prop('disabled', true);
                // If the user confirms, send the email
                $.ajax({
                    url: '{{ route('send.email') }}', // Use the correct route URL for your email sending
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                           submitButton.text('SUBMIT').prop('disabled', false);
                            // Show success alert
                            Swal.fire({
                                title: 'Success!',
                                text: response.success,
                                icon: 'success',
                                confirmButtonText: 'OK',
                              }).then(() => {
                                // Clear the form fields after success
                                $('#contact-form11')[0].reset(); // Reset the form fields
                            });
                        } else {
                           submitButton.text('SUBMIT').prop('disabled', false);
                            console.log(response);
                        }
                    },
                    error: function (xhr, status, error) {
                     submitButton.text('SUBMIT').prop('disabled', false);
                        // Show error alert
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            }
        });
    });
});

</script>


    </body>
    </html>