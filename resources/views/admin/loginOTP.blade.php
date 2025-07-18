@extends('layouts.frontend')
@section('title', 'Admin Login OTP')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <h5 class="nk-block-title">Admin Login OTP</h5>
                        <!-- <div class="nk-block-des">

                        </div> -->
                    </div>
                </div><!-- .nk-block-head -->

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

                <form method="POST" action="{{ route('admin.login.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name"></label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="admin_login_otp"
                                id="admin_login_otp" placeholder="Enter OTP" value="{{ old('admin_login_otp') }}">
                        </div>
                        @if($errors->has('admin_login_otp'))
                        <div class="error">{{ $errors->first('admin_login_otp') }}</div>
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

                    <div class="mt-5"><a href="{{ route('logout') }}"><strong>Back To Admin Login</strong></a></div>
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
                                <h4><?=config('app.name', 'FinTradePool')?>
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
            url: "<?=route('resend.admin.login.otp')?>",
            method: 'POST',
            success: function(ajaxResp) {
                if (ajaxResp.success) {
                    showTimer();
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

    function showTimer() {
        var seconds = 1;
        var minutes = 1;

        var showTimer = setInterval(() => {

            if (minutes < 0) {
                $('.time').text('');
                $('#btnResendOTP').show();
                clearInterval(showTimer);
            } else {
                let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                $('.time').text(`Resend OTP after ${tempMinutes}:${tempSeconds}`);
            }

            if (seconds <= 0) {
                minutes--;
                seconds = 59;
            }

            seconds--;

        }, 1000);
    }

    $('#btnResendOTP').hide();
    showTimer();
</script>

<script>
    $(document).ready(function() {

    });
</script>


@endsection