@extends('layouts.web')

@section('content')
<br>
<div class="container col-11 col-md-11 col-xl-10">
    <div class="row">
      <div class="col-md-4 h3 pl-0">รายการโอน</div>
    </div>
    <br>
    @foreach($Payment as $Payment_row)
    <div class="row mb-3" data-toggle="modal" data-target="#{{$Payment_row->id}}">
      <div class="col-12 mx-auto">
        <div class="row py-3 border border-secondary" style="background-color:white;">
          <div class="col-12 col-md-2 my-md-auto my-1">
            Payment ID: {{$Payment_row->purchase_no}}
          </div>
          <div class="col-12 col-md my-md-auto my-1">
            <span class="d-md-none">วันที่ : </span>{{$Payment_row->created_at}}
          </div>
          @php
              $price = App\Models\Order::where('purchase_order_id',$Payment_row->id)->sum('price');                   
          @endphp
          <div class="col-12 col-md my-md-auto my-1">
            รวมทั้งหมด {{$price}} บาท
          </div>
          @php
              $status = App\Models\PurchaseOrderStatus::where('id',$Payment_row->status_id)->first();         
          @endphp
          <div class="col-12 col-md-2 my-md-auto my-1">
            สถานะ : {{$status->name}}
          </div>
          <div class="col-5 col-md-2 my-md-auto my-1">
             <a class="btn col-12" href="{{asset('payment'.'/'.$Payment_row->id)}}" style="background-color: #72CAFF;color:white">แจ้งโอน</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach

    @foreach($Payment as $Payment_row)
    <form method="POST" action="{{asset('PaymentStatusUpdate').'/'.$Payment_row->id}}"  enctype="multipart/form-data">
      {{method_field('PUT')}}
      @csrf
      <div class="modal fade" id="{{$Payment_row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content p-2">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Payment ID: {{$Payment_row->purchase_no}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>

            </div>
            <div class="modal-body">
              <div class="">วันที่สั่งซื้อ : {{$Payment_row->created_at}}</div>
              <br>
              <div class="row">
                <div class="col-12  mx-auto " style="background-color: white;">
                    <div class="mx-2">
                        <div class="form-group">
                            <label>เลขที่สั่งซื้อสินค้า</label>
                            <input class="form-control" type="number" value="{{$Payment_row->purchase_no}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>ชื่อผู้ซื้อ</label>
                            
                              @php 
                                $name = App\Models\User::where('id',$Payment_row->buyer_id)->first()
                              @endphp

                              <input class="form-control" type="fullname" value="{{$name->name}}" readonly/>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>เบอร์ติดต่อ</label>
                                <input type="tel" class="form-control" value="0{{$name->tel}}" readonly/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>E-mail</label>
                                <input type="email" class="form-control" value="{{$name->email}}" readonly/>
                            </div>
                        </div>                    
                        <div class="form-group">
                            <label>โอนไปที่ธนาคาร</label>
                            @php
                              $bank = App\Models\Bank::where('id',$Payment_row->user_bank_id)->first();
                              $bank_acc = App\Models\UserBank::where('user_id',$Payment_row->seller_id)->where('bank_id',$Payment_row->user_bank_id)->first();
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
                                @if(isset($Payment_row->pay_date))
                                <input readonly="readonly" class="form-control" type="date" value="{{$Payment_row->pay_date->format('Y-m-d')}}"/>
                                @else
                                <input readonly="readonly" class="form-control"  value="-"/>
                                @endif
                              </div>
                            <div class="form-group col-md-6">
                                <label>เวลา</label>
                                @if(isset($Payment_row->pay_time))
                                <input readonly="readonly" class="form-control" type="time" value="{{$Payment_row->pay_time->format('H:i')}}"/>
                                @else
                                <input readonly="readonly" class="form-control" value="-"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>ราคาสินค้า</label>
                                @php
                                  $price = App\Models\Order::where('purchase_order_id',$Payment_row->id)->sum('price');
                                @endphp
                                <input class="form-control" value="{{$price}}" readonly/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>จำนวนเงินที่โอน</label>
                                @if(isset($Payment_row->pay_price))
                                <input class="form-control" name="pay_price" value="{{$Payment_row->pay_price}}" readonly/>
                                @else
                                <input class="form-control" name="pay_price" value="-" readonly/>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                          @php
                            $status = App\Models\PurchaseOrderStatus::where('id',$Payment_row->status_id)->first();         
                          @endphp
                          <select class="custom-select mr-sm-2 " id="inlineFormCustomSelect"  name="status">
                            <option hidden>{{$status->name}}</option>
                            <option value="2">ยินยันแล้ว</option>
                            <option value="1">รอการยืนยัน</option>
                            <option value="3">ยกเลิก</option>
                          </select>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
              <button type="submit" class="btn btn-primary">อัพเดต</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    @endforeach

</div>
@endsection
