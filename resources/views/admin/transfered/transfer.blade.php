@extends('admin.layouts.master')
@section('title'){{ trans('label.parcel_completed') }}@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('label.parcel_completed') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('complete_transfered', $parcel->id) }}" id="parcel_form" method="post" enctype="multipart/form-data">
                <div class="hidden">
                    {{ csrf_field() }}
                </div>
                <!-- receiver info -->
                <div class="col-ms-12">
                    <p class="file_form_top_title">{{ trans('label.receiver_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.complete_receiver') }}</div>
                            <div class="col-sm-8">
                                @php
                                    $complete_receiver_invalid = $errors->has('complete_receiver') ? ' is-invalid' : '';
                                @endphp
                                <input type="text" class="full_width form-control{{ $complete_receiver_invalid }}" name="complete_receiver" value="{{ old('complete_receiver') }}">
                                @if ($errors->has('complete_receiver'))
                                <p class="common_form_error">
                                    {{ $errors->first('complete_receiver') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.complete_receiver_tel') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control" name="complete_receiver_tel" value="{{ old('complete_receiver_tel') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <div class="col-sm-4">{{ trans('label.complete_receive_time') }}</div>
                            <div class="col-sm-8">
                                <input type="text" class="full_width form-control datepicker" name="complete_receive_time" value="{{ old('complete_receive_time', now()->format('Y-m-d h:m:s')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2">{{ trans('label.complete_note') }}</div>
                        <div class="col-sm-8" style="padding-left: 5px;">
                            <textarea class="full_width form-control" name="complete_note">{{ old('complete_note') }}</textarea>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2">{{ trans('label.picture_confirm') }}</div>
                        <div class="col-sm-8" style="padding-left: 5px;">
                            <input type="file" class="full_width form-control" name="picture_confirm">
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
    });
</script>
@endsection
