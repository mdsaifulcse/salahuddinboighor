@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    {{--@can('vendor-payment-list')--}}
        <a href="{{ route('expenditures.index') }}" class="btn btn-success pull-right">
            {{$title}} List
        </a>
    {{--@endcan--}}
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--Begin::Row-->
            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="kt-portlet">
                        {!! Form::open(array('route' => 'expenditures.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new {{$title}}
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('income_expense_head_id') ? 'has-error' : '' }}">

                                 {{Form::label('income_expense_head_id', 'Expense Head *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::select('income_expense_head_id', $incomeExpenseHeads,[], ['placeholder'=>'Select Expense Head','id'=>'kt_select2_2_1','class' => 'loadSubHead form-control','required'=>true,])}}
                                     @if ($errors->has('income_expense_head_id'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('income_expense_head_id') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('income_expense_sub_head_id') ? 'has-error' : '' }}">

                                 {{Form::label('income_expense_sub_head_id', 'Expense Sub Head *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6" id="subHeadList">
                                     {{Form::select('income_expense_sub_head_id', [],[], ['placeholder'=>'Select Expense Head First','id'=>'kt_select2_2_2','class' => 'form-control','required'=>false,])}}
                                     @if ($errors->has('income_expense_sub_head_id'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('income_expense_sub_head_id') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('amount') ? 'has-error' : '' }}">

                                 {{Form::label('amount', 'Expense Amount *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('amount',$value=old('amount'),array('min'=>0,'max'=>'9999999999','class'=>'form-control','placeholder'=>'0.0','required'=>true,'autofocus'))}}
                                     @if ($errors->has('amount'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('amount') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('expense_method') ? 'has-error' : '' }}">

                                 {{Form::label('expense_method', 'Expense Account *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">

                                     {{Form::select('expense_method', $expenseMethods,[], ['id'=>'expenseMethod','placeholder'=>'Select Expense Account','required'=>true,'class' => 'form-control'])}}

                                     @if ($errors->has('expense_method'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('expense_method') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>


                             <div id="bankAccount" class="form-group row {{ $errors->has('bank_account_id') ? 'has-error' : '' }}" style="display:none">

                                 {{Form::label('bank_account_id', 'Account *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">

                                     {{Form::select('bank_account_id', $bankAccounts,[], ['id'=>'bankAccountField','placeholder'=>'Select Account','class' => 'form-control'])}}

                                     @if ($errors->has('bank_account_id'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('bank_account_id') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>


                             <div id="checkNo" class="form-group row {{ $errors->has('check_no') ? 'has-error' : '' }}" style="display:none">

                                 {{Form::label('check_no', 'Check Number *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('check_no',$value=old('check_no'),array('id'=>'checkNoField','class'=>'form-control','placeholder'=>'Check no.','required'=>false,'autofocus'))}}
                                     @if ($errors->has('check_no'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('check_no') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>

                             <div id="paymentTrx" class="form-group row {{ $errors->has('expense_trxId') ? 'has-error' : '' }}" style="display:none">

                                 {{Form::label('expense_trxId', 'Transaction ID *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('expense_trxId',$value=old('expense_trxId'),array('id'=>'paymentTrxField','class'=>'form-control','placeholder'=>'Payment TrxID','required'=>false,'autofocus'))}}
                                     @if ($errors->has('expense_trxId'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('expense_trxId') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('expense_date') ? 'has-error' : '' }}">

                                 {{Form::label('expense_date', 'Expense Date *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('expense_date',$value=old('expense_date'),array('id'=>'expenseDate','class'=>'form-control','placeholder'=>'Expense Date','required'=>true,'autofocus'))}}
                                     @if ($errors->has('expense_date'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('expense_date') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('note') ? 'has-error' : '' }}">
                                 {{Form::label('note', 'Note', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::textArea('note',$value=old('note'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Payment Note '])}}
                                     @if ($errors->has('note'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('note') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                             </div>

                        </div> <!-- end kt-portlet__body -->


                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        @can('expenditure-list')
                                        <a href="{{route('expenditures.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
                                            @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
            </div>

        </div><!-- kt-container -->
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->

@endsection

@section('script')

            {{--Load SubCategory--}}
            <script>
                $('.loadSubHead').on('change',function () {

                    var headId=$(this).val()

                    if(headId.length===0)
                    {
                        headId=0
                        $('#subHeadList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-head-by-head")}}/'+headId);

                    }else {

                        $('#subHeadList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-head-by-head")}}/'+headId);
                    }
                })
            </script>


    <script>

        $('#expenseMethod').on('change',function () {
            var expenseMethod=$(this).val()

            if(expenseMethod=="{{\App\Models\VendorPayment::BKASH}}" || expenseMethod=="{{\App\Models\VendorPayment::ROCKET}}" || expenseMethod=="{{\App\Models\VendorPayment::NAGAD}}")
            {
                $('#paymentTrx').css('display','flex')
                $('#paymentTrxField').attr('required',true)

                $('#bankAccount').css('display','none')
                $('#checkNo').css('display','none')

                $('#bankAccountField').val('')
                $('#checkNoField').val('')

                $('#bankAccountField').attr('required',false)
                $('#checkNoField').attr('required',false)

            }else if(expenseMethod=="{{\App\Models\VendorPayment::BANK}}") {
                $('#bankAccount').css('display','flex')
                $('#checkNo').css('display','flex')

                $('#bankAccountField').attr('required',true)
                $('#checkNoField').attr('required',true)

                $('#paymentTrx').css('display','none')
                $('#paymentTrxField').val('')
                $('#paymentTrxField').attr('required',false)

            }else {

                $('#paymentTrx').css('display','none')
                $('#bankAccount').css('display','none')
                $('#checkNo').css('display','none')

                $('#paymentTrxField').val('')
                $('#bankAccountField').val('')
                $('#checkNoField').val('')

                $('#paymentTrxField').attr('required',false)
                $('#bankAccountField').attr('required',false)
                $('#checkNoField').attr('required',false)

            }
        })
    </script>


    <link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>

    <script>
        $(function() {
            $('#expenseDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#expenseDate').val('');
        });

    </script>

    <script type="text/javascript">

        function photoLoad(input,image_load) {
            var target_image='#'+$('#'+image_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

@endsection

<!-- Good -->
