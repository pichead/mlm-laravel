@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">แก้ไขข้อมูลส่วนตัว</h3>
    </div>
    <br>
<form method="POST" class="was-validated" action="{{asset(('EditUser').('/').(Auth::user()->id))}}" oninput='cm_password.setCustomValidity(cm_password.value != password.value ? "รหัสผ่านไม่ตรงกัน" : "")' enctype="multipart/form-data">
    {{method_field('PUT')}}
    @csrf
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border border-dark mx-auto p-5 rounded" style="background-color: white;">
            <div class="mx-2" data-toggle="validator" role="form">
                @foreach($user_id as $user)
                    <div class="form-group">
                        <label>ชื่อ-สกุล</label>
                        <input name="name" class="form-control" type="name" value="{{$user->name}}" required> 
                    </div>
                    <div class="form-group">
                        <label>เบอร์ติดต่อ</label>
                        <input name="tel" maxlength="10" minlength="10" class="form-control" type="tel" value="0{{$user->tel}}"> 
                    </div>
                    <div class="form-group">
                        <label>อีเมล</label>
                        <input name="email" class="form-control" type="email" value="{{$user->email}}" required> 
                    </div>
                    <div class="form-group">
                        <label>ส่งต่ออีเมล</label>
                        <div class="form-group">
                            @php
                              $mails = App\Models\UserMailForward::where('user_id',$user->id)->get();
                            @endphp
                            @foreach($mails as $mail)
                            <input readonly="readonly" class="form-control" value="{{$mail->name}}"/>
                            <input readonly="readonly" class="mt-2 form-control" value="{{$mail->forward_email}}"/>
                            <br>
                            @endforeach
                            <a class="btn col-12 blue-btn" href="{{asset('UserEmail'."/".$user->id)}}" id="forwardEmail">จัดการการส่งต่ออีเมล</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ธนาคาร</label>
                    </div>
                    <div class="form-group">
                        @php
                          $bank = App\Models\UserBank::where('user_id',$user->id)->get();
                        @endphp
                        @foreach($bank as $bank_row)
                        @php
                            $bank = App\Models\Bank::where('id',($bank_row->bank_id))->first();
                        @endphp
                        <input readonly="readonly" class="form-control" value="{{$bank->name}}"/>
                        <input readonly="readonly" class="mt-2 form-control" value="{{$bank_row->account_no}}"/>
                        <br>
                        @endforeach
                        <a class="btn col-12 green-btn" href="{{asset('UserBank'."/".$user->id)}}"  id="AddBank">จัดการธนาคาร</a>
                    </div>

                    <div class="row mt-5">
                        <div class="mx-auto">
                            <button id="sm-tbn" class="btn px-4 purple-btn" name="create" type="submit" value="บันทึกข้อมูล" >บันทึก</button>
                            <button class="btn px-4 red-btn" href="{{asset('userList')}}" type="button" >ยกเลิก</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{ asset('bootstrap/validator.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{-- <script>
$(document).ready(function(){
  $("#AddBank").click(function(){
    var txt1 = '<select class="form-control" name="bank_id[]"><option hidden value>เลือกธนาคาร</option>@foreach($Bank as $Bank_row)<option value="{{$Bank_row->id}}">{{$Bank_row->name}}</option>@endforeach</select><div class="ml-5 mt-2 form-group"><label>เลขบัญชีธนาคาร</label><input name="account_no[]" class="form-control" type="text" placeholder=""></div>'; 
    $("#bank").after(txt1);
  });
});
</script> --}}

@endsection