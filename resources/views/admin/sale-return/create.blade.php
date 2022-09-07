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

            {!! Form::open(array('route' =>'sale-return.store','method'=>'POST','class'=>'form-horizontal form-payment','id'=>'orderEdit','files'=>false)) !!}

                <div class="row">
                    <?php $currency=$setting->currency;?>
                    <div class="col-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <section class="section-right">
                            <div class="checkout-content checkout-cart">
                                <fieldset id="address0">
                                <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>{{$title}}  Info
                                    </h2>
                                <div class="box-inner">


                                    <div class="row" style="background-color: #e3e3e3;margin-bottom: 10px;padding: 5px 0;">

                                        <div class="form-group col-md-4">
                                            <label for="example-text-input" class="control-label">Sale Return Note <sup class="text-danger">*</sup></label>
                                            <div id="loadInvoiceList">
                                                {!! Form::text('note',$value=old('note'), ['placeholder' => 'Return note','class' => 'form-control','required'=>false]) !!}
                                            </div>

                                            @if ($errors->has('note'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('note') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">Search by Order ID <sup class="text-danger">*</sup></label>
                                                {{Form::text('order_id',$value=old('order_id'), ['id'=>'orderId','placeholder' => 'Enter Order ID Here','class' => 'form-control','required'=>true,])}}

                                                <span id="orderIdError" style="display:none;color:red;">Order ID is required</span>
                                                @if ($errors->has('order_id'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('order_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="example-text-input" class="control-label">&nbsp;</label><br>
                                                <button type="button" class="btn btn-warning" id="loadOrderDetailToReturn"> Search Order Detail</button>
                                            </div>

                                    </div>


                                    <div id="returnInfo">
                                        <div class="table-responsive checkout-product" id="tableLoad">
                                            <h5>Purchase Return Product</h5>
                                            <table id="productList" class="table table-bordered table-hover" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th class="text-left name">Product Name</th>
                                                    <th class="text-center quantity">Order Qty</th>
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
                                                        <td class="text-right"><strong>Total Amount:</strong></td>
                                                        <td class="text-left"><input type="number" name="vendor_total_due" value="" id="vendorDue" class="form-control"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right"><strong>Return Amount :</strong></td>

                                                        <td class="text-left"><input type="number" name="return_amount" value="" id="totalReturnAmount" class="form-control"> </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> <!-- end row -->

                                    </div><!-- end returnInfo -->

                                </div>
                                </fieldset>
                            </div>

                            <br>


                            <div class="checkout-content confirm-section">
                                <div class="confirm-order">
                                    <button type="submit" class="btn btn-success button confirm-button">{{$title}}</button>
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

        $('#loadOrderDetailToReturn').on('click',function () {

            var orderId=$('#orderId').val()


            if(orderId.length===0){
                $('#orderIdError').css('display','block')
                return false
            }else {

            }

            $('#returnInfo').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
                .load('{{URL::to("admin/load-order-detail-by-orderid")}}'+'/'+orderId);
        })

    </script>



    {{--<script>--}}
        {{--document.forms['orderEdit'].elements['order_status'].value='{{$order->order_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_status'].value='{{$order->payment_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_gateway'].value='{{$order->payment_gateway}}';--}}
    {{--</script>--}}


@endsection