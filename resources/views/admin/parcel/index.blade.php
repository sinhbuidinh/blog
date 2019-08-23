@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_list') }}@endsection
@section('head')
<style type="text/css">
    #parcels_tbl thead th:not(.small) {
        width: 150px;
    }
    th.parcel_code, td.parcel_code {
        width: 180px !important;
    }
    .page_list_block .table_text:not(.small) a {
        display: unset;
    }
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">{{ trans('message.parcel_list') }}</h1>
        <div id="group_create">
            <a href="{{ route('parcel.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('parcel')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="{{ trans('label.parcel_keyword_holder') }}" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')

    {!! $parcels->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table class="page_table table table-bordered full_width" id="parcels_tbl">
                    <thead>
                        <tr>
                            <th class="table_title parcel_code">{{ trans('label.parcel_code') }}</th>
                            <th class="table_title parcel_code">{{ trans('label.bill_code') }}</th>
                            <th class="table_title parcel_code">{{ trans('label.already_transfer') }}</th>
                            <th class="table_title">{{ trans('label.guest_code') }}</th>
                            <th class="table_title">{{ trans('label.type_transfer') }}</th>
                            <th class="table_title">{{ trans('label.parcel_type') }}</th>
                            <th class="table_title">{{ trans('label.agency') }}</th>
                            <th class="table_title">{{ trans('label.address') }}</th>
                            <th class="table_title">{{ trans('label.status') }}</th>
                            <th class="table_title">{{ trans('label.total') }}</th>
                            <th class="table_title">{{ trans('label.note') }}</th>
                            <th class="table_title small">{{ trans('label.edit') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    @if($parcels)
                    @foreach ($parcels as $parcel)
                    <tbody>
                    <tr>
                        <td class="table_text parcel_code">
                            <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->parcel_code }}</a>
                        </td>
                        <td class="table_text parcel_code">{{ $parcel->bill_code }}</td>
                        <td class="table_text">
                            @if($parcel->readyComplete)
                            <button type="button" data-url="{{ route('parcel.transfered', $parcel->id) }}" class="btn btn-primary confirm_complete">{{ trans('label.already_transfer') }}</button>
                            @endif
                        </td>
                        <td class="table_text">{{ $parcel->guest_code }}</td>
                        <td class="table_text">{{ $parcel->transferName }}</td>
                        <td class="table_text">{{ $parcel->typeName }}</td>
                        <td class="table_text">{{ $parcel->agencyName }}</td>
                        <td class="table_text">{{ $parcel->address }}</td>
                        <td class="table_text">
                            <p class="status_label">{{ $parcel->statusName }}</p>
                        </td>
                        <td class="table_text">{{ $parcel->total }}</td>
                        <td class="table_text">{{ $parcel->note }}</td>
                        <td class="table_text small">
                            <a href="{{ route('parcel.edit', $parcel->id) }}">
                                <img src="{{ asset('images/edit.png?v=1.0.1') }}">
                            </a>
                        </td>
                        <td class="table_text small">
                            <a href="{{ route('parcel.delete', $parcel->id) }}">
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
@section('script')
<script type="text/javascript">
    $(function(){
        $(document).on('click', '.confirm_complete', function(){
            window.location.href = $(this).data('url');
        });
    });
</script>
@endsection
