@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> {{ Session::get('success') }}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> {{ Session::get('error') }}
</div>
@endif