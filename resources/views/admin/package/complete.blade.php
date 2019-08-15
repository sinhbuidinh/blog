@extends('admin.layouts.master') 
@section('title')
Success
@endsection
@section('content')
<div class="common_main_wrap">
    <div class="form_wrapper">
        <div class="form_bg">
            @include('admin.layouts.session-message')
            <button class="btn btn-primary" data-location="{{ route('package.input') }}" id="create" type="button">Tiếp tục tạo mới bảng kê</button>
            <button class="btn btn-primary" data-location="{{ route('package') }}" id="packages" type="button">Danh sách bảng kê</button>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('click', '#create, #packages', function(){
        var location = $(this).data('location');
        window.location.href = location;
    });
</script>
@endsection