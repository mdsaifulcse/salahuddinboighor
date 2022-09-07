<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Validator;
use DB,Auth;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Language List';
        $max_serial=Language::max('serial_num');
        $status=[

            Language::ACTIVE=>Language::ACTIVE,
            Language::INACTIVE=>Language::INACTIVE,
        ];
        return view('admin.language.index',compact('title','max_serial','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allData=Language::select('languages.*');
        $status=[

            Language::ACTIVE=>Language::ACTIVE,
            Language::INACTIVE=>Language::INACTIVE,
        ];

        return DataTables::of($allData,$status)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')

            ->addColumn('action','
                                                <!-- delete section -->
	                                            {!! Form::open(array(\'route\'=> [\'languages.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
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
            Language::create($input);

            return redirect()->back()->with('success','New Language created successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        $max_serial=Language::max('serial_num');
        $status=[

            Language::ACTIVE=>Language::ACTIVE,
            Language::INACTIVE=>Language::INACTIVE,
        ];
        return view('admin.language.edit',compact('max_serial','status','language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
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

            $language->update($input);
            return redirect()->back()->with('success','Updated Successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        try {
            $language->delete();
            return redirect()->back()->with('success',' Language deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
