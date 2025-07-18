<li class="nav-item">
    <a class="nav-link {{ (request()->is('admin/users/info*')) ? 'active' : '' }}" href="{{route('users.info',$userId)}}"><span>Basic Info</span></a>
</li>

<li class="nav-item">
    <a class="nav-link {{ (request()->is('admin/users/transactions*')) ? 'active' : '' }}" href="{{route('users.transactions',$userId)}}"><span>Transactions</span></a>
</li>

<li class="nav-item">
    <a class="nav-link {{ (request()->is('admin/users/team*')) ? 'active' : '' }}" href="{{route('users.team',$userId)}}"><span>Downline</span></a>
</li>


