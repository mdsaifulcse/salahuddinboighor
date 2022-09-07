<?php $currency=$setting->currency;?>
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
        <td colspan="6"></td>
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
        <?php $shippingCost=!empty($shippingCost)?$shippingCost->cost:'00'?>
        <td colspan="1" class="text-left">{{$currency}} {{$shippingCost}}</td>
    </tr>
    <tr>
        <td colspan="6" class="text-right">Total:</td>
        <td colspan="1" class="text-left">{{$currency}} {{$subTotal+$totalVatTaxAmount+$shippingCost}}</td>
    </tr>
    </tfoot>
</table>
