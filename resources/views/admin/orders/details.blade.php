@extends('layouts.vmsapp')

@section('title')
    Order Detail #{{$order->order_id}} | {{auth()->user()->name}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
    <style>
        .billing-head{
            padding-bottom:20px;
            border-bottom: 1px solid #414141;
        }
        /*.billing-to,.shipping-to{*/
            /*padding-bottom:10%;*/
        /*}*/

    </style>
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Order Detail #{{$order->order_id}}
@endsection

@section('subheader-action')
    <a href="javascript:void(0)" class="btn btn-danger pull-right" title="Click to create new product" id="doPrint">
        <i class="la la-print "></i> Print
    </a>
    {{--@can('product-create')--}}
        <a href="{{ url()->previous() }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back
        </a>
    {{--@endcan--}}
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            <!--Begin::Row-->

            <?php $currency=$setting->currency;?>

            <div class="billing-head">
                <div class="row">

                    <div class="col-md-4 col-lg-4 order-status">
                        <h3>Order ID: #{{$order->order_id}}</h3>
                        <h6><strong>Order Status: </strong>
                            @if($order->order_status==\App\Models\Order::COMPLETE)
                                <span class="text-success">{{$order->order_status}} <i class="fa fa-check"></i></span>
                            @else
                                <span class="text-warning">{{$order->order_status}}</span>
                            @endif
                        </h6>
                        <h6><strong>Payment Status: </strong>
                            @if($order->payment_status==\App\Models\Order::PAID)
                                <span class="text-success">{{$order->payment_status}} <i class="fa fa-check"></i></span>
                            @else
                                <span class="text-warning">{{$order->payment_status}}</span>
                            @endif
                        </h6>

                        <h6>
                            <strong>Payment Method: </strong> <span class="text-default">{{$order->payment_gateway}}</span>
                        </h6>
                        <h6>
                            <strong>Shipping Mehtod: </strong>
                            <span class="text-default">
                            @if(!empty($order->shippingMethod))
                                    {{$order->shippingMethod->title}}
                                @else
                                No Shipping
                                @endif
                            </span>
                        </h6>

                    </div>

                    <div class="col-md-4 col-lg-4 billing-to">
                        <h3>Billing To</h3>

                        <address class="small-text">
                            <b> Company:</b> @if($order->user->profile)
                                {{$order->user->profile->company_name}} <br>
                            @endif

                            <b> Name</b>: {{$order->billing_name}}<br>
                            <b>Mobile</b>: {{$order->billing_phone}} <br>
                            <b>Address</b>: {{nl2br($order->billing_street_address)}}<br>
                        </address>

                    </div>
                    <div class="col-md-4 col-lg-4 shipping-to">
                        <h3>Shipping To</h3>

                        <address class="small-text">
                           <b> Company:</b> @if($order->user->profile)
                                {{$order->user->profile->company_name}} <br>
                            @endif

                           <b> Name</b>: {{is_null($order->shipping_name)?$order->billing_name:$order->shipping_name}}<br>
                            <b>Mobile</b>: {{is_null($order->shipping_phone)?$order->billing_phone:$order->shipping_phone}} <br>
                            <b>Address</b>: {{nl2br(is_null($order->shipping_street_address)?$order->billing_street_address:$order->shipping_street_address)}}<br>
                        </address>

                    </div>

                </div>
            </div>

            <div class="header-lined">
                <h1> </h1>
            </div>


            <div class="header-lined">
                <h3>Billing Items, Order ID: #{{$order->id}} </h3>
                <div class="checkout-content checkout-cart">
                    <div class="box-inner">
                        <div class="table-responsive checkout-product" id="tableLoad">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="text-left name" colspan="2">Product Name</th>
                                    <th class="text-center quantity">Quantity</th>
                                    <th class="text-center price">Unit Price</th>
                                    <td class="text-right">Item Total</td>
                                    <td class="text-right">Vat | Tax</td>
                                    <th class="text-right total">Total</th>
                                </tr>
                                </thead>


                                <tbody>

                                <?php $itemAmount=0;?>
                                <?php $vatTaxPercent=0;?>
                                <?php $vatTaxAmount=0;?>

                                @forelse($cartItems as $key=>$cartItem)
                                    <tr>

                                        <td class="text-left name" colspan="2">

                                                <img src="{{asset($cartItem->product->productImages[0]->small)}}" alt="{{$cartItem->product->name}}" title="{{$cartItem->product->name}}" class="img-thumbnail">
                                            {{$cartItem->product->name}}

                                        </td>
                                        <td class="text-left quantity">{{$cartItem->qty}}</td>

                                        <td class="text-right price">{{$currency}} {{$cartItem->price}}</td>

                                        <?php $itemAmount=$cartItem->qty*$cartItem->price?>

                                        <td class="text-right">{{$currency}} {{$itemAmount}}</td>

                                        <?php
                                        if ($cartItem->product->productVatTax)
                                        {
                                            $vatTaxPercent=$cartItem->product->productVatTax->vat_tax_percent;
                                            $vatTaxAmount=($itemAmount*$vatTaxPercent)/100;
                                        }
                                        ?>

                                        <td class="text-right">
                                            {{$currency}} {{$vatTaxAmount}} ({{$vatTaxPercent.'%'}})
                                        </td>

                                        <td class="text-right">{{$currency}} {{$itemAmount+$vatTaxAmount}}</td>

                                    </tr>
                                @empty

                                @endforelse

                                <tr>
                                    <td colspan="7" style="border:none;"></td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Item Sub-Total:</strong></td>
                                    <td colspan="1" class="text-left"><strong>{{$currency}} {{$order->subtotal}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>VAT | TAX :</strong></td>

                                    <td colspan="1" class="text-left"><strong>{{$currency}} {{$order->vat_tax_amount}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">
                                        <strong>
                                            @if(!empty($order->shippingMethod))
                                                {{$order->shippingMethod->title}} Cost :
                                            @else
                                                Shipping Cost :
                                            @endif
                                        </strong>
                                    </td>
                                    <td colspan="1" class="text-left"><strong>{{$currency}} {{$order->shipping_cost}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                    <td colspan="1" class="text-left"><strong>{{$currency}} {{$order->total}}</strong></td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="text-right"><strong>Discount:</strong></td>
                                    <td colspan="1" class="text-left"><strong> - {{$currency}} {{$order->coupon_discount}}</strong></td>
                                </tr>

                                <tr style="color:#03665c;">
                                    <td colspan="6" class="text-right"><strong>Total Payable:</strong></td>
                                    <td colspan="1" class="text-left"><strong>{{$currency}} {{$order->net_total}}</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

@section('script')

    <script src="{{asset('/')}}/print/jQuery.print.js" type="text/javascript"></script>

    <script>

        $(function(){
            $('#doPrint').on('click', function() {

                //Print ele2 with default options
                $.print("#kt_content");
            });
        });


    </script>

@endsection