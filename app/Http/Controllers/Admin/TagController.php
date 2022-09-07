<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\tag;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tags=Tag::orderBy('id','DESC')->paginate(20);
        $max_serial=Tag::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('tags','max_serial'));
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
        $input = $request->all();
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->tag);
        }


        $validator = Validator::make($input, [
            'tag' => 'required|max:200|unique:tags,tag,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:tags,link,NULL,id,deleted_at,NULL',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $input['created_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/tags/',150);
            }

            Tag::create($input);

            return redirect()->back()->with('success','Data Successfully Save');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'tag' => "required|unique:tags,tag,$id,id,deleted_at,NULL",
            'link' => "required|unique:tags,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $tag=Tag::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/tags/',150);

                if($tag->icon_photo!=null and file_exists($tag->icon_photo))
                {
                    unlink($tag->icon_photo);
                }
            }

            $tag->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag=Tag::findOrFail($id);
        try{
            $tag->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
