<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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


class SearchProductController extends Controller
{
    public function index(Request $request, $categoryId=null)
    {
        if (!is_null($categoryId)){

            $categoryData=Category::with('products')->select('id','category_name','category_name_bn','link')
                ->where('id',$categoryId)->first();
        }else{
            $categoryData=Category::with('products')->select('id','category_name','category_name_bn','link')
                ->where('category_name_bn',$request->category)->first();
        }

        if (empty($categoryData))
        {
            return redirect()->back()->with('error','Category Not Found !');
        }


        $products=Product::with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->filterProducts('categoryProducts','categories','id',$categoryData->id)
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
        return view('client.category-product',compact('setting','products','categoryData','request'));
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


    public function returnCategoryData(Request $request){

        return Category::select('category_name_bn','id')
            ->where('category_name', 'like', '%' .$request->q. '%')->pluck('category_name_bn','id');
    }

    public function searchProduct(Request $request)
    {

        $categoryData=Category::with('products')->select('id','category_name','link')
            ->where('id',$request->category_id)->first();


        $products=Product::with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->where('status',Product::PUBLISHED)->orderBy('products.id','DESC');

        if (!empty($categoryData))
        {
            $products=$products->where('products.category_id',$request->category_id);
        }



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

        if ($request->has('search'))
        {
            $products=$products->where('products.name', 'LIKE','%' .$request->search . '%');
        }

        $products=$products->paginate($perPage);

        $setting=$setting=DataLoad::setting();
        return view('client.product-search',compact('setting','products','categoryData','request','request'));
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

    public function categoryListShow(){
        $categories=Category::orderBy('serial_num','ASC')->where(['status'=>Category::ACTIVE])
            ->select('id','category_name','category_name_bn','icon_photo')->paginate(50);

        $setting=$setting=DataLoad::setting();
        return view('client.category-list',compact('setting','categories'));
    }

}
