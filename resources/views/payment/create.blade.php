@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">ชำระเงิน</h3>
    </div>
    <br>
    <div class="row">
        <div class="col-11 col-md-8 col-lg-6 border border-dark mx-auto p-5" style="background-color: white;">
            <form class="mx-2">
                <div class="form-group">
                    <label>เลขที่สั่งซื้อสินค้า</label>
                    <input class="form-control" type="number" placeholder=""></input>
                </div>
                <div class="form-group">
                    <label>ชื่อลูกค้า</label>
                    <input class="form-control" type="fullname" placeholder="ระบุชื่อ-นามสกุล"></input>
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
                <div class="form-group">
                    <label>ธนาคาร</label>
                    <input class="form-control" type="text" placeholder=""></input>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>วันที่ชำระเงิน</label>
                        <input type="date" class="form-control" placeholder="ระบุหมายเลขโทรศัพท์">
                    </div>
                    <div class="form-group col-md-6">
                        <label>เวลา</label>
                        <input type="time" class="form-control" placeholder="ระบุ E-mail ส่วนตัว">
                    </div>
                </div>
                <div class="form-group">
                    <label>จำนวนเงิน</label>
                    <input class="form-control" type="fullname" placeholder="ระบุชื่อ-นามสกุล"></input>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>จำนวนเงิน</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="form-group col-md-1">
                        <br>
                        <p class="pt-3">บาท</p>
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
