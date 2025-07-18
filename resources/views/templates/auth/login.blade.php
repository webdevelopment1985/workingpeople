@extends('layouts.frontend')
@section('title', 'Login')
@section('content')
<div class="nk-content ">
    <div class="nk-split nk-split-page nk-split-md">
        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">

            <div class="nk-block nk-block-middle nk-auth-body">
                <div class="brand-logo pb-5">
                    <a href="{{url('/')}}" class="logo-link">

                        <img class="logo-dark logo-img logo-img-lg" src="{{url('/assets/images/logo-dark.png')}} "
                            srcset="{{url('/assets/images/logo-dark.png')}}" alt="logo-dark">
                    </a>
                </div>
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Sign-In</h5>
                        <div class="nk-block-des">
                            <p>Fill the details below to Access the
                                <?=config('app.name', 'Sri Swap')?>
                                Account.
                            </p>
                        </div>
                    </div>
                </div>

                @if( Session::has("message") )
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get("message") }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="email-address">Username</label>
                            <!-- <a class="link link-primary link-sm" tabindex="-1" href="#">Need Help?</a> -->
                        </div>
                        <div class="form-control-wrap">
                            <input autocomplete="off" type="text" name="email" id="email"
                                class="form-control form-control-lg" id="email-address"
                                placeholder="Enter username or email">
                        </div>

                        @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                        @endif

                    </div><!-- .form-group -->
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                            <a class="link link-primary link-sm" tabindex="-1"
                                href="{{ route('forget-password') }}">Forgot Password ?</a>
                        </div>
                        <div class="form-control-wrap">
                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg"
                                data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input autocomplete="new-password" type="password" name="password" id="password"
                                class="form-control form-control-lg" placeholder="Enter your password">
                        </div>
                    </div><!-- .form-group -->
                    
						<div class="form-group">
                <label for="capatcha">Captcha</label>
                <div class="captcha">
                  <span>{!! app('captcha')->display() !!}</span>
                  <!-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> -->
                </div>
               
                @error('g-recaptcha-response')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                    </div>
                </form><!-- form -->
                <div class="form-note-s2 pt-4"> New on our platform? <a href="{{ route('register') }}">Create an
                        account</a>
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
                            </li> -->
                        <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li> -->
                    </ul><!-- .nav -->
                </div>

            </div><!-- .nk-block -->
        </div><!-- .nk-split-content -->
        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right"
            data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                <div class="slider-init">
                    <div class="slider-item">
                        <div class="nk-feature nk-feature-center">
                            <div class="nk-feature-img">
                                <!-- <img class="round" src="http://localhost/new_apps/assets/images/slides/promo-a.png" srcset="http://localhost/new_apps/assets/images/slides/promo-a2x.png 2x" alt=""> -->
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4><?=config('app.name', 'Sri Swap')?>
                                </h4>
                                <p></p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                </div><!-- .slider-init -->
            </div><!-- .slider-wrap -->
        </div><!-- .nk-split-content -->
    </div><!-- .nk-split -->
</div>
@endsection