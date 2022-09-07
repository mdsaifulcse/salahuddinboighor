
@if(count($fourthSubCats)>0)

    {!! Form::select('fourth_category_id',$fourthSubCats,[], ['id'=>'fourthSubCategory','placeholder' => '--Select Fourth Sub-Category--','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('fourth_category_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('fourth_category_id') }}</strong>
        </span>
    @endif

@else

    {!! Form::select('fourth_category_id',[],[], ['id'=>'fourthSubCategory','placeholder' => 'No Fourth Sub-Category','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('fourth_category_id'))
        <span class="help-block">
        <strong class="text-danger">{{ $errors->first('fourth_category_id') }}</strong>
    </span>
    @endif

@endif