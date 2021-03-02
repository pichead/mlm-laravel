@extends('layouts.web')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('others/styles/Datatable.css')}}">




<style>

  .dataTables_length{
    display: none;
  }
  .dataTables_filter{
    display: none;
  }

</style>

@section('content')
<br>

<div class="container col-12 mb-5 col-md-9">
        <div class="col-12 mx-auto">
            <div class="mx-auto col-12 p-0">
                @include('inc.error')
                <div id="faild-msg" class="mt-2 alert alert-danger fade d-none">
                    <span  id="faild-message"></span>
                    <button  type="button" class="close" aria-label="Close" >
                        <span id="closebtn" aria-hidden="true">&times;</span>
                    </button>
                </div>
              </div>
            <div class="form-row mx-0 my-auto">

                <div class="col-7 col-sm-8 col-lg-10 h3 my-auto">ตระกร้าสินค้า</div>
                <div class="col-5 col-sm-4 col-lg-2 px-0 clearfix">
                  <button id="btn-update-cart" class="btn col float-right px-auto blue-btn" type="button">อัพเดทตระกร้า</button>
                </div>
              </div>
            <form method="POST" action="{{asset('CreateBill')}}"  enctype="multipart/form-data">
                @csrf
                @if($item == '[]')
                    <div class="row mx-auto p-4 mt-5" style="background-color:#eaeaea">
                        <div class="col-12  text-center">ไม่มีข้อมูลสินค้า กรุณาสั่งซื้อสินค้าก่อน</div>
                        <a class="btn mx-auto px-4 mt-4" href="{{asset('stock')}}" style="background-color: #D7B0EF; color:white;">รายการสินค้า</a>
                    </div>
                @else
                <div class="tb-search-wrapper mt-4">
                    <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-4">
                        <col width="auto">
                        <col width="auto">
                        <col width="auto">
                        <col width="150px">
                        <col width="150px">
                        <col width="250px">
                      <thead>
                            <tr>
                                <th class="text-lg-center" scope="col">No.</th>
                                <th class="text-lg-center" scope="col">รายการสินค้า </th>
                                <th class="text-lg-center px-lg-0" scope="col">ราคา/ชิ้น</th>
                                <th class="text-lg-center px-lg-0" scope="col">จำนวน</th>
                                <th class="text-lg-center px-lg-0" scope="col">ราคารวม</th>
                                <th class="text-lg-center" scope="col"></th>
                            </tr>
                        </thead>
                
                        <tbody>
                            @php
                                $count = 0;
                            @endphp
                          @foreach($item as $item_row)
                            
                            @php 
                                $stockname = App\Models\Stock::where('id',$item_row->stock_id)->first();
                            @endphp
                            @foreach($price as $price_row)
                                @if($item_row->amount >= $price_row->start_total && $item_row->amount <= $price_row->end_total && $price_row->stock_id == $item_row->stock_id)
                                    @php
                                        $amount = $item_row->amount;
                                        $priceperunit = $price_row->price;
                                        $total = $amount * $priceperunit;
                                        $count = $count+1;
                                        $max_amount = App\Models\Price::where('user_id',$user)->where('stock_id',$item_row->stock_id)->max('end_total');
                                        if($max_amount < $stockname->amount){
                                            $max = $max_amount;
                                        }
                                        else{
                                            $max = $stockname->amount;
                                        }
                                    @endphp
                                    <tr class="cart-rows" data-cartid="{{$item_row->id}}" data-amountid="price-{{$count}}">
                                        <td class="text-xl-center px-0">
                                            <div class="pl-2">{{$count}}</div>
                                            <input class="d-none" name="itemid[]" value="{{$item_row->id}}" >
                                        </td>
                                        <td class="px-0" >
                                            <input class="d-none" name="stock_id[]" value="{{$stockname->id}}" >
                                            <div class="pl-2" ><span class="stock-extra-unit">{{$count}}. </span>{{$stockname->name}}</div>
                                        </td>
                                        <td class="text-xl-right px-0" >
                                            <input class="d-none" id="input-price-unit-{{$count}}" name="priceperunit[]" value="{{$priceperunit}}" />
                                            <span id="priceunit-{{$count}}"><span class="pl-2 stock-extra-unit">ราคา/ชิ้น : </span>{{number_format($priceperunit,2)}}</span>
                                        </td>
                                        <td class="text-xl-right px-0">
                                            
                                                <span class="stock-extra-unit pl-2">จำนวน : </span>
                                                <input name="amount[]" value="{{$item_row->amount}}" type="number" min="1" max="{{$max}}" id="price-{{$count}}" onclick="this.select()" 
                                                data-inputpriceunit="input-price-unit-{{$count}}" 
                                                data-priceunit="priceunit-{{$count}}" 
                                                data-resultid="result-{{$count}}"
                                                data-totalresultid="totalresult-{{$count}}"
                                                data-totalpriceid="totalprice-{{$count}}"
                                                data-stockid="{{$stockname->id}}"
                                                class="price-identifier text-center" style="width: 120px">
                                        
                                        </td>
                                        <td class="text-xl-right px-0">
                                                <span id="totalresult-{{$count}}"  class="d-none price item" >{{$total}}</span>
                                                <input id="totalprice-{{$count}}" type="number" class="d-none" name="totalprice[]" value="{{$total}}">
                                                <span class="stock-extra-unit pl-2">ราคารวม : </span><span id="result-{{$count}}" name="total[]" >{{number_format($total,2)}}</span>                                            
                                        </td>

                                        <td class="text-center px-0">
                                            <button class="btn col-5 green-btn btn-sm" type="button" data-toggle="modal" data-target="#{{$item_row->id}}" >เรทราคา</button>
                                            <button class="btn col-5 red-btn btn-sm" type="button" data-toggle="modal" data-target="#del-item-modal-{{$item_row->id}}"  name="stock_id" value="" >ลบ</button>
                                        </td>

                                    </tr>
                                @endif
                                
                            @endforeach
                                    
                            
                            
                          @endforeach
                          <tr>
                            <td colspan="4"></td>
                            <td colspan="2" class="text-xl-right" id="cash-out" ></td>
                            </tr>
                        </tbody>

                    </table>
                  </div>

                    <br>
                    <div class="row">
                        <div class="mx-auto">
                            <button class="btn px-4 purple-btn" name="create" type="submit" >สั่งซื้อ</button>
                        </div>
                    </div>
                @endif
            </form>

            @foreach($item as $item_row)
                    @php 
                        $stockname = App\Models\Stock::where('id',$item_row->stock_id)->first();
                    @endphp
                    <div class="modal fade" id="{{$item_row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                @php
                                    $name = App\Models\Stock::where('id',$item_row->stock_id)->first();                   
                                @endphp
                                    <h5 class="modal-title" id="exampleModalLabel">เรทราคา {{$name->name}}</h5>
                                
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                {{-- <div class="h5">เรทราคา {{$name->name}}</div> --}}
                                <table class="col-12 re-table table-mobile table-stocks mt-2 mb-4 dataTable">
                                    <thead>
                                        <tr class="row m-0">
                                            <th class="col col-xl text-lg-center sorting_disabled">จำนวน</th>
                                            <th class="col col-xl text-lg-center sorting_disabled">ราคา/หน่วย</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach($price as $price_row)
                                            @if($price_row->stock_id == $item_row->stock_id)
                                            <tr id="tr_0" role="row" class="row m-0 mb-5 mb-xl-0">   
                                                <td class="col col-xl text-lg-center">
                                                    <div class="row ">
                                                        <div class="col-3 mx-auto">{{$price_row->start_total}}</div>
                                                        -
                                                        <div class="col-3 mx-auto">{{$price_row->end_total}}</div>
                                                    </div>
                                                </td>
                                                <td class="col col-xl text-center">
                                                    <div class="col-4 mx-auto">{{$price_row->price}}</div>
                                                </td>

                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal" id="del-item-modal-{{$item_row->id}}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <form method="DELETE" action="{{asset('DelItem'.'/'.$item_row->id)}}"  enctype="multipart/form-data">
                                 @csrf
                                <div class="modal-header">
                                <h5 class="modal-title">ลบสินค้า : {{$stockname->name}}</h5>
                                <button class="close" data-dismiss="modal">×</button>
                                </div>
                                <div class="modal-body">
                                <div class="h5">คุณต้องการลบ "{{$stockname->name}}" ออกจากตระกร้าหรือไม่?</div>
                                <div>หากต้องการลบ กดที่ปุ่ม "ลบ" เมื่อทำการลบแล้วจะไม่สามารถแก้ไขข้อมูลได้</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn red-btn col-3">ลบ</button>
                                <button class="btn blue-btn col-3" data-dismiss="modal">ปิด</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                @endforeach
        </div>

