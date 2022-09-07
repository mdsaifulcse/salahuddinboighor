@extends('layouts.vmsapp')

@section('title')
    Order Detail #{{$order->id}} | {{auth()->user()->name}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
    <style>
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

    </style>
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Order Detail #{{$order->id}}
@endsection

@section('subheader-action')

    {{--@can('product-create')--}}
        <a href="{{ url('admin/orders/'.$order->id) }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-eye"></i> View Order
        </a>
        <a href="{{ url('admin/orders') }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back to order history
        </a>
    {{--@endcan--}}
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            {!! Form::open(array('route' => ['admin.orders.update',$order->id],'method'=>'POST','class'=>'form-horizontal form-payment','id'=>'orderEdit','files'=>false)) !!}
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-left col-lg-4 col-md-4 col-sm-6 col-xs-12">

                        <div class="checkout-content checkout-register">


                            <fieldset id="address">
                                <h2 class="secondary-title"><i class="fa fa-map-marker"></i>Order Billing Address</h2>
                                <div class=" checkout-payment-form">
                                    <div class="box-inner">

                                        <div id="payment-new" style="display: block">
                                            <div class="form-group company-input">
                                                <input type="text" name="billing_name" value="{{old('billing_name',$order->billing_name)}}" placeholder="Billing Name *" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="billing_email" value="{{old('billing_email',$order->billing_email)}}" placeholder="Billing Email"  class="form-control">
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="billing_phone" value="{{old('billing_phone',$order->billing_phone)}}" placeholder="Billing Phone *" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <textarea name="billing_street_address" rows="3" class="form-control" placeholder="Billing Address *" required>{{old('billing_street_address',$order->billing_street_address)}}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <br>
                            <fieldset id="shipping-address" style="display: block;">
                                <h2 class="secondary-title"><i class="fa fa-map-marker"></i>Order Shipping Address</h2>
                                <div class=" checkout-shipping-form">
                                    <div class="box-inner">

                                        <div id="shipping-new" style="display: block">
                                            <div class="form-group company-input">
                                                <input type="text" name="shipping_name" value="{{old('shipping_name',is_null($order->shipping_name)?$order->billing_name:$order->shipping_name)}}" placeholder=" Name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="shipping_email" value="{{old('shipping_email',is_null($order->shipping_email)?$order->billing_email:$order->shipping_email)}}" placeholder=" Email"  class="form-control">
                                            </div>
                                            <div class="form-group ">
                                                <input type="text" name="shipping_phone" value="{{old('shipping_phone',is_null($order->shipping_phone)?$order->billing_phone:$order->shipping_phone)}}" placeholder=" Phone" class="form-control">
                                            </div>
                                            <div class="form-group ">
                                                <textarea name="shipping_street_address" rows="3" class="form-control" placeholder="Shipping Address">{{old('shipping_street_address',is_null($order->shipping_street_address)?$order->billing_street_address:$order->shipping_street_address)}}</textarea>

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
                                <h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>Order Items </h2>
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
                                                        {{$cartProduct->qty}}
                                                    </td>
                                                    <td class="text-right price">{{$currency.$cartProduct->price}}</td>

                                                    <?php $itemAmount=$cartProduct->qty*$cartProduct->price?>

                                                    <td class="text-right">{{$currency.$itemAmount}}</td>

                                                    <?php
                                                    if ($cartProduct->product->productVatTax)
                                                    {
                                                        $vatTaxPercent=$cartProduct->product->productVatTax->vat_tax_percent;
                                                        $vatTaxAmount=($itemAmount*$vatTaxPercent)/100;
                                                    }
                                                    ?>

                                                    <td class="text-right">
                                                        {{$currency.$vatTaxAmount}} ({{$vatTaxPercent.'%'}})
                                                    </td>

                                                    <td class="text-right">{{$currency}}{{$itemAmount+$vatTaxAmount}}</td>

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
                                                <td colspan="6" class="text-right"><strong>Sub-Total:</strong></td>
                                                <td colspan="1" class="text-left">{{$currency.$subTotal}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right"><strong>VAT | TAX :</strong></td>

                                                <td colspan="1" class="text-left">{{$currency}}{{$totalVatTaxAmount}}</td>
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
                                                <td colspan="1" class="text-left">{{$currency}}{{$order->shipping_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                                <td colspan="1" class="text-left">{{$currency}}{{$subTotal+$totalVatTaxAmount+$order->shipping_cost}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                                </fieldset>
                            </div>

                            <section class="section-left">
                                <div class="ship-payment">
                                    <div class="checkout-content checkout-shipping-methods">
                                        <fieldset id="address0">
                                            <h2 class="secondary-title"><i class="fa fa-cogs"></i>Manage Order</h2>

                                            <div class="box-inner">
                                                <div id="payment-new" style="display: block">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-shopping-cart" aria-hidden="true"></i>.Order status <sup class="text-danger">*</sup></label>
                                                        <select class="form-control" name="order_status">
                                                            <option value="{{\App\Models\Order::CANCELLED}}">{{\App\Models\Order::CANCELLED}} </option>
                                                            <option value="{{\App\Models\Order::PENDING}}">{{\App\Models\Order::PENDING}} </option>
                                                            <option value="{{\App\Models\Order::RECEIVED}}">{{\App\Models\Order::RECEIVED}} </option>
                                                            <option value="{{\App\Models\Order::SHIPPING}}">{{\App\Models\Order::SHIPPING}} </option>
                                                            <option value="{{\App\Models\Order::COMPLETE}}">{{\App\Models\Order::COMPLETE}} </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{$currency}}.Payment status <sup class="text-danger">*</sup></label>
                                                        <select class="form-control" name="payment_status">
                                                            <option value="{{\App\Models\Order::UNPAID}}">{{\App\Models\Order::UNPAID}} </option>
                                                            <option value="{{\App\Models\Order::PAID}}">{{\App\Models\Order::PAID}} </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><i class="fa fa-credit-card" aria-hidden="true"></i>.Payment Method <sup class="text-danger">*</sup></label>
                                                        <select class="form-control" name="payment_gateway" id="paymentGateway">
                                                            <option value="{{\App\Models\Order::PAYMENT_GATEWAY}}">{{\App\Models\Order::PAYMENT_GATEWAY}} </option>
                                                            <option value="{{\App\Models\Order::BKASH}}">{{\App\Models\Order::BKASH}} </option>
                                                            <option value="{{\App\Models\Order::ROCKET}}">{{\App\Models\Order::ROCKET}} </option>
                                                            <option value="{{\App\Models\Order::BANK}}">{{\App\Models\Order::BANK}} </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" id="transactionId" style="display:none;">
                                                        <label>Transaction ID</label>
                                                        <input type="text" name="transaction_id" value="{{old('transaction_id',$order->transaction_id)}}" placeholder="Payment Transaction ID" class="form-control">
                                                    </div>

                                                    <div class="form-group" id="" style="display:block;">
                                                        @if($order->user->profile->discount_percent>0)
                                                        <label>Discount Amount (Default Discount Percent % {{$order->user->profile->discount_percent}})</label>
                                                        @else
                                                        <label>Discount Amount</label>
                                                        @endif
                                                        <input type="text" name="coupon_discount" value="{{old('coupon_discount',$discountByUserDiscountPercent)}}" placeholder="Discount" class="form-control">
                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>

                                </div>
                            </section>
                            <br>


                            <div class="checkout-content confirm-section">
                                <div class="confirm-order">
                                    <button type="submit" class="btn btn-success button confirm-button">Save Change</button>
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
        document.forms['orderEdit'].elements['order_status'].value='{{$order->order_status}}';
        document.forms['orderEdit'].elements['payment_status'].value='{{$order->payment_status}}';
        document.forms['orderEdit'].elements['payment_gateway'].value='{{$order->payment_gateway}}';
    </script>

    <script>
        
        $('#paymentGateway').on('change',function () {
            var paymentGateway=$(this).val()

            if(paymentGateway=="{{\App\Models\Order::BKASH}}" || paymentGateway=="{{\App\Models\Order::ROCKET}}")
            {
                $('#transactionId').css('display','block')
            }else {
                $('#transactionId').css('display','none')
            }
        })
    </script>


@endsection