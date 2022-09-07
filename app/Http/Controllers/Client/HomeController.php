<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\Biggapon;
use App\Models\Category;
use App\Models\News;

use App\Models\Product;

use App\Models\SocialIcon;
use Illuminate\Http\Request;

use DB,Auth,DataLoad;

class HomeController extends Controller
{
    public function index()
    {

        return view('client.index'); // Data Provide to view through AppService Provider ----
    }


    public function searchResult(Request $request)
    {
        \MyHelper::countVisitor($request);
        $results='';
        $userPlay='';

        if (isset($request->user_play) &&  $request->user_play!=''){
            $userPlay=$request->user_play;

            $results=News::with('newsCategory','newsSubCategory')
                ->orderBy('id','DESC')->where(['published_status'=>News::PUBLISHED])
                ->where('title','LIKE',"%{$request->user_play}%")
                ->orWhere('meta_description','LIKE',"%{$request->user_play}%")
                ->orWhere('topic','LIKE',"%{$request->user_play}%")
                ->orWhere('description','LIKE',"%{$request->user_play}%")
                ->paginate(20);

            return view('client.search-result',compact('results','userPlay'));

        }else{
            return redirect()->back();
        }

    }
}
