@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_completed') }}@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('label.parcel_completed') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('parcel.complete_transfered', $parcel->id) }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                </div>
                <!-- form receiver info -->
            </form>
        </div>
    </div>
</div>
@endsection