</div>

@endsection
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}

{{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script> --}}

{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}

@section('script')

<script>
    
$('#btn-update-cart').click( ( e ) => {
     e.preventDefault();

     var rowitemid = [];
        $('input[name="itemid[]"]').each( function() {
            rowitemid.push(this.value);
        });

    var rowamount = [];
        $('input[name="amount[]"]').each( function() {
            rowamount.push(this.value);
        });
    var rowtotal = [];
        $('input[name="totalprice[]"]').each( function() {
            rowtotal.push(this.value);

        });

    
    $.ajax({
        url: 'api/cart/updateCart',
        type: 'post',
        data: {"_token": "{{ csrf_token() }}",rowitemid:rowitemid,rowamount:rowamount,rowtotal:rowtotal},
        success:function(response){
            setInterval(function() {
            location.reload();
            }, 1500);
            
            $('#json-success-message').text('อัพเดตตระกร้าสำเร็จ');
            $('#user-success-msg').removeClass('d-none');
            $('#user-success-msg').addClass('show');

            setTimeout(()=>{
                $('#user-success-msg').removeClass('show');
                $('#user-success-msg').addClass('d-none');
            },2000);
            
        },
        error: function( error ){
            $('#json-faild-message').text('อัพเดตตระกร้าไม่สำเร็จ');
            $('#user-faild-msg').removeClass('d-none');
            $('#user-faild-msg').addClass('show');

            setTimeout(()=>{
                $('#user-faild-modal').removeClass('show');
                $('#user-faild-msg').addClass('d-none');
            },2000);
        }
    });

});



