<div class="sidebar">
    <div class="sidebar_contents">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ $controller == 'DashboardController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/dashboard.png?v=1.0.1') }}">Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('parcel') }}" class="{{ $controller == 'ParcelController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/parcel.png?v=1.0.1') }}">Parcel
            </a>
        </li>
    </ul>
    </div>
</div>