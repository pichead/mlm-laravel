@extends('layouts.web')

@section('content')
<br>
<div class="container col-11 col-md-6">
    <div class="row">
      <div class="col-md-4 h3 pl-0">เรทราคาสินค้า</div>
    </div>
    <br>
    <div class="p-4 border" style="background-color: white">
        <form method="POST" action="{{asset('pricecreate')}}"  enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        @foreach($user_id as $user_id_row)
                            <input name="user_id" value="{{$user_id_row->id}}" class="d-none" />
                            <div>{{$user_id_row->name}}</diV>

                        @endforeach
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="form-group">
                        <label>ใช้เทมเพลตเดียวกับผู้ใช้งานนี้</label>
                        <select class="form-control col-10 disable" name="user_templete" disabled>
                            <option value="0">เลือกผู้ใช้งาน</option>


                            @foreach($UserTree as $User_row)

                                @php
                                    $childs = App\Models\User::where('id',$User_row->child_id)->get();
                                @endphp

                                @foreach($childs as $child)
                                <option name="user_id" value="{{$child->id}}">{{$child->name}}</option>
                                @endforeach
                                
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>สินค้า</label>
                        <select id="selectproduct" class="form-control col-10" name="stock_id">
                            <option value="0">เลือกสินค้า</option>
                            @foreach($Stock as $Stock_row)
                                <option name="stock_id" data-price="{{$Stock_row->spent_price}}" data-unit="{{$Stock_row->spent_unit}}" value="{{$Stock_row->id}}">{{$Stock_row->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6 row">
                    <div class="col-6 ">
                        <div class="form-group">
                            <label class="col-12">ราคา/หน่วย</label>
                            <input class="col-10" type="text" readonly="readonly" id="productprice" />
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div class="form-group">
                            <label class="col-12">หน่วยสินค้า</label>
                            <input class="col-9" type="text" readonly="readonly" id="productunit" />
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <h4>เรทราคา</h4>
            </div>
            <table class="col-12 re-table table-mobile table-stocks mt-2 mb-4 dataTable">
                <thead>
                    <tr class="row m-0">
                        <th class="col col-xl text-lg-center sorting_disabled">จำนวน</th>
                        <th class="col col-xl text-lg-center sorting_disabled">ราคา/หน่วย</th>
                        <th class="col-1 col-xl-1"></th>
                    </tr>
                </thead>

                <tbody id="tbody">
                    <tr id="tr_0" role="row" class="price row m-0 mb-5 mb-xl-0">   
                        <td class="col col-xl text-lg-center">
                            <div class="row ">
                                <input class="col-3 mx-auto" name="start_total[]">
                                -
                                <input class="col-3 mx-auto" name="end_total[]">
                            </div>
                        </td>
                        <td class="col col-xl text-lg-center">
                            <input name="price_row[]" class="col-4">
                        </td>
                        <td class="col-1 col-xl-1 text-lg-center">
                            
                        </td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr class="btnaddrow">
                        <td class="row">
                            <div id="addBtn" class="mx-auto col-2 btn btn-success">เพิ่ม</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="row mt-5">
                <div class="mx-auto">
                    <button id="sm-tbn" class="btn px-4" name="create" type="submit" value="บันทึกข้อมูล" style="background-color: #D7B0EF; color:white;">บันทึก</button>
                    <button class="btn px-4" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</button>
                </div>
            </div>
    </div>

 

</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(function(){
    $("#selectproduct").change(function(){
        var price=$("#selectproduct option:selected").data("price");
        var unit=$("#selectproduct option:selected").data("unit");
        console.log(price,unit);
        $("#productprice").val(price);
        $("#productunit").val(unit);
    })
})

// $(function(){
//     $("#addprice").click(function(){
//         $(".btnaddrow").before('<tr role="row" class="price row m-0 mb-5 mb-xl-0"><td class="col col-xl text-lg-center"><div class="row "><input class="col-3 mx-auto">-<input class="col-3 mx-auto"></div></td><td class="col col-xl text-lg-center"><input class="col-4"></td><td class="col-1 col-xl-1 text-lg-center"><div class="delrow">X</div></td></tr>');
//     })
// })
</script>

{{-- <script>
$(function(){
    $(".delrow").click(function(){
        $(this).closest("tr").remove();
        console.log(this);
    })
})
</script> --}}

<script> 
    $(document).ready(function () { 
  
      // Denotes total number of rows 
      var rowIdx = 0; 
  
      // jQuery button click event to add a row 
      $('#addBtn').on('click', function () { 
  
        // Adding a row inside the tbody. 
        $('#tbody').append(`<tr id="R${++rowIdx}"class="price row m-0 mb-5 mb-xl-0">   
                    <td class="col col-xl text-lg-center">
                        <div class="row ">
                            <input name="start_total[]" class="col-3 mx-auto">
                            -
                            <input name="end_total[]" class="col-3 mx-auto">
                        </div>
                    </td>
                    <td class="col col-xl text-lg-center">
                        <input name="price_row[]" class="col-4">
                    </td>
                    <td class="col-1 col-xl-1 text-lg-center">
                        <div class=" remove"
                  type="button">X</div> 
                    </td>
                </tr>`); 
      }); 
  
      // jQuery button click event to remove a row. 
      $('#tbody').on('click', '.remove', function () { 
  
        // Getting all the rows next to the row 
        // containing the clicked button 
        var child = $(this).closest('tr').nextAll(); 
  
        // Iterating across all the rows  
        // obtained to change the index 
        child.each(function () { 
  
          // Getting <tr> id. 
          var id = $(this).attr('id'); 
  
          // Getting the <p> inside the .row-index class. 
          var idx = $(this).children('.row-index').children('p'); 
  
          // Gets the row number from <tr> id. 
          var dig = parseInt(id.substring(1)); 
  
          // Modifying row index. 
          idx.html(`Row ${dig - 1}`); 
  
          // Modifying row id. 
          $(this).attr('id', `R${dig - 1}`); 
        }); 
  
        // Removing the current row. 
        $(this).closest('tr').remove(); 
  
        // Decreasing total number of rows by 1. 
        rowIdx--; 
      }); 
    }); 
  </script> 

@endsection
