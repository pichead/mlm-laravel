@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="mx-auto col-12 p-0">
        @include('inc.error')
      </div>

    <div class="row clearfix">
        <h3 class="mx-auto">ชำระเงิน</h3>
    </div>
    <br>
    

        @php 
            $buyer = App\Models\User::where('id',$Payment->buyer_id)->first();
            $status = App\Models\PurchaseOrderStatus::where('id',$Payment->status_id)->first();         

        @endphp

        <div class="row">
            <div class="col-11 col-md-8 border border-dark mx-auto p-5 rounded" style="background-color: white;">
                <div class="row">
                    <div class="col-12  mx-auto " style="background-color: white;">
                        <div class="mx-2">
                            <div class="form-row">
                                <div class="col my-auto">สถานะการสั่งซื้อ : {{$status->name}}</div>
                                <div class="col clearfix">
                                    <button class="btn float-right green-btn" data-toggle="modal" data-target="#status" type="button">อัพเดตสถานะ</button>
                                </div>
                                <div class="modal" id="status">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{asset('PaymentStatusUpdate').'/'.$Payment->id}}"  enctype="multipart/form-data">
                                            {{method_field('PUT')}}
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title">สถานะการสั่งซื้อ</h5>
                                                <button class="close " data-dismiss="modal">×</button>
                                                </div>
                                                <div class="modal-body m-3">
                                                    <div class="form-row">
                                                        <div>สถานะการสั่งซื้อปัจุบัน : {{$status->name}}</div>
                                                        <select class="custom-select my-3" id="inlineFormCustomSelect"  name="status">
                                                            <option hidden value="{{$status->id}}">{{$status->name}}</option>
                                                            <option value="2">ยินยันแล้ว</option>
                                                            <option value="1">รอการยืนยัน</option>
                                                            <option value="3">ยกเลิก</option>
                                                            <option value="4">คืนเงิน</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-row">
                                                        <textarea class="form-control" id="message" rows="3" name="seller_comment">{{$Payment->seller_comment}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"  class="btn green-btn">บันทึก</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-group">
                                วันที่สั่งซื้อ : {{DateTime::createFromFormat('Y-m-d H:i:s', $Payment->created_at)->format('d/m/Y H:i:s')}}
                            </div>
                            <div class="form-group">
                                <label>เลขที่สั่งซื้อสินค้า</label>
                                <input class="form-control" type="number" value="{{$Payment->purchase_no}}" readonly>
                            </div>

                            <table id="tb-stocks" class="col-12 table-mobile table-stocks mt-2 mb-4">
                                <thead>
                                    <tr class="row m-0 table-success py-1">
                                        <td class="col-12 col-xl-1  text-lg-center sorting_disabled" >No.</td>
                                        <td class="col-12 col-xl text-lg-center sorting_disabled" >รายการสินค้า</td>
                                        <td class="col-12 col-xl text-lg-center sorting_disabled" >จำนวน</td>
                                        <td class="col-12 col-xl text-lg-center sorting_disabled">ราคา</td>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                  @foreach($Order as $Order_row)
                                    @php
                                        $name = App\Models\Stock::where('id',$Order_row->stock_id)->first();                   
                                    @endphp
                                    <tr role="row" class="row m-0 py-1">
                                      <td class="col-12 col-xl-1 text-lg-center">{{$loop->index+1}}</td>
                                      <td class="col-12 col-xl ">
                                          <span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$name->name}}
                                      </td>
                                      <td class="col-12 col-xl text-lg-right">{{number_format($Order_row->amount,0)}}</td>
                                      
                                        @foreach($priceitem as $price_row)
                                            @if($Order_row->amount >= $price_row->start_total && $Order_row->amount <= $price_row->end_total && $price_row->stock_id == $Order_row->stock_id)
                                                @php
                                                    $amount = $Order_row->amount;
                                                    $priceperunit = $price_row->price;
                                                    $total = $amount * $priceperunit;

                                                @endphp
                                                
                                                <td class="col-12 col-xl text-lg-right">{{number_format($total,2)}}</td>
                                            @endif
                                        @endforeach
                                      
                                    </tr>
                                  @endforeach
                                </tbody>
                                <tfoot>
                                    <td class="col-12 mt-2 text-right font-weight-bold">ยอดสั่งซื้อ(บาท) {{number_format($Price,2)}}</td>
                                </tfoot>
                            </table>

                            <div class="form-group">
                                <label>ชื่อผู้ซื้อ</label>
                                <input class="form-control" type="fullname" value="{{$buyer->name}}" readonly/>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="tel" class="form-control" value="0{{$buyer->tel}}" readonly/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" value="{{$buyer->email}}" readonly/>
                                </div>
                            </div>                    
                            <div class="form-group">
                                <label>ธนาคารผู้รับโอน</label>
                                @php
                                if(isset($Payment->user_bank_id)){
                                    $bank_acc = App\Models\UserBank::where('id',$Payment->user_bank_id)->first();
                                    $bank = App\Models\Bank::where('id',$bank_acc->bank_id)->first();
                                }
                                @endphp
                                @if(isset ($bank->name))
                                <input readonly="readonly" class="form-control" value="{{$bank->name}}"/>
                                @else
                                <input readonly="readonly" class="form-control" value="-"/>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>เลขบัญชีธนาคาร</label>
                                @if(isset ($bank_acc->account_no))
                                <input readonly="readonly" class="form-control" value="{{$bank_acc->account_no}}"/>
                                @else
                                <input readonly="readonly" class="form-control" value="-"/>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>วันที่ชำระเงิน</label>
                                    @if(isset($Payment->pay_date))
                                    <input readonly="readonly" class="form-control" value="{{$Payment->pay_date->format('d/m/Y')}}"/>
                                    @else
                                    <input readonly="readonly" class="form-control"  value="-"/>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>เวลา</label>
                                    @if(isset($Payment->pay_time))
                                    <input readonly="readonly" class="form-control" type="time" value="{{$Payment->pay_time->format('H:i')}}"/>
                                    @else
                                    <input readonly="readonly" class="form-control" value="-"/>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>ยอดสั่งซื้อ</label>
                                    @php
                                    $price = App\Models\Order::where('purchase_order_id',$Payment->id)->sum('price');
                                    @endphp
                                    <input class="form-control" value="{{number_format($price,2)}}" readonly/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>ยอดโอน</label>
                                    @if(isset($Payment->pay_price))
                                    <input class="form-control" name="pay_price" value="{{number_format($Payment->pay_price,2)}}" readonly/>
                                    @else
                                    <input class="form-control" name="pay_price" value="-" readonly/>
                                    @endif
                                </div>
                            </div>
                            @php
                            $filecheck = App\Models\PurchaseOrderImage::where('purchase_order_id',$Payment->id)->first(); 
                            @endphp
                            <div class="form-group">
                                @if(isset($filecheck->id))
                                <label>ไฟล์แนบ</label>
                                @endif
                                @foreach($file as $file_row)
                                    <div class="">
                                        <a target="_new" href="{{asset('app_v/public/uploads').'/'.$file_row->name.'/'}}">{{$loop->index+1}}. {{$file_row->name}}</a>
                                    </div>
                                    <br>

                                @endforeach
                            </div>
                            @if( $Payment->buyer_comment != [])
                            <div class="form-row">
                                <label for="message">เพิ่มเติม</label>
                                <input class="form-control"  value="{{$Payment->buyer_comment}}" readonly/>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

    
        <br>
        <br>
        </div>
</div>

@endsection
@section('script')
<script>
$('#status').on('hidden.bs.modal', function () {
 location.reload();
})


// $(function(){
//     $("#addprice").click(function(){
//         $(".btnaddrow").before('<tr role="row" class="price row m-0 mb-5 mb-xl-0"><td class="col col-xl text-lg-center"><div class="row "><input class="col-3 mx-auto">-<input class="col-3 mx-auto"></div></td><td class="col col-xl text-lg-center"><input class="col-4"></td><td class="col-1 col-xl-1 text-lg-center"><div class="delrow">X</div></td></tr>');
//     })
// })
</script>
@endsection
