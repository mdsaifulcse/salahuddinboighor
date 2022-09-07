
@if(count($subHeads)>0)

    {{Form::select('income_expense_sub_head_id', $subHeads,[], ['placeholder'=>'Select Expense Head First','id'=>'kt_select2_2_2','class' => 'form-control','required'=>false,])}}
    @if ($errors->has('income_expense_sub_head_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('income_expense_sub_head_id') }}</strong>
        </span>
    @endif
@else

    {{Form::select('income_expense_sub_head_id', [],[], ['placeholder'=>'Select Expense Head First','id'=>'kt_select2_2_2','class' => 'form-control','required'=>false,])}}
    @if ($errors->has('income_expense_sub_head_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('income_expense_sub_head_id') }}</strong>
        </span>
    @endif

@endif
