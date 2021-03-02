@extends('layouts.web')

@section('content')
<br>
<div class="container col-12  mb-5 col-md-11 col-xl-9">
  <h3 class="mx-auto text-center">สร้างสินค้า</h3>
  <br>
  <div class="mx-auto col-7 border border-secondary rounded" style="background-color: white">
    <form method="POST" class="was-validated" action="{{asset('CreateStocks')}}"  enctype="multipart/form-data">
      @csrf
      <div class="my-5 mx-5">
        <div class="form-group">
          <div class="col-12 p-0">ชื่อสินค้า</div>
          <input class="col-12 form-control" name="name" type="text" required>
        </div>
        <div class="form-group">
          <div class="col-12 p-0">จำนวน</div>
          <input class="col-12 form-control" name="amount" type="number" required>
        </div>
        <div class="row m-0">
          <div class="form-group col p-0 ">
            <div class="col-12 p-0">ราคาต้นทุน</div>
            <input class="col-12 form-control" name="recived_price" type="text" required>
          </div>
          <div class="form-group col p-0 ml-2">
            <div class="col-12  p-0">ราคาขาย</div>
            <input class="col-12  form-control" name="spent_price" type="text" required>
          </div>
        </div>
        <div class="row m-0">
          <div class="form-group col p-0">
            <div class="col-12  p-0">หน่วยขาย</div>
            <input class="col-12  form-control" name="spent_unit" type="text" required>
          </div>
        </div>
        <div class="row">
            <div class="mx-auto my-3">
                <button class="btn px-4 purple-btn" name="create" type="submit" value="บันทึกข้อมูล">บันทึก</button>
                <a class="btn px-4 red-btn" href="{{asset('stock')}}">ยกเลิก</a>
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


