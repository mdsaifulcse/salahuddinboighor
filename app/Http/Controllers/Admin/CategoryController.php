<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $allData=Category::orderBy('serial_num','DESC')->paginate(200);
        $max_serial=Category::max('serial_num');
        return view('admin.categories.index',compact('allData','max_serial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if (is_null($request->link)) {
            $input['link']= MyHelper::slugify($request->category_name);
        }

        $validator = Validator::make($input, [
            'category_name' => 'required',
            'link' => 'required|unique:categories,link,NULL,id,deleted_at,NULL',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['created_by']=\Auth::user()->id;

        if ($request->hasFile('icon_photo'))
        {
            $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/categories/',250,155);
        }

        Category::create($input);
        try{
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $bug2=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Category Successfully Created');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug2);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=Category::with('subCategoryData')->findOrFail($id);

        $max_serial=Category::max('serial_num');
        return view('admin.categories.edit',compact('data','max_serial'));
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
        $input = $request->all();

        $data=Category::findOrFail($id);

        $validator = Validator::make($input, [
            'category_name' => 'required',
            'serial_num' => 'required',
            'link' => "required|unique:categories,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error','Duplicate or empty record found.');
        }
        $input['updated_by']=\Auth::user()->id;
        if ($request->hasFile('icon_photo')) {
            $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/categories/',250,155);

            if($data->icon_photo!=null and file_exists($data->icon_photo)){
                unlink($data->icon_photo);
            }
        }

        try{
            $data->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug = $e->errorInfo[1];
            $bug2=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Category Successfully Updated');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! '.$bug2);
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

        $data=Category::findOrFail($id);
        try{
//            if($data->icon_photo!=null and file_exists($data->icon_photo)){
//                unlink($data->icon_photo);
//            }
            $data->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e){
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
