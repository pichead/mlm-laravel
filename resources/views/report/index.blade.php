@extends('layouts.web')

@section('style')
<link rel="stylesheet" href="{{asset('others/chosen/chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('others/styles/Datatable.css')}}">




<style>

  .dataTables_length{
    display: none;
  }
  .dataTables_filter{
    display: none;
  }

  .print-wrapper{
    display: none;
  }

    @media print {

      /* body *{
        visibility: hidden;
        height: 0;
      } */
      .content-wrapper{
        display: none;
      }
      .print-wrapper{
        display: block;
        height: auto;
        margin-top: -60px;
      }
      .print-wrapper,.print-wrapper *{
        visibility: visible;
        height: auto;
      }
      .tb-print-stock-history{
        width: auto;;
        margin: auto;
      }
      @page {
        size: A4 landscape;
        margin: 3mm 3mm;

      }


    }

</style>



@endsection



@section('content')

<div class="col-12 col-lg-11 mx-auto">
  <div class="content-wrapper">
    <div class="container mb-3 col-12">
      <div class="mx-auto col-12 p-0">
          @include('inc.error')
      </div>
        <div class="form-row mx-0 my-auto">
          <div class="col-12 my-auto px-0 h3">รายงานยอดขาย</div>
        </div>

        <div class="col-12 p-4 p-md-5 mt-4 rounded" style="background-color: white">

            <form action="{{asset('report/sale')}}" method="post">
                @csrf
                <div class="form-wrapper myboxShadow">


                    <div class="form-row">                            
                        <div class="form-group col-xl col-md-6">
                                <label>ชื่อสินค้า</label>
                                <select id="stocks" name="stock_id" class="form-control">
                                  <option value="0" {{($request_stock_id == 0) ? 'selected':''}}>ดูทั้งหมด</option>
                                    @foreach($stock as $stock_row)
                                    <option id="stock-{{$stock_row->id}}" value="{{$stock_row->id}}" {{($request_stock_id == $stock_row->id) ? 'selected':''}}>{{$stock_row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl col-md-6">
                                <label>ตัวแทน</label>
                                <select id="childs"  name="child_id" class="form-control" data-placeholder="ค้นหาชื่อตัวแทน">
                                  <option value="0" {{($childID == 0) ? 'selected':''}}>ดูทั้งหมด</option>
                                    @foreach($child as $child_row)
                                    <option id="child_option_{{$child_row->id}}" value="{{$child_row->id}}" {{($childID == $child_row->id) ? 'selected':''}}>{{$child_row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                
                        <div class="form-group col-xl col-md-6">
                        <label for="inputEmail4">วันและเวลาที่เริ่ม</label>
                            <div class="input-group date" id="start_date" data-target-input="nearest">
                            <input  name="start_date" type="text" class="form-control datetimepicker-input" data-target="#start_date" data-minlength="10" data-error="กรุณากรอกวันที่โดยใช้ปฏิทิน"  />
                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group col-xl col-md-6">
                        <label for="inputEmail4">วันและเวลาที่สิ้นสุด</label>
                        <div class="input-group date" id="end_date" data-target-input="nearest">
                            <input  name="end_date" type="text" class="form-control datetimepicker-input" data-target="#end_date" data-minlength="10" data-error="กรุณากรอกวันที่โดยใช้ปฏิทิน" />
                            <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="btn-create-wrapper text-center mt-4">
                        <button type="submit" id="create-user-btn" name="create" class="btn col-xl-1 col-md-3 col-5 blue-btn" >ค้นหา</button>
                        <button type="button" id="reset-user-btn" name="reset" class="btn col-xl-1 col-md-3 col-5 red-btn" onclick="location.href='{{asset('SaleReport')}}';" >รีเซ็ต</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="form-row mx-0 mb-3">
            <div class="col-12 col-md-8 col-lg-10 p-0 mt-3">
                <div class="col-12 pl-lg-0 px-0">
                <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
                </div>
            </div>

            <form method="POST" id="convert_form" class="col-12 col-md-4 col-lg-2 mt-3 d-flex justify-content-center px-0" action="{{asset('excel/download')}}">
                @csrf
                <input type="hidden" name="file_name" id="file_name" value="รายงานยอดขายสินค้าและบริการ" />
                <input type="hidden" name="file_content" id="file_content" />
                <button class="btn col ml-md-3  mr-2 mr-md-auto green-btn" type="button" id="btn_convert_form" onclick="downloadExcel()" name="button">Excel</button>
              
                <button class="btn col ml-md-3 purple-btn" href="#" type="button" onclick="printTable()">พิมพ์</button>
            </form> 

        </div>
        <div class="tb-search-wrapper">
          <table id="tb-stocks" class="re-table table-mobile table-stocks mb-0 mb-md-3">
            <col width="30px">
            <col width="160px">
            <col width="120px">
            <col width="auto">
            <col width="auto">
            <col width="auto">
            <col width="120px">
            <col width="auto">
            <col width="auto">
            <col width="auto">

            <thead>
                <tr>
                    <th class="text-lg-center sorting_disabled" scope="col">ลำดับ</th>
                    <th class="text-lg-center sorting_disabled" scope="col">วันที่สั่งซื้อ</th>
                    <th class="text-lg-center sorting_disabled" scope="col">เลขที่คำสั่งซื้อ</th>
                    <th class="text-lg-center sorting_disabled" scope="col">รายการสินค้า</th>
                    <th class="text-lg-center sorting_disabled" scope="col">ตัวแทน</th>
                    <th class="text-lg-center sorting_disabled" scope="col">ต้นทุน/ชิ้น</th>
                    <th class="text-lg-right sorting_disabled" scope="col">ราคาขาย/ชิ้น</th>
                    <th class="text-lg-right sorting_disabled" scope="col">จำนวน</th>
                    <th class="text-lg-center sorting_disabled" scope="col">ยอดขาย</th>
                    <th class="text-lg-center sorting_disabled" scope="col">กำไร</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $count = 0;
                @endphp
                @foreach($PurchaseOrder as $PurchaseOrder_row)
                    @php
                        if($request_stock_id == 0){
                            $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->get();
                        }
                        else{
                            $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->where('stock_id',$request_stock_id)->get();
                        }
                    @endphp
                    @foreach($Order as $Order_row)
                        @php
                            
                            $stock = App\Models\Stock::where('id',$Order_row->stock_id)->first();
                            $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();   
                            $price_per_unit = ($Order_row->price / $Order_row->amount);
                            $profit = ($Order_row->price - ($Order_row->amount * $stock->received_price));
                            $count = $count+1;
                        @endphp
                        <tr>
                            <td class="text-xl-center px-0"><div class="pl-2 pl-lg-0">{{$count}}</div></td>
                            <td class="text-xl-left px-0">
                                <div class="pl-2"><span class="stock-extra-unit">วันที่สั่งซื้อ : </span>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</div>
                            </td>
                            <td class="px-0 text-xl-left">
                                <div class="pl-2"><span class="stock-extra-unit">เลขที่คำสั่งซื้อ : </span>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</div>
                            </td>
                            <td class="text-xl-center px-0"><div class="pl-2"><span class="stock-extra-unit">รายการสินค้า : </span>{{$stock->name}}</div></td>
                            <td class="text-xl-left px-0"><div class="pl-2"><span class="stock-extra-unit">ตัวแทน : </span>{{$user->name}}</div></td>
                            <td class="text-xl-right px-0"><div class="pl-2"><span class="stock-extra-unit">ราคาต้นทุน/ชิ้น : </span>{{number_format($stock->received_price,2)}}</div></td>
                            <td class="text-xl-right px-0"><div class="pl-2"><span class="stock-extra-unit">ราคาขาย/ชิ้น : </span>{{number_format($price_per_unit,2)}}</div></td>
                            <td class="text-xl-right px-0 ">
                              <div class="d-none amounts">{{$Order_row->amount}}</div>
                              <div class="pl-2"><span class="stock-extra-unit">จำนวน : </span>{{number_format($Order_row->amount,0)}}</div>
                            </td>
                            <td class="text-xl-right px-0 ">
                              <div class="d-none prices">{{$Order_row->price}}</div>
                              <div class="pl-2"><span class="stock-extra-unit">ยอดขาย : </span>{{number_format($Order_row->price,2)}}</div>
                            </td>
                            <td class="text-xl-right px-0 "><div class="d-none profits">{{$profit}}</div><div class="pr-2"><span class="pl-2 stock-extra-unit">กำไร : </span>{{number_format($profit,2)}}</div></td>
                        </tr>
                    @endforeach
                @endforeach

                  <tr id="footer">
                    <td colspan="6" style="border-bottom: black solid 1px;"></td>
                    <td class="text-xl-right px-0"  style="border-bottom: black solid 1px;">รวม</td>
                    <td id="sum_amount" class="text-xl-right px-0"  style="border-bottom: black solid 1px;"></td>
                    <td id="sum_price" class="text-xl-right px-0" style="border-bottom: black solid 1px;"></td>
                    <td class="text-xl-right px-0 " style="border-bottom: black solid 1px;"><div id="sum_profit" class="pr-2"></div></td>
                  </tr>
          
            </tbody>
          </table>
        </div>

    </div>
  </div>

  {{-- print --}}
  <div class="print-wrapper">

    <h4 class="text-center">V Dealers</h4>
    <h4 class="text-center">รายงานยอดขายสินค้าและบริการ</h4>
    <h5 class="text-center">{{DateTime::createFromFormat('Y-m-d H:i', $start_date)->format('d/m/Y H:i')}} - {{DateTime::createFromFormat('Y-m-d H:i', $end_date)->format('d/m/Y H:i')}}</h5>

    <div class="mx-4 mt-5" style="font-size: 12px">
      <table class="table table-borderless">
        <thead class="border-top border-bottom border-dark">
          <th class="text-center" scope="col">ลำดับ</th>
          <th class="text-center" scope="col">วันที่สั่งซื้อ</th>
          <th class="text-center" scope="col">เลขที่คำสั่งซื้อ</th>
          <th class="text-center" scope="col">รายการสินค้า</th>
          <th class="text-center" scope="col">ตัวแทน</th>
          <th class="text-center" scope="col">ต้นทุน/ชิ้น</th>
          <th class="text-right" scope="col">ราคาขาย/ชิ้น</th>
          <th class="text-right" scope="col">จำนวน</th>
          <th class="text-center" scope="col">ยอดขาย</th>
          <th class="text-center" scope="col">กำไร</th>
        </thead>
        <tbody>
          @php
              $count = 0;
          @endphp
          @if($PurchaseOrder->count() == 0)
          <tr>
            <td colspan="10" class="text-center">
                ไม่มีรายการ
            </td>
          </tr>

          @endif
          @foreach($PurchaseOrder as $PurchaseOrder_row)
              @php
                  if($request_stock_id == 0){
                      $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->get();
                  }
                  else{
                      $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->where('stock_id',$request_stock_id)->get();
                  }
              @endphp
              @foreach($Order as $Order_row)
                @php
                    $stock = App\Models\Stock::where('id',$Order_row->stock_id)->first();
                    $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();   
                    $price_per_unit = ($Order_row->price / $Order_row->amount);
                    $profit = ($Order_row->price - ($Order_row->amount * $stock->received_price));
                    $count = $count+1;
                @endphp
                
                <tr>
                    <td class="text-center px-0"><div class="pl-2">{{$count}}</div></td>
                    <td class="text-left px-0">
                        <div class="pl-2">{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</div>
                    </td>
                    <td class="px-0 text-xl-left">
                        <div class="pl-2"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</div>
                    </td>
                    <td class="text-center px-0"><div class="pl-2">{{$stock->name}}</div></td>
                    <td class="text-left px-0"><div class="pl-2">{{$user->name}}</div></td>
                    <td class="text-right px-0"><div class="pl-2">{{number_format($stock->received_price,2)}}</div></td>
                    <td class="text-right px-0"><div class="pl-2">{{number_format($price_per_unit,2)}}</div></td>
                    <td class="text-right px-0 "><div class="d-none ">{{$Order_row->amount}}</div><div class="pl-2">{{number_format($Order_row->amount,0)}}</div></td>
                    <td class="text-right px-0 "><div class="d-none ">{{$Order_row->price}}</div><div class="pl-2">{{number_format($Order_row->price,2)}}</div></td>
                    <td class="text-right px-0 "><div class="d-none ">{{$profit}}</div><div class="pr-2">{{number_format($profit,2)}}</div></td>
                </tr>
                
              @endforeach
          @endforeach
          <tfoot class="border-top border-bottom border-dark">
            <tr>
              <td colspan="6"></td>
              <td colspan="1" class="text-right px-0" >รวม</td>
              <td colspan="1" id="sum_amount2" class="text-right px-0"></td>
              <td colspan="1" id="sum_price2" class="text-right px-0"></td>
              <td colspan="1" class="text-right px-0 "><div id="sum_profit2" class="pr-2"></div></td>
            </tr>
          </tfoot>
        </tbody>
      </table>
    </div>
  </div>
  {{-- end print --}}

  {{-- excel --}}
  <div id="excel_table" class="d-none">
    <table>
      <tr>
        <td colspan="10" class="text-center">รายงานยอดขายสินค้าและบริการ</td>
      </tr>
      <tr>
        <td colspan="10" class="text-center">V Dealers</td>
      </tr>
      <tr>
        <td colspan="10" class="text-center">{{DateTime::createFromFormat('Y-m-d H:i', $start_date)->format('d/m/Y H:i')}} - {{DateTime::createFromFormat('Y-m-d H:i', $end_date)->format('d/m/Y H:i')}}</td>
      </tr>
      @if($request_stock_id == 0)
        <tr>
          <td colspan="10" class="text-center">สินค้า : ทั้งหมด</td>
        </tr>
      @else
        @php
          $stock = App\Models\Stock::where('id',$request_stock_id)->first();
        @endphp
        <tr>
          <td colspan="10" class="text-center">สินค้า : {{$stock->name}}</td>
        </tr>
      @endif
      @if($childID == 0)
        <tr>
          <td colspan="10" class="text-center">ตัวแทน/ลูกทีม : ทั้งหมด</td>
        </tr>
      @else
        @php
          $user= App\Models\User::where('id',$childID)->first();
        @endphp
        <tr>
          <td colspan="10" class="text-center">ตัวแทน/ลูกทีม : {{$user->name}}</td>
        </tr>
      @endif
      <thead>
        <th>ลำดับ</th>
        <th>วันที่สั่งซื้อ</th>
        <th>เลขที่คำสั่งซื้อ</th>
        <th>รายการสินค้า</th>
        <th>ตัวแทน</th>
        <th>ต้นทุน/ชิ้น</th>
        <th>ราคาขาย/ชิ้น</th>
        <th>จำนวน</th>
        <th>ยอดขาย</th>
        <th>กำไร</th>
      </thead>
      <tbody>

        @php
            $count = 0;
        @endphp
        @if($PurchaseOrder->count() == 0)
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        @endif
        @foreach($PurchaseOrder as $PurchaseOrder_row)
            
            @php
                if($request_stock_id == 0){
                    $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->get();
                }
                else{
                    $Order = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->where('stock_id',$request_stock_id)->get();
                }
            @endphp
            @foreach($Order as $Order_row)
              @php
                  $stock = App\Models\Stock::where('id',$Order_row->stock_id)->first();
                  $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();   
                  $price_per_unit = ($Order_row->price / $Order_row->amount);
                  $profit = ($Order_row->price - ($Order_row->amount * $stock->received_price));
                  $count = $count+1;
              @endphp
              <tr>
                  <td>{{$count}}</td>
                  <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</td>
                  <td>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</td>
                  <td>{{$stock->name}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$stock->received_price}}</div></td>
                  <td>{{$price_per_unit}}</td>
                  <td>{{$Order_row->amount}}</td>
                  <td>{{$Order_row->price}}</td>
                  <td>{{$profit}}</td>
              </tr>
            @endforeach
        @endforeach
        <tfoot class="border-top border-bottom border-dark">
          <tr>
            <td colspan="8"></td>
            <td colspan="1">รวม</td>
            <td colspan="1" id="sum_profit3"></td>
          </tr>
        </tfoot>
      </tbody>
    </table>
  </div>
  {{-- end excel --}}
</div>




@endsection


@section('script')




<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{ asset('others/bootstrap-validator/validator.js') }}"></script>
<script type="text/javascript" src="{{asset('others/moment/moment-with-locales.js')}}"></script>

<script type="text/javascript" src="{{asset('others/datetime-picker/tempusdominus.js')}}"></script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> -->
<link rel="stylesheet" href="{{asset('others/datetime-picker/datetime-picker.css')}}" />



<!--  chosen -->
<script type="text/javascript" src="{{ asset('others/chosen/chosen.jquery.js') }}"></script>

<script type="text/javascript">





var sum_amount = 0;
$('.amounts').each(function(){
    sum_amount += parseFloat($(this).text());
    console.log(this);
});
$('#sum_amount').html(numeral(sum_amount).format('0,0'));
$('#sum_amount2').html(numeral(sum_amount).format('0,0'));


var sum_price = 0;
$('.prices').each(function(){
    sum_price += parseFloat($(this).text());
});
$('#sum_price').html(numeral(sum_price).format('0,0.00'));
$('#sum_price2').html(numeral(sum_price).format('0,0.00'));


var sum_profit = 0;
$('.profits').each(function(){
    sum_profit += parseFloat($(this).text());
});
$('#sum_profit').html(numeral(sum_profit).format('0,0.00'));
$('#sum_profit2').html(numeral(sum_profit).format('0,0.00'));
$('#sum_profit3').html(sum_profit);



$("#childs").chosen({
  no_results_text: "no results",
  // search_contains: true,
  // allow_duplicates:true,
  width:'100%',
  
});



$("#stocks").chosen({
  no_results_text: "no results",
  search_contains: true,
  // allow_duplicates:true,
  width:'100%',
});

</script>


<script type="text/javascript">

  function downloadExcel(){

  var url ="../api/excel/download";

  var html_table = $("#excel_table").html();
  
  $('#file_content').val(html_table);
  console.log(html_table)

  $('#convert_form').submit();
  

  }
</script>


<script type="text/javascript">


  $(document).ready( function () {


  $('#modal-btn-yes').click(function(){
      deleteStock();
  });

  $('#tb-stocks').dataTable( {
      "ordering":false,
      "info":true,
      // "dom": '<"top"i>rt<"bottom"><"clear">'
  } );


  $('#search-bar').on( 'keyup click', function () {
        // table.search($('#mySearchText').val()).draw();
        $('#tb-stocks').dataTable().fnFilter(this.value);

  } );


} );

</script>



<script type="text/javascript">


function printTable(){

  window.print();
}



$(function () {
    $('#start_date').datetimepicker({
      // format: 'd/m/Y H:i',
      locale: 'th',
      defaultDate: moment('{{$start_date}}')
    });
});

$(function () {
    $('#end_date').datetimepicker({
      // format: 'd/m/Y H:i',
      locale: 'th',
      defaultDate: moment('{{$end_date}}')
    });
});


</script>


<script>
$(document).ready( function () {
    if ($(window).width() <= 1200) {
        $('#footer').addClass('d-none');
    } else {
        $('#footer').removeClass('d-none');
    }
});
  
function checkWidth() {
    if ($(window).width() <= 1200) {
        $('#footer').addClass('d-none');
    } else {
        $('#footer').removeClass('d-none');
    }
}
$(window).resize(checkWidth);
</script>




@endsection