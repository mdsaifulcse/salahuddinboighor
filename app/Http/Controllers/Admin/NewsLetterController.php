<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Image,DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class NewsLetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.news-letter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allData=NewsLetter::leftJoin('users','users.id','news_letters.created_by')
            ->select('users.name','news_letters.*')
            ->orderBy('id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Created At','
                    <?php echo date(\'D-M-Y H:i A\',strtotime($created_at)) ;?>
                ')

            ->addColumn('action','
            
            <!-- #permissionModal -->
                        <div class="modal fade" id="editEmail<?php echo $id;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                {!! Form::open(array(\'route\' => [\'news-letters.update\',$id],\'class\'=>\'form-horizontal author_form\',\'method\'=>\'PUT\',\'files\'=>\'true\', \'id\'=>\'commentForm\',\'role\'=>\'form\',\'data-parsley-validate novalidate\')) !!}
                                    <div class="modal-header">
                                        <h4 class="modal-title">Email Edit</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="form-group row">
                                            
                                            <div class="col-md-12 col-sm-12">
                                                <input class="form-control" type="email" id="name" name="email" value="<?php echo $email; ?>" />
                                            </div>
                                        </div>
                                      
                                           
	                                                        </div>
	                                                        
	                                                        <div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success ">Update</button>
							<a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
						</div>
	                                                    {!! Form::close(); !!}
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <!-- end edit section -->
            
            
            {!! Form::open(array(\'route\'=> [\'news-letters.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                 @can(\'product-edit\')
                <a href="#editEmail<?php echo $id;?>"  data-toggle="modal" class="btn btn-success btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                @endcan
                
                @can(\'product-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-xs" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            
            
            
            
            
            
            ')
            ->rawColumns(['Created At','action'])
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
        $input = $request->all();

        try{
            $validator = Validator::make($input, [
                'email' => 'required|max:200|email',

            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            if (\Auth::check()){
                $input['created_by']=\Auth::user()->id;
            }

            $email=NewsLetter::where('email',$request->email)->first();
            if (empty($email))
            {
                NewsLetter::create($input);
            }else{
                $email->update($input);
            }




            return redirect()->back()->with('success','Thank You For Your Email');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsLetter  $newsLetter
     * @return \Illuminate\Http\Response
     */
    public function show(NewsLetter $newsLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsLetter  $newsLetter
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsLetter $newsLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsLetter  $newsLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsLetter $newsLetter)
    {
        $input = $request->all();

        try{
            $validator = Validator::make($input, [
                'email' => 'required|max:200|email',

            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            if (\Auth::check()){
                $input['created_by']=\Auth::user()->id;
            }

            $newsLetter->update($input);



            return redirect()->back()->with('success','Thank You For Your Email');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsLetter  $newsLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsLetter $newsLetter)
    {
        DB::beginTransaction();
        try{

            $newsLetter->delete();
            DB::commit();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
