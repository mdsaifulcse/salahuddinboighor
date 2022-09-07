@extends('layouts.vmsapp')

@section('title')
    {{$title}}  | {{auth()->user()->name}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
    <style>
        .form-group{
            margin-bottom:8px !important;
        }
        .secondary-title{
            background-color: #f1f1f1;
            font-weight: bold;
            font-size: 14px;
            font-style: normal;
            color: #000;
            text-transform: uppercase;
            padding: 10px;
            margin: 0;
            border-radius: 5px 5px 0 0;
        }
        .box-inner{
            border: 1px solid #f1f1f1;
            border-top: 0px;
            border-radius: 0 0 5px 5px;
            padding: 20px;
            float: left;
            width: 100%;
        }

        .secondary-title i.fa{
            background-color: #FC0505;
            color: #fff;
            width: 45px;
            height: 45px;
            font-size: 20px;
            text-align: center;
            line-height: 45px;
            border-radius: 5px 0 0;
            margin-right: 10px;
        }
        .ui-id-1{
            z-index: 999999999 !important;
        }

    </style>
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} Edit
@endsection

@section('subheader-action')

    @can('product-purchase-list')
        <a href="{{ url('admin/product-purchases') }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back to {{$title}} List
        </a>
    @endcan
@endsection


@section('content')
    <!-- for taging -->
    <link rel="stylesheet" href="{{asset('/tagging/css/jqueryui1.12.1-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/jquery.tagit.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/tagit.ui-zendesk.css')}}">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            {!! Form::open(array('route' => ['product-purchases.update',$productPurchase->id],'method'=>'PUT','class'=>'form-horizontal form-payment','id'=>'orderEdit','files'=>false)) !!}

                <div class="row">
                    <div class="col-left col-lg-4 col-md-4 col-sm-6 col-xs-12">

                        <div class="checkout-content checkout-register">


                            <fieldset id="address">
                                <h2 class="secondary-title"><i class="fa fa-user"></i>Supplier and Purchase Info</h2>
                                <div class=" checkout-payment-form">
                                    <div class="box-inner">

                                        <div id="payment-new" style="display: block">
                                            <div class="form-group company-input">
                                                <label for="example-text-input" class="col-form-label">Select Supplier <sup class="text-danger">*</sup></label>
                                                {!! Form::select('vendor_id',$suppliers,$productPurchase->vendor_id, ['id'=>'kt_select2_2_1','placeholder' => '--Select Supplier --','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('vendor_id'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('vendor_id') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="control-label">Purchase Number</label>

                                                {{Form::text('purchase_no',$value=old('purchase_no',$productPurchase->purchase_no), ['class' => 'form-control','required'=>true,'readonly'=>true])}}

                                                @if ($errors->has('purchase_no'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('purchase_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">PO Reference <sup class="text-danger">*</sup></label>

                                                {{Form::text('po_ref',$value=old('po_ref',$productPurchase->po_ref), ['class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('po_ref'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('po_ref') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Purchase Date <sup class="text-danger">*</sup></label>

                                                {{Form::text('purchase_date',$value=old('purchase_date',$productPurchase->purchase_date), ['id'=>'purchaseDate','class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('purchase_date'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('purchase_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Due Date/Payment Date <sup class="text-danger">*</sup></label>

                                                {{Form::text('due_date',$value=old('due_date',$productPurchase->due_date), ['id'=>'dueDate','class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('due_date'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('due_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Payment Terms</label>
                                                <textarea name="payment_term" rows="3" class="form-control" placeholder="Payment Terms">{{old('payment_term',$productPurchase->payment_term)}}</textarea>

                                                @if ($errors->has('payment_term'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('payment_term') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Note</label>
                                                <textarea name="note" rows="3" class="form-control" placeholder="Note here">{{old('note',$productPurchase->note)}}</textarea>

                                                @if ($errors->has('note'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('note') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                    </div>

                    <?php $currency=$setting->currency;?>
                    <div class="col-right col-lg-8 col-md-8 col-sm-6 col-xs-12">
                        <section class="section-right">
                            <div class="checkout-content checkout-cart">
                                <fieldset id="address0">
                                <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>Purchase Product Info
                                    </h2>
                                <div class="box-inner">


                                    <div class="row" style="background-color: #e3e3e3;margin-bottom: 10px;padding: 5px 0;">

                                            <div class="form-group col-md-5">
                                                <label for="example-text-input" class="control-label">Product Search <sup class="text-danger">*</sup></label>

                                                {{Form::text('product_name',$value=old('product_name'), ['id'=>'productField','class' => 'form-control','required'=>false,'style'=>'display:none',])}}

                                                <ul id="productFieldUl"></ul>
                                                <span class="productError text-danger"> </span>
                                                @if ($errors->has('product_name'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('product_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Quantity <sup class="text-danger">*</sup></label>

                                                {{Form::text('qty',$value=old('qty',1), ['id'=>'productQty','class' => 'form-control','required'=>false])}}

                                                @if ($errors->has('qty'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('qty') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Purchase price <sup class="text-danger">*</sup></label>

                                                {{Form::text('cost_price',$value=old('cost_price'), ['id'=>'costPrice','class' => 'form-control','required'=>false])}}

                                                @if ($errors->has('cost_price'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('cost_price') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">&nbsp;</label><br>
                                                <button type="button" class="btn btn-warning" id="addProductToPurchase">+ Add Product</button>
                                                <br>
                                                <span id="productAddingError" style="display:none;color:red;">Name and Qty required</span>
                                            </div>


                                    </div>



                                    <div class="table-responsive checkout-product" id="tableLoad">
                                        <table id="productList" class="table table-bordered table-hover" style="width:100%;">
                                            <thead>
                                            <tr>
                                                <th class="text-left name">Product Name</th>
                                                <th class="text-center quantity">Qty</th>
                                                <th class="text-center price">Unit Price</th>
                                                <td class="text-left">Item Total</td>
                                                <td class="text-right">Action</td>
                                            </tr>
                                            </thead>

                                            <?php $currency=$setting->currency;?>
                                            <tbody>

                                            <?php $iteTotalAmount=0;?>
                                            <?php $subTotal=0;?>
                                            <?php $discount=0;?>
                                            <?php $netAmount=0;?>

                                            @forelse($tmpPurchaseProducts as $key=>$product)

                                                <tr>
                                                    <td>{{$product->product_name}}</td>
                                                    <td>{{$product->qty}}</td>
                                                    <td>{{$product->cost_price}}</td>

                                                    <td>{{$product->item_total}}</td>
                                                    <?php $subTotal+=$product->item_total?>
                                                    <td> <a href="javascript:;" class="btn btn-danger btn-xs" id="{{$product->id}}" onclick="removeProduct({{$product->id}})"><i class="fa fa-trash"></i>  </a> </td>
                                                </tr>

                                            @empty


                                            @endforelse



                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <td colspan="4" style="border:none;"></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Sub-Total:</strong></td>
                                                <td colspan="1" class="text-left">{{$currency.' '.$subTotal}}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Discount :</strong></td>

                                                <td colspan="1" class="text-left">{{$currency}} <input type="number" name="discount" value="{{$discount}}" min="0" required id="discount"> </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Net Total :</strong></td>

                                                <td colspan="1" class="text-left">{{$currency}} <input type="number" value="{{$subTotal-$discount}}" id="netTotal" /></td>

                                                <input type="hidden" value="{{$subTotal-$discount}}" id="netTotalHidden" />
                                            </tr>


                                            </tfoot>

                                        </table>
                                    </div>

                                </div>
                                </fieldset>
                            </div>

                            <br>


                            <div class="checkout-content confirm-section">
                                <div class="confirm-order">
                                    <button type="submit" class="btn btn-success button confirm-button">Update Purchase</button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div><!-- End Row -->
            {!! Form::close() !!}


        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

@section('script')

    <script>
        function removeProduct(id) {
            $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
                .empty().load('{{URL::to("admin/remove-product-from-purchase-list-update?")}}'+'id='+id);
        }
    </script>


    {{--<script>--}}
        {{--document.forms['orderEdit'].elements['order_status'].value='{{$order->order_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_status'].value='{{$order->payment_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_gateway'].value='{{$order->payment_gateway}}';--}}
    {{--</script>--}}

    <script>

        $('#addProductToPurchase').on('click',function () {

            var productName=$('.tagit-hidden-field').val()
            var productQty=$('#productQty').val()
            var costPrice=$('#costPrice').val()

            console.log(productName)

            $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
                .load('{{URL::to("admin/add-product-to-purchase-list?")}}'+'product_name='+encodeURI(productName)+'&qty='+productQty+'&cost_price='+costPrice+'&update='+1);
        })

    </script>




    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{asset('/tagging/js/jquery-1.12.1-ui.min.js')}}"></script>
    <script src="{{asset('/tagging/js/tag-it.min.js')}}"></script>


    <script>
        $(function(){
            $('#productFieldUl').tagit({
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: false,
                singleFieldNode: $('#productField'),
                allowSpaces: true,
                fieldName:"product_name",
                tagLimit:1,
                placeholderText:'Search Product',
                //autocomplete: {source:country_list},
                autocomplete: {
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{URL::to('/admin/search-products')}}",
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },

                },

            });
        });
    </script>


    <link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>

    <script>
        $(function() {
            $('#purchaseDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                //maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#purchaseDate').val("{{date('m/d/Y',strtotime($productPurchase->purchase_date))}}");
        });

        $(function() {
            $('#dueDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                //maxDate: new Date(),
                minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#dueDate').val("{{date('m/d/Y',strtotime($productPurchase->due_date))}}");

        });
    </script>





@endsection