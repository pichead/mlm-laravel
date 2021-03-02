@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="mx-auto col-12 p-0">
        @include('inc.error')
    </div>
    <div class="row clearfix">
        <h3 class="mx-auto">สร้างตัวแทน</h3>
    </div>
    <br>
<form method="POST" class="was-validated" action="{{asset('create')}}" oninput='cm_password.setCustomValidity(cm_password.value != password.value ? "รหัสผ่านไม่ตรงกัน" : "")' enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border border-dark mx-auto p-5 rounded" style="background-color: white;">
            <div class="mx-2" data-toggle="validator" role="form">
                <div class="form-group">
                    <label>ชื่อ-สกุล</label>
                    <input name="name" class="form-control" type="name" placeholder="" value="{{ old('name') }}" required> 
                </div>
                <div class="form-group"> 
                    <label>รหัสผ่าน</label>
                    <input id="password" name="password" class="form-control" type="password" required> 
                </div>
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input id="confirm_password" name="cm_password" class="form-control" type="password" required> 
                </div>
                <div class="form-group">
                    <label>เบอร์ติดต่อ</label>
                    <input name="tel" class="form-control" type="tel" maxlength="10" placeholder="" value="{{old('tel')}}" required> 
                </div>
                <div class="form-group">
                    <label>อีเมล</label>
                    <input name="email" class="form-control" type="email" placeholder="" required> 
                </div>
                @if(Auth::user()->level_id == 1)
                <div class="form-group">
                    <label>ระดับ</label>
                    <select class="custom-select mr-sm-2" name="level" required>
                        <option selected value="1">ผู้ดูแลระบบ</option>
                        <option value="2">ตัวแทน</option>
                    </select>
                </div>
                @else
                <div class="form-group d-none">
                    <label>ระดับ</label>
                    <select class="custom-select mr-sm-2" name="level" required>
                        <option selected value="3"></option>
                    </select>
                </div>
                @endif


                

                <div class="row mt-5">
                    <div class="mx-auto">
                        <button id="sm-tbn" class="btn px-4 purple-btn" name="create" type="submit" value="บันทึกข้อมูล">บันทึก</button>
                        <a class="btn px-4 red-btn" href="{{asset('userList')}}" >ยกเลิก</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{ asset('bootstrap/validator.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection