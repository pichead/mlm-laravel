<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\Price;
use App\Models\User;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\UserTree;
use App\Models\UserLevel;
use App\Models\PurchaseOrder;
use App\Models\UserMailForward;
use App\Models\Order;
use App\Models\PurchaseOrderStatus;
use App\Models\PurchaseOrderImage;
use DateTime;
use Auth;
use DB;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexsale()
    {   
        
        $myid = Auth::user()->id;
        $mylevel = Auth::user()->level_id;


        $date_time = new DateTime();
        $datetime_pattern = $date_time->format('Y-m-d');
        $end_date =  new DateTime($datetime_pattern.' 20:00:00');
        $start_date = new DateTime($datetime_pattern.' 07:00:00');
        
        // status
        $request_status_id = 0;
        $status = PurchaseOrderStatus::get();
        // status end


        $childID = 0;
        $child_id = UserTree::where('parent_id',$myid)->get('child_id');
        $array_child_id = [];
        foreach($child_id as $childid){
            array_push($array_child_id,$childid->child_id);
        }


        $stock = Stock::where('visible',1)->get();
        $child = User::whereIn('id',$array_child_id)->get();
        $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$array_child_id)->whereBetween('created_at',[$start_date,$end_date])->get();
        $file = PurchaseOrderImage::get();


        $Order = Order::get();
        $child_id = UserTree::where('parent_id',$myid)->get('child_id');


        return view('payment.indexseller')->with('PurchaseOrder',$PurchaseOrder)
        ->with('Order',$Order)
        ->with('request_status_id',$request_status_id)
        ->with('status',$status)
        ->with('childID',$childID)
        ->with('child',$child)
        ->with('file',$file)
        ->with('start_date',$start_date->format('Y-m-d H:i'))
        ->with('end_date',$end_date->format('Y-m-d H:i'));



    }

    public function indexbuy()
    {   
        
        $myid = Auth::user()->id;
        $mylevel = Auth::user()->level_id;


        $date_time = new DateTime();
        $datetime_pattern = $date_time->format('Y-m-d');
        $end_date =  new DateTime($datetime_pattern.' 20:00:00');
        $start_date = new DateTime($datetime_pattern.' 07:00:00');
        
        // status
        $request_status_id = 0;
        $status = PurchaseOrderStatus::get();
        // status end


        $childID = 0;
        $child_id = UserTree::where('parent_id',$myid)->get('child_id');
        $array_child_id = [];
        foreach($child_id as $childid){
            array_push($array_child_id,$childid->child_id);
        }


        $stock = Stock::where('visible',1)->get();
        $child = User::whereIn('id',$array_child_id)->get();
        // $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$array_child_id)->whereBetween('created_at',[$start_date,$end_date])->get();
        $file = PurchaseOrderImage::get();


        $Order = Order::get();
        $child_id = UserTree::where('parent_id',$myid)->get('child_id');


        $PurchaseOrder = PurchaseOrder::where('visible',1)->where('buyer_id',$myid)->orderBy('created_at', 'desc')->get();
        return view('payment.indexbuyer')->with('PurchaseOrder',$PurchaseOrder)->with('Order',$Order);


    }


    public function showfind(Request $request)
    {
        // return dd($request);

        $myid = Auth::user()->id;

        $request_status_id = $request->status;
        $status = PurchaseOrderStatus::get();


        $start_date =  new Datetime(str_replace('/', '-', $request['start_date'] ));
        $end_date =  new Datetime(str_replace('/', '-', $request['end_date'] ));
        $report_start_date = $start_date->format('d/m/Y H:i');
        $report_end_date = $end_date->format('d/m/Y H:i');

        $stock = Stock::where('visible',1)->get();

        $child_id = UserTree::where('parent_id',$myid)->get('child_id');
        $array_child_id = [];
        foreach($child_id as $childid){
            array_push($array_child_id,$childid->child_id);
        }

        $childID = $request->child_id;
        if($request->child_id == 0){
            $user_id = $array_child_id;
        }
        else{
            $user_id =  [$request->child_id];
        }

        
        $child = User::whereIn('id',$array_child_id)->get();

        if($request_status_id == 0){
            $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$user_id)->whereBetween('created_at',[$start_date,$end_date])->get();
        }
        else{
            $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$user_id)->whereBetween('created_at',[$start_date,$end_date])->where('status_id',$request_status_id)->get();
        }


        $Order = Order::get();
        return view('payment.indexseller')->with('PurchaseOrder',$PurchaseOrder)
                                            ->with('Order',$Order)
                                            ->with('request_status_id',$request_status_id)
                                            ->with('status',$status)
                                            ->with('childID',$childID)
                                            ->with('child',$child)
                                            ->with('start_date',$start_date->format('Y-m-d H:i'))
                                            ->with('end_date',$end_date->format('Y-m-d H:i'));

    }


    public function cart()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
    }

    public function paymentReport()
    {
      return view('payment.paymentReport');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return($request);
        $myid = Auth::user()->id;
        $sellerid = UserTree::where('child_id',$myid)->get('parent_id');
        $current_timestamp = Carbon::now()->timestamp;
        $current_date_time = Carbon::now()->toDateTimeString();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $current_date_time)->year;
        $year = $date+543;

        $itemcount = Cart::where('user_id',$myid)->count();
        for($i = 0 ; $i < $itemcount ; $i++){
            if($request->totalprice[$i] == 0){
                $del_cart_item = Cart::find($request->itemid[$i]);
                $del_cart_item->delete();
                // return($request->totalprice);
            }
        }
        $itemcount2 = Cart::where('user_id',$myid)->count();

        if($itemcount2 == 0){
            return redirect()->back()->with('failerror', 'สินค้าในตระกร้าถูกลบออกเนื่องจากจำนวนสินค้าเกินเรทราคาที่กำหนด');
        }

        $cart = Cart::where('user_id',$myid)->get();


        // สร้างบิล
        $PurchaseOrder = new PurchaseOrder();
        $PurchaseOrder->purchase_no = $current_timestamp;
        $PurchaseOrder->year = $year;
        $PurchaseOrder->buyer_id = $myid;
        foreach($sellerid as $seller_row){
            $PurchaseOrder->seller_id = $seller_row->parent_id;
        }
        $PurchaseOrder->save();

        // สร้าง order ของบิล
        foreach($cart as $key=>$cart_row){
            $stockitem = Stock::where('id',$request->stock_id[$key])->first();
            $order = new Order();
            $order->purchase_order_id = $PurchaseOrder->id;
            $order->stock_id = $request->stock_id[$key];
            $order->amount = $request->amount[$key];
            $order->received_priceunit = $stockitem->received_price;
            $order->received_price = $stockitem->received_price * $request->amount[$key];
            $order->price = $request->priceperunit[$key] * $request->amount[$key];
            $order->save();
            $cart_row->delete();
        }

        // foreach($cart as $key=>$cart_row){
        //     $order = new Order();
        //     $order->purchase_order_id = $PurchaseOrder->id;
        //     $order->stock_id = $cart_row->stock_id;
        //     $order->amount = $cart_row->amount;
        //     $order->price = $request->itemprice[$key];
        //     $order->save();
        //     $cart_row->delete();
        // }




        return redirect()->action('paymentController@indexbuy')->with('error', 'สร้างรายการสั่งซื้อสำเร็จ!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $myid = Auth::user();
        $user = User::where('id',$myid->id)->first();
        $Order = Order::where('purchase_order_id',$id)->get();
        $Price = Order::where('purchase_order_id',$id)->sum('price');
        $Payment = PurchaseOrder::where('id',$id)->first();
        $toplineid = UserTree::where('child_id',$myid->id)->first();
        $toplinebank = UserBank::where('user_id',$toplineid->parent_id)->get();
        $priceitem = Price::where('user_id',$myid->id)->get();
        return view('payment.create')->with('Order',$Order)
                                    ->with('Payment',$Payment)
                                    ->with('user',$user)
                                    ->with('Price',$Price)
                                    ->with('toplinebank',$toplinebank)
                                    ->with('priceitem',$priceitem);
    }


    public function showdetail($id)
    {
        $file = PurchaseOrderImage::where('purchase_order_id',$id)->get();
        $myid = Auth::user()->id;
        $user = User::where('id',$myid)->first();
        $Order = Order::where('purchase_order_id',$id)->get();
        $Price = Order::where('purchase_order_id',$id)->sum('price');
        $Payment = PurchaseOrder::where('id',$id)->first();
        $priceitem = Price::where('user_id',$Payment->buyer_id)->get();
        return view('payment.detail')->with('Order',$Order)
                                    ->with('Payment',$Payment)
                                    ->with('user',$user)
                                    ->with('Price',$Price)
                                    ->with('priceitem',$priceitem)
                                    ->with('file',$file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $myid = Auth::user();
        if(isset($request->bank_id)){
            $payment = PurchaseOrder::find($id);
            $payment->user_bank_id = $request['bank_id'];
            $payment->pay_date = $request['pay_date'];
            $payment->pay_time = $request['pay_time'];
            $payment->pay_price = $request['pay_price'];
            $payment->buyer_comment = $request['buyer_comment'];
            $payment->save();
        }
        if(isset($request->buyer_comment)){
            $payment = PurchaseOrder::find($id);
            $payment->buyer_comment = $request['buyer_comment'];
            $payment->save();
        }
        
        
    
        if($request->file('file')){
            foreach($request->file('file') as $file)
              {
                $fileName = time().'_'.$myid->id.'_'.$file->getClientOriginalName();
                  $file->move(public_path('uploads'), $fileName);
                  $data=new PurchaseOrderImage;
                  $data->purchase_order_id=$id;
                  $data->name=$fileName;
                  $data->save();
              }
        }
        $payment = PurchaseOrder::where('id',$id)->first();
        $toplineId = UserTree::where('child_id',$myid->id)->first();
        $toplineName = User::where('id',$toplineId->parent_id)->first();
        $user_mails = UserMailForward::where('user_id', $toplineId->parent_id)->get('forward_email');
        $bank_acc = UserBank::where('id',$payment->user_bank_id)->first();
        $bank_name = Bank::where('id',$bank_acc->bank_id)->first();
        $Price = Order::where('purchase_order_id',$payment->id)->sum('price');

        // start mail 
        $data = array(
            'downline'   =>   $myid->name,
            'subject'   =>   "แจ้งเตือนการชำระเงิน",
            'purchase_no'      =>  $payment->purchase_no,
            'purchase_id'      =>  $payment->id,
            'bank'      =>  $bank_name->name,
            'bank_acc'      =>  $bank_acc->account_no,
            'time'      =>  $payment->pay_time,
            'price'      =>  $Price,
            'pay_price'      =>  $payment->pay_price,
        );

        // mail to topline
        Mail::to($toplineName->email)->send(new SendMail($data));
        
        // mail to topline forward
        foreach ($user_mails as $user_mail) {

            Mail::to($user_mail->forward_email)->send(new SendMail($data));
            
        }

        // end mail 



        return redirect()->action('paymentController@indexbuy')->with('error', 'อัพเดตรายการสั่งซื้อสำเร็จ!');
    }




    public function statusupdate(Request $request, $id)
    {

  

        $payment = PurchaseOrder::find($id);
        $payments = PurchaseOrder::where('id',$id)->first();
        $buyer = User::where('id',$payments->buyer_id)->first();
        $seller = User::where('id',$payments->seller_id)->first();
        $Orders = Order::where('purchase_order_id',$id)->get();
        // return ($request);


        //ถ้าสถานะไม่เปลี่ยน 
        if($request->status == $payment->status_id){
            $payment->seller_comment = $request['seller_comment'];
            $payment->save();
            return redirect()->back()->with('error', 'อัพเดตข้อมูลรายการสั่งซื้อ!');
        }



        
        // เปลี่ยนสถานะเป็นยืนยัน
        if($request->status == 2){

            // ถ้ายืนยัน->ยืนยัน
            if($payment->status_id == 2 ){
                $payment->seller_comment = $request['seller_comment'];
                $payment->save();
                return redirect()->back()->with('error', 'อัพเดตรายการสั่งซื้อสำเร็จ!');
            }


            // ถ้า xxx -> ยืนยัน
            else{
                // เช็คจำนวนสินค้าใน stock
                foreach($Orders as $Order){
                    $Stock = Stock::where('id',$Order->stock_id)->first();
                    // ถ้า stock ไม่พอให้อัพเดตแค่คอมเม้นแล้วกลับไป
                    if($Order->amount > $Stock->amount){
                        $payment->seller_comment = $request['seller_comment'];
                        $payment->save();
                        return redirect()->back()->with('failerror', 'ตัด stock ไม่สำเร็จเนื่องจากมีจำนวนสินค้าไม่เพียงพอ');
                    }
                }
                // จบการเช็คจำนวนสินค้าใน stock


                // ถ้าผ่าน loop การเช็ค stock ก็มาบันทึกข้อมูลปกติ
                foreach($Orders as $Order){
                    $Stock = Stock::where('id',$Order->stock_id)->first();
                    $Stock->amount = $Stock->amount - $Order->amount;
                    $Stock->save();
                }
                $payment->status_id = $request['status'];
                $payment->seller_comment = $request['seller_comment'];
                $payment->save();

                
                return redirect()->back()->with('error', 'อัพเดตรายการสั่งซื้อและตัด stock สำเร็จ!');
            }
        }
        // เปลี่ยนจากยืนยันเป็นอย่างอื่น
        if($payment->status_id == 2){

            // loop คืนค่าstockตามorder
            foreach($Orders as $Order){
                $Stock = Stock::where('id',$Order->stock_id)->first();
                $Stock->amount = $Stock->amount + $Order->amount;
                $Stock->save();
            }

            $payment->status_id = $request['status'];
            $payment->seller_comment = $request['seller_comment'];
            $payment->save();
        
            if(($request->status == 3) or ($request->status == 4)){
                $myid = Auth::user();
                // $toplineId = UserTree::where('child_id',$myid->id)->first();
                // $toplineName = User::where('id',$toplineId->parent_id)->first();
                $user_mails = UserMailForward::where('user_id', $seller->id)->get('forward_email');
                $bank_acc = UserBank::where('id',$payment->user_bank_id)->first();
                $bank_name = Bank::where('id',$bank_acc->bank_id)->first();
                $Price = Order::where('purchase_order_id',$payment->id)->sum('price');
                // start mail
                if($request->status == 3){
                    $data = array(
                        'downline'   =>   $myid->name,
                        'subject'   =>   "แจ้งเตือนการยกเลิกรายการ",
                        'purchase_no'      =>  $payment->purchase_no,
                        'purchase_id'      =>  $payment->id,
                        'bank'      =>  $bank_name->name,
                        'bank_acc'      =>  $bank_acc->account_no,
                        'time'      =>  $payment->pay_time,
                        'price'      =>  $Price,
                        'pay_price'      =>  $payment->pay_price,
                    );
                }
                if($request->status == 4){
                    $data = array(
                        'downline'   =>   $myid->name,
                        'subject'   =>   "แจ้งเตือนการคืนเงิน",
                        'purchase_no'      =>  $payment->purchase_no,
                        'purchase_id'      =>  $payment->id,
                        'bank'      =>  $bank_name->name,
                        'bank_acc'      =>  $bank_acc->account_no,
                        'time'      =>  $payment->pay_time,
                        'price'      =>  $Price,
                        'pay_price'      =>  $payment->pay_price,
                    );
                }
                

                // mail to topline
                Mail::to($buyer->email)->send(new SendMail($data));
                Mail::to($seller->email)->send(new SendMail($data));
                // mail to topline forward
                foreach ($user_mails as $user_mail) {

                    Mail::to($user_mail->forward_email)->send(new SendMail($data));
                    
                }

                // end mail 
            }
            
        
        
            return redirect()->back()->with('error', 'อัพเดตรายการสั่งซื้อและคืน stock สำเร็จ!');            
        }

        else{
            $payment->status_id = $request['status'];
            $payment->seller_comment = $request['seller_comment'];
            $payment->save();
            return redirect()->back()->with('error', 'อัพเดตรายการสั่งซื้อสำเร็จ!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
