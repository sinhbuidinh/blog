@extends('admin.layouts.master')
@section('title'){{ trans('message.create_guest') }}@endsection
@section('head')
<style type="text/css">
    input, select {
        padding: 0 10px;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('message.create_guest') }}</h1>
        </div>
        @if(Session::has('flashError'))
        <div class="form_box">
            <p class="alert">{{ Session::get('flashError') }}</p>
        </div>
        @endif
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('guest.create') }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                    <input type="hidden" id="tax_value" value="10" />
                </div>
                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.representative_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-2 my-auto">{{ trans('label.representative') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $representative_invalid = $errors->has('representative') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $representative_invalid }}" name="representative" value="{{ old('representative') }}">
                            @if ($errors->has('representative'))
                            <p class="common_form_error">
                                {{ $errors->first('representative') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-2 my-auto">{{ trans('label.represent_tel') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $represent_tel_invalid = $errors->has('represent_tel') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $represent_tel_invalid }}" name="represent_tel" value="{{ old('represent_tel') }}">
                            @if ($errors->has('represent_tel'))
                            <p class="common_form_error">
                                {{ $errors->first('represent_tel') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2 my-auto">{{ trans('label.represent_email') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $represent_email_invalid = $errors->has('represent_email') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $represent_email_invalid }}" name="represent_email" value="{{ old('represent_email') }}">
                            @if ($errors->has('represent_email'))
                            <p class="common_form_error">
                                {{ $errors->first('represent_email') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <p class="file_form_top_title">{{ trans('label.guest_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-2 my-auto">{{ trans('label.company_name') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $company_name_invalid = $errors->has('company_name') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $company_name_invalid }}" name="company_name" value="{{ old('company_name') }}">
                            @if ($errors->has('company_name'))
                            <p class="common_form_error">
                                {{ $errors->first('company_name') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-2 my-auto">{{ trans('label.email') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $email_invalid = $errors->has('email') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $email_invalid }}" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <p class="common_form_error">
                                {{ $errors->first('email') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2 my-auto">{{ trans('label.tel') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $tel_invalid = $errors->has('tel') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $tel_invalid }}" name="tel" value="{{ old('tel') }}">
                            @if ($errors->has('tel'))
                            <p class="common_form_error">
                                {{ $errors->first('tel') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-2 my-auto">{{ trans('label.fax') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $fax_invalid = $errors->has('fax') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $fax_invalid }}" name="fax" value="{{ old('fax') }}">
                            @if ($errors->has('fax'))
                            <p class="common_form_error">
                                {{ $errors->first('fax') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-2 my-auto">{{ trans('label.tax_code') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $tax_code_invalid = $errors->has('tax_code') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $tax_code_invalid }}" name="tax_code" value="{{ old('tax_code') }}">
                            @if ($errors->has('tax_code'))
                            <p class="common_form_error">
                                {{ $errors->first('tax_code') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-2 my-auto">{{ trans('label.tax_address') }}</div>
                        <div class="col-sm-4 my-auto">
                            @php
                                $tax_address_invalid = $errors->has('tax_address') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $tax_address_invalid }}" name="tax_address" value="{{ old('tax_address') }}">
                            @if ($errors->has('tax_address'))
                            <p class="common_form_error">
                                {{ $errors->first('tax_address') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <p class="file_form_top_title">{{ trans('label.address_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-6">{{ trans('label.provincial') }}</div>
                        <div class="col-sm-6">{{ trans('label.district') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6">
                            @php
                                $province_invalid = $errors->has('province') ? ' is-invalid' : '';
                            @endphp
                            <select id="province" class="full_width form-control{{ $province_invalid }}" name="province">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($provincials))
                                @foreach ($provincials as $code => $info)
                                    @php
                                        $check = '';
                                        if (old('province', -999) == $code) {
                                            $check = ' selected="selected"';
                                        }
                                    @endphp
                                    <option value="{{ $code }}" 
                                    data-districts="{{ route('district.by.province', $code) }}"
                                    data-display="{{ data_get($info, 'name_with_type') }}"
                                    {{ $check }}>{{ data_get($info, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('province'))
                            <p class="common_form_error">
                                {{ $errors->first('province') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-6" id="div_districts">
                            @php
                                $district_invalid = $errors->has('district') ? ' is-invalid' : '';
                            @endphp
                            <select name="district" class="full_width form-control{{ $district_invalid }}" id="district">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($districts))
                                @foreach ($districts as $code => $district)
                                    @php
                                        $districted = '';
                                        if (old('district', -999) == $code) {
                                            $districted = ' selected="selected"';
                                        }
                                    @endphp
                                    <option value="{{ $code }}" 
                                    data-display="{{ data_get($district, 'name_with_type') }}" {{$districted}}>{{ data_get($district, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('district'))
                            <p class="common_form_error">
                                {{ $errors->first('district') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6">{{ trans('label.ward') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6" id="div_wards">
                            @php
                                $ward_invalid = $errors->has('ward') ? ' is-invalid' : '';
                            @endphp
                            <select name="ward" class="full_width form-control{{ $ward_invalid }}" id="ward">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($wards))
                                @foreach ($wards as $code => $ward)
                                    @php
                                        $ward_checked = '';
                                        if (old('ward', -999) == $code) {
                                            $ward_checked = ' selected="selected"';
                                        }
                                    @endphp
                                    <option 
                                    data-display="{{ data_get($name, 'name_with_type') }}" value="{{ $code }}" {{$ward_checked}}>{{ data_get($ward, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ward'))
                            <p class="common_form_error">
                                {{ $errors->first('ward') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6">{{ trans('label.address') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-12">
                            @php
                                $address_invalid = $errors->has('address') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $address_invalid }}" name="address" id="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                            <p class="common_form_error">
                                {{ $errors->first('address') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-primary" type="submit">{{ trans('label.create_guest') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/address.js') }}"></script>
@endsection