@extends('admin.layouts.master')

@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách vận đơn</h1>
        <div id="group_create">
            <a href="{{ route('package.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('package')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="Nhập mã vận đơn" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')

    {!! $packages->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0" class="page_table">
                    <thead>
                        <tr>
                            <th class="table_title">package_code</th>
                            <th class="table_title">parcel_code</th>
                            <th class="table_title">note</th>
                            <th class="table_title small">{{ trans('label.edit') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    @if($packages)
                    @foreach ($packages as $package)
                    <tbody>
                    <tr>
                        <td class="table_text">{{ $package->package_code }}</td>
                        <td class="table_text">{{ $package->parcel_code }}</td>
                        <td class="table_text">{{ $package->note }}</td>
                        <td class="table_text small">
                            <a href="{{ route('package.edit', $package->id) }}">
                                <img src="{{ asset('images/edit.png?v=1.0.1') }}">
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('package.delete', $package->id) }}">
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
    <div class="common_pager">{!! $packages->links('admin.layouts.pagination') !!}</div>
</div>
@endsection
