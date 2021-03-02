<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\UserTree;
use App\Models\UserLevel;
use App\Models\UserMailForward;
use Auth;
use DB;
class ForwardEmailController extends Controller
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
        $myid = Auth::user()->id;
        $Forward_Mail = new UserMailForward;
        $Forward_Mail->user_id = $myid;
        $Forward_Mail->name = $request->name;
        $Forward_Mail->forward_email = $request->email;
        $Forward_Mail->save();
        return redirect()->back()->with('error','สร้างอีเมลใหม่สำเร็จ');
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
        $Forward_Mails = UserMailForward::where('user_id',$id)->get();
        return view('user.ForwardMail')->with('user',$user)
                                        ->with('Forward_Mails',$Forward_Mails);

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
        $mail = UserMailForward::find($id);
        $mail->name = $request['name'];
        $mail->forward_email = $request['email'];
        $mail->save();
        return redirect()->back()->with('error','แก้ไขอีเมลสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mail = UserMailForward::find($id);
        $mail->delete();
        return redirect()->back()->with('error','ลบอีเมลสำเร็จ');
    }
}
