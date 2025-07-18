@php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
@endphp
<div class="nk-header nk-header-fixed is-dark">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
           

                <a href="javascript:void(0);" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                        class="icon ni ni-menu"></em></a>
            </div>

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-name dropdown-indicator">{{@$user->name}}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{@$user->name}}</span>
                                        <span class="sub-text">{{@$user->email}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{route('users.edit')}}"><em
                                                class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="{{route('password.change')}}"><em
                                                class="icon ni ni-setting-alt"></em><span>Account Setting</span></a>
                                    </li>
                                    @if (session()->has('impersonate'))
                                        </li>
                                            <a href="{{ route('admin.impersonate.leave') }}"><em
                                            class="icon ni ni-signin"></em>
                                                Back to Admin
                                            </a>
                                        </li>
                                    @endif
                                    <li><a href="{{route('logout')}}"><em
                                                class="icon ni ni-signout"></em><span>Logout</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>