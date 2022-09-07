@extends('layouts.vmsapp')

@section('title')
    Edit {{$product->name}}
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Edit Product Details
@endsection

@section('subheader-action')
    @can('product-list')
        <a href="{{ route('products.index') }}" class="btn btn-success pull-right" title="Click to go back product list">
            <i class="la la-angle-double-left"></i> Product list
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')
    <style>
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

                        {!! Form::open(array('route' =>['products.update',$product->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    <i class="la la-pencil-square"></i> Edit Product Details (<sup class="text-danger">*</sup> Marks field is mandatory)
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->

                        <div class="kt-portlet__body">

                            <div class="row">
                                <div class="form-group col-md-9 col-lg-9 inputSec">

                                    <div>
                                        <label for="name" class="col-form-label">Name<sup class="text-danger">*</sup></label>
                                        <div class="">
                                            {!! Form::text('name', $value=old('name',$product->name), array('placeholder' => 'Enter product name here *','class' => 'form-control','required'=>true)) !!}

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div>
                                        <label for="example-text-input" class="col-form-label"> Keyword</label>
                                        <div class="">
                                            {!! Form::text('keyword', $value=old('keyword',$product->keyword), ['placeholder' => 'Product Keyword Here ','class' => 'form-control','required'=>false,'style'=>'display:block',]) !!}

                                            @if ($errors->has('keyword'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('keyword') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div>
                                        <label for="example-text-input" class="col-form-label">Short Description<sup class="text-danger">*</sup></label>
                                        <div class="">
                                            {!! Form::textArea('short_description', $value=old('short_description',$product->short_description), ['rows'=>4,'placeholder' => '','class' => 'form-control textarea','required'=>false]) !!}

                                            @if ($errors->has('short_description'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('short_description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <span id="shortDescriptionError" class="text-danger"></span>
                                    </div>

                                    <div>
                                        <label for="example-text-input" class="col-form-label">Description<sup class="text-danger">*</sup></label>
                                        <div class="">
                                            {!! Form::textArea('description', $value=old('description',$product->description), ['rows'=>5,'placeholder' => '','class' => 'form-control textarea','required'=>false]) !!}
                                            <strong class="text-default pull-right description-error"><span id="character_count">0</span> /10000 </strong>
                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <span id="descriptionError" class="text-danger"></span>
                                    </div>

                                    <div>
                                        <label for="example-text-input" class="col-form-label">Specification</label>
                                        <div class="">
                                            {!! Form::textArea('specification', $value=old('specification',$product->specification), ['rows'=>5,'placeholder' => '','class' => 'form-control textarea','required'=>false]) !!}

                                            @if ($errors->has('specification'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('specification') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <span id="specificationError" class="text-danger"></span>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <label for="example-text-input" class=" col-form-label">Product Tag</label>
                                            <div class="">
                                                {!! Form::select('tag_id[]', $tags,$productTagIds, array('id'=>'kt_select2_3','class' => 'form-control kt-select2','multiple'=>true,'required'=>false)) !!}

                                                @if ($errors->has('tag_id'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('tag_id') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <label for="example-text-input" class=" col-form-label">Product Collection</label>
                                            <div class="">
                                                {!! Form::select('collection_id[]', $collectionLists,$productCollections, array('id'=>'kt_select2_1','class' => 'form-control kt-select2','multiple'=>true,'required'=>false)) !!}

                                                @if ($errors->has('collection_id'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('collection_id') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div> <!-- end tag and collection row -->

                                    <hr>

                                    <span>Price Section ৳</span>
                                    <div style="border: 1px dashed #060247;padding: 10px;">
                                        <div class="row"> <!--Start price -->
                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label" title="Your Purchase Price">SKU <sup class="text-danger">*</sup></label>

                                                {!! Form::text('sku', $value=old('sku',$product->sku), ['placeholder' => 'Sku Here ','class' => 'form-control','required'=>true,]) !!}

                                                @if ($errors->has('sku'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('sku') }}</strong>
                                            </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label" title="Your Purchase Price">Cost Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('cost_price',$value=old('cost_price',$product->productStock->cost_price), ['min'=>0,'max'=>999999999,'placeholder' =>'','class' => 'form-control','required'=>true ])}}

                                                @if ($errors->has('cost_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('cost_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">Sale Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('sale_price',$value=old('sale_price',$product->productStock->sale_price), ['id'=>'salePrice','min'=>0,'max'=>999999999,'placeholder' =>'','class' => 'form-control','required'=>true])}}

                                                <span id="salePriceError" class="text-danger">  </span>

                                                @if ($errors->has('sale_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('sale_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2 ">
                                                <label for="example-text-input" class="control-label">Have Discount ?</label>
                                                {!! Form::select('promotion',[\App\Models\Product::NO=>\App\Models\Product::NO,\App\Models\Product::YES=>\App\Models\Product::YES],$product->promotion, ['id'=>'promotionType','placeholder'=>'Choose One','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('promotion'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div> <!--End price -->

                                        {{--<div class="row"> <!--Start qty -->--}}
                                            {{--<div class="form-group col-md-3">--}}
                                                {{--<label for="example-text-input" class="control-label" title="Available Stock quantity ">Old Quantity <sup class="text-danger">*</sup></label>--}}

                                                {{--{{Form::number('qty',$value=old('qty',$product->productStock->qty-$product->productStock->sold_qty), ['id'=>'oldQty','min'=>0,'max'=>500000,'class' => 'form-control','required'=>true,'readonly'=>true])}}--}}

                                                {{--@if ($errors->has('qty'))--}}
                                                    {{--<span class="help-block">--}}
                                                    {{--<strong class="text-danger">{{ $errors->first('qty') }}</strong>--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group col-md-3">--}}
                                                {{--<label for="example-text-input" class="control-label" title="Available Stock quantity ">New Quantity <sup class="text-danger">*</sup></label>--}}

                                                {{--{{Form::number('new_add_qty',$value=old('new_add_qty',0), ['id'=>'newAddQty','min'=>0,'max'=>500000,'class' => 'form-control','required'=>false])}}--}}

                                                {{--@if ($errors->has('new_add_qty'))--}}
                                                    {{--<span class="help-block">--}}
                                                    {{--<strong class="text-danger">{{ $errors->first('new_add_qty') }}</strong>--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group col-md-3">--}}
                                                {{--<label for="example-text-input" class="control-label" title="Available Stock quantity ">Total Quantity <sup class="text-danger">*</sup></label>--}}

                                                {{--{{Form::number('qty',$value=old('qty',$product->productStock->qty-$product->productStock->sold_qty), ['id'=>'totalQty','min'=>0,'max'=>500000,'class' => 'form-control','required'=>true,'readonly'=>true])}}--}}

                                                {{--@if ($errors->has('qty'))--}}
                                                    {{--<span class="help-block">--}}
                                                    {{--<strong class="text-danger">{{ $errors->first('qty') }}</strong>--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}


                                        {{--</div> <!--End stock qty -->--}}

                                        <?php
                                        if ($product->promotion==\App\Models\Product::YES){
                                            $display='flex';
                                            $required=true;
                                        }else{
                                            $display='none';
                                            $required=false;
                                        }

                                        ?>

                                        <div class="row" id="discountArea" style="display:{{$display}};"><!--start promotion -->

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label" title="Enter Discount Percent ">Discount Percent % <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_by_percent',$value=old('promotion_by_percent',$product->productPromotion?$product->productPromotion->promotion_by_percent:''), ['id'=>'promotionByPercent','min'=>0,'max'=>100,'class' => 'form-control','required'=>$required])}}

                                                @if ($errors->has('promotion_by_percent'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_by_percent') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label"> Discount Value <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_by_value',$value=old('promotion_by_value',$product->productPromotion?$product->productPromotion->promotion_by_value:''), ['step'=>'any','min'=>0,'max'=>999999999,'id'=>'promotionByValue','placeholder' =>'','class' => 'form-control','required'=>$required])}}

                                                @if ($errors->has('promotion_by_value'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_by_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label" title="Sale Price After Discount">Discount Price <sup class="text-danger">*</sup></label>

                                                {{Form::number('promotion_price',$value=old('promotion_price',$product->productPromotion?$product->productPromotion->promotion_price:''), ['min'=>0,'max'=>999999999,'id'=>'promotionPrice','placeholder' =>'','class' => 'form-control','required'=>$required])}}

                                                @if ($errors->has('promotion_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('promotion_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Date From <sup class="text-danger">*</sup></label>

                                                {{Form::text('date_start',$value=old('date_start',$product->productPromotion?date('m-d-Y',strtotime($product->productPromotion->date_start)):''),['class'=>'form-control','id'=>'dateFrom','required'=>$required])}}

                                                @if ($errors->has('date_start'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Date To<sup class="text-danger">*</sup></label>

                                                {{Form::text('date_end',$value=old('date_end',$product->productPromotion?date('m-d-Y',strtotime($product->productPromotion->date_end)):'00'),
                                                ['class'=>'form-control','id'=>'dateTo','required'=>$required])}}

                                                @if ($errors->has('date_start'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div><!--end promotion -->
                                    </div>

                                    <hr>
                                    <div class="row" style="display:none;"> <!-- weight and length Start -->

                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Weight unit</label>
                                            {!! Form::select('weight_unit_id',$weightUnitLists,$product->weight_unit_id, ['placeholder'=>'Select weight Unit','class' => 'form-control','required'=>false]) !!}

                                            @if ($errors->has('weight_unit_id'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('weight_unit_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Weight</label>

                                            {{Form::number('weight',$value=old('weight',$product->weight), ['min'=>0,'class' => 'form-control','required'=>false])}}

                                            @if ($errors->has('weight'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('weight') }}</strong>
                                                </span>
                                            @endif
                                        </div>


                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Length unit</label>
                                            {!! Form::select('length_unit_id',$lengthUnitLists,$product->length_unit_id, ['placeholder'=>'Select length Unit','class' => 'form-control','required'=>false]) !!}

                                            @if ($errors->has('length_unit_id'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('length_unit_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Length</label>

                                            {{Form::number('length',$value=old('length',$product->length), ['min'=>0,'class' => 'form-control','required'=>false])}}

                                            @if ($errors->has('length'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('length') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Height</label>

                                            {{Form::number('height',$value=old('height',$product->height), ['min'=>0,'class' => 'form-control','required'=>false])}}

                                            @if ($errors->has('height'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('height') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="example-text-input" class="control-label">Width</label>

                                            {{Form::number('width',$value=old('width',$product->width), ['min'=>0,'class' => 'form-control','required'=>false])}}

                                            @if ($errors->has('width'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('width') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div> <!-- weight and length End -->


                                    <div class="row">

                                        <div class="col-md-6 col-lg-6">
                                            <label for="example-text-input" class=" col-form-label">Related Products</label>
                                            <div class="">
                                                {!! Form::select('child_id[]', $relatedProductLists,$relatedProducts, array('id'=>'kt_select2_2_3','class' => 'form-control kt-select2','multiple'=>true,'required'=>false)) !!}

                                                @if ($errors->has('child_id'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('child_id') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row images_wrapper">

                                        <div class="form-group col-md-2" style="padding-right: 0px;padding-left: 5px;">
                                            <label for="example-text-input" class="col-form-label0"> Installation Guide (Pdf file)</label>
                                            <div class="">
                                                {!! Form::file('installation_gide', ['style'=>'font-size:10px;padding:0px','accept'=>'application/pdf','title' => 'Chose a pdf file as installation guide ','class' => 'form-control','required'=>false,]) !!}

                                                @if ($errors->has('installation_gide'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('installation_gide') }}</strong>
                                            </span>
                                                @endif

                                                @if(!empty($product->installation_gide))
                                                <a href="{{asset($product->installation_gide)}}" target="_blank">View Old File</a>
                                                    @endif
                                            </div>
                                        </div>

                                        <input type="hidden" id="totalImage" value="{{count($product->productImages)}}"></input>
                                        @forelse($product->productImages as $key=>$image)

                                            @if($image->is_thumbnail==\App\Models\ProductImage::YES)

                                                <div class="form-group col-md-2">
                                                    <label for="example-text-input" class=" col-form-label0">Thumbnail <sup class="text-danger">*</sup></label>
                                                    <div class="">
                                                        <label class="slide_upload" for="featurePhoto">
                                                            <img id="image_load" src="{{asset($image->small)}}" style="width: 110px; height: auto;cursor:pointer;border:2px dashed #260d53;">
                                                        </label>
                                                        <input type="file" name="image[{{$image->id}}]" id="featurePhoto" style="display:none" type="file"  onchange="photoLoad(this,this.id)" accept="image/*">
                                                    </div>

                                                    <a href="javascript:void(0);" class="add_button" title="Add More Image"><img src="{{asset('images/default/add-icon.png')}}">
                                                    </a>
                                                </div>

                                            @else

                                                <div class="form-group col-md-2">
                                                    <label for="example-text-input" class=" col-form-label0"> Image</label>
                                                    <div class="">
                                                        <label class="slide_upload" for="productImage_{{$key+6}}">
                                                            <img id="image_load_{{$key+6}}" src="{{asset($image->small)}}" style="width: 110px; height: auto;cursor:pointer;border:2px dashed #260d53;">
                                                        </label>
                                                        <input type="file" name="image[{{$image->id}}]" id="productImage_{{$key+6}}" style="display:none" onchange="photoLoad(this,this.id)" accept="image/*">

                                                        <a id="{{$image->id}}" href="javascript:void(0);" class="remove_button" title="Delete"><img src="http://localhost/e-commerce/public/images/default/remove-icon.png">
                                                        </a>
                                                    </div>
                                                </div>

                                                @endif

                                            @empty


                                        @endforelse

                                        <input type="hidden" name="delete_img[]" id="deletedImg">

                                    </div> <!--end image row-->


                                </div> <!-- end col-8 -->

                                <div class="form-group col-md-3 col-lg-3 dropdownSec">

                                    <?php $max=$max_serial+1; ?>
                                    <div class="">
                                        <label for="example-text-input" class="col-form-label"> Product Serial No. <sup class="text-danger">*</sup></label>
                                        {{Form::number('serial_num',$product->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Published Status<sup class="text-danger">*</sup></label>
                                        {!! Form::select('status', [\App\Models\Product::PUBLISHED=>\App\Models\Product::PUBLISHED,\App\Models\Product::UNPUBLISHED=>\App\Models\Product::UNPUBLISHED,\App\Models\Product::DRAFT=>\App\Models\Product::DRAFT],$product->status, ['class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Show at home page?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('show_home', [\App\Models\Product::YES=>\App\Models\Product::YES,\App\Models\Product::NO=>\App\Models\Product::NO],$product->show_home, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('show_home'))
                                            <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('show_home') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Is feature?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_feature', [\App\Models\Product::YES=>\App\Models\Product::YES,\App\Models\Product::NO=>\App\Models\Product::NO],$product->is_feature, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_feature'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_feature') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Most Popular?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_most_popular', [\App\Models\Product::YES=>\App\Models\Product::YES,\App\Models\Product::NO=>\App\Models\Product::NO],$product->is_most_popular, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_most_popular'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_most_popular') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Top Rated?<sup class="text-danger">*</sup></label>
                                        {!! Form::select('is_top_rated', [\App\Models\Product::YES=>\App\Models\Product::YES,\App\Models\Product::NO=>\App\Models\Product::NO],$product->is_top_rated, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('is_top_rated'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('is_top_rated') }}</strong>
                                            </span>
                                        @endif
                                    </div>



                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Origin <sup class="text-danger">*</sup></label>
                                        {!! Form::select('origin_id',$origins,$product->origin_id, ['id'=>'kt_select2_2','placeholder' => '--Select Origin --','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('origin_id'))
                                            <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('origin_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Pack Size | Unit <sup class="text-danger">*</sup></label>
                                        {!! Form::select('pack_size_unit_id',$packSizeUnits,$product->pack_size_unit_id, ['id'=>'kt_select2_2_1','placeholder' => '--Select Size --','class' => 'form-control','required'=>true]) !!}

                                        @if ($errors->has('pack_size_unit_id'))
                                            <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('pack_size_unit_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Vat|Tax</label>
                                        {!! Form::select('vat_tax_id',$vatTaxes,$product->vat_tax_id, ['placeholder' => '--Select Vat|Tax--','class' => 'form-control','required'=>false]) !!}

                                        @if ($errors->has('vat_tax_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('vat_tax_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="">
                                        <label for="example-text-input" class="col-form-label">Brand</label>
                                        {!! Form::select('brand_id',$brands,$product->brand_id, ['id'=>'kt_select2_2_2','placeholder' => '--Select brand --','class' => 'form-control','required'=>false]) !!}

                                        @if ($errors->has('brand_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('brand_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="category">
                                            <label for="example-text-input" class="col-form-label">Category<sup class="text-danger">*</sup></label>

                                            {!! Form::select('category_id',$categories,$product->category_id, ['id'=>'loadSubCategory','placeholder' => '--Select Category --','class' => 'form-control','required'=>true]) !!}

                                            @if ($errors->has('category_id'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>


                                   <div>
                                       <label for="example-text-input" class="col-form-label">Sub Category</label>
                                       <div class="" id="subCategoryList">
                                           {!! Form::select('subcategory_id',$subCategories,$product->subcategory_id, ['id'=>'loadThirdSubCategory','placeholder' => '--Select Sub-category--','class' => 'form-control','required'=>false]) !!}

                                           @if ($errors->has('subcategory_id'))
                                               <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
                                            </span>
                                           @endif
                                       </div>
                                   </div>

                                   <div>
                                       <label for="example-text-input" class="col-form-label">Third Sub-Category</label>
                                       <div class="" id="thirdSubCategoryList">
                                           {!! Form::select('third_category_id',$thirdSubCategories,$product->third_category_id, ['id'=>'loadFourthSubCategory','placeholder' => '--Select Third-sub-category--','class' => 'form-control','required'=>false]) !!}

                                           @if ($errors->has('third_category_id'))
                                               <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('third_category_id') }}</strong>
                                            </span>
                                           @endif
                                       </div>
                                   </div>

                                   <div style="display:none">
                                       <label for="example-text-input" class="col-form-label">Fourth Sub-Category</label>
                                       <div class="" id="fourthSubCategoryList">
                                           {!! Form::select('fourth_category_id',$fourthSubCategories,$product->fourth_category_id, ['id'=>'fourthSubCategory','placeholder' => '--Select fourth-sub-category--','class' => 'form-control','required'=>false]) !!}

                                           @if ($errors->has('fourth_category_id'))
                                               <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('fourth_category_id') }}</strong>
                                            </span>
                                           @endif
                                       </div>
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

    <script>
        $('#newAddQty').on('keyup',function () {

            var oldQty=$('#oldQty').val()
            var newAddQty=$(this).val()
            var totalQty=Number(oldQty)+Number(newAddQty)
            $('#totalQty').val(totalQty)

            console.log(newAddQty)

        })
    </script>


    <script>
        $('#loadThirdSubCategory').on('change',function () {

            var subCategoryId=$(this).val()

            $('#fourthSubCategory').empty()

            if(subCategoryId.length===0)
            {
                subCategoryId=0
                $('#thirdSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-third-sub-cat-by-sub-cat")}}/'+subCategoryId);

            }else {

                $('#thirdSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-third-sub-cat-by-sub-cat")}}/'+subCategoryId);
            }
        })

    </script>

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

        // Discount by Percentage ---------------------------
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
            var x = $('#totalImage').val(); //Initial field counter is 1
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
            var deleteImgIds=[];
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').parent().remove(); //Remove field html
                x--; //Decrement field counter
                var deleteId=$(this,'.remove_button').attr('id');
                deleteImgIds.push(deleteId)

                $('#deletedImg').val(deleteImgIds)

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
            var body = tinymce.get("description").getBody();
            var content = tinymce.trim(body.innerText || body.textContent);
            return content.length;
        };
        function ValidateCharacterLength() {
            var max = 10000;
            var count = CountCharacters();


            if (count > max) {
                alert("Maximum " + max + " characters allowed.")
                return false;
            }else if(count<=5) {
                alert("Minimum " + 50 + " characters required for product description")

                return false;
            }else{

//                var imgVal = $('#featurePhoto').val();
//                if(imgVal=='')
//                {
//                    $('#fimageError').show();
//                    return false;
//                }else{
//                    $('#fimageError').hide();
//                }
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

    {{--Date picker--}}
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
            $('#dateFrom').val();
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
            $('#dateTo').val();
            {{--@if($request->has('dateTo'))--}}
            {{--$('#dateTo').val("{{$request->dateTo}}");--}}
            {{--@else--}}
            {{--$('#dateTo').val('');--}}
            {{--@endif--}}
        });
    </script>


@endsection

<!-- Good -->





