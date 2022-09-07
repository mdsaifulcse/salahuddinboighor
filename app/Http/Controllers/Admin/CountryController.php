<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Validator;
use DB,Auth;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Country List';
        $max_serial=Country::max('serial_num');
        $status=[

            Country::ACTIVE=>Country::ACTIVE,
            Country::INACTIVE=>Country::INACTIVE,
        ];
        return view('admin.country.index',compact('title','max_serial','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $allData=Country::select('countries.*');
        $status=[

            Country::ACTIVE=>Country::ACTIVE,
            Country::INACTIVE=>Country::INACTIVE,
        ];

        return DataTables::of($allData,$status)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')

            ->addColumn('action','
                                                <!-- delete section -->
	                                            {!! Form::open(array(\'route\'=> [\'countries.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
	                                                {{ Form::hidden(\'id\',$id)}}
	                                                <a href="javascript:void(0)" onclick="showEditModal({{$id}})" class="btn btn-sm btn-success">Edit </a>
	                                                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="btn btn-danger btn-sm">
	                                                  Delete
	                                                </button>
	                                            {!! Form::close() !!}
            ')
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'status' => 'required|max:15'
        ]);

        $input = $request->except('_token');

        try{

            $input['created_by']=Auth::user()->id;
            Country::create($input);

            return redirect()->back()->with('success','New Country created successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        $max_serial=Country::max('serial_num');
        $status=[

            Country::ACTIVE=>Country::ACTIVE,
            Country::INACTIVE=>Country::INACTIVE,
        ];
        return view('admin.country.edit',compact('max_serial','status','country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(),[

            'name' => 'required|max:150',
            'status' => 'required|max:15'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {

            $input = $request->all();
            $input['updated_by']=Auth::user()->id;

            $country->update($input);
            return redirect()->back()->with('success','Updated Successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        try {
            $country->delete();
            return redirect()->back()->with('success','Country deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
