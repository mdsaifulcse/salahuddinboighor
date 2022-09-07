<span id="close-sidebar" class="fa fa-times"></span>
<div class="module so_filter_wrap block-shopby">
    <div class="modcontent">
        <ul data-product_id = "95">
            <li class="so-filter-options" data-option="Subcategory">
                <div class="so-filter-heading">
                    <div class="so-filter-heading-text">
                        <span>{{__('frontend.Category Name Bn')}}</span>
                    </div>
                    {{--<i class="fa fa-chevron-down"></i>--}}
                </div>
                <div class="so-filter-content-opts">
                    <div class="so-filter-content-opts-container">
                        <div class="so-filter-option-sub so-filter-option opt-select " >
                            <div class="so-option-container">
                                <!-- data come from CompanyServicePrivider -->
                                @forelse($categories as $category)
                                    @if($category->products->count()>0)
                                        <p>
                                            <a href="{{URL::to('/book/category/'.$category->id.'?ref='.$category->category_name)}}" class="@if(Request::segment(3)==$category->id)active @endif">
                                                <span><i class="fa fa-angle-double-right "></i></span> {{$category->category_name_bn}} ({{$category->products->count()}})
                                            </a>
                                        </p>
                                        @forelse($category->subCatAsSubMenu as $subCate)
                                            @if($subCate->products->count()>0)
                                                <div class="so-filter-option-sub-sub">
                                                    <label>
                                                        <a href="{{URL::to('/book/category/'.$category->link.'?sub_cat='.$subCate->link.'&brand=')}}" class="@if($request->sub_cat==$subCate->link)active @endif">> {{$subCate->sub_category_name}}({{$subCate->products->count()}})
                                                        </a>
                                                    </label>
                                                    @forelse($subCate->thirdSubAsThirdSubMenu as $thirdSub)
                                                        @if($thirdSub->products->count()>0)
                                                            <div class="so-filter-option-sub-sub-sub">
                                                                <label>
                                                                    <a href="{{URL::to('/book/category/'.$category->link.'?sub_cat='.$subCate->link.'&third_sub_cat='.$thirdSub->link.'&brand=')}}" class="@if($request->third_sub_cat==$thirdSub->link) active @endif">{{$thirdSub->third_sub_category}}({{$thirdSub->products->count()}})
                                                                    </a>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                </div>
                                            @endif
                                        @empty
                                        @endforelse
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="so-filter-options" data-option="Price" style="display:none;">
                <div class="so-filter-heading">
                    <div class="so-filter-heading-text">
                        <span>Price</span>
                    </div>
                    {{--<i class="fa fa-chevron-down"></i>--}}
                </div>
                <div class="so-filter-content-opts">
                    <div class="so-filter-content-opts-container">
                        <div class="so-filter-content-wrapper so-filter-iscroll">
                            <div class="so-filter-options">
                                <div class="so-filter-option so-filter-price">
                                    <div class="content_min_max">
                                        <div class="put-min put-min_max">
                                            <span class="name-curent">$</span> <input type="text" class="input_min form-control" value="38" min="38" max="169"> </div>
                                        <div class="put-max put-min_max">
                                            <span class="name-curent">$</span> <input type="text" class="input_max form-control" value="169" min="38" max="169"></div>
                                    </div>
                                    <div class="content_scroll">
                                        <div id="slider-range"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="module banner-left hidden-xs ">
    <div class="banner-sidebar banners">
        <div>
            <a title="Banner Image" href="layout2.html#">
                {{--<img src="image/catalog/banners/banner-sidebar.jpg" alt="Banner Image">--}}
            </a>
        </div>
    </div>
</div>