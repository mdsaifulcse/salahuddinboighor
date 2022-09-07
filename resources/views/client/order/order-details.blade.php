@extends('client.layouts.master')

@section('head')
    <title> Order Details #{{$order->order_id}} | {{auth()->user()->name}} </title>
    <meta name="description" content="Register New User , Create Account, Sign Up " />
    <meta name="keywords" content="Register New User , Create Account, Sign Up" />
    @endsection


@section('style')

    @endsection


@section('content')

    <div id="account-account" class="container">

        <ul class="breadcrumb">
            <li><a href="{{URL::to('/account/account')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/account/account')}}">Recent Order</a></li>
            <li><a href="javascript:;">Order Details</a></li>
        </ul>
        <div class="header-lined">
            <h1> </h1>
        </div>

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>
            Success: {{Session::get('success')}}
        </div>
        @endif

        <div class="row">

            <div class="col-md-9 col-lg-9 pull-md-right pull-lg-right">

                <?php $currency=$setting->currency;?>

                <div class="billing-head">
                    <div class="row">

                        <div class="col-md-4 col-lg-4 order-status">
                            <h3>Order ID: #{{$order->order_id}}</h3>
                            <h4><strong>Order Status: </strong>
                                @if($order->order_status==\App\Models\Order::COMPLETE)
                                    <span class="text-success">{{$order->order_status}} <i class="fa fa-check"></i></span>
                                @else
                                    <span class="text-warning">{{$order->order_status}}</span>
                                @endif
                            </h4>
                            <h4><strong>Payment Status: </strong>
                                @if($order->payment_status==\App\Models\Order::PAID)
                                    <span class="text-success">{{$order->payment_status}} <i class="fa fa-check"></i></span>
                                @else
                                    <span class="text-warning">{{$order->payment_status}}</span>
                                @endif
                            </h4>

                            <h4>
                                <strong>Payment Method: </strong> <span class="text-default">{{$order->payment_gateway}}</span>
                            </h4>
                            <h4>
                                <strong>Shipping Mehtod: </strong>
                                <span class="text-default">
                            @if(!empty($order->shippingMethod))
                                        {{$order->shippingMethod->title}}
                                    @else
                                        No Shipping
                                    @endif
                            </span>
                            </h4>

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

                                <b> Name</b>: {{$order->shipping_name}}<br>
                                <b>Mobile</b>: {{$order->shipping_phone}} <br>
                                <b>Address</b>: {{nl2br($order->shipping_street_address)}}<br>
                            </address>

                        </div>

                    </div>
                </div>

                <div class="header-lined">
                    <h1> </h1>
                </div>


                <div class="header-lined">
                    <h1>Billing Items, Order ID: #{{$order->order_id}} </h1>
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
                                                <a href="{{URL::to('products/details/'.$cartItem->product->id.'/'.$cartItem->product->name)}}" target="_blank">
                                                    <img src="{{asset($cartItem->product->productImages[0]->small)}}" alt="{{$cartItem->product->name}}" title="{{$cartItem->product->name}}" class="img-thumbnail"></a>
                                                <a href="{{URL::to('products/details/'.$cartItem->product->id.'/'.$cartItem->product->name)}}" target="_blank">{{$cartItem->product->name}}</a>

                                            </td>
                                            <td class="text-left quantity">{{$cartItem->qty}}</td>

                                            <td class="text-right price">{{$currency.$cartItem->price}}</td>

                                            <?php $itemAmount=$cartItem->qty*$cartItem->price?>

                                            <td class="text-right">{{$currency.$itemAmount}}</td>

                                            <?php
                                            if ($cartItem->product->productVatTax)
                                            {
                                                $vatTaxPercent=$cartItem->product->productVatTax->vat_tax_percent;
                                                $vatTaxAmount=($itemAmount*$vatTaxPercent)/100;
                                            }
                                            ?>

                                            <td class="text-right">
                                                {{$currency.$vatTaxAmount}} ({{$vatTaxPercent.'%'}})
                                            </td>

                                            <td class="text-right">{{$currency}}{{$itemAmount+$vatTaxAmount}}</td>

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

                                    <tr style="color:#03665c;">
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



            <div class="col-md-3 col-lg-3 pull-md-left pull-lg-left ">

                @include('client.layouts.partials.user-account-aside')

            </div>

        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {


            $('[data-toggle="collapse"]').click(function() {
                $(this).toggleClass( "in" );
                if ($(this).hasClass("collapsed")) {

                    $(this).empty().addClass("fa fa-chevron-up panel-minimise pull-right ");
                } else {
                    $(this).empty().addClass("fa fa-chevron-down panel-minimise pull-right");
                }
            });


// document ready
        });
    </script>

    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>
    @endsection

