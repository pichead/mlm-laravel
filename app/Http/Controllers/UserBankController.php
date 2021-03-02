<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\UserTree;
use App\Models\UserLevel;
use Auth;
use DB;
class UserBankController extends Controller
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
        // return dd($request);
        $userbank = new UserBank();
        $userbank->user_id = $request['user_id'];
        $userbank->bank_id = $request['bank_id'];
        $userbank->account_no = $request['account_no'];
        $userbank->save();
        return redirect()->back()->with('error','สร้างบัญชีธนาคารใหม่สำเร็จ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id',$id)->first();
        $Bank_all = Bank::get();
        $mybank = UserBank::where('user_id',$id)->where('visible',1)->get();
        return view('user.bank')->with('user',$user)->with('Bank_all',$Bank_all)->with('mybank',$mybank);
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
        $userbank = UserBank::find($id);
        $userbank->bank_id = $request['bank_id'];
        $userbank->account_no = $request['account_no'];
        $userbank->save();
        return redirect()->back()->with('error','แก้ไขบัญชีธนาคารสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userbank = UserBank::find($id);
        $userbank->visible = 0;
        $userbank->save();
        return redirect()->back()->with('error','ลบบัญชีธนาคารสำเร็จ');
    }
}
