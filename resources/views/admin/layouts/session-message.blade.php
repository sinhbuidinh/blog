@if(Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> {{ Session::get('success') }}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> {{ Session::get('error') }}
</div>
@endif
@if(Session::has('warning'))
<div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Warning!</strong> {{ Session::get('warning') }}
</div>
@endif
@if(Session::has('notice'))
<div class="alert alert-primary alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Notice!</strong> {{ Session::get('notice') }}
</div>
@endif