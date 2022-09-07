<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsDetailPhoto;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,DataLoad;

class NewsDetailPhotoController extends Controller
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

        $input = $request->all();

        $validator = Validator::make($input, [
            'news_id'=> 'required|exists:news,id',
            'photo'=> 'required|image|mimes:jpeg,bmp,png,webp|max:3072',
            'description'=>'required',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            if ($request->hasFile('photo'))
            {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/more-news-photo/');
            }


            NewsDetailPhoto::create($input);

            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0)
        {
            return redirect()->back()->with('success', 'News Photo is Successfully Created');
        }elseif ($bug==1062)
        {
            return redirect()->back()->with('error', 'The News has already been taken');
        }
        else
        {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsDetailPhoto  $newsDetailPhoto
     * @return \Illuminate\Http\Response
     */
    public function show($newsId)
    {
        $news=News::findOrFail($newsId);
        $allData=NewsDetailPhoto::where('news_id',$newsId)->orderBy('id','DESC')->get();
        return view('admin.news.more-news-photo.index',compact('news','allData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsDetailPhoto  $newsDetailPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsDetailPhoto $newsDetailPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsDetailPhoto  $newsDetailPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'photo'=> 'nullable|image|mimes:jpeg,bmp,png,webp|max:3072',
            'description'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newsDetailPhoto=NewsDetailPhoto::findOrFail($id);

        try {

            if ($request->hasFile('photo')) {

                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/news/big/');

                if($newsDetailPhoto->photo!=null and file_exists($newsDetailPhoto->photo)){
                    unlink($newsDetailPhoto->photo);
                }
            }

            $newsDetailPhoto->update($input);

            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Data Successfully Update');
        }elseif ($bug==1062){
            return redirect()->back()->with('error', 'The News has already been taken');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsDetailPhoto  $newsDetailPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsDetailPhoto=NewsDetailPhoto::findOrFail($id);
        DB::beginTransaction();
        try{
//            if($data->icon_photo!=null and file_exists($data->icon_photo)){
//                unlink($data->icon_photo);
//            }

            $newsDetailPhoto->delete();
            $bug = 0;
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Some thing error found !');

        }
    }
}
