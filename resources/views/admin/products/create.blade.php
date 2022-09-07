@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection

<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} by fill up required field
@endsection

@section('subheader-action')
    @can('product-list')
        <a href="{{ route('products.index') }}" class="btn btn-success pull-right" title="Click to go product list">
            <i class="la la-angle-double-left"></i> Book list
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')
    <style>
        .dropdownSec{
            background-color: #e9e9ea;
        }
        .inputSec, .dropdownSec{
            border:1px dashed #0e2291;
        }
        .inputSec{
            border-right: none;
        }
    </style>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="kt-portlet">

                        {!! Form::open(array('route' => 'products.store','method'=>'POST','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    <sup class="text-danger">*</sup> {{__('Mark field is required')}}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->

                        <div class="kt-portlet__body">

                            <div class="row">
                                <div class="form-group col-md-9 col-lg-9 inputSec">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" class="col-form-label">{{__('admin.Book Title')}}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('name', $value=old('name'), array('placeholder' => __('Book Title'),'class' => 'form-control','required'=>false)) !!}

                                            @if ($errors->has('name'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('name') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name_bn" class="col-form-label">{{__('admin.Book Title Bn')}}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('name_bn', $value=old('name_bn'), array('placeholder' => __('admin.Book Title Bn'),'class' => 'form-control','required'=>false)) !!}

                                            @if ($errors->has('name_bn'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('name_bn') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="example-text-input" class="col-form-label"> {{__('ISBN No.')}}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('isbn', $value=old('isbn'), ['placeholder' => 'Product ISBN Here ','class' => 'form-control','required'=>true]) !!}

                                            @if ($errors->has('isbn'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('isbn') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="example-text-input" class="col-form-label"> {{__('Edition')}}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('edition', $value=old('edition'), ['placeholder' => 'Product Edition Here ','class' => 'form-control','required'=>true]) !!}

                                            @if ($errors->has('edition'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('edition') }}<sup class="text-danger">*</sup></strong></span>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="example-text-input" class="col-form-label"> {{__('Number of page')}}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('number_of_page', $value=old('number_of_page'), ['placeholder' => 'Total number of page ','class' => 'form-control','required'=>true]) !!}

                                            @if ($errors->has('number_of_page'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('number_of_page') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>


                                    <div>
                                        <label for="example-text-input" class="col-form-label">{{__('admin.Summery')}}<sup class="text-danger">*</sup></label>
                                        <div class="">
                                            {!! Form::textArea('specification', $value=old('specification'), ['rows'=>5,'placeholder' =>__('admin.Summery'),'class' => 'form-control textarea','required'=>false]) !!}
                                            <strong class="text-default pull-right description-error"><span id="character_count">0</span> /10000 </strong>

                                            @if ($errors->has('specification'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('specification') }}</strong></span>
                                            @endif
                                        </div>
                                        <span id="specificationError" class="text-danger"></span>
                                    </div>
                                    <br>

                                    <hr>

                                    <span>Price Section ৳</span>
                                    <div style="border: 1px dashed #060247;padding: 10px;">
                                        <div class="row"> <!--Start price and stock qty -->
                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label" title="Your Purchase Price">SKU <sup class="text-danger">*</sup></label>

                                                {!! Form::text('sku', $value=old('sku'), ['placeholder' => 'Sku Here ','class' => 'form-control','required'=>true,]) !!}

                                                @if ($errors->has('sku'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('sku') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label" title="Your Purchase Price">Cost Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('cost_price',$value=old('cost_price'), ['min'=>0,'max'=>999999999,'placeholder' =>'','class' => 'form-control','required'=>true ])}}

                                                @if ($errors->has('cost_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('cost_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">Sale Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('sale_price',$value=old('sale_price'), ['id'=>'salePrice','min'=>0,'max'=>999999999,'placeholder' =>'','class' => 'form-control','required'=>true])}}

                                                <span id="salePriceError" class="text-danger">  </span>

                                                @if ($errors->has('sale_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('sale_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label" title="Available Stock quantity ">Stock Quantity <sup class="text-danger">*</sup></label>

                                                {{Form::number('qty',$value=old('qty'), ['min'=>0,'max'=>500000,'class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('qty'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('qty') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2 ">
                                                <label for="example-text-input" class="control-label">Have Discount ?</label>
                                                {!! Form::select('promotion',[\App\Models\Product::NO=>\App\Models\Product::NO,\App\Models\Product::YES=>\App\Models\Product::YES],[], ['id'=>'promotionType','placeholder'=>'Choose One','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('promotion'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                        </div> <!--End price and stock qty -->

                                        <div class="row" id="discountArea" style="display:none;"><!--start promotion -->

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label" title="Enter Discount Percent ">Discount Percent % <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_by_percent',$value=old('promotion_by_percent'), ['id'=>'promotionByPercent','min'=>0,'max'=>100,'class' => 'form-control','required'=>false])}}

                                                @if ($errors->has('promotion_by_percent'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_by_percent') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label"> Discount Value <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_by_value',$value=old('promotion_by_value'), ['step'=>'any','min'=>0,'max'=>999999999,'id'=>'promotionByValue','placeholder' =>'','class' => 'form-control','required'=>false])}}

                                                @if ($errors->has('promotion_by_value'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_by_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label" title="Sale Price After Discount">Discount Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_price',$value=old('promotion_price'), ['step'=>'any','min'=>0,'max'=>999999999,'id'=>'promotionPrice','placeholder' =>'','class' => 'form-control','required'=>false])}}

                                                @if ($errors->has('promotion_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Date From <sup class="text-danger">*</sup></label>

                                                <input type="text" name="date_start" class="form-control" id="dateFrom" value="" />

                                                @if ($errors->has('date_start'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Date To <sup class="text-danger">*</sup></label>

                                                <input type="text" name="date_end" class="form-control" id="dateTo" value="" />

                                                @if ($errors->has('date_start'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div><!--end promotion -->
                                    </div>

                                    <hr>


                                    <div class="row">



                                        <div class="col-md-8 col-lg-12">
                                            <label for="example-text-input" class=" col-form-label">{{__('Related Products')}}</label>
                                            <div class="">
                                                {!! Form::select('child_id[]', $relatedProductLists,[], array('id'=>'kt_select2_2_3','class' => 'form-control kt-select2','multiple'=>true,'required'=>false)) !!}

                                                @if ($errors->has('child_id'))
                                                    <span class="help-block"><strong class="text-danger">{{ $errors->first('child_id') }}</strong> </span>
                                                @endif
                                            </div>
                                        </div>


                                    </div>

                                    <hr>

                                    <div class="row images_wrapper">

                                        <div class="col-md-6">
                                            <label for="example-text-input" class="col-form-label0"><i class="la la-youtube la-2x text-danger"></i> {{__('Video Url')}}</label>
                                            {!! Form::text('video_url', $value=old('video_url'), ['placeholder' => 'Youtube video link ','class' => 'form-control','required'=>false]) !!}

                                            @if ($errors->has('video_url'))
                                                <span class="help-block"><strong class="text-danger">{{ $errors->first('video_url') }}</strong></span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4" style="padding-right: 0px;padding-left: 5px;">
                                            <label for="example-text-input" class="col-form-label0"><i class="la la-book la-2x text-danger"></i> {{__('Brochure (Pdf file)')}}</label>
                                            <div class="">
                                                {!! Form::file('installation_gide', ['style'=>'font-size:10px;padding:0px','accept'=>'application/pdf','title' => 'Chose a pdf file as installation guide ','class' => 'form-control','required'=>false,]) !!}

                                                @if ($errors->has('installation_gide'))
                                                    <span class="help-block"><strong class="text-danger">{{ $errors->first('installation_gide') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="example-text-input" class=" col-form-label0">Thumbnail <sup class="text-danger">*</sup></label>
                                            <div class="">
                                                <label class="slide_upload" for="featurePhoto">
                                                    <img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 110px; height: auto;cursor:pointer;border:2px dashed #260d53;">
                                                </label>
                                                <input id="featurePhoto" style="display:none" name="image[]" type="file"  required onchange="photoLoad(this,this.id)" accept="image/*">
                                            </div>
                                            <span class="text-danger text-center" style="display:none" id="fimageError">Thumbnail Image is Required  </span>
                                            <a href="javascript:void(0);" class="add_button" title="Add More Image"><img src="{{asset('images/default/add-icon.png')}}">
                                            </a>
                                        </div>


                                    </div> <!--end image row-->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="example-text-input" class="col-form-label"> Keyword</label>
                                            {!! Form::text('keyword', $value=old('keyword'), ['placeholder' => 'Product Keyword Here ','class' => 'form-control','required'=>false,'style'=>'display:block',]) !!}

                                            @if ($errors->has('keyword'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('keyword') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                </div> <!-- end col-8 -->

                                <div class="form-group col-md-3 col-lg-3 dropdownSec">

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">{{_('Author')}} </label>
                                        {!! Form::select('author_id[]',$authorLists,[], ['placeholder' => '--Select Author --','multiple'=>true,'class' => 'form-control select2tags','required'=>false]) !!}

                                        @if ($errors->has('author_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('author_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">{{_('Puplisher')}} <sup class="text-danger">*</sup></label>
                                        {!! Form::select('publisher_id',$publisherLists,[], ['id'=>'kt_select2_2','placeholder' => '--Select Publisher --','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('publisher_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('publisher_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">{{_('Language')}} <sup class="text-danger">*</sup></label>
                                        {!! Form::select('language_id',$languageLists,[], ['placeholder' => '--Select Language --','class' => 'form-control select2tags','required'=>true]) !!}

                                        @if ($errors->has('language_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('language_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">{{_('Country')}}  <sup class="text-danger">*</sup></label>
                                        {!! Form::select('country_id',$countryLists,[], ['id'=>'kt_select2_2_1','placeholder' => '--Select Country --','class' => 'form-control select2tags','required'=>true]) !!}

                                        @if ($errors->has('country_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('country_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Vat | Tax</label>
                                        {!! Form::select('vat_tax_id',$vatTaxes,[], ['placeholder' => '--Select Vat|Tax--','class' => 'form-control','required'=>false]) !!}

                                        @if ($errors->has('vat_tax_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('vat_tax_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    {{--<div class="">--}}
                                        {{--<label for="example-text-input" class="col-form-label">Brand</label>--}}
                                        {{--{!! Form::select('brand_id',$brands,[], ['id'=>'kt_select2_2_2','placeholder' => '--Select brand --','class' => 'form-control','required'=>false]) !!}--}}

                                        {{--@if ($errors->has('brand_id'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('brand_id') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                    <div class="category">
                                            <label for="example-text-input" class="col-form-label">{{__('admin.Category Name Bn')}}<sup class="text-danger">*</sup></label>

                                            {!! Form::select('category_id',$categories,[], ['id'=>'loadSubCategory','placeholder' => '--Select Category --','class' => 'form-control select2tags','required'=>true]) !!}

                                            @if ($errors->has('category_id'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>


                                   <div>
                                       <label for="example-text-input" class="col-form-label">{{__('admin.Sub Category Name Bn')}}</label>
                                       <div class="" id="subCategoryList">
                                           {!! Form::select('subcategory_id',[],[], ['id'=>'loadThirdSubCategory','placeholder' => 'First Select Category','class' => 'form-control select2tags','required'=>false]) !!}

                                           @if ($errors->has('subcategory_id'))
                                               <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
                                            </span>
                                           @endif
                                       </div>
                                   </div>

                                   {{--<div>--}}
                                       {{--<label for="example-text-input" class="col-form-label">Third Sub-Category</label>--}}
                                       {{--<div class="" id="thirdSubCategoryList">--}}
                                           {{--{!! Form::select('third_category_id',[],[], ['id'=>'loadFourthSubCategory','placeholder' => 'First Select Sub-Category','class' => 'form-control','required'=>false]) !!}--}}

                                           {{--@if ($errors->has('third_category_id'))--}}
                                               {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('third_category_id') }}</strong>--}}
                                            {{--</span>--}}
                                           {{--@endif--}}
                                       {{--</div>--}}
                                   {{--</div>--}}

                                   <div style="display:none">
                                       <label for="example-text-input" class="col-form-label">Fourth Sub-Category</label>
                                       <div class="" id="fourthSubCategoryList">
                                           {!! Form::select('fourth_category_id',[],[], ['id'=>'fourthSubCategory','placeholder' => 'First Select Third-Category','class' => 'form-control','required'=>false]) !!}

                                           @if ($errors->has('fourth_category_id'))
                                               <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('fourth_category_id') }}</strong>
                                            </span>
                                           @endif
                                       </div>
                                   </div>


                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Published Status<sup class="text-danger">*</sup></label>
                                        {!! Form::select('status', $status,[], ['class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Show at home page?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('show_home', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('show_home'))
                                            <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('show_home') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Is feature?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_feature', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_feature'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_feature') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Is New Book?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_new', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_new'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_new') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Added to reading list?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('added_reading_list', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('added_reading_list'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('added_reading_list') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Most Popular?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_most_popular', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_most_popular'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_most_popular') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--<div class="">--}}
                                        {{--<label for="example-text-input" class="col-form-label">Top Rated?<sup class="text-danger">*</sup></label>--}}
                                        {{--{!! Form::select('is_top_rated', $yesNoStatus,[], ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}--}}

                                        {{--@if ($errors->has('is_top_rated'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('is_top_rated') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                    <?php $max=$max_serial+1; ?>
                                    <div class="">
                                        <label for="example-text-input" class="col-form-label"> Product Serial No. <sup class="text-danger">*</sup></label>
                                        {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                    </div>

                                </div> <!-- end col-md-3 col-lg-3 -->


                            </div><!-- end row -->


                        </div> <!--End kt-portlet__body -->


                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">

                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success" onclick="return ValidateCharacterLength()">Submit</button>

                                        @can('product-list')
                                            <a href="{{ route('products.index') }}" class="btn btn-secondary pull-right "> Cancel </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--End::Row-->
    </div>

    <!-- end:: Content -->

@endsection

@section('script')

    {{--Discount Calculation--}}

    <script>

        //discount area hide and show ---------------
        $('#promotionType').on('change',function () {

            var promotionType=$(this).val()

            $('#promotionByPercent').val('')
            $('#promotionByValue').val('')
            $('#promotionPrice').val('')
            $('#dateFrom').val('')
            $('#dateTo').val('')

            if (promotionType=='Yes')
                {
                    $('#discountArea').css('display','flex')

                    $('#promotionByPercent').attr('required',true)
                    $('#promotionByValue').attr('required',true)
                    $('#promotionPrice').attr('required',true)
                    $('#dateFrom').attr('required',true)
                    $('#dateTo').attr('required',true)

                }else {
                    $('#discountArea').css('display','none')

                    $('#promotionByPercent').attr('required',false)
                    $('#promotionByValue').attr('required',false)
                    $('#promotionPrice').attr('required',false)
                    $('#dateFrom').attr('required',false)
                    $('#dateTo').attr('required',false)
                }
        })

        // Discount by Percentage ---------------------------
        $('#promotionByPercent').on('keyup',function () {

            var percentage=$(this).val();

            var salePrice=$('#salePrice').val()

            if (salePrice<1)
            {
                $('#salePriceError').html('Sale price is required')
                return false;
            }
            $('#salePriceError').html('')

            var discountVal=(percentage*salePrice)/100

            $('#promotionByValue').val(discountVal)

            $('#promotionPrice').val(salePrice-discountVal)
        })


        // Discount by Value ---------------------------
        $('#promotionByValue').on('keyup',function () {

            var discountVal=$(this).val();

            var salePrice=$('#salePrice').val()

            if (salePrice<1)
            {
                $('#salePriceError').html('Sale price is required')
                return false;
            }
            $('#salePriceError').html('')

           var percentage=(discountVal*100)/salePrice

            $('#promotionByValue').attr('max',salePrice)

            $('#promotionByPercent').val(Math.round(percentage))

            $('#promotionPrice').val(salePrice-discountVal)
        })

    </script>


    <!-- Add / Remove Image Upload -->
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 5; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.images_wrapper'); //Input field wrapper
            var x =1; //Initial field counter is 1
            var v =1; //Initial field counter is 1
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    v++; //Increment field counter
                    var forProductImage=v+'">'
                    var inputProductImage='<input id="productImage_'+v
                    var imageUpload='<img id="image_load_'+v
                    var deleteTag='<a id="'+v

                    var fieldHTML = '<div class="form-group col-md-2">\n' +
                        '<label for="example-text-input" class=" col-form-label0"> Image</label>\n' +
                        '<div class="">\n' +
                        '<label class="slide_upload" for="productImage_' +forProductImage+
                        '\n' +
                        imageUpload+'" src="{{asset('images/default/default.png')}}" style="width: 110px; height: auto;cursor:pointer;border:2px dashed #260d53;">\n' +
                        '</label>\n' +
                        inputProductImage+'" style="display:none" name="image[]" type="file" onchange="photoLoad(this,this.id)" accept="image/*">\n' +
                        '@if ($errors->has('image'))\n' +
                        '<span class="help-block">\n' +
                        '<strong class="text-danger">{{ $errors->first('image') }}</strong>\n' +
                        '</span>\n' +
                        '@endif\n' +
                        deleteTag+'" href="javascript:void(0);"  class="remove_button" title="Delete"><img src="{{asset('images/default/remove-icon.png')}}">\n' +
                        '</a>\n' +
                        '</div>\n' +
                        '</div>';

                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').parent().remove(); //Remove field html
                x--; //Decrement field counter
                //var deleteId=$(this,'.remove_button').attr('id');
            });
        });
    </script>


    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

    {{--Text Editor--}}
    <script>
        tinymce.init({
            selector: '.textarea',
            menubar: true,
            theme: 'modern',
            plugins: 'table image code link lists textcolor imagetools colorpicker ',
            browser_spellcheck: true,
            toolbar1: 'forecolor backcolor formatselect | bold italic strikethrough | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            // enable title field in the Image dialog
            image_title: true,
            setup: function (ed) {
                ed.on('keyup', function (e) {
                    var count = CountCharacters();
                    document.getElementById("character_count").innerHTML = "Characters: " + count;
                });
            }
        });


        function CountCharacters() {
            var body = tinymce.get("specification").getBody();
            var content = tinymce.trim(body.innerText || body.textContent);
            return content.length;
        };
        function ValidateCharacterLength() {
            var max = 10000;
            var count = CountCharacters();


            if (count > max) {
                alert("Maximum " + max + " characters allowed.")
                return false;
            }else if(count<=4) {
                alert("Minimum " + 50 + " characters required for product Spacification")

                return false;
            }else{

                var imgVal = $('#featurePhoto').val();
                if(imgVal=='')
                {
                    $('#fimageError').show();
                    return false;
                }else{
                    $('#fimageError').hide();
                }
                return;
            }
        }

    </script>

    {{--Load SubCategory--}}
    <script>
        $('#loadSubCategory').on('change',function () {

            var categoryId=$(this).val()

            $('#loadFourthSubCategory').empty()
            $('#fourthSubCategory').empty()

            if(categoryId.length===0)
            {
                categoryId=0
                $('#subCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-cat-by-cat")}}/'+categoryId);

            }else {

                $('#subCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-cat-by-cat")}}/'+categoryId);
            }
        })
    </script>

    {{--Image Upload--}}
    <script type="text/javascript">
        function photoLoad(input,image_load) {
            var target_image='#'+$('#'+image_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

    <link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>

    <script>
        $(function() {
            $('#dateFrom').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                //maxDate: new Date(),
                minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#dateFrom').val('');
        });

        $(function() {
            $('#dateTo').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                //maxDate: new Date(),
                minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#dateTo').val('');
            {{--@if($request->has('dateTo'))--}}
            {{--$('#dateTo').val("{{$request->dateTo}}");--}}
            {{--@else--}}
            {{--$('#dateTo').val('');--}}
            {{--@endif--}}
        });
    </script>


@endsection

<!-- Good -->





