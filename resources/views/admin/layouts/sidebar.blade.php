<div class="sidebar">
    <div class="sidebar_contents">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ $controller == 'DashboardController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/dashboard.png?v=1.0.1') }}">{{ trans('label.sidebar_dashboard') }}
            </a>
        </li>
        <li>
            <a href="{{ route('parcel') }}" class="{{ $controller == 'ParcelController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/parcel.png?v=1.0.1') }}">{{ trans('label.sidebar_parcel') }}
            </a>
        </li>
        <li>
            <a href="{{ route('package') }}" class="{{ $controller == 'PackageController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/package.png?v=1.0.1') }}">{{ trans('label.sidebar_package') }}
            </a>
        </li>
        <li>
            <a href="{{ route('guest') }}" class="{{ $controller == 'GuestController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/guest.png?v=1.0.1') }}">{{ trans('label.sidebar_guest') }}
            </a>
        </li>
    </ul>
    </div>
</div>