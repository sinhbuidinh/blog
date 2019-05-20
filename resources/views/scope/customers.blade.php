@extends('layout', ['title' => 'Customers'])

@section('content')

<h1>Customers <small class="text-muted font-weight-light">({{ number_format($customers->total()) }} found)</small></h1>

<form class="input-group my-4" action="{{ route('customers') }}" method="get">
    <input type="hidden" name="order" value="{{ request('order') }}">
    <input type="text" class="w-50 form-control" placeholder="Search..." 
        name="search" value="{{ $search }}">
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<table class="table my-4">
    <tr>
        @php
            $route_param = request()->except('page');
        @endphp
        <th><a class="{{ $order_field === 'name' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'name'] + $route_param) }}">Name</a></th>
        <th><a class="{{ $order_field === 'company' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'company'] + $route_param) }}">Company</a></th>
        <th><a class="{{ $order_field === 'birthday' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'birthday'] + $route_param) }}">Birthday</a></th>
        <th><a class="{{ $order_field === 'last_interaction' ? 'text-dark' : '' }}" href="{{ route('customers', ['order' => 'last_interaction'] + $route_param) }}">Last Interaction</a></th>
    </tr>
    @foreach ($customers as $customer)
        <tr>
            <td><a>{{ $customer->last_name }}, {{ $customer->first_name }}</a></td>
            <td>{{ $customer->companyName }}</td>
            <td>{{ $customer->birth_date->format('F j') }}</td>
            <td>
                {{ $customer->lastInteraction->created_at->diffForHumans() }}
                <span class="text-secondary">({{ $customer->lastInteraction->type }})</span>
            </td>
        </tr>
    @endforeach
</table>

{{ $customers->appends(request()->all())->links() }}

@endsection
