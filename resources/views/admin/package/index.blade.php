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
                <div class="row col-sm-12">
                    <div class="col-sm-3">
                        <input type="text" id="keyword" name="keyword" placeholder="Nhập mã bảng kê" value="{{ old('keyword', data_get($search, 'keyword')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="datepicker" id="date" name="date" placeholder="{{ trans('label.pick_date') }}" value="{{ old('date', data_get($search, 'date')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="status" id="status">
                            @php
                                $last_status = old('status', data_get($search, 'status'));
                                $status = (is_null($last_status) && $last_status != 0) ? -999 : $last_status;
                            @endphp
                            <option value="">{{ trans('label.pick_status') }}</option>
                            @if(!empty($statuses))
                            @foreach($statuses as $id => $name)
                                @php
                                    $status_selected = '';
                                    if ($id == $status) {
                                        $status_selected = 'selected="selected"';
                                    }
                                @endphp
                                <option value="{{ $id }}" {{ $status_selected }}>{{ $name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="list_search_submit">
                            <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                        </button>
                    </div>
                </div>
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
                            <th class="table_title">{{ trans('label.agency') }}</th>
                            <th class="table_title">{{ trans('label.create_date') }}</th>
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
                            @else
                            <p class="status_label">{{ $package->statusName }}</p>
                            @endif
                        </td>
                        <td class="table_text">{{ $package->parcelDisplay }}</td>
                        <td class="table_text">{{ $package->agencyName }}</td>
                        <td class="table_text">{{ $package->created_at }}</td>
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
    <div class="common_pager">{!! $packages->links('pagination::bootstrap-4') !!}</div>
</div>
<input type="hidden" name="transfer_url" id="transfer_url">
<button type="button" name="agency_list" id="agency_list" class="full_width form-control" data-toggle="modal" data-target="#agency_list_model" style="display: none;">{{ trans('label.agency') }}</button>
<div class="modal fade" id="agency_list_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('label.agency_list_model') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control full_width select2" name="agency" id="agency" style="width: 180px;">
                    <option value="">{{ trans('label.please_choose') }}</option>
                    @if(!empty($agency))
                    @foreach($agency as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('label.close') }}</button>
                <button class="btn btn-primary" id="pick_agency" type="submit">{{ trans('label.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function(){
        $('select.select2').select2();
        $('.datepicker').datepicker({
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            startDate: '-0d',
        });
    });
    $(document).on('click', '.confirm_transfer', function(){
        $('#agency_list').click();
        $('#transfer_url').val($(this).data('url'));
    });
    $(document).on('click', '#pick_agency', function(){
        var agency = $('#agency').find('option:selected').val();
        if (typeof agency == 'undefined' || agency == '') {
            alert('Vui lòng chọn đơn vị vận chuyển');
            return false;
        }
        var page_destination = $('#transfer_url').val() + '?agency=' + agency;
        window.location.href = page_destination;
    });
</script>
@endsection