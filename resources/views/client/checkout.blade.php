@extends('client.layouts.master')

@section('head')
    <title> Checkout | Confirm Order </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
    @endsection


@section('style')
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_onepagecheckout/css/so_onepagecheckout.css">

    @endsection

@section('content')

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/cart-products')}}">Shopping Cart</a></li>
            <li><a href="{{URL::to('/checkout/checkout')}}">Checkout</a></li>
        </ul>
        <div class="row">

            <div id="content" class="col-sm-12">

                <h1>Checkout</h1>
                {!! Form::open(array('route' => 'orders.confirm','method'=>'POST','class'=>'form-horizontal form-payment','files'=>false)) !!}
                <div class="so-onepagecheckout layout1 ">
                    <div class="col-left col-lg-4 col-md-4 col-sm-6 col-xs-12">

                        <div class="checkout-content checkout-register">

                            <?php
                                $userAddressCount=count($user->relUserAddress);
                            ?>

                            <fieldset id="address">
                                <h2 class="secondary-title"><i class="fa fa-map-marker"></i>Your Billing Address</h2>
                                <div class=" checkout-payment-form">
                                    <div class="box-inner">

                                            <div id="payment-new" style="display: block">
                                                <input type="hidden" name="address_id" value="other_address" class="user-address">
                                                @if($userAddressCount>0)
                                                    <div class="form-group company-input" style="margin-left:15px;">
                                                        @foreach($user->relUserAddress as $address)
                                                        <label class="radio-inline">
                                                            <input type="radio" name="address_id" class="user-address" value="{{$address->id}}">{{$address->address1}} ({{$address->type}})
                                                        </label>
                                                            @endforeach
                                                            <label class="radio-inline">
                                                                <input type="radio" name="address_id" value="other_address" class="user-address">Other Address
                                                            </label>
                                                    </div>
                                                    <hr>

                                                    @endif
                                                
                                                
                                                <div style="display: {{$userAddressCount>0?'none':'block'}};" id="billingAddress">
                                                   Billing Address Type : &nbsp;
                                                    <div class="form-group company-input" style="margin-left:15px;">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="billing_type" checked>Home
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="billing_type">Office
                                                        </label>
                                                    </div>
                                                    <div class="form-group company-input">
                                                        <input type="text" name="billing_name" value="{{old('billing_name',auth()->user()->name)}}" placeholder="Billing Name *" class="form-control billing" >
                                                        @if ($errors->has('billing_name'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_name') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="billing_email" value="{{old('billing_email',auth()->user()->email)}}" placeholder="Billing Email"  class="form-control billing">
                                                        @if ($errors->has('billing_email'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_email') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <input type="text" name="billing_phone" value="{{old('billing_phone',auth()->user()->mobile)}}" placeholder="Billing Phone *" class="form-control billing" >
                                                        @if ($errors->has('billing_phone'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_phone') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <input type="text" name="billing_city" value="{{old('billing_city')}}" placeholder="City *" class="form-control billing" >
                                                        @if ($errors->has('billing_city'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_city') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <input type="text" name="billing_post" value="{{old('billing_post')}}" placeholder="Post *" class="form-control billing" >
                                                        @if ($errors->has('billing_post'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_post') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group ">
                                                        <input type="text" name="billing_post_code" value="{{old('billing_post_code')}}" placeholder="Post Code *" class="form-control billing" >
                                                        @if ($errors->has('billing_post_code'))
                                                            <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_post_code') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group ">
                                                        @if($user->profile)
                                                            <textarea name="billing_street_address" rows="3" class="form-control billing" placeholder="Billing Address *" >{{old('billing_street_address',$user->profile->address)}}</textarea>
                                                        @else
                                                            <textarea name="billing_street_address" rows="3" class="form-control billing" placeholder="Billing Address *" >{{old('billing_street_address')}}</textarea>
                                                        @endif

                                                            @if ($errors->has('billing_street_address'))
                                                                <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('billing_street_address') }}</strong>
                                                            </span>
                                                            @endif
                                                    </div>
                                                </div>

                                            </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="shipping_same_as_billing" id="shipping_info" value="1  ">
                                    My billing and shipping addresses are the same.
                                </label>
                            </div>
                            <fieldset id="shipping-address" style="display: block;">
                                <h2 class="secondary-title"><i class="fa fa-map-marker"></i>Your Shipping Address</h2>
                                <div class=" checkout-shipping-form">
                                    <div class="box-inner">

                                        <div id="shipping-new" style="display: block">
                                           Shipping Address Type : &nbsp;
                                            <div class="form-group company-input" style="margin-left:15px;">
                                                <label class="radio-inline">
                                                    <input type="radio" name="shipping_type" checked>Home
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="shipping_type">Office
                                                </label>
                                            </div>
                                            <div class="form-group company-input">
                                                <input type="text" name="shipping_name" value="{{old('shipping_name')}}" placeholder="Name *" required class="form-control shipping">
                                                @if ($errors->has('shipping_name'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="shipping_email" value="{{old('shipping_email')}}" placeholder="Email *" required  class="form-control shipping">
                                                @if ($errors->has('shipping_email'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="shipping_phone" value="{{old('shipping_phone')}}" placeholder="Phone *" required class="form-control shipping">
                                                @if ($errors->has('shipping_phone'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_phone') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="shipping_city" value="{{old('shipping_city')}}" placeholder="City *" required class="form-control shipping">
                                                @if ($errors->has('shipping_city'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_city') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="shipping_post" value="{{old('shipping_post')}}" placeholder="Post *" required class="form-control shipping">
                                                @if ($errors->has('shipping_post'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_post') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="shipping_post_code" value="{{old('shipping_post_code')}}" placeholder="Post Code *" class="form-control">
                                                @if ($errors->has('shipping_post_code'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping_post_code') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group ">
                                                <textarea name="shipping_street_address" rows="3" class="form-control" placeholder="Shipping Address *">{{old('shipping_street_address')}}</textarea>
                                                @if ($errors->has('billing_post_code'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('billing_post_code') }}</strong>
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
                        <section class="section-left">
                            <div class="ship-payment">
                                <div class="checkout-content checkout-shipping-methods">
                                    <h2 class="secondary-title"><i class="fa fa-location-arrow"></i>Shipping Method</h2>
                                    <div class="box-inner">
                                        <p><strong>Flat Rate</strong></p>
                                        <div class="radio">
                                            {{--@if($shippingMethod->is_default==\App\Models\ShippingMethod::YES) checked="checked" @endif--}}

                                            <label>
                                                <input type="radio" name="shipping_method_id" value="0" id="shipping_0" class="shipping" checked="checked" onclick="addShippingCost(0)">
                                                No Shipping - {{$currency.' 0'}}
                                            </label>
                                            @forelse($shippingMethods as $shippingMethod)
                                            <label>
                                                <input type="radio" name="shipping_method_id" value="{{$shippingMethod->id}}" id="shipping_{{$shippingMethod->id}}" class="shipping" onclick="addShippingCost({{$shippingMethod->id}})">
                                                {{$shippingMethod->title}} - {{$currency}} {{$shippingMethod->cost}}
                                            </label>
                                                @empty

                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                        <section class="section-right">


                            <div class="checkout-content checkout-cart">
                                <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>Shopping Cart </h2>
                                <div class="box-inner">
                                    <div class="table-responsive checkout-product" id="tableLoad">
                                        <table class="table table-bordered table-hover">
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
                                            <?php $subTotal=0;?>
                                            <?php $totalAmount=0;?>
                                            <?php $itemAmount=0;?>
                                            <?php $vatTaxPercent=0;?>
                                            <?php $vatTaxAmount=0;?>
                                            <?php $totalVatTaxAmount=0;?>

                                            @forelse($cartProducts as $cartProduct)
                                            <tr>

                                                <td class="text-left name" colspan="2">
                                                    <a href="{{URL::to('products/details/'.$cartProduct->product->id.'/'.$cartProduct->product->name)}}" target="_blank">
                                                        <img src="{{asset($cartProduct->product->productImages[0]->small)}}" alt="{{$cartProduct->product->name}}" title="{{$cartProduct->product->name}}" class="img-thumbnail"></a>
                                                    <a href="{{URL::to('products/details/'.$cartProduct->product->id.'/'.$cartProduct->product->name)}}" target="_blank">{{$cartProduct->product->name}}</a>

                                                </td>
                                                <td class="text-left quantity">
                                                    <div class="input-group">
                                                        <input type="number" name="qty" value="{{$cartProduct->qty}}" id="qty_{{$cartProduct->id}}" size="1" min="1" max="9999999" class="form-control">
                                                        <span class="input-group-btn">

                                                            <span data-toggle="tooltip" title="" data-product-key="{{$cartProduct->id}}" class="btn-delete" data-original-title="Remove" onclick="productDelete({{$cartProduct->id}})"><i class="fa fa-trash-o"></i></span>


                                                            <span onclick="productUpdate({{$cartProduct->id}})" data-toggle="tooltip" title="" data-product-key="{{$cartProduct->id}}" class="btn-update" data-original-title="Update"><i class="fa fa-refresh"></i></span>

                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-right price">{{$currency}} {{$cartProduct->price}}</td>

                                                <?php $itemAmount=$cartProduct->qty*$cartProduct->price?>

                                                <td class="text-right">{{$currency}} {{$itemAmount}}</td>

                                                <?php
                                                if ($cartProduct->product->productVatTax)
                                                {
                                                    $vatTaxPercent=$cartProduct->product->productVatTax->vat_tax_percent;
                                                    $vatTaxAmount=($itemAmount*$vatTaxPercent)/100;
                                                }
                                                ?>

                                                <td class="text-right">
                                                   {{$currency}} {{$vatTaxAmount}} ({{$vatTaxPercent.'%'}})
                                                </td>

                                                <td class="text-right">{{$currency}} {{$itemAmount+$vatTaxAmount}}</td>

                                            </tr>
                                            <?php $subTotal+=$itemAmount;?>
                                            <?php $totalVatTaxAmount+=$vatTaxAmount;?>
                                            @empty

                                            @endforelse

                                            <tr>
                                                <td colspan="7" style="border:none;"></td>
                                            </tr>

                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="text-right">Sub-Total:</td>
                                                    <td colspan="1" class="text-left">{{$currency}} {{$subTotal}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-right"><strong>VAT | TAX :</strong></td>

                                                    <td colspan="1" class="text-left">{{$currency}} {{$totalVatTaxAmount}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-right">Shipping Cost:</td>
                                                    <td colspan="1" class="text-left">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-right">Total:</td>
                                                    <td colspan="1" class="text-left">{{$currency}} {{$subTotal+$totalVatTaxAmount}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>


                            <div class="checkout-content confirm-section">
                                <div>
                                    <h2 class="secondary-title"><i class="fa fa-comment"></i>Add Comments About Your Order</h2>
                                    <label>
                                        <textarea name="note" rows="4" class="form-control"  placeholder="Your Order Note Here"></textarea>
                                    </label>
                                </div>

                                {{--<div class="checkbox check-newsletter">--}}
                                    {{--<label for="newsletter">--}}
                                        {{--<input type="checkbox" name="newsletter" value="1" id="newsletter">--}}
                                        {{--I wish to subscribe to the Your Store - Layout 2 newsletter.--}}
                                    {{--</label>--}}
                                {{--</div>--}}


                                <div class="confirm-order">
                                    <button type="submit" class="btn btn-success button confirm-button">Confirm Order</button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
        </div>

    @endsection

@section('script')

    <script>
        $('.user-address').on('click',function () {

            if($(this).val()=='other_address'){
                $('#billingAddress').css('display','block')
                $('.billing').attr('required',true)
            }else {
                $('#billingAddress').css('display','none')
                $('.billing').removeAttr('required',false)
            }
        })
    </script>

    <script>
        $('#shipping_info').on('click',function () {

            if($(this).prop("checked") == true){
                $('#shipping-address').css('display','none')
                $('.shipping').removeAttr('required',false)
            }else {
                $('#shipping-address').css('display','block')
                $('.shipping').attr('required',true)
            }
        })
    </script>

    <script>

        function addShippingCost(shippingId) {

            $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("checkout/add-shipping-cost")}}/'+shippingId);

        }

        function productUpdate(id) {

            var shippingId=0;
            $('.shipping').each(function () {
                if (this.checked){
                    shippingId = $(this).val() ;
                }
            });

            var qty=$('#qty_'+id).val()

            $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("checkout/product-update")}}/'+id+'/'+qty+'/'+shippingId);

        }



        function productDelete(id) {
            var shippingId=0;
            $('.shipping').each(function () {
                if (this.checked){
                    shippingId = $(this).val() ;
                }
            });
            $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("checkout/product-delete")}}/'+id+'/'+shippingId);
        }

    </script>

    @endsection

