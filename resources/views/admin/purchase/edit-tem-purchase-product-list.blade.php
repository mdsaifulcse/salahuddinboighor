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

<script>

    function removeProduct(id) {

        $('#tableLoad').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
            .empty().load('{{URL::to("admin/remove-product-from-purchase-list-update?")}}'+'id='+id);
    }

    $('#discount').on('keyup',function () {

        var discount = $(this).val()
        var netTotalHidden = $('#netTotalHidden').val()
          $('#netTotal').val(netTotalHidden-discount)
    });

</script>