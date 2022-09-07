<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\VisitorTrack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,MyHelper,DataLoad;

class ArchiveController extends Controller
{
    public function  archiveNews(Request $request)
    {
        $newses=News::with('newsCategory','newsSubCategory')
            ->orderBy('id','DESC');

        if ((isset($request->dateFrom) && $request->dateFrom!=null) && (isset($request->dateTo) && $request->dateTo!=null))
        {
            $newses=$newses->whereBetween('published_date',[Carbon::parse($request->dateFrom),Carbon::parse($request->dateTo)]);

        }elseif(isset($request->dateFrom) && $request->dateFrom!=null)
        {
            $newses=$newses->whereDate('published_date','>=',Carbon::parse($request->dateFrom));
        }
        elseif (isset($request->dateTo) && $request->dateTo!=null)
        {
            $newses=$newses->whereDate('published_date','<=',Carbon::parse($request->dateTo));
        }


        if (isset($request->category_id) && $request->category_id!=null)
        {
            $newses=$newses->where('category_id',$request->category_id);
        }

        if (isset($request->division_id) && $request->division_id!=null)
        {
            $newses=$newses->where('division_id',$request->division_id);
        }

        if (isset($request->keyword) && $request->keyword!=null)
        {
            $newses=$newses->where('title','LIKE', "%{$request->keyword}%")
                ->orWhere('topic',"%{$request->keyword}%")->orWhere('meta_description',"%{$request->keyword}%")
                ->orWhere('description',"%{$request->keyword}%");
        }


        $newses=$newses->paginate(20);

        $categories=DataLoad::categoryList();
        $states=DataLoad::divisionList();

        \MyHelper::countVisitor($request);

        return view('client.archive-news',compact('newses','categories','states','request'));

    }

}
