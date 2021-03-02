<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\UserTree;
use App\Models\UserLevel;
use Auth;
use DB;


use Illuminate\Http\Request;


class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $myid = Auth::user()->id;

        $UserTree = UserTree::where('parent_id',$myid)->get('child_id');
        // $childs = User::where('id',$UserTree)->get();
        // $child = UserTree::where('parent_id',$UserTree)->get();

        // foreach (UserTree::where('parent_id',$myid)->get('child_id') as $row) {
        //     echo [$row];
            
        //     foreach (UserTree::where('parent_id',$row->child_id)->get('child_id') as $test){
        //         echo $test;
        //     }
            
        //     // $test = +$row;
        //     // echo $test;
        // }
        // echo $test;
        return view('user.index')->with(['UserTree'=>$UserTree]);
    
        // return (['UserTree'=>$UserTree]);

        




        // return ($child);





        // $User = User::whereIn('id',[$tree_id])->get();
        // return view('user/index')->with([
        //     'User'=>$User
        // ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Bank = Bank::where('visible',1)->get();

        return view('user.create')->with([
            'Bank'=>$Bank
          ]);
    }


    public function edituser()
    {
        $myid = Auth::user()->id;
        $user_id = User::where('id',$myid)->get();
        return view('user.edit')->with('user_id',$user_id);
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

        try{
            

            // check email
            $emails = User::get('email');
            foreach($emails as $email){
                if($email->email == $request->email){
                    return back()->withInput()->with('failerror','อีเมลนี้ถูกใช้งานแล้ว กรุณาเปลี่ยนอีเมล');
                }
            }
            // end check email


            DB::beginTransaction();
            $myid = Auth::user()->id;
            $user = new User();
            $user->name = $request['name'];
            $user->password = bcrypt($request['password']);
            $user->email = $request['email'];
            $user->tel = $request['tel'];
            $user->level_id = $request['level'];
            $user->save();

            $user_tree = new UserTree();
            $user_tree->parent_id = $myid;
            $user_tree->child_id = $user->id;
            $user_tree->save();

            // $bank = $request->bank_id[0];

            // if($bank != 0){

            //     foreach($request->bank_id as $key=>$bank_id){
            //         $user_bank = new UserBank();
            //         $user_bank->bank_id = $bank_id;
            //         $user_bank->user_id = $user->id;
            //         $user_bank->account_no = $request->account_no[$key];
            //         $user_bank->save();
            //     }
                
            // }
            

            DB::commit();
            return redirect()->action('userController@index')->with('error','สร้างลูกค้าใหม่สำเร็จ');
        }

        catch (\PDOException $e) {

            DB::rollBack();
            return $e;

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
        $Bank = UserBank::where('user_id',$id)->get();
        $user_id = User::where('id',$id)->get();
        return view('user.edit')->with(['user_id'=>$user_id])->with(['Bank'=>$Bank]);
        // return dd($Bank);
    }

    public function treeview()
    {
        
        return view('user.treeview');
        
    }


    public function resetpassword(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        return view('user.resetpassword')->with('user',$user);
    }

    public function passwordupdate(Request $request)
    {
        $user = user::find($request->reset);
        $user->password = bcrypt($request['password']);
        $user->save();
        return redirect()->action('userController@index')->with('error','รีเซ็ตรหัสผ่านสำเร็จ');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = user::find($id);
        $user->name = $request->name;
        $user->tel= $request->tel;
        $user->email = $request->email;
        $user->save();
        return redirect()->action('userController@index')->with('error','อัพเดตข้อมูลสำเร็จ');
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
