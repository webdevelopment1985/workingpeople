@extends('templates.partials.main')
@section('title', 'Change Password')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <!-- <div class="nk-block nk-block-lg"> -->
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="title nk-block-title">Change Password</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Old Passwod</label>
                                            <div class="form-control-wrap">
                                                <input class="form-control" type="password" name="current_password"
                                                    required>
                                            </div>
                                            <!-- @error('current_password')
                                                    <span>{{ $message }}</span>
                                                @enderror -->
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <div class="form-control-wrap">
                                                <input class="form-control" type="password" name="new_password"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Confirm New Password</label>
                                            <div class="form-control-wrap">
                                                <input class="form-control" type="password"
                                                    name="new_password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Change
                                                Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div><!-- .components-preview -->
        </div>
        <!-- </div> -->
    </div>
</div>
@endsection