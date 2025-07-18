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
                        <h5 class="nk-block-title">Register</h5>
                        <div class="nk-block-des">
                            <p>Create New
                                <?=config('app.name', 'FinTradePool')?>
                                Account
                            </p>
                        </div>
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


                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row g-4">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="name">Sponsor</label>
								<div class="form-control-wrap">
									<input type="text" class="form-control form-control-lg" name="sponsor" id="sponsor"
										placeholder="Sponsor" value="<?=old('sponsor')?old('sponsor'):$sponsor?>">
								</div>
								@if($errors->has('sponsor'))
								<div class="error">{{ $errors->first('sponsor') }}</div>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="name">Your Name</label>
								<div class="form-control-wrap">
									<input type="text" class="form-control form-control-lg" name="name" id="name"
										placeholder="Enter your name" value="{{ old('name') }}">
								</div>
								@if($errors->has('name'))
								<div class="error">{{ $errors->first('name') }}</div>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="email">Username</label>
								<div class="form-control-wrap">
									<input class="form-control form-control-lg" type="text" name="username" id="username"
										placeholder="Enter your username" value="{{ old('username') }}">
								</div>
								@if($errors->has('username'))
								<div class="error">{{ $errors->first('username') }}</div>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="email">Your Email</label>
								<div class="form-control-wrap">
									<input class="form-control form-control-lg" type="email" name="email" id="email"
										placeholder="Enter your email address" value="{{ old('email') }}">
								</div>
								@if($errors->has('email'))
								<div class="error">{{ $errors->first('email') }}</div>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="password">Password</label>
								<div class="form-control-wrap">
									<input type="password" class="form-control form-control-lg" name="password" id="password"
										placeholder="Enter your password">
								</div>

								@if($errors->has('password'))
								<div class="error">{{ $errors->first('password') }}</div>
								@endif

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="password">Confirm Password</label>
								<div class="form-control-wrap">
									<input type="password" class="form-control form-control-lg" name="password_confirmation"
										id="password_confirmation" placeholder="Enter Confirm Password">
								</div>
								@if($errors->has('password_confirmation'))
								<div class="error">{{ $errors->first('password_confirmation') }}</div>
								@endif
							</div>
						</div>
						<div class="col-md-12">
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

			  </div>
						<div class="col-md-12">
							 <div class="form-group">
								<div class="custom-control custom-control-xs custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="checkbox" name="checkbox">
									<label class="custom-control-label" for="checkbox">I agree to
										<?=config('app.name', 'FinTradePool')?>
										<a tabindex="-1" href="{{ route('Privacy') }}" target='blank'>Priv acy Policy</a> &amp; <a tabindex="-1"
											href="{{ route('terms') }}" target='blank'>
											Terms.</a></label>
								</div>

								@if($errors->has('checkbox'))
								<div class="error">{{ $errors->first('checkbox') }}</div>
								@endif

							</div>
						</div>
						<div class="col-12">
						   <div class="form-group">
								<button class="btn btn-lg btn-primary btn-block">Register</button>
							</div>
						</div>
					</div>
					

                    

                    

                    



                    
                    
                   
                 
                </form><!-- form -->
                <div class="form-note-s2 pt-4"> Already have an account ? <a href="{{ route('login') }}"><strong>Sign in
                            instead</strong></a>
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
                                <!-- <img class="round" src="http://localhost/new_apps/assets/images/slides/promo-a.png" srcset="http://localhost/new_apps/assets/images/slides/promo-a2x.png 2x" alt=""> -->
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4><?=config('app.name', 'FinTradePool')?>
                                </h4>
                                <p>.</p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                </div><!-- .slider-init -->
            </div><!-- .slider-wrap -->
        </div><!-- nk-split-content -->
    </div><!-- nk-split -->
</div>
@endsection