@extends('templates.partials.main')
@section('title', 'Profile')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <!-- <div class="nk-block nk-block-lg"> -->
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="title nk-block-title">User Profile</h4>
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
                            <form method="POST" action="{{ url('/update-users') }}">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Full Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $user->name) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="email-address-1">Email address</label>
                                            <div class="form-control-wrap">
                                                <input class="form-control" type="email" name="emails"
                                                    value="{{ old('email', $user->email) }}" disabled>
                                                <input class="form-control" type="hidden" name="email"
                                                    value="{{ old('email', $user->email) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="phone-no-1">Phone No</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="mobile"
                                                    value="{{ old('mobile', $user->mobile) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="pay-amount-1">Amount</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="pay-amount-1">
                                                    </div>
                                                </div>
                                            </div> -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>
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