<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Biggapon;
use App\Models\MostReadNews;
use App\Models\News;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\VisitorTrack;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

use EasyBanglaDate\Types\BnDateTime ;


class CategoryNewsController extends Controller
{
    public function index(Request $request, $category,$subCate=null,$newsId=null,$title=null, News $news)
    {

        $categoryData=Category::where('link',$category)->first();

        if (empty($categoryData))
        {
            return redirect()->back();
        }


        $categoryNews=News::with('newsCategory','newsSubCategory','newsAuthor','newsAuthor.profile')
            ->categoryNews('newsCategory','categories','link',$category)
            ->where('published_status',News::PUBLISHED);

        $allLatestNews=News::with('newsCategory','newsSubCategory')
            ->orderBy('id','DESC')->where('published_status',News::PUBLISHED)
            ->where('id','!=',$newsId);

        $categoryMostReadNews=News::with('newsCategory','newsSubCategory','mostReadNews')
            ->whereHas('mostReadNews',function ($q){
                $q->orderBy("most_read_news.read_number",'DESC');
            })->where('category_id',$categoryData->id);

        $mostReadNews=News::with('newsCategory','newsSubCategory','mostReadNews')
            ->whereHas('mostReadNews',function ($q){
                $q->orderBy("most_read_news.read_number",'DESC');
            });

        if ($newsId!=null)
        {
            News::findOrFail($newsId);

            $news=$categoryNews->with('moreNewsPhotos')->where('id',$newsId)->first();

            $latestCatNews=$allLatestNews->categoryNews('newsCategory','categories','link',$category)
                ->where('id','!=',$newsId)->take(5)->get();

            $latestNews=News::with('newsCategory','newsSubCategory')
                ->orderBy('id','DESC')->where('published_status',News::PUBLISHED)
                ->where('id','!=',$newsId)->take(4)->get();

            $categoryMostReadNews=$categoryMostReadNews->take(5)->get();

            $mostReadNews=$mostReadNews->take(4)->get();

            $readNews=MostReadNews::where('news_id',$newsId)->first();
            if (empty($readNews))
            {
                MostReadNews::create(['news_id'=>$newsId,'category_id'=>$categoryData->id,'read_number'=>1]);

            }else{
                $readNews->update(['read_number'=>$readNews->read_number+1]);
            }

            $sideA=Biggapon::where(['status'=>Biggapon::ACTIVE,'show_on_page'=>Biggapon::DETAIL_PAGE])->orderBy('serial_num','DESC')->take(2)->get();

            \MyHelper::countVisitor($request);
            return view('client.news-details',compact('news','latestCatNews','latestNews','categoryMostReadNews','mostReadNews','sideA'));
        }



        $subCatData='';
        if (!is_null($subCate) && $subCate!='news')
        {
            $subCatData=SubCategory::where('link',$subCate)->first();

            if (empty($subCatData))
            {
                return redirect()->back();
            }

            $categoryNews=$categoryNews->categoryNews('newsSubCategory','sub_categories','link',$subCate);

        }

        $allLatestNews=$allLatestNews->take(5)->get();
        $categoryMostReadNews=$categoryMostReadNews->take(10)->get();
        $mostReadNews=$mostReadNews->take(10)->get();


        if ($request->ajax()){
            $categoryNews= $categoryNews->simplePaginate(20);

            $output = '';

            if (count($categoryNews)>0){

                $url='';
                $image='';

                foreach ($categoryNews as $news){

                    if (isset($news->newsSubCategory))
                    {
                        $url=url($news->newsCategory->link.'/'.$news->newsSubCategory->link.'/'.$news->id.'/'.$news->title);
                    }else{
                        $url=url($news->newsCategory->link.'/'.'news'.'/'.$news->id.'/'.$news->title);
                    }
                    $image=asset($news->feature_medium);
                    $output.="
                    <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
                        <div class=\"single-block cat-block\">
                            <div class=\"row\">
                                <div class=\"col-xs-5 col-sm-5\">
                                    <div class=\"img-box\">
                                        <a href=\"$url\" title=\"$news->title\">
                                            <img alt=\"$news->title\" src=\"$image\" data-src=\"$news->feature_medium\" class=\"lazyload img-responsive\">
                                        </a>
                                    </div>
                                </div>
                                <div class=\"col-xs-7 col-sm-7\">
                                    <div class=\"paddingTop10 paddingRight10\">
                                        <h3 style=\"font-size:1.1em;\"><a href=\"$url\" title=\"$news->title\">$news->title</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                } // end foreach
            }else{
                $output.='<h4 class="text-danger text-center">No Record Found !</h4>';
            }
            return $output;
        }


        $categoryNews= $categoryNews->simplePaginate(21);

        $sideA=Biggapon::where(['status'=>Biggapon::ACTIVE,'show_on_page'=>Biggapon::OTHER_PAGE])->orderBy('serial_num','DESC')->take(2)->get();

        \MyHelper::countVisitor($request);

        return view('client.category-news',compact('categoryData','subCatData','categoryNews','allLatestNews','categoryMostReadNews',
            'mostReadNews','sideA'));
    }


    public function topicalNews($topic,Request $request)
    {

        if ($topic!=null){

            $topicalNews=News::with('newsCategory','newsSubCategory')
                ->orderBy('id','DESC')->where(['published_status'=>News::PUBLISHED])
                ->where('topic','LIKE',"%{$topic}%")->simplePaginate(1);

            if ($request->ajax()){


                $result='';
                if (count($topicalNews)>0){

                    $url='';
                    foreach ($topicalNews as $topic)
                    {

                        if (isset($topic->newsSubCategory))
                        {
                            $url=url($topic->newsCategory->link.'/'.$topic->newsSubCategory->link.'/'.$topic->id.'/'.$topic->title);
                        }else{
                            $url=url($topic->newsCategory->link.'/'.'news'.'/'.$topic->id.'/'.$topic->title);
                        }
                        $image=asset($topic->feature_medium);
                        $categoryData=$topic->newsCategory->category_name;
                        $categoryLink=url($topic->newsCategory->link);

                         $bongabda = new \EasyBanglaDate\Types\BnDateTime($topic->published_date);
                        $dateTime=$bongabda->getDateTime()->format('h:i a, l jS F Y ');


                        //$dateTime=\MyHelper::bn_date_time(date('h:i A, d M Y l'),strtotime($topic->published_date));

                        if (strlen($topic->meta_description) != strlen(utf8_decode($topic->meta_description)))
                        {
                            $metaDes=substr($topic->meta_description,0,300);
                        }else{
                            $metaDes=substr($topic->meta_description,0,19);
                        }


                        $result.="<div class=\"tag-block\">
                                    <div class=\"row\">
                                        <div class=\"col-sm-4\">
                                            <div class=\"tag-img\">
                                                <a href=\"$url\">
                                                    <img alt=\"$topic->title\" src=\"$image\"  class=\"lazyload img-responsive\">
                                                </a>
                                                <div class=\"overlay-category\">
                                                    <a href=\"$categoryLink\" rel=\"nofollow\">$categoryData</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=\"col-sm-8\">
                                            <h3>
                                                <a href=\"$url\">$topic->title</a>
                                            </h3>
                                            <small>$dateTime</small>
                                            <p>
                                                $metaDes
                                            </p>
                                        </div>
                                    </div>
                                </div>";

                    } // end foreach

                }else{
                    $result.='<h4 class="text-danger text-center">No Record Found !</h4>';
                }
                return $result;

            }

            \MyHelper::countVisitor($request);

            return view('client.topical-news',compact('topicalNews','topic'));

        }else{
            return redirect()->back();
        }

    }

}
