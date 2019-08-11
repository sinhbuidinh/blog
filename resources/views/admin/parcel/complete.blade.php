@extends('admin.layouts.master') 
@section('title')
Success
@endsection
@section('content')
<div class="common_main_wrap">
    <div class="form_wrapper">
        <div class="form_bg">
            <p class="regester_complete_text">{{ $message }}</p>@include('admin.layouts.session-message')
            <button class="btn btn-primary" data-location="{{ route('parcel.input') }}" id="create" type="button">Tiếp tục tạo mới đơn hàng</button>
            <button class="btn btn-primary" data-location="{{ route('parcel') }}" id="parcels" type="button">Danh sách đơn hàng</button>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('click', '#create, #parcels', function(){
        var location = $(this).data('location');
        window.location.href = location;
    });
</script>
@endsection