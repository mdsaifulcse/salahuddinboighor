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


@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')

    {{--@can('purchase-return-list')--}}
        <a href="{{ url('admin/purchase-return') }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back to {{$title}} List
        </a>
    {{--@endcan--}}
@endsection


@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            {!! Form::open(array('route' =>'purchase-return.store','method'=>'POST','class'=>'form-horizontal form-payment','id'=>'orderEdit','files'=>false)) !!}

                <div class="row">
                    <?php $currency=$setting->currency;?>
                    <div class="col-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <section class="section-right">
                            <div class="checkout-content checkout-cart">
                                <fieldset id="address0">
                                <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>{{$title}} Info
                                    </h2>
                                <div class="box-inner">


                                    <div class="row" style="background-color: #e3e3e3;margin-bottom: 10px;padding: 5px 0;">

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">Select Supplier <sup class="text-danger">*</sup></label>
                                                {!! Form::select('vendor_id',$suppliers,[], ['id'=>'kt_select2_2_1','placeholder' => '--Select Supplier --','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('vendor_id'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('vendor_id') }}</strong>
                                                    </span>
                                                @endif

                                            </div>


                                            <div class="form-group col-md-2">
                                                <label for="example-text-input" class="control-label">Invoice <sup class="text-danger">*</sup></label>
                                                <div id="loadInvoiceList">
                                                    {!! Form::select('product_purchase_id',[],[], ['id'=>'purchaseId','placeholder' => '--Select Invoice --','class' => 'form-control','required'=>true]) !!}

                                                </div>

                                                @if ($errors->has('product_purchase_id'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('product_purchase_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="example-text-input" class="control-label">Note <sup class="text-danger">*</sup></label>
                                                <div id="loadInvoiceList">
                                                    {!! Form::text('note',$value=old('note'), ['placeholder' => 'Return note','class' => 'form-control','required'=>false]) !!}
                                                </div>

                                                @if ($errors->has('note'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('note') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                    </div>



                                    <div id="returnInfo">
                                        <div class="table-responsive checkout-product" id="tableLoad">
                                            <h5>Purchase Return Product</h5>
                                            <table id="productList" class="table table-bordered table-hover" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th class="text-left name">Product Name</th>
                                                    <th class="text-center quantity">Invoice Qty</th>
                                                    <th class="text-center quantity">Balance Qty</th>
                                                    <th class="text-center quantity">Return Qty</th>
                                                    <th class="text-center price">Unit Price</th>
                                                    <td class="text-left">Total Price </td>
                                                    <td class="text-left">Return Price </td>
                                                </tr>
                                                </thead>

                                                <?php $currency=$setting->currency;?>
                                                <tbody>

                                                <?php $iteTotalAmount=0;?>
                                                <?php $subTotal=0;?>
                                                <?php $discount=0;?>
                                                <?php $netAmount=0;?>



                                                </tbody>

                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 payment-calculation-blank"></div>

                                            <div class="col-md-6 col-lg-6 payment-calculation">
                                                <table class="table table-bordered table-hover">
                                                    <tbody>

                                                    <tr>
                                                        <td class="text-right"><strong>Supplier Total Due:</strong></td>
                                                        <td class="text-left"><input type="number" name="vendor_total_due" value="" id="vendorDue" class="form-control"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right"><strong>Return Amount :</strong></td>

                                                        <td class="text-left"><input type="number" name="return_amount" value="" id="totalReturnAmount" class="form-control"> </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right"><strong >Last Due Amount :</strong></td>

                                                        <td class="text-left"><input type="number" name="due_after_return" value="" id="lastDueAmount" min="0" max="99999999" class="form-control" readonly> </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div><!-- end returnInfo -->

                                </div>
                                </fieldset>
                            </div>

                            <br>


                            <div class="checkout-content confirm-section">
                                <div class="confirm-order">
                                    <button type="submit" class="btn btn-success button confirm-button">Purchase Return</button>
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

        $('#kt_select2_2_1').on('change',function () {

            var vendorId=$(this).val()

            $('#loadInvoiceList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
                .load('{{URL::to("load-purchase-number-by-vendor")}}'+'/'+vendorId);

            $('#vendorDue').get('{{URL::to("vendor-remaining-due-calculation")}}'+'/'+vendorId);

        })

    </script>


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
            $('#purchaseDate').val();
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
            $('#dueDate').val();

        });
    </script>





@endsection