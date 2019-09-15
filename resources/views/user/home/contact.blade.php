@extends('user.layouts.kn247.master') 
@section('title')
Liên hệ | KN247
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Để lại thắc mắc bên dưới</h1>
        </div>
    </div>
    <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
            <form action="#leave-msg" method="post">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="require" for="name">Họ tên</label>
                        <input type="text" id="name" class="form-control ">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="require" for="phone">SDT</label>
                        <input type="text" id="phone" class="form-control ">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="require" for="email">Email</label>
                        <input type="email" id="email" class="form-control ">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="require" for="message">Nội dung</label>
                        <textarea name="message" id="message" class="form-control " cols="30" rows="8"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <input type="submit" value="Gửi KN247" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
