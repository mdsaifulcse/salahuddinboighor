<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,DataLoad;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.news.index');
    }



    public function getNewData()
    {

        $allData=News::leftJoin('categories','news.category_id','categories.id')
            ->leftJoin('users','news.news_author_id','users.id')
            ->select('categories.category_name','users.name','news.*')->orderBy('id','desc');

        return DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('news on','
                @if($show_at_homepage=="Yes")
                    <span class="btn btn-primary btn-xs">Home Classified </span>
                    @endif

               @if($is_cover_news=="Yes")
                <span class="btn btn-success btn-xs">Cover Classified </span>
                @endif
                ')
            ->addColumn('More News','
                @can(\'news-edit\')
                <a href="{{route(\'more-news-photo.show\',$id)}}" target="_blank" title="Add More Photo & News" class="btn btn-warning btn-sm"><i class="la la-plus"></i> </a>
                @endcan
                ')


            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'news.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                 @can(\'news-edit\')
                <a href="{{route(\'news.edit\',$id)}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                @endcan
                
                @can(\'news-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-xs">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            ')
            ->rawColumns(['news on','More News','action'])
            ->toJson();

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newsAuthors=DataLoad::newsAuthor();
        $categories=DataLoad::categoryList();
        $states=DataLoad::divisionList();

        return view('admin.news.create',compact('newsAuthors','categories','states'));
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
            'title'=> 'required|max:120',
            'feature_photo'=> 'required|image|mimes:jpeg,bmp,png,webp|max:3072',
            'description'=>'required',
            'topic'=>'required',
            'category_id'=>'required|exists:categories,id',
            'sub_cat_id'=>'nullable|exists:sub_categories,id',
            'division_id'=>'nullable|exists:divisions,id',
            'news_author_id'=>'nullable|exists:users,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try {


            $input['topic']=$request->topic[0];

            $input['created_by']=\Auth::user()->id;

            if (isset($request->published_status) && $request->published_status==News::PUBLISHED)
            {
                $input['published_date']=Carbon::now();
            }


            if ($request->hasFile('feature_photo')) {

                $input['feature_photo']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/big/');
                $input['feature_medium']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/medium',350,182);
                $input['feature_small']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/small',120);
            }


            News::create($input);

            $bug = 0;
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'News is Successfully Created');
        }elseif ($bug==1062){
            return redirect()->back()->with('error', 'The News has already been taken');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $newsAuthors=DataLoad::newsAuthor();
        $categories=DataLoad::categoryList();
        $states=DataLoad::divisionList();

        $subCats=DataLoad::subCatList($news->category_id);

        return view('admin.news.edit',compact('news','subCats','newsAuthors','categories','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title'=> 'required|max:120',
            'feature_photo'=> 'nullable|image|mimes:jpeg,bmp,png,webp|max:3072',
            'description'=>'required',
            'topic'=>'required',
            'category_id'=>'required|exists:categories,id',
            'sub_cat_id'=>'nullable|exists:sub_categories,id',
            'division_id'=>'nullable|exists:divisions,id',
            'news_author_id'=>'nullable|exists:users,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try {


            $input['topic']=$request->topic[0];

            $input['update_by']=\Auth::user()->id;

            if (isset($request->published_status) && $request->published_status==News::PUBLISHED  && $news->published_date==null)
            {
                $input['published_date']=Carbon::now();
            }


            if ($request->hasFile('feature_photo')) {

                $input['feature_photo']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/big/');
                $input['feature_medium']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/medium',350);
                $input['feature_small']=\MyHelper::photoUpload($request->file('feature_photo'),'images/news/small',120);

                if($news->feature_photo!=null and file_exists($news->feature_photo)){
                    unlink($news->feature_photo);
                }
                if($news->feature_medium!=null and file_exists($news->feature_medium)){
                    unlink($news->feature_medium);
                }
                if($news->feature_small!=null and file_exists($news->feature_small)){
                    unlink($news->feature_small);
                }
            }


            $news->update($input);

            $bug = 0;
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'News Successfully Update');
        }elseif ($bug==1062){
            return redirect()->back()->with('error', 'The News has already been taken');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news=News::findOrFail($id);
        DB::beginTransaction();
        try{
//            if($data->icon_photo!=null and file_exists($data->icon_photo)){
//                unlink($data->icon_photo);
//            }

            $news->delete();
            $bug = 0;
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
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
