@extends('client.layouts.master')

@section('head')
    <title> Your Wish List Product' (s) </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
    @endsection


@section('style')

    @endsection

@section('content')

    <div id="checkout-cart" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/cart-products')}}">Wish List Product</a></li>
        </ul>
        <?php $currency=$setting->currency;?>
        <div class="row">
            <div id="content" class="col-sm-12">
                <h1>Your Wish List Product(s)</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-center">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-right">Unit Price</td>
                                <td class="text-right">Vat | Tax</td>
                                <td class="text-right">Total</td>
                                <td class="text-right">Action</td>
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

                            <td class="text-right">{{$currency}} {{$cartProduct->price}}</td>

                            <?php $itemAmount=$cartProduct->qty*$cartProduct->price?>


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
                            <td class="text-right">
                                <a href="javascript:;"
                                                       onclick='event.preventDefault();document.getElementById("addToCartForm{{$cartProduct->id}}").submit();'
                                                       class="btn btn-md btn-warning" >
                                    Add To Cart
                                </a>
                                <form id="addToCartForm{{$cartProduct->id}}" action="{{route('cart-products.store')}}" method="POST" style="display: none;">
                                    @csrf
                                    <input class="form-control" type="hidden" name="qty" value="1">
                                    <input type="hidden" name="product_id" value="{{$cartProduct->product_id}}">
                                </form>
                            </td>
                        </tr>

                        <?php $totalAmount+=$itemAmount;?>
                        <?php $totalVatTaxAmount+=$vatTaxAmount;?>
                            @empty

                        @endforelse
                        </tbody>

                    </table>
                </div>

                <br>
            </div>
        </div>
    </div>

    @endsection

@section('script')

    @endsection

