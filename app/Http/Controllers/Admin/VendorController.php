<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Supplier ';
        return view('admin.vendors.index',compact('title'));
    }

    public function getVendorData()
    {
        $allData=Vendor::orderBy('id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')


            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'vendors.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                 @can(\'vendor-edit\')
                <a href="{{route(\'vendors.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                @endcan
                
                @can(\'vendor-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-xs" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            ')
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max_serial=Vendor::max('serial_num');

        $title='Supplier';
        $status=[
            \App\Models\Vendor::ACTIVE  => \App\Models\Vendor::ACTIVE ,
            \App\Models\Vendor::INACTIVE  => \App\Models\Vendor::INACTIVE,
        ];
        return view('admin.vendors.create',compact('max_serial','title','status'));
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
            'name' => 'required|max:200',
            'email' => 'required|max:200',
            'mobile' => 'required|max:50',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{

            $input['created_by']=\Auth::user()->id;
            if (is_null($request->balance))
            {
                $input['balance']=0.0;
            }
            Vendor::create($input);

            return redirect()->back()->with('success','Data Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $title='Supplier Update';
        $max_serial=Vendor::max('serial_num');
        $status=[
            \App\Models\Vendor::ACTIVE  => \App\Models\Vendor::ACTIVE ,
            \App\Models\Vendor::INACTIVE  => \App\Models\Vendor::INACTIVE,
        ];
        return view('admin.vendors.edit',compact('title','status','max_serial','vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $input = $request->all();

        $id=$vendor->id;

        $validator = Validator::make($input, [
            'name' => 'required|max:200',
            'email' => 'required|max:200',
            'mobile' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $input['updated_by']=\Auth::user()->id;


        try{
            if (is_null($request->balance))
            {
                $input['balance']=0.0;
            }

            $vendor->update($input);

            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        try{
            $vendor->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
