<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Auth,Validator,MyHelper,Route;
class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections=Collection::orderBy('id','DESC')->paginate(20);
        $max_serial=Collection::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('collections','max_serial'));
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
            $input['link']= MyHelper::slugify($request->collection);
        }



        $validator = Validator::make($input, [
            'collection' => 'required|max:200|unique:collections,collection,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:collections,link,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails())
        {

            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }

        $input['created_by']=\Auth::user()->id;



        try{

            Collection::create($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $productCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $productCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $productCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $productCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $productCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'collection' => "required|max:200|unique:collections,collection,$id,id,deleted_at,NULL",
            'link' => "unique:collections,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }


        try{

            $collection=Collection::findOrFail($id);
            $input['updated_by']=\Auth::user()->id;

            $collection->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $productCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection=Collection::findOrFail($id);
        try{
            $collection->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
