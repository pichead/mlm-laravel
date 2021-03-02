<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\UserLevel;
use App\Models\User;
use App\Models\Price;
use Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // authorized level = 1
        
        // $myid = Auth::user()->id;
        // $Stock = Stock::where('visible',1)->orderBy('name', 'ASC')->get();
        // $userlevel = User::where('id',$myid)->first();
        // $price = Price::where('user_id',$myid)->get();

        // return view('stock.index')->with('price',$price)->with('Stock',$Stock);

        $myid = Auth::user()->id;
        $Stock = Stock::where('visible',1)->orderBy('name', 'ASC')->get();
        $userlevel = User::where('id',$myid)->first();
        $price = Price::where('user_id',$myid)->get();

        if(($userlevel->level_id) == 1){
            return view('stock.index')->with('price',$price)->with('Stock',$Stock);
        }
        else{
            return view('stock.indexstore')->with('price',$price)->with('Stock',$Stock)->with('myid',$myid);
        }
    }

    public function indexstore()
    {
        // authorized level = 2,3

        $myid = Auth::user()->id;
        $Stock = Stock::where('visible',1)->orderBy('name', 'ASC')->get();
        $userlevel = User::where('id',$myid)->first();
        $price = Price::where('user_id',$myid)->get();

         
         return view('stock.indexstore')->with('price',$price)->with('Stock',$Stock)->with('myid',$myid);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock = new stock();
        $stock->name = $request['name'];
        $stock->received_price = $request['recived_price'];
        $stock->spent_price = $request['spent_price'];
        $stock->spent_unit = $request['spent_unit'];
        $stock->amount= $request['amount'];
        $stock->save();
        return redirect()->action('StockController@index')->with('error','สร้างสินค้าสำเร็จ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $stock = stock::find($id);
        $stock->name = $request['name'];
        $stock->received_price = $request['recived_price'];
        $stock->spent_price = $request['spent_price'];
        $stock->spent_unit = $request['spent_unit'];
        $stock->amount= $request['amount'];
        $stock->save();
        return redirect()->action('StockController@index')->with('error','แก้ไขสินค้าสำเร็จ');
    }


    public function delstore(Request $request, $id)
    {
        $stock = stock::find($id);
        $stock->visible = 0;
        $stock->save();
        return redirect()->action('StockController@index')->with('error','ลบสินค้าสำเร็จ');
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
