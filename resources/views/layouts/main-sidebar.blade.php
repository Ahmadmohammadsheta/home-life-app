

<div class="d-flex">
    <button id="toggle-btn" type="button">
        <i class="lni lni-grid-alt"></i>
    </button>
    <div class="sidebar-logo">
        <a href="">CodzSword</a>
    </div>
</div>
<ul class="sidebar-nav">
    @foreach (mysqlTables() as $item)

    <li class="sidebar-item">
        <a href="{{ url('/' . $page=strtolower($item)) }}" class="sidebar-link"><i class="lni lni-agenda"></i><span>{{ __($item) }}</span></a>
    </li>

    @endforeach
{{--
    <li class="sidebar-item">
        <a href="" class="sidebar-link"><i class="lni lni-user"></i><span>Users</span></a>
    </li>
    <li class="sidebar-item">
        <a href="" class="sidebar-link"><i class="lni lni-agenda"></i><span>Profile</span></a>
    </li> --}}
    <li class="sidebar-item">
        <a href="" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth"><i class="lni lni-protection"></i><span>Auth</span></a>
        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="" class="sidebar-link">Login</a>
            </li>
            <li class="sidebar-item">
                <a href="" class="sidebar-link">Register</a>
            </li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a href="" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi"><i class="lni lni-layout"></i><span>Multi Level</span></a>
        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">Two Links</a>
                <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link">Link 1</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link">Link 2</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a href="" class="sidebar-link"><i class="lni lni-popup"></i><span>Notifications</span></a>
    </li>
    <li class="sidebar-item">
        <a href="" class="sidebar-link"><i class="lni lni-cog"></i><span>Setting</span></a>
    </li>
</ul>
<div class="sidebar-footer">
    <a href="" class="sidebar-link">          <!-- Settings Dropdown -->
    <div class="sm:flex sm:items-center sm:ms-6">
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <a href="" class="sidebar-link text-primary">
                            <i class="lni lni-exit"></i>
                            <span>{{ __('Log Out') }}</span>
                        </a>
            </x-dropdown-link>
        </form>
    </div>
</a>
</div>
