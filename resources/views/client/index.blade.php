@extends('client.layouts.master')
@section('head')
    <title> Home | {{$setting->company_title}} </title>
    <meta name="description" content="{{$setting->company_}}" /><meta name="keywords" content=" " />
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/animate.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/owl.carousel.css">
    <style>
        .so-categories .card{min-height:194px;max-height:217px;border:1px solid #b8b8b8;margin-bottom:10px;}
        .card-horizontal {display: inline-flex;flex: 1 1 auto;}
        .card-horizontal .img-square-wrapper{padding: 5px; margin-right: 5px;max-width: 140px;margin: auto 5px;}
        .card-horizontal .card-body{padding:20px 5px;}
        .card-horizontal .card-body a{font-size:14px;display:block;padding:1px;}
        .card-horizontal .card-body a:first-child{color: black;font-weight: 500;padding-bottom: 6px;}
    </style>
@endsection
@section('content')
    <div id="content" class="">
        <div class="so-page-builder">
            <div style="margin-bottom:15px;">
                <div class="container page-builder-ltr">
                    <div class="row row_gw4 ">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_6s4m  slideshow-full">
                            <div class="row row_ki3w  row-style ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="module sohomepage-slider">
                                        <div class="modcontent">
                                            <div id="sohomepage-slider1">
                                                <div class="so-homeslider sohomeslider-inner-1">
                                                    <!-- Data come form CompanyServiceProvider -->
                                                    @forelse($sliders as $slider)
                                                        <div class="item">
                                                            <a href="javascript:;" title="{{$slider->caption}}" target="_self">
                                                                <img class="lazyload"   src="" data-src="{{asset($slider->image)}}"  alt="slide 1" />
                                                            </a>
                                                            <div class="sohomeslider-description"> </div>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div> <!--/.modcontent-->
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!--End Slider Container-->
            </div>


            <div id="register-login-profile">
                <div class="container">
                    <div class="register-login">
                        <div class="row">
                            <!--top Biggapon-->
                            @forelse($biggapons->where('place',\App\Models\Biggapon::TOP)->where('show_on_page',\App\Models\Biggapon::HOME_PAGE)->take(1) as $i=>$topBiggapon)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_llqj  col-style">
                                    <div class="banners bannersb">
                                        <div class="banner">
                                            <a href="{{URL::to($topBiggapon->target_url)}}"><img src="{{asset($topBiggapon->image)}}" alt="image"></a>
                                        </div>
                                    </div>
                                </div><!--end row-->
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_vnrl  col-style">--}}
                        {{--<!--[if gt IE 9]><!-->--}}
                        {{--<div class="so-categories module theme3 custom-slidercates" style="margin-top:30px;marign-bottom:15px;">--}}
                            {{--<h3 class="modtitle text-center"><span>{{__('frontend.Shop by Categories')}}</span></h3>--}}
                            {{--<div class="form-group"> <a class="viewall" href="{{URL::to('/book/categories')}}">View All</a></div>--}}
                            {{--<div class="container">--}}
                                {{--<div class="row">--}}
                                    {{--<?php $i=0;?>--}}
                                    {{--@forelse($categories->chunk(7) as $j=>$categorie)--}}
                                        {{--<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 ">--}}
                                            {{--<div class="card">--}}
                                                {{--<div class="card-horizontal">--}}
                                                    {{--<div class="img-square-wrapper hidden-xs">--}}
                                                        {{--@if(isset($categories[$i]))--}}
                                                            {{--<a href="{{URL::to('/book/category/'.$categories[$i]->id.'?ref='.$categories[$i]->category_name)}}"><img class="img-responsive" src="{{asset($categories[$i]->icon_photo)}}" alt="{{$categories[$i]->category_name_bn}}"></a>--}}
                                                        {{--@else--}}
                                                            {{--<img class="img-responsive" src="http://via.placeholder.com/300x180" alt="Card image cap">--}}
                                                        {{--@endif--}}
                                                    {{--</div>--}}
                                                    {{--<div class="card-body">--}}
                                                        {{--@foreach($categorie as $k=>$value)--}}
                                                            {{--<a href="{{URL::to('/book/category/'.$value->id.'?ref='.$value->category_name)}}" class="card-text">{{$value->category_name_bn}}</a>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<?php $i+=7;?>--}}
                                    {{--@empty--}}
                                    {{--@endforelse--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div><!-- end Shop by Categories row -->--}}

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style">
                        <div id="featureBook" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.Feature Product')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">
                                        @forelse($featureProducts as $key=>$featureProduct)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if ($featureProduct->promotion==\App\Models\Product::YES && isset($featureProduct->productPromotion) && $featureProduct->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$featureProduct->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$featureProduct->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$featureProduct->id."/$featureProduct->name")}}" target="_self" title="{{$featureProduct->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($featureProduct->productImages[0]->medium)}}" alt="{{$featureProduct->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">

                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$featureProduct->id}}">

                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>

                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$featureProduct->name}}"
                                                                        onclick='event.preventDefault();
                                                                                document.getElementById("wishListForm{{$featureProduct->id}}").submit();'><i class="fa fa-heart-o"></i><span>{{$featureProduct->name}}</span></button>

                                                                {!! Form::close() !!}
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}

                                                                <form id="wishListForm{{$featureProduct->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$featureProduct->id}}">

                                                                </form>
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;

                                                                        if (!empty($featureProduct->product_review_avg_rating)){
                                                                            $averageReview=ceil($featureProduct->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor

                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$featureProduct->id."/$featureProduct->name")}}" title="{{$featureProduct->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($featureProduct->name) != strlen(utf8_decode($featureProduct->name)))
                                                                        {
                                                                            echo substr($featureProduct->name,0,120);
                                                                        }else{
                                                                            echo substr($featureProduct->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$featureProduct->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$featureProduct->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                        {{__('frontend.No Data Found')}}
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row --><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_pfg8  col-style">
                        <div class="block-policy1">
                            <ul>
                                <li class="item-3">
                                    <a href="javascript:;" class="item-inner">
                                        <i class="fa fa-truck fa-2x"></i>
                                        <div class="content">
                                            <b>ডেলিভারি চার্জ সম্পূর্ণ ফ্রি</b>
                                            <span>২৪ ঘন্টার মধ্যে হোম ডেলিভারি</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="item-4">
                                    <a href="javascript:;" class="item-inner">
                                        <i class="fa fa-gift fa-2x"></i>
                                        <div class="content">
                                            <b>প্যাকেজ ক্রয়-বিক্রয়ে বিশেষ সুযোগ</b>
                                            <span>প্যাকেজে বই ক্রয়-বিক্রয়ে রয়েছে আকর্ষণীয় গ্রিফ্ট</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="item-1">
                                    <a href="javascript:;" class="item-inner">
                                        <i class="fa fa-book fa-2x"></i>
                                        <div class="content">
                                            <b>সেরা পাবলিকেশনস</b>
                                            <span>প্রায় ৩ হাজার বই এর এক বিশেষ সমাহার</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="item-2">
                                    <a href="javascript:;" class="item-inner">
                                        <i class="fa fa-cart-plus fa-2x"></i>
                                        <div class="content">
                                            <b>বাংলাদেশের যেকোন প্রান্ত থেকে অর্ডার করুন</b>
                                            <span>রয়েছে সর্বোচ্চ ৫০% প্রর্যন্ত ডিসকাউন্ট</span>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!--End Feature Container -->
            <!--Start Bongobondho, bangladesh Independent-->
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style">
                        <div id="bongobondhoBangladeshIndependent" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.Bangabandhu Banglades Independent')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">

                                        @forelse($bongobondhoBangladeshCatBooks as $key=>$bongobondhoBangladeshCatBook)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if ($bongobondhoBangladeshCatBook->promotion==\App\Models\Product::YES && isset($bongobondhoBangladeshCatBook->productPromotion) && $bongobondhoBangladeshCatBook->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$bongobondhoBangladeshCatBook->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$bongobondhoBangladeshCatBook->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$bongobondhoBangladeshCatBook->id."/$bongobondhoBangladeshCatBook->name")}}" target="_self" title="{{$bongobondhoBangladeshCatBook->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($bongobondhoBangladeshCatBook->productImages[0]->medium)}}" alt="{{$bongobondhoBangladeshCatBook->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>

                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">

                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$bongobondhoBangladeshCatBook->id}}">

                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>

                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$bongobondhoBangladeshCatBook->name}}"
                                                                        onclick='event.preventDefault();
                                                                                document.getElementById("wishListForm{{$bongobondhoBangladeshCatBook->id}}").submit();'><i class="fa fa-heart-o"></i><span>{{$bongobondhoBangladeshCatBook->name}}</span></button>

                                                                {!! Form::close() !!}
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}

                                                                <form id="wishListForm{{$bongobondhoBangladeshCatBook->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$bongobondhoBangladeshCatBook->id}}">

                                                                </form>
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;

                                                                        if (!empty($bongobondhoBangladeshCatBook->product_review_avg_rating)){
                                                                            $averageReview=ceil($bongobondhoBangladeshCatBook->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor

                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>

                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$bongobondhoBangladeshCatBook->id."/$bongobondhoBangladeshCatBook->name")}}" title="{{$bongobondhoBangladeshCatBook->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($bongobondhoBangladeshCatBook->name) != strlen(utf8_decode($bongobondhoBangladeshCatBook->name)))
                                                                        {
                                                                            echo substr($bongobondhoBangladeshCatBook->name,0,120);
                                                                        }else{
                                                                            echo substr($bongobondhoBangladeshCatBook->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$bongobondhoBangladeshCatBook->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$bongobondhoBangladeshCatBook->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                        {{__('frontend.No Data Found')}}
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->

                    @forelse($biggapons->where('place',\App\Models\Biggapon::MIDDLE)->take(1)->where('show_on_page',\App\Models\Biggapon::HOME_PAGE) as $i=>$middleBiggapon)
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_llqj  col-style">
                            <div class="banners bannersb">
                                <div class="banner"><a href="{{URL::to($middleBiggapon->target_url)}}"><img src="{{asset($middleBiggapon->image)}}" alt="image"></a></div>
                            </div>
                        </div><!--end row-->
                @empty
                @endforelse<!--end row-->
                </div>
            </div>
            <!--End Bongobondho, bangladesh Independent-->

            <!--Start Bongobondho Popular Book -->
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style">
                        <div id="bongobondhoPopular" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.Bangabandhu Popular Book')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">

                                        @forelse($bongobondhoPopularCatBooks as $key=>$bongobondhoPopularCatBook)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if ($bongobondhoPopularCatBook->promotion==\App\Models\Product::YES && isset($bongobondhoPopularCatBook->productPromotion) && $bongobondhoPopularCatBook->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$bongobondhoPopularCatBook->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$bongobondhoPopularCatBook->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$bongobondhoPopularCatBook->id."/$bongobondhoPopularCatBook->name")}}" target="_self" title="{{$bongobondhoPopularCatBook->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($bongobondhoPopularCatBook->productImages[0]->medium)}}" alt="{{$bongobondhoPopularCatBook->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">

                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$bongobondhoPopularCatBook->id}}">

                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>

                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$bongobondhoPopularCatBook->name}}"
                                                                        onclick='event.preventDefault();
                                                                                document.getElementById("wishListForm{{$bongobondhoPopularCatBook->id}}").submit();'><i class="fa fa-heart-o"></i><span>{{$bongobondhoPopularCatBook->name}}</span></button>

                                                                {!! Form::close() !!}
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}

                                                                <form id="wishListForm{{$bongobondhoPopularCatBook->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$bongobondhoPopularCatBook->id}}">

                                                                </form>
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;

                                                                        if (!empty($bongobondhoPopularCatBook->product_review_avg_rating)){
                                                                            $averageReview=ceil($bongobondhoPopularCatBook->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor

                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$bongobondhoPopularCatBook->id."/$bongobondhoPopularCatBook->name")}}" title="{{$bongobondhoPopularCatBook->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($bongobondhoPopularCatBook->name) != strlen(utf8_decode($bongobondhoPopularCatBook->name)))
                                                                        {
                                                                            echo substr($bongobondhoPopularCatBook->name,0,120);
                                                                        }else{
                                                                            echo substr($bongobondhoPopularCatBook->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$bongobondhoPopularCatBook->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$bongobondhoPopularCatBook->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                        {{__('frontend.No Data Found')}}
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            </div>
            <!--End Bongobondho Popular Book -->

            <!--Start New Book you can read-->
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style">
                        <div id="newProduct" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.New books that you want to buy')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">

                                        @forelse($newProducts as $key=>$newProduct)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if ($newProduct->promotion==\App\Models\Product::YES && isset($newProduct->productPromotion) && $newProduct->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$newProduct->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$newProduct->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$newProduct->id."/$newProduct->name")}}" target="_self" title="{{$newProduct->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($newProduct->productImages[0]->medium)}}" alt="{{$newProduct->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">

                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$newProduct->id}}">

                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>

                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$newProduct->name}}"
                                                                        onclick='event.preventDefault();
                                                                                document.getElementById("wishListForm{{$newProduct->id}}").submit();'><i class="fa fa-heart-o"></i><span>{{$newProduct->name}}</span></button>

                                                                {!! Form::close() !!}
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}

                                                                <form id="wishListForm{{$newProduct->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$newProduct->id}}">

                                                                </form>
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;

                                                                        if (!empty($newProduct->product_review_avg_rating)){
                                                                            $averageReview=ceil($newProduct->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor

                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$newProduct->id."/$newProduct->name")}}" title="{{$newProduct->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($newProduct->name) != strlen(utf8_decode($newProduct->name)))
                                                                        {
                                                                            echo substr($newProduct->name,0,120);
                                                                        }else{
                                                                            echo substr($newProduct->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$newProduct->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$newProduct->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                        {{__('frontend.No Data Found')}}
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            </div>
            <!--End New Book you can read-->

            <!--Start The Story, Novel-->
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style"> <!-- end Shop by Categories row -->
                        <div id="StoriesNovelpPoems" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.Stories, novels, poems and more')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">
                                        @forelse($StoriesNovelPoemsCatBooks as $key=>$StoriesNovelPoemsCatBook)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if ($StoriesNovelPoemsCatBook->promotion==\App\Models\Product::YES && isset($StoriesNovelPoemsCatBook->productPromotion) && $StoriesNovelPoemsCatBook->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$StoriesNovelPoemsCatBook->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$StoriesNovelPoemsCatBook->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$StoriesNovelPoemsCatBook->id."/$StoriesNovelPoemsCatBook->name")}}" target="_self" title="{{$StoriesNovelPoemsCatBook->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($StoriesNovelPoemsCatBook->productImages[0]->medium)}}" alt="{{$StoriesNovelPoemsCatBook->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">
                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}
                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$StoriesNovelPoemsCatBook->id}}">
                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>
                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$StoriesNovelPoemsCatBook->name}}"
                                                                        onclick='event.preventDefault();document.getElementById("wishListForm{{$StoriesNovelPoemsCatBook->id}}").submit();'>
                                                                    <i class="fa fa-heart-o"></i><span>{{$StoriesNovelPoemsCatBook->name}}</span>
                                                                </button>
                                                                {!! Form::close() !!}
                                                                <form id="wishListForm{{$StoriesNovelPoemsCatBook->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$StoriesNovelPoemsCatBook->id}}">
                                                                </form>
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;
                                                                        if (!empty($StoriesNovelPoemsCatBook->product_review_avg_rating)){
                                                                            $averageReview=ceil($StoriesNovelPoemsCatBook->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$StoriesNovelPoemsCatBook->id."/$StoriesNovelPoemsCatBook->name")}}" title="{{$StoriesNovelPoemsCatBook->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($StoriesNovelPoemsCatBook->name) != strlen(utf8_decode($StoriesNovelPoemsCatBook->name)))
                                                                        {
                                                                            echo substr($StoriesNovelPoemsCatBook->name,0,120);
                                                                        }else{
                                                                            echo substr($StoriesNovelPoemsCatBook->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>

                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$StoriesNovelPoemsCatBook->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$StoriesNovelPoemsCatBook->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @empty

                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                        No Most Popular Product
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!--end company Feature -->
            <!--End The Story, Novel-->

            <!--Start Most Popular-->
            <div class="container page-builder-ltr">
                <div class="row row_7qar  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style"> <!-- end Shop by Categories row -->
                        <div id="mostPopular" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                            <h4 class="modtitle">{{__('frontend.Most Popular')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">
                                        @forelse($mostPopularProducts as $key=>$mostPopularProduct)
                                            <?php
                                            $discountPercent=0;
                                            $promotionSalePrice=0;
                                            if (isset($mostPopularProduct->productPromotion) && $mostPopularProduct->productPromotion->date_end>=date('Y-m-d'))
                                            {
                                                $discountPercent=$mostPopularProduct->productPromotion->promotion_by_percent;
                                                $promotionSalePrice=$mostPopularProduct->productPromotion->promotion_price;
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="{{url('book/details/'.$mostPopularProduct->id."/$mostPopularProduct->name")}}" target="_self" title="{{$mostPopularProduct->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($mostPopularProduct->productImages[0]->medium)}}" alt="{{$mostPopularProduct->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                            @if($discountPercent>0)
                                                                <span class="label label-sale">- {{$discountPercent}}%</span>
                                                            @endif
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="button-group cartinfo--static">
                                                                {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}
                                                                <input class="form-control" type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="product_id" value="{{$mostPopularProduct->id}}">
                                                                <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>
                                                                <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$mostPopularProduct->name}}"
                                                                        onclick='event.preventDefault();document.getElementById("wishListForm{{$mostPopularProduct->id}}").submit();'>
                                                                    <i class="fa fa-heart-o"></i><span>{{$mostPopularProduct->name}}</span>
                                                                </button>
                                                                {!! Form::close() !!}
                                                                <form id="wishListForm{{$mostPopularProduct->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input class="form-control" type="hidden" name="qty" value="1">
                                                                    <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                    <input type="hidden" name="product_id" value="{{$mostPopularProduct->id}}">
                                                                </form>
                                                                {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}
                                                            </div>
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;
                                                                        if (!empty($mostPopularProduct->product_review_avg_rating)){
                                                                            $averageReview=ceil($mostPopularProduct->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$mostPopularProduct->id."/$mostPopularProduct->name")}}" title="{{$mostPopularProduct->name}}" target="_self">
                                                                        <?php
                                                                        if (strlen($mostPopularProduct->name) != strlen(utf8_decode($mostPopularProduct->name)))
                                                                        {
                                                                            echo substr($mostPopularProduct->name,0,120);
                                                                        }else{
                                                                            echo substr($mostPopularProduct->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>

                                                            <div class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$mostPopularProduct->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$mostPopularProduct->productStock->sale_price}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4><a href="javascript:void (0)" title="Incididunt picanha" target="_self">No Most Popular Product</a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!--End Mos Popular-->

            <div class="container page-builder-ltr">
                <div class="row row_akx2  row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_3r5f  col-style">
                        <div id="topRatedBook" class="so-category-slider container-slider module so-category-slider-ltr cate-slider3">
                            <h4 class="modtitle">{{__('frontend.Top Rated')}}</h4>
                            <div class="modcontent">
                                <div class="page-top">
                                    <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                </div>
                                <div class="categoryslider-content hide-featured preset01-4 preset02-3 preset03-2 preset04-2 preset05-1">
                                    <div class="loading-placeholder"></div>
                                    <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">
                                        @forelse($topRatedProducts as $key=>$topRatedProduct)
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">
                                                        <div class="left-block left-b">
                                                            <?php
                                                            $discountPercent=0;
                                                            $promotionSalePrice=0;
                                                            if (isset($topRatedProduct->productPromotion) && $topRatedProduct->productPromotion->date_end>=date('Y-m-d'))
                                                            {
                                                                $discountPercent=$topRatedProduct->productPromotion->promotion_by_percent;
                                                                $promotionSalePrice=$topRatedProduct->productPromotion->promotion_price;
                                                            }
                                                            ?>
                                                            <div class="product-image-container top-rate-image-container">
                                                                <a class="lt-image" href="{{url('book/details/'.$topRatedProduct->id."/$topRatedProduct->name")}}" target="_self" title="{{$topRatedProduct->name}}">
                                                                    <img data-sizes="auto" src="" data-src="{{asset($topRatedProduct->productImages[0]->medium)}}" alt="{{$topRatedProduct->name}}" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history">
                                                                    <div class="ratings">
                                                                        <?php
                                                                        $maxReview=5;
                                                                        $averageReview=0;

                                                                        if (!empty($topRatedProduct->product_review_avg_rating)){
                                                                            $averageReview=ceil($topRatedProduct->product_review_avg_rating);
                                                                        }
                                                                        $inActiveStar=$maxReview-$averageReview;
                                                                        ?>
                                                                        <div class="rating-box">
                                                                            @for($x=0;$x<$averageReview;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor

                                                                            @for($x=0;$x<$inActiveStar;$x++)
                                                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                            @endfor
                                                                        </div>
                                                                        <span class="rating-num">( {{$averageReview}} )</span>
                                                                    </div>

                                                                </div>
                                                                <h4>
                                                                    <a href="{{url('book/details/'.$topRatedProduct->id."/$topRatedProduct->name")}}" title="Fatback picanha" target="_self">
                                                                        <?php
                                                                        if (strlen($topRatedProduct->name) != strlen(utf8_decode($topRatedProduct->name)))
                                                                        {
                                                                            echo substr($topRatedProduct->name,0,120);
                                                                        }else{
                                                                            echo substr($topRatedProduct->name,0,60);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <p class="price">
                                                                @if($promotionSalePrice>0)
                                                                    <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                    <span class="price-old">{{$setting->currency}} {{$topRatedProduct->productStock->sale_price}} </span>
                                                                @else
                                                                    <span class="price-new">{{$setting->currency}} {{$topRatedProduct->productStock->sale_price}}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="item">
                                                <div class="item-inner product-thumb transition product-layout product-grid">
                                                    <div class="product-item-container">

                                                        <div class="left-block left-b">
                                                            <div class="product-image-container ">
                                                                <a class="lt-image" href="javascript:void(0)" target="_self" title="Fatback picanha">
                                                                    <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="No Top Rated Product" class="lazyload">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption hide-cont">
                                                                <div class="rate-history"></div>
                                                                <h4>
                                                                    <a href="javascript:void(0)" title="Fatback picanha" target="_self">
                                                                        No Top Rated Product
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Start Reading list product-->
                    <div class="row row_7qar  row-style ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_4xg8  col-style">
                                <div id="readingListBooks" class=" so-category-slider container-slider module so-category-slider-ltr cate-slider1">
                                    <h4 class="modtitle">{{__('frontend.Some books that may be added to your reading list')}}</h4>
                                    <div class="modcontent">
                                        <div class="page-top">
                                            <div class="item-sub-cat"><ul><li> <a href="{{URL::to('book/categories')}}" title="" target="_self">View All</a></li></ul></div>
                                        </div>
                                        <div class="categoryslider-content hide-featured preset01-6 preset02-4 preset03-3 preset04-2 preset05-1">
                                            <div class="loading-placeholder"></div>
                                            <div class="slider category-slider-inner not-js cols-6 products-list" data-effect="none">

                                                @forelse($readingListProducts as $key=>$readingListProduct)
                                                    <?php
                                                    $discountPercent=0;
                                                    $promotionSalePrice=0;
                                                    if ($readingListProduct->promotion==\App\Models\Product::YES && isset($readingListProduct->productPromotion) && $readingListProduct->productPromotion->date_end>=date('Y-m-d'))
                                                    {
                                                        $discountPercent=$readingListProduct->productPromotion->promotion_by_percent;
                                                        $promotionSalePrice=$readingListProduct->productPromotion->promotion_price;
                                                    }
                                                    ?>
                                                    <div class="item">
                                                        <div class="item-inner product-thumb transition product-layout product-grid">
                                                            <div class="product-item-container">
                                                                <div class="left-block left-b">
                                                                    <div class="product-image-container ">
                                                                        <a class="lt-image" href="{{url('book/details/'.$readingListProduct->id."/$readingListProduct->name")}}" target="_self" title="{{$readingListProduct->name}}">
                                                                            <img data-sizes="auto" src="" data-src="{{asset($readingListProduct->productImages[0]->medium)}}" alt="{{$readingListProduct->name}}" class="lazyload">
                                                                        </a>
                                                                    </div>
                                                                    @if($discountPercent>0)
                                                                        <span class="label label-sale">- {{$discountPercent}}%</span>
                                                                    @endif
                                                                </div>
                                                                <div class="right-block">
                                                                    <div class="button-group cartinfo--static">

                                                                        {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                        <input class="form-control" type="hidden" name="qty" value="1">
                                                                        <input type="hidden" name="product_id" value="{{$readingListProduct->id}}">

                                                                        <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>

                                                                        <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$readingListProduct->name}}"
                                                                                onclick='event.preventDefault();
                                                                                        document.getElementById("wishListForm{{$readingListProduct->id}}").submit();'><i class="fa fa-heart-o"></i><span>{{$readingListProduct->name}}</span></button>

                                                                        {!! Form::close() !!}
                                                                        {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}

                                                                        <form id="wishListForm{{$readingListProduct->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                                                            @csrf
                                                                            <input class="form-control" type="hidden" name="qty" value="1">
                                                                            <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                                                            <input type="hidden" name="product_id" value="{{$readingListProduct->id}}">

                                                                        </form>
                                                                    </div>
                                                                    <div class="caption hide-cont">
                                                                        <div class="rate-history">
                                                                            <div class="ratings">
                                                                                <?php
                                                                                $maxReview=5;
                                                                                $averageReview=0;

                                                                                if (!empty($readingListProduct->product_review_avg_rating)){
                                                                                    $averageReview=ceil($readingListProduct->product_review_avg_rating);
                                                                                }
                                                                                $inActiveStar=$maxReview-$averageReview;
                                                                                ?>
                                                                                <div class="rating-box">
                                                                                    @for($x=0;$x<$averageReview;$x++)
                                                                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                                    @endfor
                                                                                    @for($x=0;$x<$inActiveStar;$x++)
                                                                                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                                                                    @endfor

                                                                                </div>
                                                                                <span class="rating-num">( {{$averageReview}} )</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4>
                                                                            <a href="{{url('book/details/'.$readingListProduct->id."/$readingListProduct->name")}}" title="{{$readingListProduct->name}}" target="_self">
                                                                                <?php
                                                                                if (strlen($readingListProduct->name) != strlen(utf8_decode($readingListProduct->name)))
                                                                                {
                                                                                    echo substr($readingListProduct->name,0,120);
                                                                                }else{
                                                                                    echo substr($readingListProduct->name,0,60);
                                                                                }
                                                                                ?>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="price">
                                                                        @if($promotionSalePrice>0)
                                                                            <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                            <span class="price-old">{{$setting->currency}} {{$readingListProduct->productStock->sale_price}} </span>
                                                                        @else
                                                                            <span class="price-new">{{$setting->currency}} {{$readingListProduct->productStock->sale_price}}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="item">
                                                        <div class="item-inner product-thumb transition product-layout product-grid">
                                                            <div class="product-item-container">
                                                                <div class="left-block left-b">
                                                                    <div class="product-image-container ">
                                                                        <a class="lt-image" href="javascript:void (0)" target="_self" title="">
                                                                            <img data-sizes="auto" src="" data-src="{{asset('images/default/default.png')}}" alt="" class="lazyload">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="right-block">
                                                                    <div class="caption hide-cont">
                                                                        <div class="rate-history"></div>
                                                                        <h4>
                                                                            <a href="javascript:void (0)" title="Incididunt picanha" target="_self">
                                                                                {{__('frontend.No Data Found')}}
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end row -->
                        </div>
                    <!--End Reading list product-->

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_vxsa  col-style">
                        <h3 class="text-center">{{__('frontend.Weekly Top Authors')}}</h3>
                        <div class="slider-brands">
                            <div class="contentslider" data-items_column0="8" data-items_column1="6" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-hoverpause="yes">
                                <!-- Data come form CompanyServiceProvider -->
                                @forelse($authors as $key=>$author)
                                    <div class="item">
                                        <a href="{{URL::to('book/author/'.$author->id)}}" title="{{$author->name_bn}}">
                                            @if(!empty($author->photo))
                                                <img src="{{asset($author->photo)}}" class="img-circle img-responsive" title="{{$author->name}}" alt="{{$author->name}}">
                                            @else
                                                <img src="{{asset('images/default/default.png')}}" alt="{{$author->brand_name}}">
                                            @endif
                                        </a>
                                    </div>
                                @empty
                                    <div class="item"> <a href="javascript:;">{{__('frontend.No Data Found')}}</a></div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @forelse($biggapons->where('place',\App\Models\Biggapon::BOTTOM)->take(1)->where('show_on_page',\App\Models\Biggapon::HOME_PAGE) as $i=>$bottomBiggapon)
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_llqj  col-style">
                            <div class="banners bannersb">
                                <div class="banner">
                                    <a href="{{URL::to($bottomBiggapon->target_url)}}"><img src="{{asset($bottomBiggapon->image)}}" alt="image"></a>
                                </div>
                            </div>
                        </div><!--end row-->
                @empty
                @endforelse<!--end row-->
                </div>
            </div>
            <!--End Top Rated -->

        </div>
    </div>
    @include('client.layouts.partials.right-side-menu')
@endsection
@section('script')
    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>
    <!-- slider Active -- sohomeslider-inner-1-->
    <script type="text/javascript">
        var total_item = 3 ;
        $(".sohomeslider-inner-1").owlCarousel2({
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            autoplay: true,
            autoplayTimeout: 5000,
            autoplaySpeed:  1000,
            smartSpeed: 500,
            autoplayHoverPause: true,
            startPosition: 0,
            mouseDrag:  true,
            touchDrag: true,
            dots: true,
            autoWidth: false,
            dotClass: "owl2-dot",
            dotsClass: "owl2-dots",
            nav: true,
            loop: true,
            navSpeed: 500,
            navText: ["&#139;", "&#155;"],
            navClass: ["owl2-prev", "owl2-next"],
            responsive: {
                0:{ items: 1,
                    nav: total_item <= 1 ? false : ((false ) ? true: false),
                },
                480:{ items: 1,
                    nav: total_item <= 1 ? false : ((false ) ? true: false),
                },
                768:{ items: 1,
                    nav: total_item <= 1 ? false : ((false ) ? true: false),
                },
                992:{ items: 1,
                    nav: total_item <= 1 ? false : ((false ) ? true: false),
                },
                1200:{ items: 1,
                    nav: total_item <= 1 ? false : ((false ) ? true: false),
                }
            },
        });
    </script>

    <script type="text/javascript">
        //<![CDATA[ Feature Book
        jQuery(document).ready(function ($) {
            ;(function (element) {
                var id = $("#featureBook");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        rtl: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#featureBook");
        });
        //]]>
    </script>


    <script type="text/javascript">
        //<![CDATA[ Bongobondho Bangladesh Indipendent
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#bongobondhoBangladeshIndependent");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#bongobondhoBangladeshIndependent");
        });
        //]]>
    </script>
    <script type="text/javascript">
        //<![CDATA[ Bongobondho Bangladesh Indipendent
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#bongobondhoPopular");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#bongobondhoPopular");
        });
        //]]>
    </script>
    <script type="text/javascript">
        //<![CDATA[ New Product
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#newProduct");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#newProduct");
        });
        //]]>
    </script>
    <script type="text/javascript">
        //<![CDATA[ readingListBooks
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#readingListBooks");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#readingListBooks");
        });
        //]]>
    </script>

    <script type="text/javascript">
        //<![CDATA[ HEALTH & BEAUTY
        jQuery(document).ready(function ($) {
            jQuery(document).ready(function ($) {
                ;(function (element) {
                    var id = $("#so_category_slider_191");
                    var $element = $(element),
                        $extraslider = $(".slider", $element),
                        $featureslider = $('.product-feature', $element),
                        _delay = 500,
                        _duration = 800,
                        _effect = 'none',
                        total_item = 10;

                    var width_window = $(window).width();

                    $(window).on('load', function() {
                        $extraslider.on("initialized.owl.carousel2", function () {
                            var $item_active = $(".slider .owl2-item.active", $element);
                            if ($item_active.length > 1 && _effect != "none") {
                                _getAnimate($item_active);
                            }
                            else {
                                var $item = $(".owl2-item", $element);
                                $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                            }
                            $extraslider.show();
                            $('.loading-placeholder', id).hide();
                            // var $navpage = $(".page-top .page-title-categoryslider span", id);
                            // $(".slider .owl2-controls", id).insertAfter($navpage);
                            // $(".slider .owl2-dot", id).css("display", "none");

                        }).owlCarousel2({
                            rtl: false,
                            margin: 20,
                            slideBy: 1,
                            autoplay: 0,
                            autoplayHoverPause: 0,
                            autoplayTimeout: 0,
                            autoplaySpeed: 1000,
                            startPosition: 0,
                            mouseDrag: 1,
                            touchDrag: 1,
                            autoWidth: false,
                            responsive: {
                                0:{	items: 2,
                                    nav: total_item <= 1 ? false : ((true) ? true: false),
                                },
                                480:{ items: 2,
                                    nav: total_item <= 2 ? false : ((true) ? true: false),
                                },
                                768:{ items: 3,
                                    nav: total_item <= 3 ? false : ((true) ? true: false),
                                },
                                992:{ items: 4,
                                    nav: total_item <= 4 ? false : ((true) ? true: false),
                                },
                                1200:{ items: 5,
                                    nav: total_item <= 4 ? false : ((true) ? true: false),
                                }
                            },
                            nav: true,
                            loop: true,
                            navSpeed: 500,
                            navText: ["&#139;", "&#155;"],
                            navClass: ["owl2-prev", "owl2-next"]
                        });

                        var height_slider = $('.slider', id).outerHeight();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }

                        $( window ).resize(function() {
                            var width_window = $(window).width();
                            if (width_window > 1200) {
                                $('.item-cat-image', id).css('min-height', height_slider-20);
                            }
                            else {
                                $('.item-cat-image', id).removeAttr('style');
                            }
                        })
                    });

                })("#so_category_slider_191");
            });

        });
        //]]>
    </script>

    <script type="text/javascript">
        //<![CDATA[  Storey, Poit, Novel
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#StoriesNovelpPoems");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#StoriesNovelpPoems");
        });
        //]]>
    </script>
    <script type="text/javascript">
        //<![CDATA[  Most Popular
        jQuery(document).ready(function ($) {
            (function (element) {
                var id = $("#mostPopular");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();
                    }).owlCarousel2({
                        lrt: false,
                        margin: 20,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            992:{ items: 4,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 5,
                                nav: total_item <= 4 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#mostPopular");
        });
        //]]>
    </script>

    <script type="text/javascript">
        //<![CDATA[ Top Rated
        jQuery(document).ready(function ($) {
            ;(function (element) {
                var id = $("#topRatedBook");
                var $element = $(element),
                    $extraslider = $(".slider", $element),
                    $featureslider = $('.product-feature', $element),
                    _delay = 500,
                    _duration = 800,
                    _effect = 'none',
                    total_item = 10;

                var width_window = $(window).width();

                $(window).on('load', function() {
                    $extraslider.on("initialized.owl.carousel2", function () {
                        var $item_active = $(".slider .owl2-item.active", $element);
                        if ($item_active.length > 1 && _effect != "none") {
                            _getAnimate($item_active);
                        }
                        else {
                            var $item = $(".owl2-item", $element);
                            $item.css({"opacity": 1, "filter": "alpha(opacity = 100)"});
                        }
                        $extraslider.show();
                        $('.loading-placeholder', id).hide();

                    }).owlCarousel2({
                        rtl: false,
                        margin: 30,
                        slideBy: 1,
                        autoplay: 0,
                        autoplayHoverPause: 0,
                        autoplayTimeout: 0,
                        autoplaySpeed: 1000,
                        startPosition: 0,
                        mouseDrag: 1,
                        touchDrag: 1,
                        autoWidth: false,
                        responsive: {
                            0:{	items: 2,
                                nav: total_item <= 1 ? false : ((true) ? true: false),
                            },
                            480:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            768:{ items: 2,
                                nav: total_item <= 2 ? false : ((true) ? true: false),
                            },
                            992:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            },
                            1200:{ items: 3,
                                nav: total_item <= 3 ? false : ((true) ? true: false),
                            }
                        },
                        nav: true,
                        loop: true,
                        navSpeed: 500,
                        navText: ["&#139;", "&#155;"],
                        navClass: ["owl2-prev", "owl2-next"]
                    });

                    var height_slider = $('.slider', id).outerHeight();
                    if (width_window > 1200) {
                        $('.item-cat-image', id).css('min-height', height_slider-20);
                    }
                    else {
                        $('.item-cat-image', id).removeAttr('style');
                    }

                    $( window ).resize(function() {
                        var width_window = $(window).width();
                        if (width_window > 1200) {
                            $('.item-cat-image', id).css('min-height', height_slider-20);
                        }
                        else {
                            $('.item-cat-image', id).removeAttr('style');
                        }
                    })
                });

            })("#topRatedBook");
        });
        //]]>
    </script>

@endsection

