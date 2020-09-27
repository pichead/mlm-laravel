@extends('layouts.web')

@section('content')
<br>
<div class="container col-11 col-md-8">
    <div class="row">
      <div class="col-md-4 h3 pl-0">รายการสินค้า</div>
      <div class="col-md-7 px-0 offset-md-1">
        <a class="btn col-3" href="{{asset('createGoods')}}" type="button" style="background-color: #72CAFF;color:white">สร้างสินค้า</a>
        <input class="float-right col-8 form-control" type="text" placeholder="Search">
      </div>
    </div>
    <br>

    <div class="row">


        <table class="col-12 text-lg-center re-table table-mobile table-stocks mt-2 mb-4 dataTable">
            <thead>
                <tr class="row m-0">
                    <th class="col-12 col-xl-1 text-lg-center sorting_disabled" >No.</th>
                    <th class="col-12 col-xl text-lg-center sorting_disabled" >รายการสินค้า </th>
                    <th class="col-12 col-xl text-lg-center sorting_disabled" >ราคา/หน่วย</th>
                    <th class="col-12 col-xl-2 text-lg-center sorting_disabled"></th>
                </tr>
            </thead>

            <tbody>
              @foreach($Inventory as $Inventory_row)
                <tr role="row" class="row m-0 mb-5 mb-xl-0">
                    <td class="col-12 col-xl-1 text-lg-center" data-th="">{{$loop->index+1}}</td>
                    <td data-th="" class="col-12 col-xl">
                        <span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$Inventory_row->ProductList}}
                    </td>
                    <td data-th="" class="col-12 col-xl text-xl-center pr-xl-4"><span class="stock-extra-unit">ราคา/หน่วย: </span>{{$Inventory_row->price}} บาท </td>
                    <td class="col-12 col-xl-2">
                        <a class="btn col-3 col-xl-8 mx-1" type="button" data-toggle="modal" data-target="#editModal{{$loop->index+1}}" style="background-color:#58d6cc; color:White">แก้ไข</a>
                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>
        <div class="row">
          <div class="col-12 text-center">
            {{ $Inventory->links() }}
          </div>
        </div>

    </div>
    @foreach($Inventory as $Inventory_row)
    <!-- model -->
    <div class="modal" id="editModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg w-100">
        <div class="modal-content py-4">
          <div class="modal-header col-11 mx-auto">
            <h1 class="modal-title">เรทราคา: {{$Inventory_row->ProductList}}</h1>
          </div>
          <div class="modal-body col-11 mx-auto">
            <table class="text-center re-table mt-2 dataTable">
                <thead>
                    <tr class="row m-0">
                        <th class="col-7">จำนวน</th>
                        <th class="col-4">หน่วย</th>
                        <th class="col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row m-0">
                        <td class="col-7 row m-0">
                          <div class="col text-right">1</div>
                          <div class="col-1">-</div>
                          <div class="col text-left">100</div>
                        </td>
                        <td class="col-4">
                          <div class="col-12">2000 บาท</div>
                        </td>
                        <td class="col-1">
                          <a class="col-12 p-0" href="" style="color:red;">X</a>
                        </td>
                    </tr>
                    <tr class="row m-0">
                        <td class="col-7 row m-0">
                          <div class="col text-right">101</div>
                          <div class="col-1">-</div>
                          <div class="col text-left">200</div>
                        </td>
                        <td class="col-4 col-md">
                          <div class="col-12 col-md-12 ">1500 บาท</div>
                        </td>
                        <td class="col-1">
                          <a class="col-12 p-0" href="" style="color:red;">X</a>
                        </td>
                    </tr>

                    <!-- input form -->
                    <tr class="row m-0">
                        <td class="col-7 row m-0">
                          <div class="col clearfix">
                            <input class="form-control float-right" type="text" placeholder="minimum" style="text-align:center;">
                          </div>
                          <div class="col-1">-</div>
                          <div class="col text-left clearfix">
                            <input class="form-control float-left" type="text" placeholder="miximum" style="text-align:center;">
                          </div>
                        </td>
                        <td class="col-4">
                          <div class="col-12">
                            <input class="form-control mx-auto" type="text" placeholder="price" style="text-align:center;">
                          </div>
                        </td>
                        <td class="col-1"></td>
                    </tr>
                    <!-- end input form -->

                    <!-- bottom table -->
                    <tr>
                      <td  colspan="3">
                        <a class="btn col-5 col-md-4 col-lg-3 h-100" style="background-color: #58d6cc; color:white;">เพิ่ม</a>
                      </td>
                    </tr>
                    <!-- end bottom table -->
                </tbody>
            </table>
          </div>
          <div class="row">
              <div class="mx-auto my-3">
                  <button class="btn px-4" type="button" style="background-color: #D7B0EF; color:white;">บันทึก</button>
                  <a class="btn px-4" data-dismiss="modal" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</a>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end model -->
    @endforeach
</div>
@endsection
