<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VatTax;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class VatTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vatTaxes=VatTax::orderBy('id','DESC')->paginate(20);
        $max_serial=VatTax::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('vatTaxes','max_serial'));
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
            'vat_tax_name' => 'required|max:200',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $input['created_by']=\Auth::user()->id;

        try{

            VatTax::create($input);

            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VatTax  $vatTax
     * @return \Illuminate\Http\Response
     */
    public function show(VatTax $vatTax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VatTax  $vatTax
     * @return \Illuminate\Http\Response
     */
    public function edit(VatTax $vatTax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VatTax  $vatTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'vat_tax_name' => 'required|max:200',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $tag=VatTax::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{
            $tag->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VatTax  $vatTax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vatTax=VatTax::findOrFail($id);
        try{
            $vatTax->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
