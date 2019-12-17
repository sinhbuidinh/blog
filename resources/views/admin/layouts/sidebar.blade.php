<div class="sidebar">
    <div class="sidebar_contents">
    <ul style="overflow-x: hidden; overflow-y: scroll; height: 540px;">
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
            <a href="{{ route('refund') }}" class="{{ $controller == 'RefundController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/refund.png?v=1.0.1') }}">{{ trans('label.sidebar_refund') }}
            </a>
        </li>
        <li>
            <a href="{{ route('forward') }}" class="{{ $controller == 'ForwardController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/forward.png?v=1.0.1') }}">{{ trans('label.sidebar_forward') }}
            </a>
        </li>
        <li>
            <a href="{{ route('transfereds') }}" class="{{ $controller == 'TransferedController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/transfered.png?v=1.0.1') }}">{{ trans('label.sidebar_transfered') }}
            </a>
        </li>
        <li>
            <a href="{{ route('debt') }}" class="{{ $controller == 'DebtController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/debt.png?v=1.0.1') }}">{{ trans('label.sidebar_debt') }}
            </a>
        </li>
        <li>
            <a href="{{ route('guest') }}" class="{{ $controller == 'GuestController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/guest.png?v=1.0.1') }}">{{ trans('label.sidebar_guest') }}
            </a>
        </li>
        <li>
            <a href="{{ route('print.debt') }}" class="{{ $controller == 'PrintController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/print_debt.png?v=1.0.1') }}">{{ trans('label.sidebar_print_debt') }}
            </a>
        </li>
        @if(isSuperAdmin('admin'))
        <li>
            <a href="{{ route('users') }}" class="{{ $controller == 'AccountController' ? 'active' : ''}}">
                <img src="{{ asset('images/admin/sidebar/account.png?v=1.0.1') }}">{{ trans('label.sidebar_users') }}
            </a>
        </li>
        @endif
    </ul>
    </div>
</div>