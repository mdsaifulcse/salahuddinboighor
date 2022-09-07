<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Validator;
use DB;
use Yajra\DataTables\DataTables;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Author List';
        return view('admin.publisher.index',compact('title'));
    }

    public function getpublishersData(){
        $allData=Publisher::select('publishers.*');

        return DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')

            ->addColumn('action','
                        <!-- #permissionModal -->
                        
	                                            <!-- end edit section -->

	                                            <!-- delete section -->
	                                            {!! Form::open(array(\'route\'=> [\'publishers.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
	                                                {{ Form::hidden(\'id\',$id)}}
	                                                <a href="{{route(\'publishers.edit\',$id)}}" class="btn btn-sm btn-success">Edit </a>
	                                                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="btn btn-danger btn-sm">
	                                                  Delete
	                                                </button>
	                                            {!! Form::close() !!}
            ')->addColumn('Photo','
                    <img src="<?php echo asset($photo);?>" alt="<?php echo $name;?>" width="50">
                ')
            ->rawColumns(['action','Photo'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Create New Publisher';
        $status=[

            Publisher::ACTIVE=>Publisher::ACTIVE,
            Publisher::INACTIVE=>Publisher::INACTIVE,
        ];
        $maxSerial=Publisher::max('serial_num');
        return view('admin.publisher.create',compact('title','status','maxSerial'));
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
            'email'  => "nullable|unique:publishers|email|max:100",
            'mobile'  => "nullable|unique:publishers|max:15",
            'address1'=> 'nullable|max:100',
            'contact'=> 'nullable|max:100',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',

        ]);

        $input = $request->except('_token');
        $input['establish']=date('Y-m-d',strtotime($request->establish));

        try{
            $photoPath='';
            if ($request->hasFile('photo'))
            {
                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/publisher-images',150);

                $input['photo']=$photoPath;
            }

            $input['created_by']=\Auth::user()->id;
            Publisher::create($input);

            return redirect()->back()->with('success','New Publisher created successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        $title='Edit Publisher Info';
        $status=[

            Publisher::ACTIVE=>Publisher::ACTIVE,
            Publisher::INACTIVE=>Publisher::INACTIVE,
        ];
        $maxSerial=Publisher::max('id');
        return view('admin.publisher.edit',compact('title','status','maxSerial','publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $id=$publisher->id;
        $input = $request->except('_token');
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'email'  => "nullable|unique:publishers,email,$id|email|max:100",
            'mobile'  => "nullable|unique:publishers,mobile,$id|max:15",
            'address1'=> 'nullable|max:100',
            'contact'=> 'nullable|max:100',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {

            $input['establish']=date('Y-m-d',strtotime($request->establish));

            $photoPath='';
            if ($request->hasFile('photo'))
            {
                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/publisher-images',150);

                if (!empty($publisher) && file_exists($publisher->photo)){
                    unlink($publisher->photo);
                }
                $input['updated_by']=\Auth::user()->id;
                $input['photo']=$photoPath;
            }
            $publisher->update($input);
            return redirect()->back()->with('success','Updated Successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        try {
            $publisher->delete();
            return redirect()->back()->with('success',' Publisher deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
