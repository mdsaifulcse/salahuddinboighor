@extends('client.layouts.master')

@section('head')
    <title> {{$product->name}} </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
@endsection


@section('style')
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/animate.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_home_slider/css/owl.carousel.css">

    <style>

        .myratings{
            color: orange;
        }
        .ratingStar > label:before {
            content:'★';
            color: grey;
            cursor:pointer;
            font-size:3em;
        }
        .ratingStar:hover > label:before {
            color: orange;
        }

        .ratingStar > label:hover ~ label:before {
            color: grey;
        }
    </style>

@endsection


@section('content')
    <script src="{{asset('/client/assets')}}/javascript/jquery/jquery-2.1.1.min.js"></script>

    <?php $currency=$setting->currency;?>
    <div class="breadcrumbs ">
        <div class="container">
            <div class="current-name">
                {{$product->categoryProducts->category_name}}
            </div>

            <ul class="breadcrumb">
                <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{URL::to('/products/category/'.$product->categoryProducts->link)}}">{{$product->categoryProducts->category_name}}</a></li>
                @if(!empty($product->subCategoryProducts))
                    <li><a href="{{URL::to('/products/category/'.$product->categoryProducts->link.'?&sub_cat='.$product->subCategoryProducts->link)}}">{{$product->subCategoryProducts->sub_category_name}}</a>
                    </li>
                @endif

                @if(!empty($product->thirdCategoryProducts))
                    <?php
                    $subCatLink='';
                    if (!empty($product->subCategoryProducts)){
                        $subCatLink=$product->subCategoryProducts->link;

                    }
                    ;?>
                    <li><a href="{{URL::to('/products/category/'.$product->categoryProducts->link.'?&sub_cat='.$subCatLink.'&third_sub_cat='.$product->thirdCategoryProducts->link)}}">{{$product->thirdCategoryProducts->third_sub_category}}</a></li>
                @endif
            </ul>
        </div>
    </div> <!-- end breadcrumbs-->



    <div class="content-main container product-detail ">
        <div class="row" style="position: relative;">

            {{--<aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas " >--}}
            {{--<span id="close-sidebar" class="fa fa-times"></span>--}}
            {{--<div class="module so_filter_wrap block-shopby">--}}


            {{--<div class="modcontent">--}}
            {{--<ul>--}}


            {{--<li class="so-filter-options" data-option="Subcategory">--}}
            {{--<div class="so-filter-heading">--}}
            {{--<div class="so-filter-heading-text">--}}
            {{--<span>Category</span>--}}
            {{--</div>--}}
            {{--<i class="fa fa-chevron-down"></i>--}}
            {{--</div>--}}

            {{--<div class="so-filter-content-opts">--}}
            {{--<div class="so-filter-content-opts-container">--}}

            {{--<div class="so-filter-option-sub so-filter-option opt-select " >--}}
            {{--<div class="so-option-container">--}}

            {{--<!-- data come from CompanyServiceProvider -->--}}
            {{--@forelse($categories as $category)--}}
            {{--@if($category->products->count()>0)--}}
            {{--<label>--}}
            {{--<a href="{{URL::to('/products/category/'.$category->link)}}" class="@if($product->categoryProducts->link==$category->link)active @endif"><span><i class="fa fa-angle-double-right "></i></span> {{$category->category_name}} ({{$category->products->count()}})--}}
            {{--</a>--}}
            {{--</label>--}}

            {{--@forelse($category->subCatAsSubMenu as $subCate)--}}
            {{--@if($subCate->products->count()>0)--}}
            {{--<div class="so-filter-option-sub-sub">--}}
            {{--<label>--}}
            {{--<?php--}}
            {{--$productSubCatLink='';--}}
            {{--if (!empty($product->subCategoryProducts))--}}
            {{--{--}}
            {{--$productSubCatLink=$product->subCategoryProducts->link;--}}
            {{--}--}}
            {{--;?>--}}
            {{--<a href="{{URL::to('/products/category/'.$category->link.'?sub_cat='.$productSubCatLink.'&brand=')}}" class="@if($productSubCatLink==$subCate->link)active @endif">> {{$subCate->sub_category_name}}({{$subCate->products->count()}})--}}
            {{--</a>--}}
            {{--</label>--}}

            {{--@forelse($subCate->thirdSubAsThirdSubMenu as $thirdSub)--}}
            {{--@if($thirdSub->products->count()>0)--}}
            {{--<div class="so-filter-option-sub-sub-sub">--}}
            {{--<label>--}}
            {{--<?php--}}
            {{--$productThirdCatLink='';--}}
            {{--if (!empty($product->thirdCategoryProducts))--}}
            {{--{--}}
            {{--$productThirdCatLink=$product->thirdCategoryProducts->link;--}}
            {{--}--}}
            {{--;?>--}}
            {{--<a href="{{URL::to('/products/category/'.$category->link.'?sub_cat='.$subCate->link.'&third_sub_cat='.$thirdSub->link.'&brand=')}}" class="@if($productThirdCatLink==$thirdSub->link) active @endif">{{$thirdSub->third_sub_category}}({{$thirdSub->products->count()}})--}}
            {{--</a>--}}
            {{--</label>--}}
            {{--</div>--}}
            {{--@endif--}}
            {{--@empty--}}
            {{--@endforelse--}}
            {{--</div>--}}
            {{--@endif--}}
            {{--@empty--}}
            {{--@endforelse--}}

            {{--@endif--}}
            {{--@empty--}}
            {{--@endforelse--}}

            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--</li>--}}



            {{--<li class="so-filter-options" data-option="Manufacturer">--}}
            {{--<div class="so-filter-heading">--}}
            {{--<div class="so-filter-heading-text">--}}
            {{--<span>Brand</span>--}}
            {{--</div>--}}
            {{--<i class="fa fa-chevron-down"></i>--}}
            {{--</div>--}}

            {{--<div class="so-filter-content-opts">--}}
            {{--<div class="so-filter-content-opts-container">--}}

            {{--<div class="so-filter-option opt-select">--}}

            {{--@forelse($brands as $brand)--}}
            {{--@if($brand->products->count()>0)--}}
            {{--<div class="so-option-container">--}}
            {{--<label>--}}
            {{--<?php--}}
            {{--$brandProductsLik='';--}}
            {{--if (!empty($product->brandProducts))--}}
            {{--{--}}
            {{--$brandProductsLik=$product->brandProducts->link;--}}
            {{--}--}}

            {{--;?>--}}
            {{--<a href="{{request()->fullUrlWithQuery(['brand'=>$brand->link])}}" class="@if($brandProductsLik==$brand->link)active @endif">{{$brand->brand_name}} ({{$brand->products->count()}})--}}
            {{--</a></label>--}}
            {{--<div class="option-count ">--}}
            {{--<span>8</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
            {{--@empty--}}
            {{--@endforelse--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{----}}

            {{--</ul>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="module banner-left hidden-xs ">--}}
            {{--<h2></h2>--}}
            {{--<div class="banner-sidebar banners">--}}
            {{--<div>--}}
            {{--<a title="Banner Image" href="layout2.html#">--}}
            {{--<img src="image/catalog/banners/banner-sidebar.jpg" alt="Banner Image">--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}
            {{--</aside>--}}


            <div id="content" class="product-view col-md-12 col-sm-12 col-xs-12 fluid-sidebar">


                <a href="javascript:void(0)" class=" open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Refine</a>
                <div class="sidebar-overlay "></div>


                <div class="content-product-mainheader clearfix">
                    <div class="row">
                        <div class="content-product-left  col-md-6 col-sm-12 col-xs-12">
                            <div class="so-loadeding"></div>

                            <div class="large-image  ">
                                <img itemprop="image" class="product-image-zoom lazyautosizes lazyloaded" data-sizes="auto" src="{{asset($product->productImages[0]->big)}}" data-src="{{asset($product->productImages[0]->big)}}" data-zoom-image="{{asset($product->productImages[0]->big)}}" title="{{$product->name}}" alt="{{$product->name}}" sizes="457px">
                            </div>

                            <div id="thumb-slider" class="full_slider  contentslider--default" data-rtl="no" data-autoplay="no" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="10" data-items_column0="4" data-items_column1="3" data-items_column2="5" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">

                                @forelse($product->productImages as $productImage)
                                    <div class="image-additional">
                                        <a data-index="0" class="img thumbnail  active" data-image="{{asset($productImage->big)}}" title="{{$product->name}}">
                                            <img class="lazyautosizes lazyloaded" data-sizes="auto" src="{{asset($productImage->small)}}" data-src="{{asset($productImage->small)}}" title="{{$product->name}}" alt="{{$product->name}}" sizes="82px">
                                        </a>
                                    </div>
                                @empty

                                @endforelse
                            </div>

                        </div>

                        <div class="content-product-right col-md-6 col-sm-12 col-xs-12">
                            <div class="title-product">
                                <h1>{{$product->name}}</h1>
                            </div>

                            <div class="box-review">

                                <?php
                                $maxReview=5;
                                $averageReview=0;

                                if (!empty($product->product_review_avg_rating)){
                                    $averageReview=ceil($product->product_review_avg_rating);
                                }
                                $inActiveStar=$maxReview-$averageReview;
                                ?>

                                <div class="rating">
                                    <div class="rating-box">

                                        @for($x=0;$x<$averageReview;$x++)
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        @endfor

                                        @for($x=0;$x<$inActiveStar;$x++)
                                            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        @endfor

                                    </div>
                                </div>

                                <a class="reviews_button" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
                                    {{$averageReview}} review
                                </a>

                                {{--<span class="order-num">Orders (20)</span>--}}
                            </div>


                            <div class="product_page_price price" itemprop="offerDetails" itemscope="" itemtype="">
                                <?php

                                $discountPercent=0;
                                $promotionSalePrice=0;

                                if (isset($product->productPromotion) && $product->productPromotion->date_end>=date('Y-m-d'))
                                {
                                    $discountPercent=$product->productPromotion->promotion_by_percent;
                                    $promotionSalePrice=$product->productPromotion->promotion_price;
                                }
                                ?>

                                @if($promotionSalePrice>0)
                                    <span class="price-new"><span itemprop="price" id="price-special">{{$currency}} {{$promotionSalePrice}}</span></span>
                                    <span class="price-old" id="price-old">{{$currency}} {{$product->productStock->sale_price}}</span>

                                @else
                                    <span class="price-new"><span itemprop="price" id="price-special">{{$currency}} {{$product->productStock->sale_price}}</span></span>
                                @endif


                                @if($discountPercent>0)
                                    <span class="label-product label-sale">-{{$discountPercent}}%</span>
                                @endif

                            </div>

                            <div class="product-box-desc">
                                <div class="inner-box-desc">
                                    <div class="model"><span>Product Code: </span> {{$product->sku}}</div>

                                    @if(!empty($product->originProducts))
                                        <div class="brand"><span>Origin </span><a href="">{{$product->originProducts->origin}}</a></div>
                                    @endif

                                    @if(!empty($product->packSizeUnitProducts))
                                        <div class="brand"><span>{{$product->packSizeUnitProducts->label}} </span><a href="">{{$product->packSizeUnitProducts->size}}</a></div>
                                    @endif

                                    @if(!empty($product->brandProducts))
                                        <div class="brand"><span>Brands </span><a href="">{{$product->brandProducts->brand_name}}</a></div>
                                    @endif

                                    @if(!empty($product->categoryProducts))
                                        <div class="brand"><span>Category </span><a href="">{{$product->categoryProducts->category_name}}</a></div>
                                    @endif


                                    {{--<div class="reward"><span>Reward Points:</span> 100</div>--}}

                                    <div class="stock"><span> Stock </span> <i class="fa fa-check-square-o"></i> In Stock {{$balanceQty=($product->productStock->qty+$product->productStock->sold_return_qty)-($product->productStock->sold_qty+$product->productStock->purchase_return_qty)}}

                                    </div>

                                    @if(!empty($product->installation_gide))

                                        <div class="stock"><span> Installation Giud </span>
                                            <a href="{{asset($product->installation_gide)}}" target="_blank"> <i class="fa fa-eye"></i> Click To View Installation Giud</a>
                                        </div>
                                    @endif
                                </div>


                                {{--<a class="image-popup-sizechart" href="{{asset('/client')}}/images/catalog/404/size-chart.jpg">Size Chart </a>--}}

                            </div>


                            <div id="product">

                                {{--<h3>Available Options</h3>--}}


                                <div class="box-cart clearfix form-group">
                                    {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}
                                    <div class="form-group box-info-product">
                                        <div class="option quantity">
                                            <div class="input-group quantity-control" unselectable="on" style="user-select: none;">
                                                <span class="input-group-addon product_quantity_down fa fa-minus"></span>
                                                <input class="form-control" type="number" min="1" max="999999" name="qty" value="1">
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <span class="input-group-addon product_quantity_up fa fa-plus"></span>
                                            </div>
                                        </div>
                                        <div class="detail-action">
                                            <div class="cart">
                                                <input type="submit" value="Add to Cart" data-loading-text="Loading..." id="button-cart" class="btn btn-mega btn-lg ">
                                            </div>
                                            <div class="add-to-links wish_comp">
                                                <ul class="blank">
                                                    {{--<li class="wishlist">--}}
                                                    {{--<a onclick="wishlist.add({{$product->id}});"><i class="fa fa-heart"></i></a>--}}
                                                    {{--</li>--}}
                                                    {{--<li class="compare">--}}
                                                    {{--<a onclick="compare.add({{$product->id}});"><i class="fa fa-retweet"></i></a>--}}
                                                    {{--</li>--}}

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                    <div class="clearfix"></div>
                                </div>

                                <div class="form-group social-share clearfix">
                                    <div class="title-share">Share This</div><div class="title-share"></div>
                                    <div class="wrap-content">
                                        <div class="custom-social-share">
                                            <div class="custom_share_count pull-left"></div>
                                            <ul class="social-media custom-social-share">
                                                <li>
                                                    <button type="button" onclick='window.open ("https://www.facebook.com/sharer.php?u={{Request::url()}}","mywindow","menubar=1,resizable=1,width=350,height=250");'>
                                                        <i class="fa fa-facebook" style="background-color:#3b5998"></i></button>
                                                </li>
                                                <li>
                                                    <button type="button" onclick='window.open ("https://twitter.com/intent/tweet?text={{$product->name}}&url={{Request::url()}}","mywindow","menubar=1,resizable=1,width=360,height=250");'>
                                                        <i class="fa fa-twitter" style="background-color:#00aced"></i></button>
                                                </li>
                                                <li>
                                                    <button type="button" data-action="share/whatsapp/share" onclick='window.open ("https://web.whatsapp.com/send?text={{Request::url()}}", "mywindow","menubar=1,resizable=1,width=360,height=450");'>
                                                        <i class="fa fa-whatsapp" style="background: #25D366;"></i></button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                {{--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-529be2200cc72db5"></script>--}}

                                <div id="tab-tags">
                                    <i class="fa fa-tags"></i> Tags:

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="content-product-maintop form-group clearfix">

                    @include('client.layouts.partials.right-side-menu')
                </div>

                <div class="content-product-mainbody clearfix row">


                    <div class="content-product-content col-sm-12">
                        <div class="content-product-midde clearfix">

                            <div class="producttab ">
                                <div class="tabsslider vertical-tabs  vertical-tabs  col-xs-12">
                                    <ul class="nav nav-tabs col-lg-12 col-sm-4">
                                        <li class="active"><a data-toggle="tab" href="#tab-summery">Summery </a></li>
                                        <li><a data-toggle="tab" href="#tab-description">Specification </a></li>
                                        <li><a data-toggle="tab" href="#tab-author">Author </a></li>

                                        <li><a href="#tab-review" data-toggle="tab">Reviews</a></li>

                                        <li><a href="#tab-contentshipping" data-toggle="tab">Shipping Methods</a></li>

                                    </ul>

                                    <div class="tab-content  col-lg-12 col-sm-8  col-xs-12">

                                        <div class="tab-pane active" id="tab-summery">
                                            <?php echo $product->specification?>
                                        </div>
                                        <div class="tab-pane" id="tab-description">

                                            <table class="table table-striped table-bordered table-hover" style="font-size:15px;">
                                                <tbody>

                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Title')}}</td>
                                                    <td class="text-left">{{$product->name_bn}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Author')}}</td>
                                                    <td class="text-left">
                                                        @forelse($product->relProductAuthorsName as $author)
                                                            <a href="{{URL::to('/book/author/'.$author->author_id)}}" class="text-primary">{{$author->name.', '}}</a>
                                                        @empty

                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Publisher')}}</td>
                                                    <td class="text-left">
                                                        <a href="{{URL::to('/book/publisher/'.$product->id)}}" class="text-primary">{{$product->publisher->name}}
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('ISBN')}}</td>
                                                    <td class="text-left">{{$product->isbn}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Edition')}}</td>
                                                    <td class="text-left">{{$product->edition}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Number of page')}}</td>
                                                    <td class="text-left">{{$product->number_of_page}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Country')}}</td>
                                                    <td class="text-left">{{$product->Country->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" class="bg-info">{{__('Language')}}</td>
                                                    <td class="text-left">{{$product->language->name}}</td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="tab-pane" id="tab-author">
                                            @forelse($product->relProductAuthorsName as $author)
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img class="img-fluid img-circle img-responsive center-block" src="{{asset($author->photo)}}" alt="{{$author->name}}" title="{{$author->name}}">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h3>{{$author->name}}</h3>
                                                        <?php echo $author->bio?>
                                                    </div>
                                                </div>

                                            @empty
                                            @endif
                                        </div>

                                        <div class="tab-pane" id="tab-review">
                                            {!! Form::open(array('route' => 'product.rating','method'=>'POST','class'=>'form-horizontal form-payment','files'=>false)) !!}
                                            <div class="form-group company-input">

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">

                                                            <div class="card-body text-center ratingStar">
                                                                <h2 class="text-center">Rating this product</h2>
                                                                <hr>
                                                                <h3 class="mt-1"><span class="myratings"> &nbsp;</span></h3>

                                                                <input type="radio" id="star1" name="rating" value="1" required class="hidden" />
                                                                <label class="full" for="star1" title="1 stars"></label>

                                                                <input type="radio" id="star2" name="rating" value="2" required  class="hidden" />
                                                                <label class="full" for="star2" title="2 stars"></label>

                                                                <input type="radio" id="star3" name="rating" value="3"  required class="hidden" />
                                                                <label class="full" for="star3" title="3 stars"></label>

                                                                <input type="radio" id="star4" name="rating" value="4" required  class="hidden" />
                                                                <label class="full" for="star4" title="4 stars"></label>

                                                                <input type="radio" id="star5" name="rating" value="5" required  class="hidden" />
                                                                <label class="full" for="star5" title="5 stars"></label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group company-input">
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <button type="submit" class="btn btn-default btn-center">Submit Rating</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                        <div class="tab-pane" id="tab-contentshipping">
                                            <div class="shipping_methods_info">
                                                <table class="table table-striped table-bordered table-hover">
                                                    @forelse($shippingMethods as $key=>$shippingMethod)
                                                        <tr>
                                                            <td width="5%">{{$key+1}}</td>
                                                            <td width="30%" class="bg-infos">{{$shippingMethod->title}}</td>
                                                            <td class="text-left"> {{$currency}} {{$shippingMethod->cost}}</td>
                                                        </tr>

                                                    @empty

                                                    @endforelse
                                                </table>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content-product-bottom clearfix">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#product-related">Related Products</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="product-related" class="tab-pane fade active in">

                                    <div class="clearfix module related-horizontal ">
                                        <h3 class="modtitle hidden"><span>Related Products </span></h3>

                                        <div class="related-products products-list  contentslider owl2-carousel owl2-theme owl2-responsive-1200 owl2-loaded" data-rtl="no" data-autoplay="no" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="4" data-items_column1="3" data-items_column2="3" data-items_column3="1" data-items_column4="1" data-arrows="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
                                            <!-- Products list -->



                                            <div class="owl2-stage-outer">
                                                <div class="owl2-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0.6s ease 0s; width: 879px;">

                                                    @forelse($product->relatedProducts as $key=>$relatedProduct)
                                                        <div class="owl2-item active" style="width: 263px; margin-right: 30px;">
                                                            <div class="product-layout product-grid">
                                                                <div class="product-item-container">
                                                                    <div class="left-block left-b">
                                                                        <div class="product-image-container">
                                                                            <a href=" " title="{{$relatedProduct->products->name}}">
                                                                                <img data-sizes="auto" src="{{asset($relatedProduct->products->productImages[0]->medium)}}" data-src="{{asset($relatedProduct->products->productImages[0]->medium)}}" title="{{$relatedProduct->products->name}}" class="img-responsive lazyautosizes lazyloaded" sizes="263px">
                                                                            </a>
                                                                        </div>

                                                                        <div class="box-label">

                                                                            <?php
                                                                            $discountPercent=0;
                                                                            $promotionSalePrice=0;

                                                                            if (isset($relatedProduct->products->productPromotion) && $relatedProduct->products->productPromotion->date_end>=date('Y-m-d'))
                                                                            {
                                                                                $discountPercent=$relatedProduct->products->productPromotion->promotion_by_percent;
                                                                                $promotionSalePrice=$relatedProduct->products->productPromotion->promotion_price;
                                                                            }
                                                                            ?>

                                                                            @if($discountPercent>0)
                                                                                <div class="box-label">
                                                                            <span class="label-product label-sale">
                                                                                 -{{$discountPercent}} %
                                                                            </span>

                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                    </div>

                                                                    <div class="right-block right-b">

                                                                        <div class="button-group cartinfo--static">

                                                                            {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                                                            <input class="form-control" type="hidden" min="1" max="999999" name="qty" value="1">
                                                                            <input type="hidden" name="product_id" value="{{$relatedProduct->child_id}}">

                                                                            <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>
                                                                            {!! Form::close() !!}

                                                                        </div>


                                                                        <div class="hide-cont">

                                                                            <div class="rate-history">
                                                                                <div class="ratings">

                                                                                    <?php
                                                                                    $maxReview=5;
                                                                                    $averageReview=0;

                                                                                    if (!empty($relatedProduct->products->product_review_avg_rating)){
                                                                                        $averageReview=ceil($relatedProduct->products->product_review_avg_rating);
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
                                                                                    <a class="rating-num"  href="{{url('/products/details/'.$relatedProduct->products->id."/$relatedProduct->products->name")}}" rel="nofollow" target="_blank" >({{$averageReview}})</a>
                                                                                </div>


                                                                            </div>

                                                                            <h4><a href="https://opencart.opencartworks.com/themes/so_supermarket/layout2/index.php?route=product/product&amp;product_id=42 ">{{$relatedProduct->products->name}} </a></h4>
                                                                        </div>

                                                                        <div class="price">
                                                                            @if($promotionSalePrice>0)
                                                                                <span class="price-new">{{$setting->currency}} {{$promotionSalePrice}}</span>
                                                                                <span class="price-old">{{$setting->currency}} {{$product->productStock->sale_price}} </span>
                                                                            @else
                                                                                <span class="price-new">{{$setting->currency}} {{$product->productStock->sale_price}}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @empty

                                                    @endforelse


                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>
                        <!--End extraslider-inner -->

                    </div>


                </div>

            </div>
        </div>
    </div>


@endsection

@section('script')

    <script src="{{asset('/client/assets')}}/javascript/soconfig/js/jquery.elevateZoom-3.0.8.min.js"></script>

    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>

    <script>
        $('.hidden').on('click',function () {
            $('.myratings').text($(this).val())
        })
    </script>


    <script type="text/javascript"><!--
        $(document).ready(function() {
            var zoomCollection = '.large-image img';
            $( zoomCollection ).elevateZoom({
                //value zoomType (window,inner,lens)
                zoomType: "window",
                lensSize    :'250',
                easing:false,
                scrollZoom : true,
                gallery:'thumb-slider',
                cursor: 'pointer',
                galleryActiveClass: "active",
            });
            $(zoomCollection).bind('touchstart', function(){
                $(zoomCollection).unbind('touchmove');
            });

            $('.large-image img').magnificPopup({
                items: [
                        @forelse($product->productImages as $productImage)
                    {src:"{{asset($productImage->big)}}"},
                    @empty
                    @endforelse
                ],
                gallery: { enabled: true, preload: [0,2] },
                type: 'image',
                mainClass: 'mfp-fade',
                callbacks: {
                    open: function() {
                        var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                        var magnificPopup = $.magnificPopup.instance;
                        magnificPopup.goTo(activeIndex);
                    }
                }

            });
        });
        //--></script>




    <script type="text/javascript"><!--
        $('#button-cart0').on('click', function() {

            $.ajax({
                url: '{{route('cart-products.store')}}',
                type: 'post',
                data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[name=\'_token\']'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-cart').button('loading');
                },
                complete: function() {
                    $('#button-cart').button('reset');
                },
                success: function(json) {
                    $('.alert').remove();
                    $('.text-danger').remove();
                    $('.form-group').removeClass('has-error');
                    if (json['error']) {
                        if (json['error']['option']) {
                            for (i in json['error']['option']) {
                                var element = $('#input-option' + i.replace('_', '-'));



                                if (element.parent().hasClass('input-group')) {
                                    element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                } else {
                                    element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                }
                            }
                        }

                        if (json['error']['recurring']) {
                            $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                        }

                        // Highlight any found errors
                        $('.text-danger').parent().addClass('has-error');
                    }

                    if (json['success']) {
                        $('.text-danger').remove();
                        $('#wrapper').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="fa fa-close close" data-dismiss="alert"></button></div>');
                        $('#cart  .total-shopping-cart ').html(json['total'] );
                        $('#cart > ul').load('index.php?route=common/cart/info ul li');

                        timer = setTimeout(function () {
                            $('.alert').addClass('fadeOut');
                        }, 4000);
                        $('.so-groups-sticky .popup-mycart .popup-content').load('index.php?route=extension/module/so_tools/info .popup-content .cart-header');
                    }


                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        //--></script>




    <script type="text/javascript"><!--
        $(document).ready(function() {

            // Initialize the sticky scrolling on an item
            sidebar_sticky = 'right';

            if(sidebar_sticky=='left'){
                $(".left_column").stick_in_parent({
                    offset_top: 10,
                    bottoming   : true
                });
            }else if (sidebar_sticky=='right'){
                $(".right_column").stick_in_parent({
                    offset_top: 10,
                    bottoming   : true
                });
            }else if (sidebar_sticky=='all'){
                $(".content-aside").stick_in_parent({
                    offset_top: 10,
                    bottoming   : true
                });
            }


            $("#thumb-slider .image-additional").each(function() {
                $(this).find("[data-index='0']").addClass('active');
            });

            $('.product-options li.radio').click(function(){
                $(this).addClass(function() {
                    if($(this).hasClass("active")) return "";
                    return "active";
                });

                $(this).siblings("li").removeClass("active");
                $(this).parent().find('.selected-option').html('<span class="label label-success">'+ $(this).find('img').data('original-title') +'</span>');
            })

            $('.thumb-video').magnificPopup({
                type: 'iframe',
                iframe: {
                    patterns: {
                        youtube: {
                            index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
                            id: 'v=', // String that splits URL in a two parts, second part should be %id%
                            src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
                        },
                    }
                }
            });
        });
        //--></script>


@endsection

