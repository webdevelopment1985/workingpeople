<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!-- <li class="menu-title">
                    <span>Main</span>
                </li> -->
                <!-- Dashboard -->
                <li class="{{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <i data-feather="home"></i>
                        <span>
                            {{__('sidebar.dashboard')}}
                        </span>
                    </a>
                </li>
                <!-- /Dashboard -->

                <!-- Users -->
                <li class="{{ (request()->is('admin/user*')) ? 'active' : '' }}">
					<a href="{{ route('users.index') }}" title="{{__('sidebar.user')}}"
						class="sidebar-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">
						 <i data-feather="users"></i>
						<span>{{__('sidebar.user')}}</span>
					</a>
				</li>
                <!-- /Users -->



                <!-- deposit -->
                <li class="{{ (request()->is('admin/deposits*')) ? 'active' : '' }}">
					<a href="{{route('deposits.index')}}" title="{{__('sidebar.setting')}}"
						class="sidebar-link {{ (request()->is('admin/deposits/*')) ? 'active' : '' }}">
						<i data-feather="corner-right-up"></i>
						<span>{{__('sidebar.deposit')}}</span>
					</a>
				</li>
                <!-- /deposit -->

                <!-- Invoice -->
                <li class="{{ (request()->is('admin/invoices*')) ? 'active' : '' }}">
                        <a href="{{route('invoices.index')}}" title="{{__('Investment Reports')}}"
                            class="sidebar-link {{ (request()->is('admin/invoices/*')) ? 'active' : '' }}">
                            <i data-feather="briefcase"></i>
                            <span>{{__('Investments')}}</span>
                        </a>
                    </li>


                    <li class="{{ (request()->is('admin/transfer*')) ? 'active' : '' }}">
                        <a href="{{route('transfer.history')}}" title="{{__('Transfer Reports')}}"
                            class="sidebar-link {{ (request()->is('admin/transfer/*')) ? 'active' : '' }}">
                            <i data-feather="briefcase"></i>
                            <span>{{__('Transfer History')}}</span>
                        </a>
                    </li>

                <!-- Withdraw -->
                <li class="{{ (request()->is('admin/withdraw*')) ? 'active' : '' }}">
                            <a href="{{route('withdraw.index')}}" title="Withdraw"
                                class="sidebar-link {{ (request()->is('admin/withdraw*')) ? 'active' : '' }}">
                                <i data-feather="corner-right-down"></i>
                                <span>Withdraw</span>
                            </a>
                        </li>
                <!-- /Withdraw -->
                 <!-- Transactions -->
                 <li class="{{ (request()->is('admin/transactions*')) ? 'active' : '' }}">
                    <a href="{{route('transactions.index')}}" title="Transactions"
                        class="sidebar-link {{ (request()->is('admin/transactions*')) ? 'active' : '' }}">
                        <i data-feather="credit-card"></i>
                        <span>All Transactions</span>
                    </a>
                </li>
                <!-- /Transactions -->

                <!-- Settings -->
                <li class="{{ (request()->is('admin/setting*')) ? 'active' : '' }}">
                    <a href="{{route('settings.index')}}" title="{{__('sidebar.setting')}}"
                        class="sidebar-link {{ (request()->is('admin/setting*')) ? 'active' : '' }}">
                        <i data-feather="settings"></i>
                        <span>{{__('sidebar.website-setting')}}</span>
                    </a>
                </li>
                <!-- /Settings -->


                <!-- /Invoice -->

            </ul>
        </div> <!-- /Sidebar-Menu -->
    </div> <!-- /Sidebar-inner -->
</div><!-- /Sidebar -->