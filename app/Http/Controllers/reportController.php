<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Order;
use DateTime;
use Auth;
use DB;
class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $adjustment_types;

    public function __construct()
    {
        // $this->adjustment_types = collect();
        // $this->adjustment_types->push(['id'=1>,'name'=>'ดูทั้งหมด']);

        // $this->adjustment_types->push(['id'=>2,'name'=>'ปรับสต็อคแบบกำหนดเอง']);
        // $this->adjustment_types->push(['id'=>3,'name'=>'เบิกสินค้า']);
        // $this->adjustment_types->push(['id'=>4,'name'=>'ขายสินค้าให้ลูกค้า']);
        // $this->adjustment_types->push(['id'=>6,'name'=>'ตัดทรีทเมนต์']);
        // $this->adjustment_types->push(['id'=>100,'name'=>'บันทึกลงสต็อคครั้งแรก']);

    }

    public function index()
    {
        $selected_stock_id = 0;
        $selected_adjustment_type = 0;

        $date_time = new DateTime();

        $datetime_pattern = $date_time->format('Y-m-d');

        $stocks = PurchaseOrder::where('visible',1)->orderBy('id','asc')->get();


        // กรอบเวลาเริ่มต้น-สิ้นสุด
        $end_date =  new DateTime($datetime_pattern.' 20:00:00');
        $start_date = new DateTime($datetime_pattern.' 07:00:00');
        // กรอบเวลาเริ่มต้น-สิ้นสุด


        // return var_dump($this->adjustment_types->pluck("id")->toArray());

        $stock_history_records = $this->loadStockHistory($stocks->pluck("id")->toArray(),$this->adjustment_types->pluck("id")->toArray(),$start_date,$end_date);
        // $stock_history_records = $this->loadStockHistory($selected_stock_id,$this->adjustment_types->get('id'),$start_date,$end_date);

        $report_start_date = $start_date->format('d/m/Y H:i');
        $report_end_date = $end_date->format('d/m/Y H:i');

        return view('report.index')->with(['start_date'=>$start_date->format('Y-m-d H:i'),

                                                      'selected_adjustment_type'=>$selected_adjustment_type,
                                                      'stock_history_records'=>$stock_history_records,
                                                      'stocks'=>$stocks,
                                                      'selected_stock_id'=>$selected_stock_id,
                                                      'report_start_date'=>$report_start_date,
                                                      'report_end_date'=>$report_end_date,
                                                      'end_date'=>$end_date->format('Y-m-d H:i')]);
    }


    public function show(Request $request){

        $stocks = PurchaseOrder::where('visible',1)->orderBy('name','asc')->get();
  
        $selected_stock_ids = ($request->stocks == 0) ? $stocks->pluck("id")->toArray() : [$request->stocks];
        $start_date =  new Datetime(str_replace('/', '-', $request['start_date'] ));
        $end_date =  new Datetime(str_replace('/', '-', $request['end_date'] ));
  
        // return $end_date;
  
        $adjustment_types = ($request->adjustment_types == 0) ? $this->adjustment_types->pluck("id")->toArray() : [$request->adjustment_types];
  
        $stock_history_records = $this->loadStockHistory($selected_stock_ids,$adjustment_types,$start_date,$end_date);
  
        $report_start_date = $start_date->format('d/m/Y H:i');
        $report_end_date = $end_date->format('d/m/Y H:i');
  
        return view('report.index')->with(['start_date'=>$start_date->format('Y-m-d H:i'),
  
                                                      'selected_adjustment_type'=>($request->adjustment_types == 0) ? 0 : $request->adjustment_types,
                                                      'stock_history_records'=>$stock_history_records,
                                                      'stocks'=>$stocks,
                                                      'selected_stock_id'=>($request->stocks == 0) ? 0 : $request->stocks ,
                                                      'report_start_date'=>$report_start_date,
                                                      'report_end_date'=>$report_end_date,
                                                      'end_date'=>$end_date->format('Y-m-d H:i')]);
  
      }
  
  
      function loadStockHistory($selected_stock_ids,$selected_adjustment_types,$start_date,$end_date){

        $stock_history_records = PurchaseOrder::whereIn('adjustments_type',$selected_adjustment_types)
                                  ->whereIn('stock_id',$selected_stock_ids)
                                  ->whereBetween('created_at',[$start_date,$end_date])
                                  ->orderBy('stock_id','desc')
                                  ->orderBy('created_at','asc')
                                  ->get();
  
        return $stock_history_records;
  
      }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
