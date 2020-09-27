@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">สมัครสมาชิก</h3>
    </div>
    <br>
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border border-dark mx-auto p-5" style="background-color: white;">
            <form class="mx-2">
                <div class="form-group">
                    <label>ชื่อ-สกุล</label>
                    <input class="form-control" type="fullname" placeholder="ชื่อจริง และ นามสกุล"></input>
                </div>
                <div class="form-group">
                    <label>ที่อยู่</label>
                    <textarea class="form-control" id="message" rows="5"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>เบอร์ติดต่อ</label>
                        <input type="tel" class="form-control" placeholder="ระบุหมายเลขโทรศัพท์">
                    </div>
                    <div class="form-group col-md-6">
                        <label>E-mail</label>
                        <input type="email" class="form-control" placeholder="ระบุ E-mail ส่วนตัว">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>ธนาคาร</label>
                        <input type="text" class="form-control" placeholder="ระบุธนาคารสำหรับการชำระเงิน">
                    </div>
                    <div class="form-group col-md-6">
                        <label>เลขบัญชีธนาคาร</label>
                        <input type="number" class="form-control" placeholder="ระบุเลชบัญชีธนาคาร">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="mx-auto">
            <button class="btn px-4" type="button" style="background-color: #D7B0EF; color:white;">บันทึก</button>
            <button class="btn px-4" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</button>
        </div>
    </div>
</div>

@endsection
