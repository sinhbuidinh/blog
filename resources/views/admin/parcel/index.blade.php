@extends('admin.layouts.master')

@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách bưu phẩm</h1>
        <div id="group_create">
            <a href="{{ route('parcel.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('parcel')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="Nhập mã hóa đơn" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>

    {!! $parcels->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0" class="page_table">
                    <thead>
                        <tr>
                            <th class="table_title">会社名</th>
                            <th class="table_title">請求者名</th>
                            <th class="table_title">ステータス</th>
                            <th class="table_title small">詳細</th>
                            <th class="table_title small">編集</th>
                            <th class="table_title small">削除</th>
                        </tr>
                    </thead>
                    @if($parcels)
                    @foreach ($parcels as $parcel)
                    <tbody>
                    <tr>
                        <td class="table_text">{{ $company->company_name }}</td>
                        <td class="table_text">{{ $company->sender_name }}</td>
                        <td class="table_text">
                            <p class="status_label">{{ $company->statusName }}</p>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('detail_company', $company->id) }}">
                                <img src="{{ asset('images/detail.png?v=1.0.1') }}" />
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('edit_company', $company->id) }}">
                                <img src="{{ asset('images/edit.png?v=1.0.1') }}">
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('delete_company', $company->id) }}">
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
    <div class="common_pager">{!! $parcels->links('admin.layouts.pagination') !!}</div>
</div>
@endsection
