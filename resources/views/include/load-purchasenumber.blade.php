
@if(count($purchaseNoList)>0)

    {!! Form::select('product_purchase_id',$purchaseNoList,[], ['id'=>'purchaseId','placeholder' => '--Select Invoice --','class' => 'form-control','required'=>true]) !!}

@else

    {!! Form::select('product_purchase_id',[],[], ['id'=>'purchaseId','placeholder' => '--No Invoice --','class' => 'form-control','required'=>true]) !!}

@endif

<script>
    $('#purchaseId').on('change',function () {
        var purchaseId=$(this).val()

        $('#returnInfo').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>')
            .load('{{URL::to("load-purchase-info-by-purchase-id-to-return")}}'+'/'+purchaseId);
    })
</script>
