@extends('layouts.web')

@section('content')
<div class="container mb-5 col-11 col-md-6">
    <div class="mx-auto col-12 p-0">
        @include('inc.error')
    </div>
    <div class="row">
      <div class="col-12 h3">เรทราคาสินค้า : <span>{{$user_id->name}} : {{$stock->name}} ({{number_format($stock->received_price,2)}} บาท)</div>
    
    </div>
    <br>
    <div class="p-4 border rounded" style="background-color: white">
        <form method="POST" class="was-validated"  action="{{asset('pricecreate')}}"  enctype="multipart/form-data">

            @csrf
            
            <input class="d-none" name="user_id" value="{{$user_id->id}} " />
            <input class="d-none" name="stock_id" value="{{$stock->id}}" />
            
            @php
                $priceitem = App\Models\Price::where('user_id',$user_id->id)->where('stock_id',$stock->id)->first();
            @endphp
            @if(isset($priceitem->stock_id))
            <h5 class="" style="color:red;">*หากต้องการแก้ไขเรทราคา จะต้องกำหนดเรทราคาใหม่ทั้งหมดเพื่อแทนที่เรทราคาเก่า</h5>
            <h4>เรทราคาปัจจุบัน</h4>
            <table class="col-12 re-table table-mobile table-stocks mt-2 mb-4 dataTable">
                <thead>
                    <tr class="row m-0">
                        <th class="col col-xl text-lg-center sorting_disabled">จำนวน</th>
                        <th class="col col-xl text-lg-center sorting_disabled">ราคา/หน่วย</th>
                        <th class="col-1 col-xl-1"></th>
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach($price as $price_row)
                    
                    <tr role="row" class="price row m-0 mb-5 mb-xl-0">
                        <td class="d-none"><input name="oldprice_id[]" value="{{$price_row->id}}"/></td>
                        <td class="col col-xl text-lg-center">
                            <div class="row ">
                                <div class="col-3 mx-auto text-center">{{$price_row->start_total}}</div>
                                -
                                <div class="col-3 mx-auto text-center">{{$price_row->end_total}}</div>
                            </div>
                        </td>
                        <td class="col col-xl text-lg-center">
                            <div class="col-4 mx-auto text-center">{{$price_row->price}}</div>
                        </td>
                        <td class="col-1 col-xl-1 text-lg-center">                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @endif
            <h4>เรทราคาใหม่</h4>
            
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
                                <input class="col-4 mx-auto form-control" type="number" name="start_total[]" value="1" readonly>
                                -
                                <input class="col-4 mx-auto form-control max" name="end_total[]" type="number" onclick="this.select()" required>
                            </div>
                        </td>
                        <td class="col col-xl text-lg-center">
                            <input name="price_row[]" class="col-5 mx-auto form-control" type="number" min="0" onclick="this.select()" required>
                        </td>
                        <td class="col-1 col-xl-1 text-lg-center">
                            
                        </td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr class="btnaddrow">
                        <td class="row">
                            <div id="addBtn" class="mx-auto col-2 btn green-btn">เพิ่ม</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="row mt-5">
                <div class="mx-auto">
                    <button id="sm-tbn" class="btn purple-btn" type="submit"  >สร้างเรทราคาใหม่</button>
                    <button class="btn px-4 red-btn" href="{{asset('price').'/'.$user_id->id}}" type="button" >ยกเลิก</button>
                </div>
            </div>
        </form>
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
        var maxamount = $('.max').last().val();

        // Adding a row inside the tbody. 
        $('#tbody').append(`<tr id="R${++rowIdx}"class="price row m-0 mb-5 mb-xl-0">   
                    <td class="col col-xl text-lg-center">
                        <div class="row ">
                            <input class="col-4 mx-auto form-control" name="start_total[]" type="number" value="${++maxamount}" required readonly>
                            -
                            <input class="col-4 mx-auto form-control max" name="end_total[]" type="number" value="${++maxamount}" min="${++maxamount}" onclick="this.select()" required>
                        </div>
                    </td>
                    <td class="col col-xl text-lg-center">
                        <input name="price_row[]" class="col-5 mx-auto form-control" type="number" min="0" onclick="this.select()" required>
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
