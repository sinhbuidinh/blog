@extends('admin.layouts.master')

@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách bảng kê</h1>
        <div id="group_create">
            <a href="{{ route('package.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('package')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="Nhập mã bảng kê" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
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
                            <th class="table_title">{{ trans('label.package_code') }}</th>
                            <th class="table_title">{{ trans('label.confirm') }}</th>
                            <th class="table_title">{{ trans('label.parcel_list') }}</th>
                            <th class="table_title">{{ trans('label.status') }}</th>
                            <th class="table_title">{{ trans('label.note') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($packages)
                    @foreach ($packages as $package)
                    <tr>
                        <td class="table_text">{{ $package->package_code }}</td>
                        <td class="table_text">
                            @if($package->readyTransfer)
                            <button type="button" data-url="{{ route('package.transfer', $package->id) }}" class="btn btn-primary confirm_transfer">{{ trans('label.transfer') }}</button>
                            @endif
                        </td>
                        <td class="table_text">{{ $package->parcelDisplay }}</td>
                        <td class="table_text">
                            <p class="status_label">{{ $package->statusName }}</p>
                        </td>
                        <td class="table_text">{{ $package->note }}</td>
                        <td class="table_text small" style="text-align:center;">
                            <a href="{{ route('package.delete', $package->id) }}">
                                <img src="{{ asset('images/delete.png?v=1.0.1') }}">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="common_pager">{!! $packages->links('admin.layouts.pagination') !!}</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('click', '.confirm_transfer', function(){
        window.location.href = $(this).data('url');
    });
</script>
@endsection