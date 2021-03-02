<table class="table table-borderless d-none">
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
        <tr>
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
                <td class="text-right px-0 "><div class="d-none amounts">{{$Order_row->amount}}</div><div class="pl-2">{{number_format($Order_row->amount,0)}}</div></td>
                <td class="text-right px-0 "><div class="d-none prices">{{$Order_row->price}}</div><div class="pl-2">{{number_format($Order_row->price,2)}}</div></td>
                <td class="text-right px-0 "><div class="d-none profits">{{$profit}}</div><div class="pr-2">{{number_format($profit,2)}}</div></td>
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