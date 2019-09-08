@extends('admin.layouts.master')
@section('title'){{ trans('label.fail_transfer') }}@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('label.fail_transfer') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('fail_info', $parcel->id) }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                </div>
                <!-- fail info -->
                <div class="col-ms-12">
                    <p class="file_form_top_title">{{ trans('label.fail_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.reason') }}</div>
                            <div class="col-sm-8">
                                <select class="form-control" name="reason" id="reason">
                                    <option value="">{{ trans('label.please_choose_reason') }}</option>
                                    @if(!empty($reasons))
                                    @foreach($reasons as $id => $name)
                                        @php
                                            $reason_selected = '';
                                            if ($id == old('reason')) {
                                                $reason_selected = 'selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ $id }}" {{ $reason_selected }}>{{ $name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('reason'))
                                <p class="common_form_error">
                                    {{ $errors->first('reason') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.fail_time') }}</div>
                            <div class="col-sm-8">
                                @php
                                    $fail_invalid = $errors->has('fail_time') ? ' is-invalid' : '';
                                @endphp
                                <input type="text" class="full_width form-control datepicker{{ $fail_invalid }}" name="fail_time" value="{{ old('fail_time', now()->format('Y-m-d h:m:s')) }}">
                                @if ($errors->has('fail_time'))
                                <p class="common_form_error">
                                    {{ $errors->first('fail_time') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2">{{ trans('label.fail_note') }}</div>
                        <div class="col-sm-8" style="padding-left: 5px;">
                            <textarea class="full_width form-control" name="fail_note">{{ old('fail_note') }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- guest info -->
                <div class="col-ms-12">
                    <p class="file_form_top_title">{{ trans('label.guest_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.guest_code') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="guest_code" value="{{ $parcel->guest_code }}" disabled>
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.company_name') }}</div>
                            <div class="col-sm-8">
                                <textarea class="full_width form-control" name="company_name" disabled>{{ $parcel->companyName }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2">{{ trans('label.address') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-8">
                            <textarea class="full_width form-control" name="guest_address" disabled>{{ $parcel->guestAddress }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- parcel info -->
                <div class="col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.parcel_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.parcel_code') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="parcel_code" value="{{ $parcel->parcel_code }}" disabled>
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.bill_code') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="bill_code" value="{{ $parcel->bill_code }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.type_transfer') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="type_transfer" value="{{ $parcel->transferName }}" disabled>
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.parcel_type') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="parcel_type" value="{{ $parcel->typeName }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.agency') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="agency" value="{{ $parcel->agencyName }}" disabled>
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.address') }}</div>
                            <div class="col-sm-8">
                                <textarea class="full_width form-control" name="address" disabled>{{ $parcel->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.delivery_to_company_name') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="receiver_company" value="{{ $parcel->receiver_company }}" disabled>
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.full_name') }}</div>
                            <div class="col-sm-8">
                                <textarea class="full_width form-control" name="receiver" disabled>{{ $parcel->receiver }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- button action -->
                <div class="form_btn_area center">
                    <button class="btn btn-primary" id="update_complete" type="button">{{ trans('label.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function(){
        $('.datepicker').datepicker({
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            startDate: '-0d',
            onSelect: function(datetext) {
                var d = new Date(); // for now
                var h = d.getHours();
                h = (h < 10) ? ("0" + h) : h;
                var m = d.getMinutes();
                m = (m < 10) ? ("0" + m) : m;
                var s = d.getSeconds();
                s = (s < 10) ? ("0" + s) : s;
                datetext = datetext + " " + h + ":" + m + ":" + s;
                $('.datepicker').val(datetext);
            }
        });
        $(document).on('click', '#update_complete', function(){
            $(this).attr("disabled", true);
            $(this).html('Sending, please wait...');
            $('#parcel_form').submit();
        });
        $('#reason').select2();
    });
</script>
@endsection
