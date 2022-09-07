<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PagePhoto;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=Page::with('pagePhoto')->orderby('id','desc')->paginate(20);
        $max_serial=Page::max('serial_num');

        return view('admin.slider.page',compact('allData','max_serial'));
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

        $input=$request->all();

        $link=str_replace(' , ', '-', $input['title']);
        $link=str_replace(', ', '-', $link);
        $link=str_replace(' ,', '-', $link);
        $link=str_replace(',', '-', $link);
        $link=str_replace('/', '-', $link);
        $link=rtrim($link,' ');
        $link=str_replace(' ', '-', $link);
        $link=str_replace('.', '', $link);
        $link=substr($link,0,50);
        $link=strtolower($link);
        $input['link']=$link;


        $validator = Validator::make($input,[
            //'name'  => 'required|max:50|unique:page,name',
            'title' => 'required|max:200|unique:pages,title',
            'link' => 'required|max:200|unique:pages,link',
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048,',
            'file' => 'mimes:pdf',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {



            $input['created_by'] = \Auth::user()->id;

            unset($input['photo']);


            $page=Page::create($input);

            if ($request->hasFile('photo')){
                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/page/');

                PagePhoto::create(['page_id'=>$page->id,'photo'=>$photoPath]);
            }

            $bug=0;
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=$request->all();

        if ($request->link==null)
        {
            $link=str_replace(' , ', '-', $input['title']);
            $link=str_replace(', ', '-', $link);
            $link=str_replace(' ,', '-', $link);
            $link=str_replace(',', '-', $link);
            $link=str_replace('/', '-', $link);
            $link=rtrim($link,' ');
            $link=str_replace(' ', '-', $link);
            $link=str_replace('.', '', $link);
            $link=substr($link,0,50);
            $link=strtolower($link);
            $input['link']=$link;
        }else{
            $input['link']=$request->link;
        }


        $validator = Validator::make($input,[
            //'name'  => 'required|max:50|unique:page,name',
            'title' => "required|max:200|unique:pages,title,$id",
            'link' => "required|max:200|unique:pages,link,$id",
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048,',
            'file' => 'mimes:pdf',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            $page=Page::findOrFail($id);

            $input['created_by'] = \Auth::user()->id;

            unset($input['photo']);


            $page->update($input);

            if ($request->hasFile('photo')){

                $photo=PagePhoto::where('page_id',$id)->first();

                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/page/');


                if (!empty($photo))
                {
                    if (file_exists($photo->photo)){
                        unlink($photo->photo);
                    }

                    $photo->update(['photo'=>$photoPath]);

                }else{
                    PagePhoto::create(['page_id'=>$id,'photo'=>$photoPath]);
                }

            }

            $bug=0;
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page=Page::findOrFail($id);

        DB::beginTransaction();
        try{


            $pagePhoto=PagePhoto::where('page_id',$page->id)->first();

            if (!empty($pagePhoto) && file_exists($pagePhoto->photo))
            {
                unlink($pagePhoto->photo);
            }
            $pagePhoto->delete();

            $page->delete();

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
