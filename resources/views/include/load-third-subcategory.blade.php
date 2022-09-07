
@if(count($thirdSubCats)>0)

    {!! Form::select('third_category_id',$thirdSubCats,[], ['id'=>'loadFourthSubCategory','placeholder' => '--Select Third Sub-Category--','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('third_category_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('third_category_id') }}</strong>
        </span>
    @endif

@else

    {!! Form::select('third_category_id',[],[], ['id'=>'loadFourthSubCategory','placeholder' => 'No Third Sub-Category','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('third_category_id'))
        <span class="help-block">
        <strong class="text-danger">{{ $errors->first('third_category_id') }}</strong>
    </span>
    @endif

@endif

<script>
    $('#loadFourthSubCategory').on('change',function () {

        var thirdSubCategoryId=$(this).val()
        //$('#fourthSubCategory').empty()

        if(thirdSubCategoryId.length===0)
        {
            thirdSubCategoryId=0
            $('#fourthSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-fourth-sub-cat-by-third-sub-cat")}}/'+thirdSubCategoryId);

        }else {

            $('#fourthSubCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-fourth-sub-cat-by-third-sub-cat")}}/'+thirdSubCategoryId);
        }
    })

</script>