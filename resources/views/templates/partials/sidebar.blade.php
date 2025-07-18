<div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em
                    class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="{{route('dashboard')}}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{url('/assets/images/logo-dark.png')}}"
                    srcset="{{url('/assets/images/logo2x.png')}} 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{url('/assets/images/logo-dark.png')}}"
                    srcset="{{url('/assets/images/logo-dark2x.png')}} 2x" alt="logo-dark">
            </a>
        </div>
    </div>

    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    @if(Illuminate\Support\Facades\Auth::user()->isAdmin() != 1)
                    <li class="nk-menu-item">
                        <a href="{{route('dashboard')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @else
                    <li class="nk-menu-item">
                        <a href="{{route('admin.dashboard')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    @endif


                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
                            <span class="nk-menu-text">Deposit</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('deposit.usdt')}}" class="nk-menu-link"><span
                                        class="nk-menu-text">USDT</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nk-menu-item">
                        <a href="{{route('buy.package')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-bag"></em></span>
                            <span class="nk-menu-text">Investment</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{route('user.internalTransfer')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-arrow-left"></em></span>
                            <span class="nk-menu-text">Internal Transfer</span>
                        </a>
                    </li>
                    


                   

                    <li class="nk-menu-item has-sub">

                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
                            <span class="nk-menu-text">Withdraw</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('user.withdraw')}}" class="nk-menu-link"><span
                                        class="nk-menu-text">Withdraw Now</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('user.walletTransfer')}}" class="nk-menu-link"><span
                                        class="nk-menu-text">Wallet Transfer</span></a>
                            </li>

                        </ul>

                    </li> 


                    <li class="nk-menu-item">
                        <a href="{{route('user.transactions')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chat"></em></span>
                            <span class="nk-menu-text">All Transactions</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{route('user.teams')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chat"></em></span>
                            <span class="nk-menu-text">My Team</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{route('logout')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li>
                    <!-- .nk-menu-item -->
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                            <span class="nk-menu-text">User Manage</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="html/user-list-default.html" class="nk-menu-link"><span class="nk-menu-text">User List</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/user-list-regular.html" class="nk-menu-link"><span class="nk-menu-text">User List</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/user-list-compact.html" class="nk-menu-link"><span class="nk-menu-text">User List</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/user-details-regular.html" class="nk-menu-link"><span class="nk-menu-text">User Details</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/user-profile-regular.html" class="nk-menu-link"><span class="nk-menu-text">User Profile</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/user-card.html" class="nk-menu-link"><span class="nk-menu-text">User Contact</span></a>
                            </li>
                        </ul>
                    </li> -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->


        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>