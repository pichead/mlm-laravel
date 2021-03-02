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
use App\Exports\SaleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Auth;
use DB;
class ReportPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myid = Auth::user()->id;
        $date_time = new DateTime();
        $datetime_pattern = $date_time->format('Y-m-d');
        $end_date =  new DateTime($datetime_pattern.' 20:00:00');
        $start_date = new DateTime($datetime_pattern.' 07:00:00');
        $request_stock_id = 0;
        $childID = 0;
        $child_id = UserTree::where('parent_id',$myid)->get('child_id');
        $array_child_id = [];
        foreach($child_id as $childid){
            array_push($array_child_id,$childid->child_id);
        }


        $stock = Stock::where('visible',1)->get();
        $child = User::whereIn('id',$array_child_id)->get();
        $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$array_child_id)->whereBetween('created_at',[$start_date,$end_date])->get();





        return view('report.index')->with('stock',$stock)
                                   ->with('start_date',$start_date->format('Y-m-d H:i'))
                                   ->with('end_date',$end_date->format('Y-m-d H:i'))
                                   ->with('child',$child)
                                   ->with('childID',$childID)
                                   ->with('request_stock_id',$request_stock_id)
                                   ->with('PurchaseOrder',$PurchaseOrder);
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
    public function show(Request $request)
    {
        // return dd($request);


        $myid = Auth::user()->id;

        $request_stock_id = $request->stock_id;


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

        // return ($user_id);
        
        $child = User::whereIn('id',$array_child_id)->get();
        $PurchaseOrder = PurchaseOrder::whereIn('buyer_id',$user_id)->whereBetween('created_at',[$start_date,$end_date])->get();


        return view('report.index')->with('stock',$stock)
                                    ->with('start_date',$start_date->format('Y-m-d H:i'))
                                    ->with('end_date',$end_date->format('Y-m-d H:i'))
                                    ->with('child',$child)
                                    ->with('childID',$childID)
                                    ->with('request_stock_id',$request_stock_id)
                                    ->with('PurchaseOrder',$PurchaseOrder);

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


    public function export(Request $request)
    {
        $excel_data = $request;
        return Excel::download(new SaleReportExport, 'SaleReport.xlsx')->with('excel_data',$excel_data);
    }


}
