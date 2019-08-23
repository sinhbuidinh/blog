@extends('admin.layouts.master')
@section('head')
<style type="text/css">
    #guests thead th:not(.small) {
        width: 150px;
    }
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách khách hàng</h1>
        <div id="group_create">
            <a href="{{ route('guest.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('guest')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="Nhập mã khách hàng" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')
    {!! $guests->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table cellpadding="0" cellspacing="0" border="0" class="table page_table" id="guests">
                    <thead>
                        <tr>
                            <th class="table_title">{{ trans('label.guest_code') }}</th>
                            <th class="table_title">{{ trans('label.company_name') }}</th>
                            <th class="table_title">{{ trans('label.address') }}</th>
                            <th class="table_title">{{ trans('label.tel') }}</th>
                            <th class="table_title">{{ trans('label.tax_code') }}</th>
                            <th class="table_title">{{ trans('label.representative') }}</th>
                            <th class="table_title">{{ trans('label.represent_tel') }}</th>
                            <th class="table_title small">{{ trans('label.edit') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    @if($guests)
                    @foreach ($guests as $guest)
                    <tbody>
                    <tr>
                        <td class="table_text">{{ $guest->guest_code }}</td>
                        <td class="table_text">{{ $guest->company_name }}</td>
                        <td class="table_text">{{ $guest->address }}</td>
                        <td class="table_text">{{ $guest->tel }}</td>
                        <td class="table_text">{{ $guest->tax_code }}</td>
                        <td class="table_text">{{ $guest->representative }}</td>
                        <td class="table_text">{{ $guest->represent_tel }}</td>
                        <td class="table_text small">
                            <a href="{{ route('guest.edit', $guest->id) }}">
                                <img src="{{ asset('images/edit.png?v=1.0.1') }}">
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('guest.delete', $guest->id) }}">
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
    <div class="common_pager">{!! $guests->links('pagination::bootstrap-4') !!}</div>
</div>
@endsection
