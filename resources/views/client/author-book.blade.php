@extends('client.layouts.master')
@section('head')
    <title> {{$authorData->name}} Books </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_color_swatches_pro/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_filter_shop_by/css/nouislider.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_filter_shop_by/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/soconfig/css/owl.carousel.css">

@endsection
@section('content')
<script src="{{asset('/client/assets')}}/javascript/jquery/jquery-2.1.1.min.js"></script>
    <div class="breadcrumbs ">
        <div class="container">
            <div class="current-name">
                {{$authorData->name}}
            </div>
            <ul class="breadcrumb">
                <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{URL::to('/book')}}">{{__('frontend.Book')}}</a></li>
                <li><a href="{{URL::to('/author')}}">{{__('frontend.Author')}}</a></li>
                <li><a href="{{URL::to('book/author/'.$authorData->id.'?ref='.$authorData->name)}}">{{$authorData->name}}</a></li>
            </ul>
        </div>
    </div>
    <div class="container product-listing content-main ">
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas" >
            @include('client.layouts.partials.product-filter')
            </aside>
            <div id="content" class="col-md-9 col-sm-12 col-xs-12 fluid-sidebar">
                <!-- So Groups -->
                <div class="products-category clearfix">
                    {{--<div class="refine-search form-group clearfix">--}}
                        {{--<h3 class="title-category">Refine Search</h3>--}}
                        {{--<ul class="refine-search__content ">--}}
                            {{--<li class="refine-search__subitem">--}}
                                {{--<a href="index_39.htm" class="thumbnail"><img class="lazyload"  data-sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="https://opencart.opencartworks.com/themes/so_supermarket/layout2/image/cache/catalog/logo-footer-270x270.png" alt="Consectetur" /> </a>--}}
                                {{--<a href="index_39.htm" class="text-center">Consectetur</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    <h3 class="title-category ">{{$authorData->name}}</h3>
                    <section style="background-color: #01a75485;padding: 20px;border-radius: 5px;">
                        <div class="row">
                            <div class="col-md-2">
                                <img class="img-fluid img-circle img-responsive center-block" src="{{asset($authorData->photo)}}" alt="{{$authorData->name}}" title="{{$authorData->name}}">
                            </div>
                            <div class="col-md-9">
                                <h3>{{$authorData->name}}</h3>
                                <?php
                                $halfBio=substr($authorData->bio,0,920);
                                echo $halfBio;
                                ?>
                                <a id="readMore"><strong>Read More</strong></a>
                                <span style="display:none;" id="fullBio"><?php echo $halfBio=substr($authorData->bio,923,-1)?></span>

                            </div>
                        </div>
                    </section>

                    <div class="product-filter product-filter-top filters-panel">
                        <div class="row">
                            <div class="col-md-4 col-sm-5 view-mode">
                                <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Refine</a>
                                <div class="sidebar-overlay "></div>
                                <div class="list-view">
                                    <div class="btn btn-gridview">Grid View:</div>
                                    <button type="button" id="grid-view-2" class="btn btn-view hidden-sm hidden-xs">2</button>
                                    <button type="button" id="grid-view-3" class="btn btn-view hidden-sm hidden-xs ">3</button>
                                    <button type="button" id="grid-view-4" class="btn btn-view hidden-sm hidden-xs">4</button>
                                    <button type="button" id="grid-view-5" class="btn btn-view hidden-sm hidden-xs">5</button>
                                    <button type="button" id="grid-view" class="btn btn-default grid hidden-lg hidden-md" title="Grid"><i class="fa fa-th-large"></i></button>
                                    <button type="button" id="list-view" class="btn btn-default list " title="List"><i class="fa fa-bars"></i></button>
                                    <button type="button" id="table-view" class="btn btn-view"><i class="fa fa-table" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="short-by-show form-inline text-right col-md-8 col-sm-7 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="input-limit">Show:</label>
                                    <select id="input-limit" class="form-control" onchange="perPageLimit(this.value)">
                                        <option value="20" @if($request->perPage==20) selected="selected"@endif>20</option>
                                        <option value="25" @if($request->perPage==25) selected="selected"@endif>25</option>
                                        <option value="50" @if($request->perPage==50) selected="selected"@endif>50</option>
                                        <option value="75" @if($request->perPage==75) selected="selected"@endif>75</option>
                                        <option value="100" @if($request->perPage==100) selected="selected"@endif>100</option>
                                    </select>
                                </div>
                                {{--<div class="form-group product-compare hidden-sm hidden-xs">--}}
                                    {{--<a href="index_3.htm" id="compare-total" class="btn btn-default">--}}
                                        {{--Product Compare (0)--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="products-list row nopadding-xs">
                        @forelse($products as $key=>$product)
                        <div class="product-layout ">
                            <div class="product-item-container">
                                <div class="left-block left-b">
                                    <div class="product-card__gallery product-card__right">
                                        @forelse($product->productImages as $productImage)
                                        <div class="item-img thumb-active" data-src="{{asset($productImage->medium)}}">
                                            <img class="lazyload" data-sizes="auto" src="" data-src="{{asset($productImage->small)}}" alt="{{$product->name}}">
                                        </div>
                                            @empty
                                        @endforelse
                                    </div>
                                    <div class="product-image-container">
                                        <a href="{{url('/book/details/'.$product->id."/$product->name")}}" title="{{$product->name}}">
                                            <img src="{{asset($product->productImages[0]->medium)}}" alt="{{$product->name}}" title="{{$product->name}}" class="img-responsive" id="product-image-{{$key}}" />
                                        </a>
                                    </div>
                                    <?php
                                        $discountPercent=0;
                                        $promotionSalePrice=0;
                                        if ($product->Promotion==\App\Models\Product::YES && isset($product->productPromotion) && $product->productPromotion->date_end>=date('Y-m-d'))
                                        {
                                            $discountPercent=$product->productPromotion->promotion_by_percent;
                                            $promotionSalePrice=$product->productPromotion->promotion_price;
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
                                <div class="right-block right-b">
                                    <div class="button-group cartinfo--static">
                                        {!! Form::open(['route'=>'cart-products.store','method'=>'POST','class'=>'form-horizontal','files'=>false]) !!}

                                            <input class="form-control" type="hidden" name="qty" value="1">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <button class="addToCart" type="submit" title="Add to Cart"><span>Add to Cart</span></button>
                                        <button class="wishlist btn-button" type="button" title="Add to Wish List - {{$product->name}}"
                                                onclick='event.preventDefault();document.getElementById("wishListForm{{$product->id}}").submit();'>
                                            <i class="fa fa-heart-o"></i><span>{{$product->name}}</span>
                                        </button>
                                        {!! Form::close() !!}
                                        <form id="wishListForm{{$product->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                            @csrf
                                            <input class="form-control" type="hidden" name="qty" value="1">
                                            <input class="form-control" type="hidden" name="type" value="{{\App\Models\CartProduct::WISHLIST}}">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                        </form>
                                        {{--<button class="compare btn-button" type="button" title="Add to Compare" onclick="compare.add('95');"><i class="fa fa-retweet"></i><span>Add to Compare</span></button>--}}
                                    </div>
                                    <div class="hide-cont">
                                        <div class="rate-history">
                                            <div class="ratings">
                                                <?php
                                                $maxReview=5;
                                                $averageReview=0;

                                                if (!empty($product->product_review_avg_rating)){
                                                    $averageReview=ceil($product->product_review_avg_rating);
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
                                                <a class="rating-num"  href="{{url('/book/details/'.$product->id."/$product->name")}}" rel="nofollow" target="_blank" >({{$averageReview}})</a>
                                            </div>
                                            {{--<div class="order-num">Orders (33)</div>--}}
                                        </div>
                                        <h4>
                                            <a href="{{url('/book/details/'.$product->id."/$product->name")}}">{{substr($product->name,0,25)}}</a>
                                        </h4>
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
                        @empty
                        @endforelse
                    </div>
                    <div class="product-filter product-filter-bottom filters-panel">
                        <div class="row">
                            <div class="col-sm-12 text-center">{!! $products->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('client.layouts.partials.right-side-menu')
@endsection
@section('script')
<script src="{{asset('/client/assets')}}/javascript/so_filter_shop_by/js/nouislider.js"></script>
<script src="{{asset('/client/assets')}}/javascript/soconfig/js/owl.carousel.js"></script>
<script>
    $('#readMore').on('click',function () {
        $('#fullBio').css({'display':'block'})
        $(this).css({'display':'none'})
    })

    function perPageLimit(perPageValue) {
        window.location.href="<?php echo request()->fullUrlWithQuery(['perPage'=>''])?>"+perPageValue;
        $("#input-limit select").val(perPageValue);
    }
</script>
    <script type="text/javascript"><!--
        reinitView();
        function reinitView() {
            $( '.product-card__gallery .item-img').hover(function() {
                $(this).addClass('thumb-active').siblings().removeClass('thumb-active');
                var thumb_src = $(this).attr("data-src");
                $(this).closest('.product-item-container').find('img.img-responsive').attr("src",thumb_src);
            });
            $('.view-mode .list-view button').bind("click", function() {
                $(this).parent().find('button').removeClass('active');
                $(this).addClass('active');
            });
            // Product List
            $('#list-view').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-list col-xs-12');
                localStorage.setItem('listview', 'list');
            });
            // Product Grid
            $('#grid-view').click(function() {
                var cols = $('.left_column , .right_column ').length;
                $('.products-category .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');

                localStorage.setItem('listview', 'grid');
            });
            // Product Grid 2
            $('#grid-view-2').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-grid product-grid-2 col-lg-6 col-md-6 col-sm-6 col-xs-12');
                localStorage.setItem('listview', 'grid-2');
            });
            // Product Grid 3
            $('#grid-view-3').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-grid product-grid-3 col-lg-4 col-md-4 col-sm-6 col-xs-12');
                localStorage.setItem('listview', 'grid-3');
            });
            // Product Grid 4
            $('#grid-view-4').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-grid product-grid-4 col-lg-3 col-md-4 col-sm-6 col-xs-12');
                localStorage.setItem('listview', 'grid-4');
            });
            // Product Grid 5
            $('#grid-view-5').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-grid product-grid-5 col-lg-15 col-md-4 col-sm-6 col-xs-12');
                localStorage.setItem('listview', 'grid-5');
            });
            // Product Table
            $('#table-view').click(function() {
                $('.products-category .product-layout').attr('class', 'product-layout product-table col-xs-12');
                localStorage.setItem('listview', 'table');
            })
            if(localStorage.getItem('listview')== null) localStorage.setItem('listview', 'grid-3');

            if (localStorage.getItem('listview') == 'table') {
                $('#table-view').trigger('click');
            } else if (localStorage.getItem('listview') == 'grid-2'){
                $('#grid-view-2').trigger('click');
            } else if (localStorage.getItem('listview') == 'grid-3'){
                $('#grid-view-3').trigger('click');
            } else if (localStorage.getItem('listview') == 'grid-4'){
                $('#grid-view-4').trigger('click');
            } else if (localStorage.getItem('listview') == 'grid-5'){
                $('#grid-view-5').trigger('click');
            } else {
                $('#list-view').trigger('click');
            }
        }
        //--></script>
@endsection
