<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB, MyHelper;
use Yajra\DataTables\DataTables;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Author List';
        return view('admin.author.index',compact('title'));
    }

    public function getAuthorsData(){
        $allData=Author::select('authors.*');

        return DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')

            ->addColumn('action','
                        <!-- #permissionModal -->
                        
	                                            <!-- end edit section -->

	                                            <!-- delete section -->
	                                            {!! Form::open(array(\'route\'=> [\'authors.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
	                                                {{ Form::hidden(\'id\',$id)}}
	                                                <a href="{{route(\'authors.edit\',$id)}}" class="btn btn-sm btn-success">Edit </a>
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
        $title='Create New Author';
        $status=[

            Author::ACTIVE=>Author::ACTIVE,
            Author::INACTIVE=>Author::INACTIVE,
        ];
        $showHome=[

            Author::Yes=>Author::Yes,
            Author::No=>Author::No,
        ];
        $maxSerial=Author::max('serial_num');
        return view('admin.author.create',compact('title','status','showHome','maxSerial'));
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
            'email'  => "nullable|unique:authors|email|max:100",
            'mobile'  => "nullable|unique:authors|max:15",
            'address1'=> 'nullable|max:100',
            'contact'=> 'nullable|max:100',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',

        ]);

        $input = $request->except('_token');

        try{
            $input['link']= MyHelper::slugify($request->name);
            $photoPath='';
            if ($request->hasFile('photo'))
            {
                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/author-images',150,150);

                $input['photo']=$photoPath;
            }

            $input['created_by']=Auth::user()->id;
             Author::create($input);

            return redirect()->back()->with('success','New Author created successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        $title='Edit Author Info';
        $status=[

            Author::ACTIVE=>Author::ACTIVE,
            Author::INACTIVE=>Author::INACTIVE,
        ];
        $showHome=[
            Author::Yes=>Author::Yes,
            Author::No=>Author::No,
        ];
        $maxSerial=Author::max('id');
        return view('admin.author.edit',compact('title','status','showHome','maxSerial','author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {

        $id=$author->id;
        $input = $request->except('_token');
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'email'  => "nullable|unique:authors,email,$id|email|max:100",
            'mobile'  => "nullable|unique:authors,mobile,$id|max:15",
            'address1'=> 'nullable|max:100',
            'contact'=> 'nullable|max:100',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {

            $input = $request->all();
            $input['link']= MyHelper::slugify($request->name);
            $photoPath='';
            if ($request->hasFile('photo'))
            {
                $photoPath=\MyHelper::photoUpload($request->file('photo'),'images/author-images',150,150);

                if (!empty($author) && file_exists($author->photo)){
                    unlink($author->photo);
                }
                $input['updated_by']=Auth::user()->id;
                $input['photo']=$photoPath;
            }

            $author->update($input);
            return redirect()->back()->with('success','Updated Successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {

        try {
            $author->delete();
            return redirect()->back()->with('success',' Author deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
