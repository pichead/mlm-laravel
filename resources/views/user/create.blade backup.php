@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">สมัครสมาชิก</h3>
    </div>
    <br>
<form method="POST" action="{{asset('create')}}" oninput='cm_password.setCustomValidity(cm_password.value != password.value ? "รหัสผ่านไม่ตรงกัน" : "")' enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border border-dark mx-auto p-5" style="background-color: white;">
            <div class="mx-2" data-toggle="validator" role="form">
                <div class="form-group">
                    <label>ชื่อ-สกุล</label>
                    <input name="name" class="form-control" type="name" placeholder="ชื่อจริง และ นามสกุล"> 
                </div>
                <div class="form-group"> 
                    <label>รหัสผ่าน</label>
                    <input id="password" name="password" class="form-control" type="ใส่รหัสผ่าน"> 
                </div>
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input id="confirm_password" name="cm_password" class="form-control" type="ยืนยันรหัสผ่าน"> 
                </div>
                <div class="form-group">
                    <label>เบอร์ติดต่อ</label>
                    <input name="tel" class="form-control" type="tel" placeholder=""> 
                </div>
                <div class="form-group">
                    <label>อีเมล</label>
                    <input name="email" class="form-control" type="email" placeholder=""> 
                </div>
                <div id="bank" class="form-group">
                    <label>ธนาคาร</label><span class="ml-2 py-0 px-2 h5 border" type="button" id="AddBank" style="border-radius: 15px;">+</span>
                    <select class="form-control" name="bank_id[]">
                        <option value="0">เลือกธนาคาร</option>
                        @foreach($Bank as $Bank_row)
                            <option value="{{$Bank_row->id}}">{{$Bank_row->name}}</option>
                        @endforeach
                    </select>
                    <div class="ml-5 mt-2 form-group">
                        <label>เลขบัญชีธนาคาร</label>
                        <input name="account_no[]" class="form-control" type="text" placeholder=""> 
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="mx-auto">
                        <button id="sm-tbn" class="btn px-4" name="create" type="submit" value="บันทึกข้อมูล" style="background-color: #D7B0EF; color:white;">บันทึก</button>
                        <button class="btn px-4" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{ asset('bootstrap/validator.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $("#AddBank").click(function(){
    var txt1 = '<select class="form-control" name="bank_id[]"><option hidden value>เลือกธนาคาร</option>@foreach($Bank as $Bank_row)<option value="{{$Bank_row->id}}">{{$Bank_row->name}}</option>@endforeach</select><div class="ml-5 mt-2 form-group"><label>เลขบัญชีธนาคาร</label><input name="account_no[]" class="form-control" type="text" placeholder=""></div>'; 
    $("#bank").after(txt1);
  });
});
</script>

@endsection