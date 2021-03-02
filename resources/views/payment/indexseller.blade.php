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
  <div class="container  mb-3 col-12">
    <div class="mx-auto col-12 p-0">
      @include('inc.error')
    </div>
    <div class="form-row mx-0 my-auto">
      <div class="col-12 my-auto px-0 h3">ประวัติการขาย</div>
      
      <div class="col-12 p-4 p-md-5 mt-4 mx-0 rounded" style="background-color: white">

        <form action="{{asset('payment/find')}}" method="post">
                @csrf
                <div class="form-wrapper myboxShadow">
                    <div class="form-row">
                            <div class="form-group col-xl col-md-6">
                                <label>สถานะ</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" {{($request_status_id  == 0) ? 'selected':''}}>ดูทั้งหมด</option>
                                    @foreach($status as $status_row)
                                    <option value="{{$status_row->id}}" {{($request_status_id == $status_row->id) ? 'selected':''}}>{{$status_row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl col-md-6">
                                <label>ตัวแทน</label>
                                <select id="child" name="child_id" class="form-control">
                                    <option value="0" {{($childID == 0) ? 'selected':''}}>ดูทั้งหมด</option>
                                    @foreach($child as $child_row)
                                    <option value="{{$child_row->id}}" {{($childID == $child_row->id) ? 'selected':''}}>{{$child_row->name}}</option>
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

                    <div class="text-center mt-4">
                        <button type="submit" id="create-user-btn" name="create" class="btn col-xl-1 col-md-3 col-5 blue-btn" >ค้นหา</button>
                        <button type="button" id="reset-user-btn" name="reset" class="btn col-xl-1 col-md-3 col-5 red-btn" onclick="location.href='{{asset('SaleList')}}';" >รีเซ็ต</button>
                    </div>
                </div>

        </form>
      </div>
    

      <div class="form-row col-12 mx-0 mb-3">
        <div class="col-12 col-md-8 col-lg-10 p-0 mt-3">
            <div class="col-12 pl-lg-0 px-0">
            <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
            </div>
        </div>

        <form method="POST" id="convert_form" class="col-12 col-md-4 col-lg-2 mt-3 d-flex justify-content-center px-0" action="{{asset('excel/download')}}">
            @csrf
            <input type="hidden" name="file_name" id="file_name" value="รายงานประวัติการขายสินค้าและบริการ" />
            <input type="hidden" name="file_content" id="file_content" />
            <button class="btn col ml-md-3  mr-2 mr-md-auto green-btn" type="button" id="btn_convert_form" onclick="downloadExcel()" name="button">Excel</button>
          
            <button class="btn col ml-md-3 purple-btn" href="#" type="button" onclick="printTable()">พิมพ์</button>
        </form> 

    </div>

      <div class="tb-search-wrapper col-12 px-0">
        <table id="tb-stocks" class="re-table table-mobile table-stocks mb-0 mb-md-3">
          <thead>
              <tr>
                  <th class="text-lg-center sorting_disabled" scope="col">ลำดับ</th>
                  <th class="text-lg-center sorting_disabled" scope="col">เลขคำสั่งซื้อ</th>
                  <th class="text-lg-center sorting_disabled" scope="col">วันที่</th>
                  <th class="text-lg-center sorting_disabled" scope="col">ตัวแทน</th>
                  <th class="text-lg-center sorting_disabled" scope="col">ชื่อบัญชี</th>
                  {{-- <th class="text-lg-center sorting_disabled" scope="col">ธนาคารที่โอน</th>
                  <th class="text-lg-center sorting_disabled" scope="col">เลขบัญชี</th> --}}
                  <th class="text-lg-right sorting_disabled" scope="col">ยอดสั่งซื้อ</th>
                  <th class="text-lg-center sorting_disabled" scope="col">สถานะ</th>
                  <th class="text-lg-center sorting_disabled" scope="col"></th>
              </tr>
          </thead>
          <tbody>
            @foreach($PurchaseOrder as $PurchaseOrder_row)
              @php
                $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();
                $price = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->sum('price');               
                $status = App\Models\PurchaseOrderStatus::where('id',$PurchaseOrder_row->status_id)->first();
                if(isset($PurchaseOrder_row->user_bank_id)){
                  $user_bank = App\Models\UserBank::where('id',$PurchaseOrder_row->user_bank_id)->first();
                  $bank_name =  App\Models\Bank::where('id',$user_bank->bank_id)->first();
                }
              @endphp
              <tr>
                <td class="text-xl-center py-auto px-0"><div class="pl-2 pl-lg-0">{{$loop->index+1}}</div></td>
                <td class="text-xl-left py-auto px-0">
                  <div class="pl-2"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</div>
                </td>
                <td class="text-xl-left py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">วันที่ : </span>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</div></td>
                <td class="text-xl-left py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">ตัวแทน : </span>{{$user->name}}</td>
                <td class="text-xl-center py-auto px-0">
                  <div class="pl-2">
                    @if(isset($PurchaseOrder_row->user_bank_id))
                    <span class="stock-extra-unit">ชื่อบัญชี : </span>{{$user_bank->name}}
                    @else
                      ไม่ระบุ
                    
                    @endif
                  </div>
                </td>

                <td class="text-xl-right py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">ราคา : </span>{{number_format($price,2)}}</div>
                </td>
                <td class="text-xl-center py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">สถานะ : </span>{{$status->name}}</div></td>
                <td class="text-center px-0">
                  <a class="btn blue-btn py-auto btn-sm" href="{{asset('paymentdetail'.'/'.$PurchaseOrder_row->id)}}" >รายละเอียด</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="print-wrapper">

  <h4 class="text-center">V Dealers</h4>
  <h4 class="text-center">รายงานประวัติการขายสินค้าและบริการ</h4>
  <h5 class="text-center">{{DateTime::createFromFormat('Y-m-d H:i', $start_date)->format('d/m/Y H:i')}} - {{DateTime::createFromFormat('Y-m-d H:i', $end_date)->format('d/m/Y H:i')}}</h5>

  <div class="mx-4 mt-5" style="font-size: 12px">
      <table class="table table-borderless">
      <thead class="border-top border-bottom border-dark">
        <th class="text-center" scope="col">No.</th>
                  <th class="text-center" scope="col">เลขคำสั่งซื้อ</th>
                  <th class="text-center" scope="col">วันที่</th>
                  <th class="text-center" scope="col">ตัวแทน</th>
                  <th class="text-center" scope="col">ชื่อบัญชี</th>
                  {{-- <th class="text-lg-center sorting_disabled" scope="col">ธนาคารที่โอน</th>
                  <th class="text-lg-center sorting_disabled" scope="col">เลขบัญชี</th> --}}
                  <th class="text-right" scope="col">ยอดสั่งซื้อ</th>
                  <th class="text-center" scope="col">สถานะ</th>
      </thead>
      <tbody class="border-bottom border-dark">
        @if($PurchaseOrder->count() == 0)
        <tr>
          <td colspan="10" class="text-center">
              ไม่มีรายการ
          </td>
        </tr>
        @endif
        @foreach($PurchaseOrder as $PurchaseOrder_row)
              @php
                $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();
                $price = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->sum('price');               
                $status = App\Models\PurchaseOrderStatus::where('id',$PurchaseOrder_row->status_id)->first();
                if(isset($PurchaseOrder_row->user_bank_id)){
                  $user_bank = App\Models\UserBank::where('id',$PurchaseOrder_row->user_bank_id)->first();
                  $bank_name =  App\Models\Bank::where('id',$user_bank->bank_id)->first();
                }
              @endphp
              <tr>
                <td class="text-center py-auto px-0"><div class="pl-2">{{$loop->index+1}}</div></td>
                <td class="text-left py-auto px-0">
                  <div class="pl-2"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</div>
                </td>
                <td class="text-left py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">วันที่ : </span>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</div></td>
                <td class="text-left py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">ตัวแทน : </span>{{$user->name}}</td>
                <td class="text-center py-auto px-0">
                  <div class="pl-2">
                    @if(isset($PurchaseOrder_row->user_bank_id))
                    <span class="stock-extra-unit">ชื่อบัญชี : </span>{{$user_bank->name}}
                    @else
                      ยังไม่ได้ใส่ธนาคาร
                    
                    @endif
                  </div>
                </td>
                {{-- <td class="text-xl-center py-auto px-0">
                  <div class="pl-2">
                    @if(isset($PurchaseOrder_row->user_bank_id))
                    <span class="stock-extra-unit">ธนาคารที่โอน : </span>{{$bank_name->name}}
                    
                    @else
                      ยังไม่ได้ใส่ธนาคาร
                    
                    @endif
                  </div>
                </td>
                <td class="text-xl-center py-auto px-0">
                  <div class="pl-2">
                    @if(isset($PurchaseOrder_row->user_bank_id))
                      <span class="stock-extra-unit">เลขบัญชี : </span>{{$user_bank->account_no}}
                    
                    @else
                      ไม่ได้ใส่เลขบัญชี
                    
                    @endif
                  </div>
                </td> --}}
                <td class="text-right py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">ราคา : </span>{{number_format($price,2)}}</div>
                </td>
                <td class="text-center py-auto px-0"><div class="pl-2"><span class="stock-extra-unit">สถานะ : </span>{{$status->name}}</div></td>
              </tr>
            @endforeach
      </tbody>
    </table>
  </div>
</div>

<div id="excel_table" class="d-none">
  <table>
    <tr>
        <td colspan="7" class="text-center">รายงานยอดขายสินค้าและบริการ</td>
      </tr>
      <tr>
        <td colspan="7" class="text-center">V Dealers</td>
      </tr>
      <tr>
        <td colspan="7" class="text-center">{{DateTime::createFromFormat('Y-m-d H:i', $start_date)->format('d/m/Y H:i')}} - {{DateTime::createFromFormat('Y-m-d H:i', $end_date)->format('d/m/Y H:i')}}</td>
      </tr>
      @if($request_status_id  == 0)
        <tr>
          <td colspan="7" class="text-center">สถานะ : ทั้งหมด</td>
        </tr>
      @else
        @php
          $status = App\Models\PurchaseOrderStatus::where('id',$request_status_id)->first();
        @endphp
        <tr>
          <td colspan="7" class="text-center">สถานะ : {{$status->name}}</td>
        </tr>
      @endif
      @if($childID == 0)
        <tr>
          <td colspan="7" class="text-center">ตัวแทน/ลูกทีม : ทั้งหมด</td>
        </tr>
      @else
        @php
          $user= App\Models\User::where('id',$childID)->first();
        @endphp
        <tr>
          <td colspan="7" class="text-center">ตัวแทน/ลูกทีม : {{$user->name}}</td>
        </tr>
      @endif
    <thead>
        <tr>
            <th>No.</th>
            <th>เลขคำสั่งซื้อ</th>
            <th>วันที่</th>
            <th>ตัวแทน</th>
            <th>ชื่อบัญชี</th>
            <th>ยอดสั่งซื้อ</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>
      @foreach($PurchaseOrder as $PurchaseOrder_row)
        @php
          $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();
          $price = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->sum('price');               
          $status = App\Models\PurchaseOrderStatus::where('id',$PurchaseOrder_row->status_id)->first();
          if(isset($PurchaseOrder_row->user_bank_id)){
            $user_bank = App\Models\UserBank::where('id',$PurchaseOrder_row->user_bank_id)->first();
            $bank_name =  App\Models\Bank::where('id',$user_bank->bank_id)->first();
          }
        @endphp
        <tr>
          <td>{{$loop->index+1}}</td>
          <td>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}</td>
          <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}</td>
          <td>{{$user->name}}</td>
          <td>
              @if(isset($PurchaseOrder_row->user_bank_id))
                {{$user_bank->name}}
              @else
                ยังไม่ได้ใส่ธนาคาร
              @endif

          </td>

          <td>{{$price}}</td>
          <td>{{$status->name}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>


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




  $("#child").chosen({
    no_results_text: "no results",
    // search_contains: true,
    // allow_duplicates:true,
    width:'100%',
    
  });
  
  
  
  $("#status").chosen({
    no_results_text: "no results",
    search_contains: true,
    // allow_duplicates:true,
    width:'100%',
  });
  
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

  function downloadExcel(){

  var url ="../api/excel/download";

  var html_table = $("#excel_table").html();
  
  $('#file_content').val(html_table);
  console.log(html_table)

  $('#convert_form').submit();
  

  }
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
@endsection
