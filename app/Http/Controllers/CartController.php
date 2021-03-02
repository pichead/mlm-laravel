<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\Price;
use App\Models\User;
use DB;
use Auth;

use Exception;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('admin.create');
        $user = Auth::user()->id;
        $item = Cart::where("user_id",$user)->get();
        $price = Price::where('user_id',$user)->get();
        return view('payment.cart')->with('item',$item)
                                    ->with('price',$price)
                                    ->with('user',$user);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $Cart = new Cart();
        $Cart->user_id = $user;
        $Cart->stock_id = $request['stock_id'];
        $Cart->save();
        $item = Cart::where("user_id",$user)->get();
        $price = Price::where('user_id',$user)->get();
        return redirect()->action('CartController@index');
    }

    public function updateCart(Request $request)
    {
        // echo json_encode($request);

        try{

            // throw new Exception('test error');

            DB::beginTransaction();
            $user = Auth::user()->id;
            $itemcount = Cart::where('user_id',$user)->count();
            $cart_row = Cart::where('user_id',$user)->get();
            $price = Price::where('user_id',$user)->get();
            for($i = 0 ; $i < $itemcount ; $i++){
                $count = ($cart_row[$i]->id);
                $cart = Cart::find($count);
                if($request->rowtotal[$i] == 0){
                    $cart->delete();
                }
                else{
                    $cart->amount = $request->rowamount[$i];
                    $cart->save();
                }
                
            }

            

            DB::commit();
            return response()->json(['success'=> 1 , 'error' => '']);
        }
        catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            // return $e;
            // return 0;
            return response()->json(['success'=> 0 , 'error' => $e->getMessage() ]);
      }
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
        // return dd($request);
        $cart = cart::find($id);
        $cart->amount= $request['amount'];
        $cart->save();
        return redirect()->back()->with('alert', 'แก้ไขสินค้าสำเร็จ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart=Cart::find($id);
        $cart->delete();
        return redirect()->back()->with('alert', 'แก้ไขสินค้าสำเร็จ!');

    }
}