let prices = null;
// let cart = null;
$(document).ready(()=>{

    loadPrice();

});

function loadPrice(){

    $.get( "api/price/loadPrice",function(response){

            prices = JSON.parse(response.prices);

    }).fail(function(error){
                console.log('api/loadprice',error);
    });


}

    var sum = 0;
    $('.price').each(function(){
        sum += parseFloat($(this).text());
    });
    $('#cash-out').html("ราคารวมทั้งหมด "+(numeral(sum).format('0,0.00'))+" บาท");

    



$('.price-identifier').on('keyup change', (e) =>{

        var selected_stock_id = $('#' + e.target.id).data('stockid');
        var qty = isNaN(e.target.value) ? 0 : e.target.value;


        let price = getPrice(selected_stock_id,qty);
        let total_price = price * qty;
        
        var resultid = $('#' + e.target.id).data('resultid');
        var totalresultid = $('#' + e.target.id).data('totalresultid');
        var totalpriceid = $('#' + e.target.id).data('totalpriceid');

        // .format('0,0')
        $('#' + resultid).html(numeral(total_price).format('0,0.00'));
        $('#' + totalresultid).html(total_price);
        $('#' + totalpriceid).val(total_price);

        // priceunit
        var priceunitid = $('#' + e.target.id).data('priceunit');
        $('#' + priceunitid).html(numeral(price).format('0,0.00'));
        var inputpriceunitid = $('#' + e.target.id).data('inputpriceunit');
        $('#' + inputpriceunitid).val(price);

        var items = $('.item'),
            cashOut = $('#cash-out'),
            sum = 0;
        $.each(items, function(value) {
        // items[value] will contain an HTML element, representing an 'item'.
        var itemValue = parseFloat(items[value].innerHTML);
        sum += !isNaN(itemValue) ? itemValue : 0;
        });

        cashOut.html('ราคารวมทั้งหมด ' + numeral(sum).format('0,0.00') +' บาท');

        console.log(sum);
        if(sum == 0){
            console.log('เกินจำนวน');
            $('#faild-message').text('จำนวนสินค้าที่คุณต้องการเกินเรทราคา');
            $('#faild-msg').removeClass('d-none');         
            $('#faild-msg').addClass('show');       
        }

});

$(document).ready(function(){
    $("#closebtn").click(function () {
        $('#faild-msg').addClass('d-none');  
        $('#faild-msg').removeClass('show');
    });
});

function getPrice(selected_stock_id,qty){


    for(var i=0; i < prices.length; i++){

        var selected_price = prices[i];
        if(selected_price.stock_id == selected_stock_id && selected_price.start_total <= qty && selected_price.end_total >= qty ){
                    // console.log('the price is ', selected_price.price );
                    return selected_price.price;
        }

        }

    return 0;
    
}


</script>





@endsection
