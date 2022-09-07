
@if(count($subCats)>0)

    {!! Form::select('subcategory_id',$subCats,[], ['id'=>'loadThirdSubCategory','placeholder' => '--Select Sub-Category--','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('subcategory_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
        </span>
    @endif

@else

    {!! Form::select('subcategory_id',[],[], ['id'=>'loadThirdSubCategory','placeholder' => 'No Sub-Category','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('subcategory_id'))
        <span class="help-block">
        <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
    </span>
    @endif

@endif

<script>
    $('#loadThirdSubCategory').on('change',function () {

        var subCategoryId=$(this).val()

        $('#fourthSubCategory').empty()

        if(subCategoryId.length===0)
        {
            subCategoryId=0
            $('#thirdSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-third-sub-cat-by-sub-cat")}}/'+subCategoryId);

        }else {

            $('#thirdSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-third-sub-cat-by-sub-cat")}}/'+subCategoryId);
        }
    })

</script>