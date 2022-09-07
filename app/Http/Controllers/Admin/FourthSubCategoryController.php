<?php

namespace App\Http\Controllers\Admin;

use App\Models\FourthSubCategory;
use App\Models\ThirdSubCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB,Auth,Validator,MyHelper;

class FourthSubCategoryController extends Controller
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
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->fourth_sub_category);
        }


        $validator = Validator::make($input, [
            'fourth_sub_category' => 'required|max:200',
            'link' => 'required|unique:fourth_sub_categories,link,NULL,id,deleted_at,NULL',
            'third_sub_category_id' => 'required|exists:third_sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['created_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/fourth-sub-categories/',100);
            }

            FourthSubCategory::create($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $bug2=$e->errorInfo[2];
        }
        if($bug==0)
        {
            return redirect()->back()->with('success','Data Successfully Inserted');
        }elseif($bug==1062)
        {
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug2);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FourthSubCategory  $forthSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thirdSutCategory=ThirdSubCategory::with('subCategory')->findOrFail($id);

        $allData=FourthSubCategory::with('thirdSubCategory')->where('third_sub_category_id',$id)->orderBy('id','DESC')->paginate(50);

        $max_serial=FourthSubCategory::where('third_sub_category_id',$id)->max('serial_num');

        return view('admin.categories.fourth-sub-category',compact('allData','thirdSutCategory','max_serial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FourthSubCategory  $forthSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FourthSubCategory $forthSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FourthSubCategory  $forthSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'fourth_sub_category' => 'required|max:200',
            'link' => "required|unique:fourth_sub_categories,link,$id,id,deleted_at,NULL",
            'third_sub_category_id' => 'required|exists:third_sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {

            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $data=FourthSubCategory::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/fourth-sub-categories/',100);

                if($data->icon_photo!=null and file_exists($data->icon_photo))
                {
                    unlink($data->icon_photo);
                }
            }


            $data->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug = $e->errorInfo[1];
            $bug2=$e->errorInfo[2];
        }
        if($bug==0)
        {
            return redirect()->back()->with('success','Data Successfully Updated');
        }elseif($bug==1062)
        {
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug2);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FourthSubCategory  $forthSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id )
    {
        $forthSubCategory=FourthSubCategory::findOrFail($id);
        try{
            $forthSubCategory->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e)
        {
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0)
        {
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451)
        {
            return redirect()->back()->with('error','This Data is Used anywhere ! ');
        }
        elseif($bug>0)
        {
            return redirect()->back()->with('error','Some thing error found !'.$bug);
        }
    }
}
