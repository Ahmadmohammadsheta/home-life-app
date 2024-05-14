

<form action="#" class="d-none d-sm-inline-block">
    <div class="input-group input-group-navbar">
        <input type="text" class="form-control border-0 rounded-0" placeholder="Search......">
        <button type="button" class="btn border-0 rounded-0">
            <i class="lni lni-search-alt"></i>
        </button>
    </div>
</form>
<div class="navbar-collapse collapse">
    <ul class="navbar-nav ms-auto">
        <div class="sm:flex sm:items-center sm:ms-6">
            <x-dropdown-link :href="route('profile.edit')">
                <span class="text-warning">{{ Auth::user()->name }}</span>
            </x-dropdown-link>
        </div>
        <li class="nav-item dropdown">
            <a href="" class="van-icon pe-md-0" data-bs-toggle="dropdown">
                <img src="{{ asset("assets/icons/user.svg") }}" alt="" class="avatar img-fluid">
            </a>
            <div class="dropdown-menu dropdown-menu-end rounded">
                <a href="" class="dropdown-item">
                    <i class="lni lni-timer"></i>
                    <span>Analytics</span>
                </a>
                <a href="" class="dropdown-item">
                    <i class="lni lni-cog"></i>
                    <span>Setting</span>
                </a>
                <div class="dropdown-divider"></div>
                 <!-- Settings Dropdown -->
                <div class="sm:flex sm:items-center sm:ms-6">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        <a href="" class="dropdown-item text-primary">
                            <i class="lni lni-exit"></i>
                            <span>{{ __('Log Out') }}</span>
                        </a>
                        </x-dropdown-link>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</div>
