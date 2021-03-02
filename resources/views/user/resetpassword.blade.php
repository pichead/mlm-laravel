@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">รีเซ็ตรหัสผ่าน</h3>
    </div>
    <br>
<form method="POST"  action="{{asset('reset')}}" oninput='cm_password.setCustomValidity(cm_password.value != password.value ? "รหัสผ่านไม่ตรงกัน" : "")' enctype="multipart/form-data">
    {{method_field('PUT')}}
    @csrf
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border mx-auto p-5 rounded" style="background-color: white;">
            <div class="mx-2" data-toggle="validator" role="form">
                <div class="form-group">
                        <label>อีเมล</label>
                        <input class="form-control" type="email" value="{{$user->email}}" disabled> 
                    </div>
                <div class="form-group"> 
                    <label>รหัสผ่านใหม่</label>
                    <input id="password" name="password" class="form-control" type="password"> 
                </div>
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input id="confirm_password" name="cm_password" class="form-control" type="password"> 
                </div>
                <div class="row mt-5">
                    <div class="mx-auto">
                        <button id="sm-tbn" class="btn px-4 purple-btn" name="reset" type="submit" value="{{$user->id}}" >ยืนยัน</button>
                        <button class="btn px-4 red-btn" type="button">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{ asset('bootstrap/validator.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection