@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_list') }}@endsection
@section('head')
<style type="text/css">
    .list_search.list_search_with_button input {
        width: 100%;
    }
    th.parcel_code, td.parcel_code {
        width: 180px !important;
    }
    .page_list_block .table_text a {
        display: unset;
    }
    table {
        border-collapse: collapse;
        width: 300px;
        overflow-x: scroll;
        display: block;
    }
    thead {
        background-color: #EFEFEF;
    }
    thead,
    tbody {
        display: block;
    }
    tbody {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 140px;
    }
    td, th {
        min-width: 180px;
        height: 25px;
        border: dashed 1px lightblue;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
        padding: 10px;
    }
    th:first-child,
    td:first-child {
        min-width: 50px !important;
        width: 50px;
        padding: 12px !important;
        text-align: center;
    }
    img#download {
        cursor: pointer;
        width: 40px;
        height: 40px;
        background: transparent;
    }
</style>
@endsection

@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">{{ trans('message.debt_info') }}</h1>
    </div>
    <div class="search_form">
        <form action="{{ route('debt')}}" method="get" id="debt_info">
            <div class="list_search list_search_with_button">
                <div class="row col-sm-12">
                    <div class="col-sm-5">
                        <select class="form-control" name="guest_id" id="guest_id">
                            @php
                                $guest_id = old('guest_id', data_get($search, 'guest_id'));
                            @endphp
                            <option value="">{{ trans('label.please_choose_guest') }}</option>
                            @if(!empty($guests))
                            @foreach($guests as $guest)
                                @php
                                    $guest_selected = '';
                                    if (data_get($guest, 'id') == $guest_id) {
                                        $guest_selected = 'selected="selected"';
                                    }
                                @endphp
                                <option value="{{ data_get($guest, 'id') }}" {{ $guest_selected }}>{{ data_get($guest, 'company_name') .' - '. data_get($guest, 'guest_code') }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="input-sm form-control" placeholder="{{ trans('message.dates_input') }}" id="dates" name="dates" value="{{ old('dates', data_get($search, 'dates')) }}" autocomplete="off">
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="list_search_submit">
                            <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <img id="download" data-url="{{ route('debt.export') }}" src="{{ asset('images/admin/sidebar/excel_download.png?v=1.0.1') }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')
    <div class="page_list_block">
        <div class="page_table table-responsive">
            @include('admin.debt.export')
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
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
        $('#guest_id').select2();
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection