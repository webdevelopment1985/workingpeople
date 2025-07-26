@extends('layouts.frontend')
@section('title', 'Forgot Password')
@section('content')
<div class="nk-content ">
    <div class="nk-split nk-split-page loginRow nk-split-md">
        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white w-lg-45">

            <div class="nk-block nk-block-middle nk-auth-body">
                <div class="brand-logo pb-5">
                    <a href="{{url('/')}}" class="logo-link">

                        <img class="logo-dark logo-img logo-img-lg" src="{{url('/assets/images/workingpeople-logo.svg')}} "
                            srcset="{{url('/assets/images/workingpeople-logo.svg')}} 2x" alt="logo-dark 1">
                    </a>
                </div>
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Reset password</h5>
                        <div class="nk-block-des">
                            <p>If you forgot your password, then we’ll email you instructions to reset your
                                password.</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->

                @if( Session::has("message") )
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get("message") }}
                </div>
                @endif

                <form action="{{ route('forget.password.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" id="default-01"
                                placeholder="Enter your email address" name="email">
                        </div>
                        @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                        @endif

                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Send Reset Link</button>
                    </div>
                </form><!-- form -->
                <div class="form-note-s2 pt-5">
                    <a href="{{route('login')}}"><strong>Return to login</strong></a>
                </div>
            </div><!-- .nk-block -->
            <div class="nk-block nk-auth-footer">
                <div class="nk-block-between">
                    <ul class="nav nav-sm">
                        <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Terms & Condition</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Privacy Policy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li> -->
                    </ul><!-- .nav -->
                </div>

            </div><!-- .nk-block -->
        </div><!-- .nk-split-content -->
        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right"
            data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
            <div class="w-100 w-max-550px p-3 p-sm-5 m-auto">
                <div class="nk-feature nk-feature-center">
                    <div class="nk-feature-img">
                        <img class="round" src="./images/slides/promo-a.png" srcset="./images/slides/promo-a2x.png 2x"
                            alt="">
                    </div>
                    <div class="nk-feature-content py-4 p-sm-5">
                        <h4><?=config('app.name', 'Sri Swap')?>
                        </h4>
                        <p></p>
                    </div>
                </div>
            </div>
        </div><!-- .nk-split-content -->
    </div><!-- .nk-split -->
</div>
@endsection