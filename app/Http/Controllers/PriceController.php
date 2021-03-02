<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Price;
use App\Models\UserTree;
use App\Models\Stock;
use App\Models\Cart;



use Auth;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.price');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
     


        //     if(($request->start_total) == [null] && ($request->end_total) == [null] && ($request->price_row) == [null]) {
        //         return("is null");
        //     } 
        //     else {
        //         return($request->start_total);
        //     }
       
        // สร้างเรทราคาใหม่
        foreach($request->price_row as $key=>$price_row){
            $price = new Price();
            $price->user_id = $request['user_id'];
            $price->stock_id = $request['stock_id'];
            $price->start_total = $request->start_total[$key];
            $price->end_total = $request->end_total[$key];
            $price->price = $price_row;
            $price->save();
        }

        // ลบเรทราคาเก่า
        if(isset ($request->oldprice_id)){
            foreach($request->oldprice_id as $oldprice){
                $old = Price::where('id',$oldprice);
                $old->delete();
            }
        }
        $stockname = Stock::where('id',$request['stock_id'])->first();

        return redirect()->back()->with('error','สร้างเรทราคา '.$stockname->name.' สำเร็จ');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = User::where('id',$id)->first();

        $myid = Auth::user()->id;
        $UserTree = UserTree::where('parent_id',$myid)->get('child_id');
        $stock = Stock::where('visible',1)->orderBy('name', 'ASC')->get();
        $price = Price::where('user_id',$id)->get();
        return view('user.price')->with('user_id',$user_id)
                                ->with('UserTree',$UserTree)
                                ->with('stock',$stock)
                                ->with('myid',$myid)
                                ->with('price',$price);
        
        // return $Stock;
    }

    public function showprice($id,$item)
    {
        $user_id = User::where('id',$id)->first();
        $myid = Auth::user()->id;
        $UserTree = UserTree::where('parent_id',$myid)->get('child_id');
        $stock = Stock::where('visible',1)->where('id',$item)->first();
        $price = Price::where('user_id',$id)->where('stock_id',$item)->get();
        return view('user.priceitem')->with('user_id',$user_id)
                                ->with('UserTree',$UserTree)
                                ->with('stock',$stock)
                                ->with('myid',$myid)
                                ->with('price',$price);
        
        // return $Stock;
    }

    public function loadPrice(){
        $user = Auth::user()->id;
        $itemss = Cart::where("user_id",$user)->get();
        $price = Price::where('user_id',$user)->get();

        foreach($itemss as $item_row){
            $price_item = Price::where('user_id',$user)->where('stock_id',$item_row->stock_id)->get();
            $array_price = [];
            foreach($price_item as $price_item_row){
                if($item_row->amount >= $price_item_row->start_total && $item_row->amount <= $price_item_row->end_total){
                    array_push($array_price,$price_item_row->price); 
                }
            }
            if($array_price == []){
                $del_item = Cart::where('id',$item_row->id)->first();
                $del_item->delete();
            }
        }

        $item = Cart::where("user_id",$user)->get();


        return response()->json([
                    'carts' => $item->toJson(),
                    'prices' => $price->toJson()
            ]);
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
}
