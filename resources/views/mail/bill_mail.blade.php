<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>


<body>
    <div class="mx-2">
        <h2 class="text-center" style="color: red">V Dealer</h2>

        <p>เรื่อง {{ $data['subject'] }} </p>

        <p>คุณ {{ $data['downline'] }} ได้ทำการแจ้งโอนเงิน รายละเอียดดังนี้</p>
        <p>เลขที่สั่งซื้อสินค้า : {{ $data['purchase_no'] }}</p>

        <br>

        <p>รายการสินค้า</p>
        <table class="table col-11 mx-auto">
            <thead class="table-success">
                <tr>
                    <th>No.</th>
                    <th>รายการสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
            @foreach($Order as $Order_row)
                @php
                    $name = App\Models\Stock::where('id',$Order_row->stock_id)->first();                   
                @endphp
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$name->name}}</td>
                    <td>{{number_format($Order_row->amount,0)}}</td>
                    @foreach($priceitem as $price_row)
                        @if($Order_row->amount >= $price_row->start_total && $Order_row->amount <= $price_row->end_total && $price_row->stock_id == $Order_row->stock_id)
                            @php
                                $amount = $Order_row->amount;
                                $priceperunit = $price_row->price;
                                $total = $amount * $priceperunit;
                            @endphp
                            <td>{{number_format($total,2)}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
                <tr>
                    <td colspan="4" class="text-right">ยอดสั่งซื้อ(บาท) {{number_format($Price,2)}}</td>
                </tr>
            </tbody>
        </table>

        <br>

        <p>โอนไปที่ธนาคาร : {{ $data['bank'] }} เลขบัญชี {{ $data['bank_acc'] }}</p>
        <p>วันที่ชำระเงิน : {{ $data['time'] }}</p>
        <p>ยอดสั่งซื้อ : {{ number_format($data['price'],2) }}</p>
        <p>ยอดโอน : {{ number_format($data['pay_price'],2) }}</p>


        <p>หากคุณเป็นสมาชิก V Dealer สามารถ <span><a href="{{'localhost'.'/'.'downline'.'/'.'public'.'/'.'payment'.'/'.$data['purchase_id']}}">คลิกที่นี่</a></span> เพื่อดูรายละเอียด</p>
        
    </div>
</body>
</html>