@if(count($cartItems)>0)
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

        <?php $itemTotalAmount=0;?>
        <?php $totalReturnAmount=0;?>
        <?php $discount=0;?>
        <?php $netAmount=0;?>

        @foreach($cartItems as $product)
            <tr>
                <td>{{$product->product->name}}
                    <input type="hidden" name="product_id[{{$product->id}}]" value="{{$product->product_id}}" readonly>
                </td>
                <td>
                    {{$product->qty}}
                    <input type="hidden" name="order_item_qty[{{$product->id}}]" value="{{$product->qty}}" readonly>
                </td>

                <td><input type="number" name="return_item_qty[{{$product->id}}]" value="0" id="returnQty_{{$product->id}}"
                            required min="0" max="9999999" onkeyup="calculateReturnPrice({{$product->id}})" placeholder="Return Qty">
                </td>

                <td>{{$product->price}}
                    <input type="hidden" name="sale_price[{{$product->id}}]" value="{{$product->price}}" id="costPrice_{{$product->id}}">
                </td>

                <td> <span id="itemTotalPrice_{{$product->id}}"></span>

                    <input type="hidden" name="item_total_price[{{$product->id}}]" value="0" id="itemTotalPrice1_{{$product->id}}" readonly>
                </td>

                <?php $itemTotalAmount=$product->cost_price*$product->qty;?>
                <?php $totalReturnAmount+=$product->cost_price*$product->qty;?>

                <td>
                    <input type="number" name="item_return_price[{{$product->id}}]" value="0" id="itemTotalReturnPrice_{{$product->id}}" onkeyup="totalReturnAmountCalculation({{$product->id}})" class="itemTotalReturnPrice">

                </td>
            </tr>

            @endforeach


        </tbody>

    </table>
</div>

<div class="row">
    <div class="col-md-6 col-lg-6 payment-calculation-blank"></div>

    <div class="col-md-6 col-lg-6 payment-calculation">
        <table class="table table-bordered table-hover">
            <tbody>


            <tr>
                <td class="text-right"><strong>Total Amount :</strong></td>

                <td class="text-left"><input type="number" name="total_amount" value="" id="totalReturnAmount" required class="form-control"> </td>
            </tr>
            <tr>
                <td class="text-right"><strong>Return Amount :</strong></td>

                <td class="text-left"><input type="number" name="return_amount" value="" id="totalReturnAmount" required class="form-control"> </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

    @else
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

            <tbody>
            <tr>
                <td colspan="6" class="text-center text-danger">No Order Data Found !</td>
            </tr>

            </tbody>

        </table>
    </div>
@endif

<script>

    function calculateReturnPrice(id) {

        var returnQty=$('#returnQty_'+id).val()
        var costPrice=$('#costPrice_'+id).val()
        var returnPrice=costPrice*returnQty

        $('#itemTotalReturnPrice_'+id).val(returnPrice)
        $('#itemTotalPrice_'+id).html(returnPrice)
        $('#itemTotalPrice1_'+id).val(returnPrice)

        var totalReturnAmount=0
        $('.itemTotalReturnPrice').each(function (i,data) { // total Return Amount -------

            var itemTotalReturnPrice=data.value
            //var id= (data.id).split('_')[1]
//            if (commossion!='' && $('#id_'+id).is(":checked")){
//                sumOfCommission+=parseInt(commossion)
//            }

              totalReturnAmount+=parseInt(itemTotalReturnPrice)
        })


        $('#totalReturnAmount').empty().val(totalReturnAmount)

        var vendorDue=$('#vendorDue').val()

        var lastDueAmount=vendorDue-totalReturnAmount
        $('#lastDueAmount').empty().val(lastDueAmount)
    }

    function totalReturnAmountCalculation(id) {

        var totalReturnAmount=0
        $('.itemTotalReturnPrice').each(function (i,data) { // total Return Amount -------

            var itemTotalReturnPrice=data.value
            //var id= (data.id).split('_')[1]
//            if (commossion!='' && $('#id_'+id).is(":checked")){
//                sumOfCommission+=parseInt(commossion)
//            }

              totalReturnAmount+=parseInt(itemTotalReturnPrice)
        })

        $('#totalReturnAmount').empty().val(totalReturnAmount)

        var vendorDue=$('#vendorDue').val()

        var lastDueAmount=vendorDue-totalReturnAmount
        $('#lastDueAmount').empty().val(lastDueAmount)
    }


</script>