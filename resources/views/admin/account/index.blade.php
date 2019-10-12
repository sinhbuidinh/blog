@extends('admin.layouts.master')
@section('title')
{{ trans('label.user_list') }}
@endsection

@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">{{ trans('label.user_list') }}</h1>
        <div id="group_create">
            <a href="{{ route('register') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('users')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="Nhập tên hoặc email" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')
    {!! $users->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table cellpadding="0" cellspacing="0" border="0" class="table page_table" id="guests">
                    <thead>
                        <tr>
                            <th class="table_title">{{ trans('label.name') }}</th>
                            <th class="table_title">{{ trans('label.email') }}</th>
                            <th class="table_title">{{ trans('label.user_type') }}</th>
                            <th class="table_title text-center">{{ trans('label.change_pass') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    @if($users)
                    @foreach ($users as $user)
                    <tbody>
                    <tr>
                        <td class="table_text">{{ $user->name }}</td>
                        <td class="table_text">{{ $user->email }}</td>
                        <td class="table_text">{{ $user->typeName }}</td>
                        <td class="table_text">
                            <a href="{{ route('user.change_pass', $user->id) }}">
                                <img src="{{ asset('images/change_pass.svg?v=1.0.1') }}">
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('user.delete', $user->id) }}">
                                <img src="{{ asset('images/delete.png?v=1.0.1') }}">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="common_pager">{!! $users->links('pagination::bootstrap-4') !!}</div>
</div>
@endsection