<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Biggapon;
use App\Models\Brand;
use App\Models\MostReadNews;
use App\Models\News;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\ThirdSubCategory;
use App\Models\VisitorTrack;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

use EasyBanglaDate\Types\BnDateTime ;
use DataLoad;


class SearchAuthorBooksController extends Controller
{
    public function index(Request $request, $authorId=null)
    {
        if (!is_null($authorId)){

            $authorData=Author::where('id',$authorId)->first();
        }else{
            $authorData=Author::where('name_bn',$request->author)->first();
        }
        if (empty($authorData))
        {
            return redirect()->back()->with('error','Author Not Found !');
        }

        $products=Product::with('relProductAuthors','categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->filterProducts('relProductAuthors','book_authors','author_id',$authorData->id)
            ->where('status',Product::PUBLISHED)->orderBy('products.id','DESC');

        if (!empty($request->sub_cat))
        {
            $subCategory=SubCategory::select('id','link')
                ->where('link',$request->sub_cat)->first();
            if (empty($subCategory))
            {
                return redirect()->back()->with('error',' Sub-Category Not Found !');
            }
            $products=$products->filterProducts('subCategoryProducts','sub_categories','link',$subCategory->link);
        }
        if (!empty($request->third_sub_cat))
        {
            $thirdCategory=ThirdSubCategory::select('id','link')
                ->where('link',$request->third_sub_cat)->first();

            if (empty($thirdCategory))
            {
                return redirect()->back()->with('error',' Third-Category Not Found !');
            }

            $products=$products->filterProducts('thirdCategoryProducts','third_sub_categories','link',$thirdCategory->link);

        }
        if (!empty($request->brand))
        {
            $brand=Brand::select('id','link')
                ->where('link',$request->brand)->first();

            if (empty($brand))
            {
                return redirect()->back()->with('error',' Brand Not Found !');
            }
            $products=$products->filterProducts('brandProducts','brands','link',$brand->link);
        }
        $perPage=20;
        if ($request->has('perPage'))
        {
            $perPage=$request->perPage;
        }

        $products=$products->paginate($perPage);


        $setting=$setting=DataLoad::setting();
        return view('client.author-book',compact('setting','products','authorData','request'));
    }

    public function authorListShow(){
        $authors=Author::orderBy('serial_num','ASC')->where(['status'=>Author::ACTIVE])
          ->select('id','name','name_bn','photo')->paginate(50);

        $popularAuthors=Author::select('id','name','name_bn','photo')->where(['status'=>Author::ACTIVE,'show_home'=>Author::Yes])
            ->orderBy('serial_num',"ASC")->get();

        $setting=$setting=DataLoad::setting();
        return view('client.author-list',compact('setting','authors','popularAuthors'));
    }

    public function returnAuthorData(Request $request){

        return Author::select('name_bn','id')
            ->where('name', 'like', '%' .$request->q. '%')->pluck('name_bn','id');
    }

    public function singleProductDetails($productId,$productName=null,Request$request)
    {
        $product=Product::with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','originProducts','packSizeUnitProducts','productReview','productPromotion','tags','relatedProducts',
            'relProductAuthorsName','publisher','country','language')
            ->withCount('productReview')->withAvg('productReview','rating')->findOrFail($productId);

        $setting=$setting=DataLoad::setting();
        $shippingMethods=ShippingMethod::where(['status'=>ShippingMethod::ACTIVE])->orderBy('serial_num','ASC')->get();

        //dd($product);

        return view('client.single-product',compact('product','request','setting','shippingMethods'));
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
                        $categoryId=url($topic->newsCategory->link);

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
                                                    <a href=\"$categoryId\" rel=\"nofollow\">$categoryData</a>
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
