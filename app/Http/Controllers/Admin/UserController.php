<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\UserProfile;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\User;

use Spatie\Permission\Models\Role;

use DB,Hash,Validator;
use Yajra\DataTables\DataTables;



class UserController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */


    public function index(Request $request)

    {
        $roles = Role::whereNotIn('name',['developer','general-customer'])->orderBy('id','DESC')->pluck('name')->toArray();

        $data = User::with('profile')->role($roles)->where('id','!=',1)->orderBy('id', 'DESC')->paginate(15);

        return view('admin.users.index', compact('data'))

            ->with('i', ($request->input('page', 1) - 1) * 5);
    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create(Request $request)

    {
        $roles = Role::where('name','!=','developer')->orderBy('id','DESC')->pluck('name', 'name')->all();

        return view('admin.users.create', compact('roles'));
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required',
            'email'  => "nullable|unique:users|email|max:100",
            'mobile'  => "nullable|unique:users|max:15",
            'username' => ['nullable', 'string', 'max:200', "unique:users"],

            'address'=> 'nullable|max:100',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',

            'password' => 'required|same:confirm_password',
            'roles' => 'required'

        ]);



       //return $input = $request->all();
        $input = $request->except('_token');

        $input['password'] = Hash::make($input['password']);

        DB::beginTransaction();
        try{
            $user = User::create($input);

            $avatarPath='';
            if ($request->hasFile('avatar'))
            {
                $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'images/user-images',150);

                $input['avatar']=$avatarPath;
            }

            $input['user_id']=$user->id;
            $profile=UserProfile::create($input);


            $user->assignRole($request->input('roles'));
            $bug=0;
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','User created successfully');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug);
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

        $user = User::find($id);

        return view('admin.users.show', compact('user'));
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $user = User::find($id);

        $roles = Role::where('name','!=','developer')->pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
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

        $this->validate($request, [

            'name' => 'required',
            'mobile' => ['required', 'string', 'max:15', "unique:users,mobile," . $id],
            'email' => ['nullable', 'string', 'max:100', "unique:users,email," . $id],
            'username' => ['nullable', 'string', 'max:50', "unique:users,username," . $id],
            'address'=> 'nullable|max:100',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',
            'roles' => 'required'

        ]);


        $input = $request->except('password','_token');

        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);


            $user->update($input);

            $userProfile=UserProfile::where('user_id',$id)->first();

            $avatarPath='';
            if ($request->hasFile('avatar'))
            {
                $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'images/user-images',150);

                if (!empty($userProfile) && file_exists($userProfile->avatar)){
                    unlink($userProfile->avatar);
                }
                $input['avatar']=$avatarPath;
            }


            if (empty($userProfile))
            {
                $input['user_id']=$id;
                UserProfile::create($input);
            }else{
                $userProfile->update($input);
            }


            DB::table('model_has_roles')->where('model_id', $id)->delete();


            $user->assignRole($request->input('roles'));

            $bug=0;
            DB::commit();

        }catch (Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Updated');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug);
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

        User::findOrFail($id);

        try{
            User::find($id)->delete();

            $userProfile=UserProfile::where('user_id',$id)->first();
            if (!empty($userProfile) && file_exists($userProfile->avatar)){
                unlink($userProfile->avatar);
            }


            $order=Order::where('user_id',$id)->first();
            if (!empty($order))
            {
                Order::whereIn('user_id',[$id])->delete();
            }

            if (!empty($userProfile))
            {
                $userProfile->delete();
            }



            DB::table('model_has_roles')->where('model_id', $id)->delete();

            DB::commit();
            $bug = 0;
        }catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];

        }


        if($bug == 0){
            return redirect()->back()->with('success','User Deleted Successfully');
        }elseif ($bug==1451){

        return redirect()->back()->with('error', 'Sorry this Course can not be delete due to used another module');

        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }

    
    }


    protected function changeUserPassword($userId)
    {
        $user=User::findOrFail($userId);
        return view('admin.users.change-user-password',compact('user'));
    }


    protected function resetUserPassword(Request $request)
    {

        //return $request;
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{

            $user=User::findOrFail($request->id);
            $user->update([
                'password'=>Hash::make($request->new_password),
            ]);

            $bug=0;
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();;
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','Password successfully change');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug);
        }

    }



}
