@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_list') }}@endsection
@section('head')
<style type="text/css">
    table#parcels_tbl {
        border-collapse: collapse;
        overflow-x: scroll;
        display: block;
    }
    #parcels_tbl thead,
    #parcels_tbl tbody {
        display: block;
    }
    #parcels_tbl tbody {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 450px;
    }
    #parcels_tbl td,
    #parcels_tbl th {
        min-width: 180px;
        height: 25px;
        border: dashed 1px lightblue;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }
    #parcels_tbl th:first-child,
    #parcels_tbl td:first-child {
        min-width: 50px !important;
        width: 50px;
        padding: 12px !important;
        text-align: center;
    }
    #download {
        cursor: pointer;
        background: transparent;
    }
    #download img {
        width: 40px;
        height: 40px;
    }
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách vận đơn trong bảng kê</h1>
    </div>
    <div class="search_form">
        <div class="list_search list_search_with_button">
            <div class="col-sm-2">
                <p data-url="{{ route('package.export', $package->id) }}" id="download" style="display: inline-block">
                    <img style="width: 40px;" src="{{ asset('images/admin/sidebar/excel_download.png?v=1.0.1') }}" />Export</p>
            </div>
        </div>
    </div>
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content">
                @include('admin.package.export')
            </div>
        </div>
    </div>
    <div class="row col-sm-12">
        <a class="btn btn-primary" href="{{ route('package', $varsIndex) }}">{{ trans('label.back') }}</a>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function(){
        $('#download').on('click', function(){
            var url = $(this).data('url');
            var data = $('#debt_info').serialize();
            var goto = url + '?' + data;
            window.location.href = goto;
        });
        $('table.scroll-table').on('scroll', function() {
            $("#" + this.id + " > *").width($(this).width() + $(this).scrollLeft());
        });
    });
</script>
@endsection