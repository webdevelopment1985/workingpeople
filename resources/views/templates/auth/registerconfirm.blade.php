@extends('layouts.frontend')
@section('title', 'Register')
@section('content')
<div class="nk-content ">
    <div class="nk-split nk-split-page nk-split-md">
        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white w-lg-45">

            <div class="nk-block nk-block-middle nk-auth-body">
                <div class="brand-logo pb-5">
                    <a href="{{url('/')}}" class="logo-link">

                        <img class="logo-dark logo-img logo-img-lg" src="{{url('/assets/images/logo-dark.png')}} "
                            srcset="{{url('/assets/images/logo-dark2x.png')}} 2x" alt="logo-dark">
                    </a>
                </div>
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Confirm Your Registration</h5>
                        <!-- <div class="nk-block-des">

                        </div> -->
                    </div>
                </div><!-- .nk-block-head -->

                @if( isset($email) )
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    Please verify your account : {{$email}} before login
                </div>
                @endif

                @if( Session::has("success") )
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get("success") }}
                </div>
                @endif




                @if( Session::has("error") )
                <div class="alert alert-danger alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get("error") }}
                </div>
                @endif

                <p id="message_error" class="text-danger mb-0"></p>

                <p id="message_success" class="text-success mb-0"></p>

                <form method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name"></label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control form-control-lg" name="confirm_otp"
                                id="confirm_otp" placeholder="Enter OTP " value="{{ old('confirm_otp') }}">
                        </div>
                        @if($errors->has('confirm_otp'))
                        <div class="error">{{ $errors->first('confirm_otp') }}</div>
                        @endif
                    </div>



                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Confirm</button>
                    </div>
                </form><!-- form -->
                <div class="form-note-s2 pt-4">
                    Didn't received OTP ? <strong>
                        <a href="javascript:void(0);" onclick="resendOTP(); return false" id="btnResendOTP">Resend
                            OTP</a></strong>

                    <strong class="time text-success"></strong>

                    <div class="mt-5"><a href="{{ route('logout') }}"><strong>Back To Login</strong></a></div>
                </div>
            </div><!-- .nk-block -->

        </div><!-- nk-split-content -->
        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right"
            data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                <div class="slider-init">
                    <div class="slider-item">
                        <div class="nk-feature nk-feature-center">
                            <div class="nk-feature-img">
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4><?= config('app.name', 'WorkingPeoples') ?>
                                </h4>
                                <p></p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                </div><!-- .slider-init -->
            </div><!-- .slider-wrap -->
        </div><!-- nk-split-content -->
    </div><!-- nk-split -->
</div>
<script>
    function resendOTP() {
        $.ajax({
            url: "<?= route('resend.confirm.otp') ?>",
            method: 'POST',
            success: function(ajaxResp) {
                if (ajaxResp.success) {
                    timer();
                    $('#btnResendOTP').hide();
                    $('#message_success').text(ajaxResp.message);
                    setTimeout(() => {
                        $('#message_success').text('');
                    }, 10000);
                } else {
                    $('#message_error').text(ajaxResp.message);
                    setTimeout(() => {
                        $('#message_error').text('');
                    }, 5000);
                }
            },
            error: function(error) {}
        });
    }

    function timer() {
        var seconds = 5;
        var minutes = 1;

        var timer = setInterval(() => {

            if (minutes < 0) {
                $('.time').text('');
                $('#btnResendOTP').show();
                clearInterval(timer);
            } else {
                let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                $('.time').text(tempMinutes + ':' + tempSeconds);
            }

            if (seconds <= 0) {
                minutes--;
                seconds = 59;
            }

            seconds--;

        }, 1000);
    }

    timer();
</script>
@endsection