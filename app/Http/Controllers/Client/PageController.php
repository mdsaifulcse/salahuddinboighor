<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Models\UserFeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB,Auth,Validator,MyHelper,Route;

class PageController extends Controller
{
    public function aboutUs()
    {
        $setting=Setting::first();
        return view('client.about-us',compact('setting'));
    }
    public function contactUs()
    {
        $setting=Setting::first();
        return view('client.contact-us',compact('setting'));
    }

    public function pageView($link)
    {
        $page=Page::with('pagePhoto')->where('link',$link)->first();
        return view('client.page',compact('page'));
    }

    public function saveUserFeedBack(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:100',
            'mobile' => 'required|max:50',
            'email' => 'required|max:100',
            'message' => 'required|max:300',
            'image'=> 'nullable|mimes:jpg,jpeg,png,webp,gif,bmp|Max:2048',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {

            $input['image']=\MyHelper::fileUpload($request->file('image'),'images/user-feedback/');
        }

        $feedBackData=UserFeedBack::create($input);
        try{
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }


        Mail::to('deshpage.usa@gmail.com')->send(new \App\Mail\UserFeedBack($feedBackData));

        if($bug==0){
            return redirect()->back()->with('success','Your Message Successfully Send');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }

    }


}
