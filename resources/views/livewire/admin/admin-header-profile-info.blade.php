<div>
    @if ( Auth::guard('admin')->check() )
    <div class="user-info-dropdown" style="margin-right: 31px;">
        <div class="dropdown">
            <a
                class="dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
            >
                <span class="user-icon">
                    <img src="{{ $admin->picture }}" alt="" />
                </span>
                <span class="user-name">{{ $admin->name }}</span>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
            >
                <a class="dropdown-item" href="{{ route('admin.profile') }}"
                    ><i class="dw dw-user1"></i> Profile</a
                >
                <a class="dropdown-item" href="{{ route('admin.settings') }}"
                    ><i class="dw dw-settings2"></i> Setting</a
                >
                <a class="dropdown-item" href="{{ route('admin.logout_handler') }}"
                    onclick="event.preventDefault();document.getElementById('adminLogoutForm').submit();"><i class="dw dw-logout"></i> Log Out</a
                >
                <form action="{{ route('admin.logout_handler') }}" id="adminLogoutForm" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    @elseif( Auth::guard('user')->check() )
    <div class="user-info-dropdown" style="margin-right: 31px;">
        <div class="dropdown">
            <a
                class="dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
            >
                <span class="user-icon">
                    <img src="{{ $user->picture }}" alt="{{ $user->name }}" />
                </span>
                <span class="user-name">{{ $user->name }}</span>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
            >
                <a class="dropdown-item" href="{{ route('consignor.profile') }}"
                    ><i class="dw dw-user1"></i> Profile</a
                >
                <a class="dropdown-item" href=""
                    ><i class="dw dw-settings2"></i> Setting</a
                >
                <a class="dropdown-item" href="{{ route('consignor.logout-handler') }}"
                    onclick="event.preventDefault();document.getElementById('userLogoutForm').submit();"><i class="dw dw-logout"></i> Log Out</a
                >
                <form action="{{ route('consignor.logout-handler') }}" id="userLogoutForm" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
