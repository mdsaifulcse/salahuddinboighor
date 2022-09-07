<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=Testimonial::orderby('serial_num','ASC')->paginate(20);
        $max_serial=Testimonial::max('serial_num');

        return view('admin.slider.testimonial',compact('allData','max_serial'));
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
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048'

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->all();


        try {

            if ($request->hasFile('image')){
                $input['image']=\MyHelper::photoUpload($request->file('image'),'images/testimonial/',142);
            }


            $input['created_by'] = \Auth::user()->id;

            Testimonial::create($input);
            $bug = 0;

        } catch (\Exception $e) {
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
     * @param  \App\Model\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {

        return view('backend.testimonial.edit',compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //return $request;
        $data = Testimonial::where('id',$id)->first();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'content' => 'required'

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        try {

            if ($request->hasFile('image')){
                $input['image']=\MyHelper::photoUpload($request->file('image'),'images/testimonial/',142);
                if (file_exists($data->image)){
                    unlink($data->image);
                }
            }

            $data->update($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Updated Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            $data=Testimonial::findOrFail($id);

//            if (file_exists($data->image)){
//                unlink($data->image);
//            }

            $data->delete();

            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }

    }
}
