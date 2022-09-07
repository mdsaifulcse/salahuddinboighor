<?php

namespace App\Http\Controllers\Client\userResource;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator,MyHelper,DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //auth()->setDefaultDriver('web');
    }

    protected function changeMyPassword()
    {
        $user=User::findOrFail(auth()->user()->id);
        return view('client.user.password',compact('user'));
    }


    protected function updateMyPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, auth()->user()->password))
        {
            return redirect()->back()->with('error','Old password does not match to our record');
        }

        DB::beginTransaction();
        try{

            $user=User::findOrFail(auth()->user()->id);
            $user->update([
                'password'=>Hash::make($request->new_password),
            ]);

            $bug=0;
            DB::commit();
            return redirect()->back()->with('success','Password successfully change');
        }catch (\Exception $e){
            DB::rollback();;
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }


    protected function myProfile()
    {
        $user=User::with('profile')->findOrFail(auth()->user()->id);
        return view('client.user.profile-update',compact('user'));

    }


    protected function updateMyProfile(Request $request)
    {

        $user=User::findOrFail(auth()->user()->id);


        $id=auth()->user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'email'  => "required||max:100|unique:users,email,$id",
            'mobile'  => "nullable|max:15|unique:users,mobile,$id",
            'contact'=> 'nullable|max:50',
            'address'=> 'nullable|max:200',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try{

            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
            ]);

            if (isset($request->contact) || isset($request->company_name) || isset($request->address) ||  isset($request->avatar)){

                $userProfile=UserProfile::where('user_id',auth()->user()->id)->first();

                $avatarPath='';

                $profileInput=[
                    'address'=>$request->address,
                    'contact'=>$request->contact,
                    'company_name'=>$request->company_name,
                    'user_id'=>auth()->user()->id,
                ];

                if ($request->hasFile('avatar')) {
                    $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'user-images',200);

                    if (!empty($userProfile) && file_exists($userProfile->avatar)){
                        unlink($userProfile->avatar);
                    }
                    $profileInput['avatar']=$avatarPath;
                }


                if (empty($userProfile))
                {
                    UserProfile::create($profileInput);
                }else{
                    $userProfile->update($profileInput);
                }


            }


            $bug=0;
            DB::commit();

        }catch (\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','Profile Successfully Updated');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }


    }
}
