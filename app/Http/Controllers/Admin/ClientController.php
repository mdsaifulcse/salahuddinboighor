<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use DB,Hash,Validator;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.customers.index');
    }

    public function getCustomerDataList ()
    {
        $roles = Role::whereIn('name',['general-customer'])->orderBy('id','DESC')->pluck('name')->toArray();

        $allData = User::with('profile')->role($roles)->where('users.id','!=',1)->orderBy('users.id', 'DESC');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Company',function (User $user){
                return $user->profile->company_name;
            })
            ->addColumn('Address',function (User $user){
                return $user->profile->address;
            })

            ->addColumn('Register_At','
                    {{date(\'M-d-Y h:i A\',strtotime($created_at))}}
                ')
            ->addColumn('Action','
                 {!! Form::open(array(\'route\' => [\'customers.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}

                   @can(\'customers-edit\')
                    <a href="{{route(\'customers.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                    </a>
                    @endcan
                    
                    @can(\'customers-delete\')
                    <a href="{{URL::to(\'/admin/user-password/\'.$id)}}" class="btn btn-primary btn-sm" title="Click to change password">
                        <i class="fa fa-key"></i>
                    </a>
                    @endcan
                    
                    <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}")\' title="Click here to remove order" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i></button>
                {!! Form::close() !!}
            ')
            ->rawColumns(['Company','Address','Register_At','Action'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
                $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'images/client-images',150);

                $input['avatar']=$avatarPath;
            }

            $input['user_id']=$user->id;
            $profile=UserProfile::create($input);


            $user->assignRole(['general-customer']);
            $bug=0;
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','Client created successfully');
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

        $user=User::with('profile')->findOrFail($id);
        return view('admin.customers.edit',compact('user'));
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
                $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'images/client-images',150);

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

            $user->assignRole(['general-customer']);

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
}
