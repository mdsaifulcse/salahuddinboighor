@extends('client.layouts.master')

@section('head')
    <title> Your Shopping Product' (s) </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
    @endsection


@section('style')

    @endsection

@section('content')

    <div id="checkout-cart" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/cart-products')}}">Shopping Cart</a></li>
        </ul>
        <?php $currency=$setting->currency;?>
        <div class="row">
            <div id="content" class="col-sm-12">
                <h1>Your shopping Item(s)</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-center">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-left">Quantity</td>
                                <td class="text-right">Unit Price</td>
                                <td class="text-right">Item Total</td>
                                <td class="text-right">Vat | Tax</td>
                                <td class="text-right">Total</td>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $totalAmount=0;?>
                        <?php $itemAmount=0;?>
                        <?php $vatTaxPercent=0;?>
                        <?php $vatTaxAmount=0;?>
                        <?php $totalVatTaxAmount=0;?>

                        @forelse($cartProducts as $cartProduct)
                        <tr>
                            <td class="text-center">
                                <a href="{{URL::to('products/details/'.$cartProduct->product->id.'/'.$cartProduct->product->name)}}" target="_blank">
                                    <img src="{{asset($cartProduct->product->productImages[0]->small)}}" alt="{{$cartProduct->product->name}}" title="{{$cartProduct->product->name}}" class="img-thumbnail"></a>
                            </td>

                            <td class="text-left"><a href="{{URL::to('products/details/'.$cartProduct->product->id.'/'.$cartProduct->product->name)}}" target="_blank">{{$cartProduct->product->name}}</a>
                            </td>

                            <td class="text-left">
                                {!! Form::open(array('route' => ['cart-products.update',$cartProduct->id],'method'=>'PUT')) !!}
                                <div class="input-group btn-block" style="max-width: 200px;">


                                    <input type="number" name="qty" value="{{$cartProduct->qty}}" size="1" min="1" class="form-control">

                                    <span class="input-group-btn">

              <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Update"><i class="fa fa-refresh"></i></button>

            <button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="event.preventDefault();
                                                document.getElementById({{$cartProduct->id}}).submit();" data-original-title="Remove"><i class="fa fa-times-circle"></i></button>

              </span>
                                </div>
                                {!! Form::close() !!}

                                {!! Form::open(array('route' => ['cart-products.destroy',$cartProduct->id],'method'=>'DELETE','id'=>"$cartProduct->id")) !!}

                                {!! Form::close() !!}
                            </td>
                            <td class="text-right">{{$currency}} {{$cartProduct->price}}</td>

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

                        <?php $totalAmount+=$itemAmount;?>
                        <?php $totalVatTaxAmount+=$vatTaxAmount;?>
                            @empty

                        @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-8">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td class="text-right"><strong>Sub-Total:</strong></td>
                                <td class="text-right">{{$currency}} {{$totalAmount}}</td>
                            </tr>

                            <tr>
                                <td class="text-right"><strong>VAT | TAX :</strong></td>

                                <td class="text-right">{{$currency}} {{$totalVatTaxAmount}}</td>
                            </tr>

                            <tr>
                                <td class="text-right"><strong>Total:</strong></td>
                                <td class="text-right">{{$currency}} {{$totalAmount+$totalVatTaxAmount}}</td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>

                <div class="buttons clearfix">
                    <div class="pull-left"><a href="{{URL::to('/')}}" class="btn btn-default">Continue Shopping</a></div>

                    <div class="pull-left"><a href="{{URL::to('/wish-list-products')}}" class="btn btn-warning"> <i class="fa fa-shopping-cart"></i> Wishlist</a></div>
                    @if(Auth::check())
                        <div class="pull-right"><a href="{{URL::to('/checkout/checkout')}}" class="btn btn-primary">Checkout</a></div>
                        @else
                        <div class="pull-right"><a href="javascript:;" data-target="#so_sociallogin" data-toggle="modal"  class="btn btn-primary">Checkout</a></div>
                        @endif
                </div>
                <br>
            </div>
        </div>
    </div>

    @endsection

@section('script')

    @endsection

