@extends('layouts.web')

@section('content')
<br>
<div class="container mb-5">
    <div class="row clearfix">
        <h3 class="mx-auto">ชำระเงิน</h3>
    </div>
    <br>
    <form method="POST" class="" action="{{asset('PaymentUpdate').'/'.$Payment->id}}"  enctype="multipart/form-data">
        {{method_field('PUT')}}
        @csrf
        <div class="row">
            <div class="col-11 col-md-8  border border-dark mx-auto p-5 rounded" style="background-color: white;">
                <div class="mx-2">
                    <div class="form-group">
                        <label>เลขที่สั่งซื้อสินค้า</label>
                        <input class="form-control"  value="{{number_format($Payment->purchase_no,0,",","-")}}" readonly>
                    </div>

                    <table id="tb-stocks" class="col-12 table-mobile table-stocks mt-2 mb-4">
                        <thead>
                            <tr class="row m-0 table-success py-1">
                                <td class="col-12 col-xl-1  text-lg-center sorting_disabled" >No.</td>
                                <td class="col-12 col-xl text-lg-center sorting_disabled" >รายการสินค้า</td>
                                <td class="col-12 col-xl text-lg-center sorting_disabled" >จำนวน</td>
                                <td class="col-12 col-xl text-lg-center sorting_disabled" >ราคา/ชิ้น</td>
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
                                        <td class="col-12 col-xl text-lg-right">{{number_format($priceperunit,2)}}</td>
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
                        <input class="form-control" type="fullname" value="{{$user->name}}" readonly/>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>เบอร์ติดต่อ</label>
                            <input type="tel" class="form-control" value="0{{$user->tel}}" readonly/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>E-mail</label>
                            <input type="email" class="form-control" value="{{$user->email}}" readonly/>
                        </div>
                    </div>
                @if(isset($Payment->user_bank_id))
                    @php
                        $bankname = App\Models\UserBank::where('id',$Payment->user_bank_id)->first();
                        $bank = App\Models\Bank::where('id',$bankname->bank_id)->first();
                    @endphp
                    <div class="form-group ">
                        <label>ธนาคารผู้รับโอน</label>
                        <input class="d-none" value="{{$Payment->user_bank_id}}"  />
                        <input type="text" class="form-control" value="{{$bank->name}} ({{$bankname->name}})" readonly/>
                    </div>
                    <div class="form-group">
                        <label>เลขบัญชีธนาคาร</label>
                        <input readonly="readonly" value="{{$bankname->account_no}}" class="form-control" required/>
                    </div>
                @else
                    <div class="form-group was-validated">
                        <label>ธนาคาร</label>
                        <select id="bank" class="form-control" name="bank_id" required> 
                            <option hidden disabled selected value>เลือกธนาคาร</option>
                            @foreach($toplinebank as $Bank_row)
                                @php
                                    $bankname = App\Models\Bank::where('id',$Bank_row->bank_id)->first('name');
                                @endphp
                                <option value="{{$Bank_row->id}}" data-no="{{$Bank_row->account_no}}">{{$bankname->name}} ({{$Bank_row->name}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <label>เลขบัญชีธนาคาร</label>
                        <input readonly id="no" class="form-control" type="number" required/>
                    </div>
                @endif


                    <div class="form-row">

                        @if(isset($Payment->pay_date))
                        <div class="form-group col-md-6">
                            <label>วันที่ชำระเงิน</label>
                            <input   class="form-control " value="{{DateTime::createFromFormat('Y-m-d H:i:s', $Payment->pay_date)->format('d/m/Y ')}}" readonly/>
                        </div>
                        @else
                        <div class="form-group col-md-6 was-validated">
                            <label>วันที่ชำระเงิน</label>
                            <input type="date" name="pay_date" class="form-control" max = <?php echo date('Y-m-d'); ?> required/>
                        </div>
                        @endif

                        @if(isset($Payment->pay_time))
                        <div class="form-group col-md-6">
                            <label>เวลา</label>
                            <input  class="form-control" value="{{DateTime::createFromFormat('Y-m-d H:i:s', $Payment->pay_time)->format('H:i:s ')}}" readonly/>
                        </div>
                        @else
                        <div class="form-group col-md-6 was-validated">
                            <label>เวลา</label>
                            <input type="time" name="pay_time" class="form-control" required/>
                        </div>
                        @endif

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>ยอดสั่งซื้อ</label>
                            <input class="form-control" value="{{number_format($Price,2)}}" readonly/>
                        </div>
                        @if(isset($Payment->pay_price))
                        <div class="form-group col-md-6">
                            <label>ยอดโอน</label>
                            <input class="d-none"  value="{{$Payment->pay_price}}">
                            <input class="form-control" value="{{number_format($Payment->pay_price,2)}}" readonly/>
                        </div>
                        @else
                        <div class="form-group col-md-6 was-validated">
                            <label>ยอดโอน</label>
                            <input class="form-control" name="pay_price" min="{{$Price}}" type="number" step="0.01" onclick="this.select()" placeholder="ระบุจำนวนเงินที่โอนเข้ามา" required/>
                        </div>
                        @endif
                    </div>
                    @php
                        $files = App\Models\PurchaseOrderImage::where('purchase_order_id',$Payment->id)->get();
                        $filecheck = App\Models\PurchaseOrderImage::where('purchase_order_id',$Payment->id)->first(); 
                    @endphp
                    @if(isset($filecheck->purchase_order_id))
                    <div class="form-group">
                        <label  for="file">แนบรูปภาพ</label>
                        <br>
                        @foreach($files as $file_row)
                            <a target="_new" href="{{asset('app_v/public/uploads').'/'.$file_row->name.'/'}}">{{$loop->index+1}}. {{$file_row->name}}</a>
                        <br>
                        @endforeach
                        <br>
                        <input id="file" type="file" name="file[]" class="form-control-file" accept=".jpg,.gif,.png" multiple >
                        {{-- <input id="file" type="file" name="file" class="form-control-file" accept=".jpg,.gif,.png"> --}}
                        <div id="user-faild-msg" class="mt-2 alert alert-danger fade d-none">
                            <span  id="json-faild-message"></span>
                            <button  type="button" class="close" aria-label="Close" >
                                <span id="closebtn" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @else
                    <div class="form-group">
                        <label for="file">แนบรูปภาพ</label>
                        <input id="file" type="file" name="file[]" class="form-control-file" accept=".jpg,.gif,.png" multiple >
                        {{-- <input id="file" type="file" name="file" class="form-control-file" accept=".jpg,.gif,.png" > --}}
                        <div id="user-faild-msg" class="mt-2 alert alert-danger fade d-none">
                            <span  id="json-faild-message"></span>
                            <button  type="button" class="close" aria-label="Close" >
                                <span id="closebtn" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    @if(isset($filecheck->purchase_order_id))
                    <div class="form-group  mt-2">
                        <label for="message">เพิ่มเติม</label>
                        <textarea class="form-control no-validate" rows="3" name="buyer_comment">{{$Payment->buyer_comment}}</textarea>
                    </div>
                    @else 
                    <div class="form-group mt-2">
                        <label for="message">เพิ่มเติม</label>
                        <textarea class="form-control no-validate" rows="3" name="buyer_comment"></textarea>
                    </div>
                </div>
                    @endif
                    
                    
                </div>
            </div>
            <br>
            <br>

            <div class="mx-auto d-flex justify-content-center">
                <button class="btn px-4 mx-1 purple-btn" type="submit">บันทึก</button>
                <a class="btn px-4 mx-1 red-btn" href="{{asset('BuyList')}}">ยกเลิก</a>
            </div>

        </div>

    
        
    </form>

    
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function(){
    $("#bank").change(function(){
        var no=$("#bank option:selected").data("no");
        console.log(no);
        $("#no").val(no);
    })


})


    $(document).ready(function(){
        $("#closebtn").click(function () {
            $('#user-faild-msg').addClass('d-none');  
            $('#user-faild-msg').removeClass('show');
        });
        $("#file").click(function () {
            $('#user-faild-msg').addClass('d-none');  
            $('#user-faild-msg').removeClass('show');
        });
    });
</script>

<script>
    
    $('document').ready(()=>{

        $("input[type='file']").change(function () {
            var count_file = this.files.length;

            console.log(count_file);

            for(i = 0; i < count_file; i++){
                if(this.files[i].size > 1200000) {
                    $('#json-faild-message').text('รูปภาพมีขนาดใหญ่เกินไป อัพโหลดรูปภาพใหม่ขนาดไม่เกิน 1MB');
                    $('#user-faild-msg').removeClass('d-none');         
                    $('#user-faild-msg').addClass('show');        
                    $(this).val('');
                }
            }

            
        });

    });
</script>
