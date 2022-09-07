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
        <a href="{{ route('vendor-payments.index') }}" class="btn btn-success pull-right">
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
                        {!! Form::open(array('route' => 'vendor-payments.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new {{$title}}
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('vendor_id') ? 'has-error' : '' }}">

                                 {{Form::label('vendor_id', 'Supplier Name *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::select('vendor_id', $vendors,[], ['placeholder'=>'Select Supplier','id'=>'kt_select2_2_1','class' => 'form-control','required'=>true,])}}
                                     @if ($errors->has('vendor_id'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('vendor_id') }}</strong>
                    			</span>
                                     @endif
                                 </div>

                             </div>


                             <div class="form-group row {{ $errors->has('payable') ? 'has-error' : '' }}">

                                 {{Form::label('payable', 'Total Due *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('payable',$value=old('payable'),array('id'=>'totalDue','step'=>'any','min'=>0,'max'=>'9999999999','class'=>'form-control','placeholder'=>'0.0','required'=>true,'autofocus'))}}

                                     <span style="display:block;color:red;" id="totalDueError"></span>

                                     @if ($errors->has('payable'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('payable') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('payment') ? 'has-error' : '' }}">

                                 {{Form::label('payment', 'Payment Amount *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('payment',$value=old('payment'),array('id'=>'paymentAmount','min'=>0,'max'=>'9999999999','class'=>'form-control','placeholder'=>'0.0','required'))}}
                                     @if ($errors->has('payment'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('payment') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('due') ? 'has-error' : '' }}">

                                 {{Form::label('due', 'Due Remaining', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('due',$value=old('due'),array('id'=>'dueRemaining','min'=>0,'class'=>'form-control','placeholder'=>'00.0','readonly'=>true,'required'=>true,'autofocus'))}}
                                     @if ($errors->has('due'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('due') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                             </div>

                             <div class="form-group row {{ $errors->has('payment_method') ? 'has-error' : '' }}">

                                 {{Form::label('payment_method', 'Payment Method *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">

                                     {{Form::select('payment_method', $paymentMethods,[], ['id'=>'paymentMethod','placeholder'=>'Select Payment Method','required'=>true,'class' => 'form-control'])}}

                                     @if ($errors->has('payment_method'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('payment_method') }}</strong>
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

                             <div id="paymentTrx" class="form-group row {{ $errors->has('payment_trxId') ? 'has-error' : '' }}" style="display:none">

                                 {{Form::label('payment_trxId', 'Transaction ID *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('payment_trxId',$value=old('payment_trxId'),array('id'=>'paymentTrxField','class'=>'form-control','placeholder'=>'Payment TrxID','required'=>false,'autofocus'))}}
                                     @if ($errors->has('payment_trxId'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('payment_trxId') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('payment_date') ? 'has-error' : '' }}">

                                 {{Form::label('payment_date', 'Payment Date *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('payment_date',$value=old('payment_date'),array('id'=>'paymentDate','class'=>'form-control','placeholder'=>'Date','required'=>true,'autofocus'))}}
                                     @if ($errors->has('payment_date'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('payment_date') }}</strong>
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
                                        @can('vendor-payment-list')
                                        <a href="{{route('vendor-payments.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
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
    <script>
        $('#kt_select2_2_1').on('change',function () {

            var vendorId=$(this).val()

            $.ajax({
                url: "{{URL::to('/admin/calculate-vendor-remaining-due')}}"+'/'+vendorId,
                dataType: "json",
                success: function( data ) {
                   console.log(data)
                    $('#totalDue').val(data)
                }
            });
        })


    </script>


    <script>
        // Discount by Percentage ---------------------------
        $('#paymentAmount').on('keyup',function () {

            var paymentAmount=$(this).val();

            var totalDue=$('#totalDue').val()

            if (totalDue<1)
            {
                $('#totalDueError').html('Total due is required')
                return false;
            }
            $('#totalDueError').html('')

            $('#dueRemaining').val(totalDue-paymentAmount)
        })
    </script>

    <script>

        $('#paymentMethod').on('change',function () {
            var paymentMethod=$(this).val()

            if(paymentMethod=="{{\App\Models\VendorPayment::BKASH}}" || paymentMethod=="{{\App\Models\VendorPayment::ROCKET}}" || paymentMethod=="{{\App\Models\VendorPayment::NAGAD}}")
            {
                $('#paymentTrx').css('display','flex')
                $('#paymentTrxField').attr('required',true)

                $('#bankAccount').css('display','none')
                $('#checkNo').css('display','none')

                $('#bankAccountField').val('')
                $('#checkNoField').val('')

                $('#bankAccountField').attr('required',false)
                $('#checkNoField').attr('required',false)

            }else if(paymentMethod=="{{\App\Models\VendorPayment::BANK}}") {
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
            $('#paymentDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#paymentDate').val('');
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
