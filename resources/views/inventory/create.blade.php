@extends('layouts.web')

@section('content')
<br>
<div class="container col-12 col-md-11 col-xl-8">
  <div class="row">
    <div class="col-md-4 h3">สร้างรายการสินค้า</div>
  </div>
  <br>

  <div class="row mb-3">
    <div class="col-12 mx-auto">
      <div class="form-row py-3 border border-secondary p-2 p-md-5" style="background-color:white;">
        <div class="form-group col-md-6">
          <label>ชื่อสินค้า</label>
          <input type="text" class="form-control" placeholder="ระบุชื่อสินค้า">
        </div>
        <div class="form-group col-md-4">
          <label>ราคา/หน่วย</label>
          <div class="row m-0">
            <input type="number" class="col-9 form-control" placeholder="ระบุราคาต่อหนึ่งหน่วย">
            <div class="col-3 my-auto">บาท</div>
          </div>
        </div>
        <div class="form-group col-md-2">
          <label>หน่วยสินค้า</label>
          <input type="text" class="form-control" placeholder="ระบุหน่วยสินค้า">
        </div>
        <br>
        <br>
        <div class="form-group col-12">เรทราคา</div>



        <table class="text-center re-table mt-2 mb-4 dataTable">
            <thead>
                <tr class="row m-0">
                    <th class="col-6 col-md">จำนวน</th>
                    <th class="col-5 col-md">หน่วย</th>
                    <th class="col-1 col-md-1"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="row m-0">
                    <td class="col-6 col-md row m-0">
                      <div class="col col-md-5 text-right">1</div>
                      <div class="col-1 col-md-2">-</div>
                      <div class="col col-md-5 text-left">100</div>
                    </td>
                    <td class="col-5 col-md">
                      <div class="col-12 col-md-12 ">2000 บาท</div>
                    </td>
                    <td class="col-1 col-md-1">
                      <a class="col-12 col-md-12 p-0" href="" style="color:red;">X</a>
                    </td>
                </tr>
                <tr class="row m-0">
                    <td class="col-6 col-md row m-0">
                      <div class="col col-md-5 text-right">101</div>
                      <div class="col-1 col-md-2">-</div>
                      <div class="col col-md-5 text-left">200</div>
                    </td>
                    <td class="col-5 col-md">
                      <div class="col-12 col-md-12 ">1500 บาท</div>
                    </td>
                    <td class="col-1 col-md-1">
                      <a class="col-12 col-md-12 p-0" href="" style="color:red;">X</a>
                    </td>
                </tr>

                <!-- input form -->
                <tr class="row m-0">
                    <td class="col-6 col-md row m-0">
                      <div class="col col-md-5 clearfix">
                        <input class="form-control col-md-7 float-right" type="text" placeholder="minimum" style="text-align:center;">
                      </div>
                      <div class="col-1 col-md-2">-</div>
                      <div class="col col-md-5 text-left clearfix">
                        <input class="form-control col-md-7 float-left" type="text" placeholder="miximum" style="text-align:center;">
                      </div>
                    </td>
                    <td class="col-5 col-md">
                      <div class="col-12 col-md-12 ">
                        <input class="form-control col-7 mx-auto" type="text" placeholder="price" style="text-align:center;">
                      </div>
                    </td>
                    <td class="col-1 col-md-1"></td>
                </tr>
                <!-- end input form -->


                <!-- bottom table -->
                <tr>
                  <td  colspan="3">
                    <a class="btn col-3 col-md-2 col-lg-1 h-100" style="background-color: #58d6cc; color:white;">เพิ่ม</a>
                  </td>
                </tr>
                <!-- end bottom table -->
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
      <div class="mx-auto my-3">
          <button class="btn px-4" type="button" style="background-color: #D7B0EF; color:white;">บันทึก</button>
          <a class="btn px-4" href="{{asset('inventory')}}" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</a>
      </div>
  </div>
</div>
@endsection

@section('script')


@endsection
