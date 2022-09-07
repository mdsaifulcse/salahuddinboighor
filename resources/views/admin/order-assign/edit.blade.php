@extends('layouts.vmsapp')

@section('title')
    {{$title}}  | {{auth()->user()->name}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
    <style>
        .form-group{
            margin-bottom:8px !important;
        }
        .secondary-title{
            background-color: #f1f1f1;
            font-weight: bold;
            font-size: 14px;
            font-style: normal;
            color: #000;
            text-transform: uppercase;
            padding: 10px;
            margin: 0;
            border-radius: 5px 5px 0 0;
        }
        .box-inner{
            border: 1px solid #f1f1f1;
            border-top: 0px;
            border-radius: 0 0 5px 5px;
            padding: 20px;
            float: left;
            width: 100%;
        }

        .secondary-title i.fa{
            background-color: #FC0505;
            color: #fff;
            width: 45px;
            height: 45px;
            font-size: 20px;
            text-align: center;
            line-height: 45px;
            border-radius: 5px 0 0;
            margin-right: 10px;
        }
        .ui-id-1{
            z-index: 999999999 !important;
        }

    </style>
@endsection


<!-- begin:: Content Head -->

@section('subheader')
   Edit {{$title}}
@endsection

@section('subheader-action')

    {{--@can('product-purchase-create')--}}
        <a href="{{ url('admin/order-assign') }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back to {{$title}} List
        </a>
    {{--@endcan--}}
@endsection



@section('content')
    <!-- for taging -->
    <link rel="stylesheet" href="{{asset('/tagging/css/jqueryui1.12.1-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/jquery.tagit.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/tagit.ui-zendesk.css')}}">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            {!! Form::open(array('route' =>['order-assign.update',$orderAssignDelivery->id],'method'=>'PUT','class'=>'form-horizontal form-payment','id'=>'orderEdit','files'=>false)) !!}

                <div class="row justify-content-center">
                    <div class="col-left col-lg-5 col-md-5 col-sm-6 col-xs-12">

                        <div class="checkout-content checkout-register">


                            <fieldset id="address">
                                <h2 class="secondary-title"><i class="fa fa-user"></i>Order Assign to Delivery Man</h2>
                                <div class=" checkout-payment-form">
                                    <div class="box-inner">

                                        <div id="payment-new">

                                            <div class="form-group">
                                                <label for="example-text-input" class="control-label">Order ID <sup class="text-danger">*</sup></label>

                                                {{Form::text('order_id_no',$value=old('order_id_no',$orderAssignDelivery->order->order_id), ['class' => 'form-control','required'=>true,'placeholder'=>'Enter Order ID'])}}

                                                <ul id="orderIDFieldUl0"></ul>
                                                <span class="productError text-danger"> </span>
                                                @if ($errors->has('order_id_no'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('order_id_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group company-input">
                                                <label for="example-text-input" class="col-form-label">Assign To <sup class="text-danger">*</sup></label>
                                                {!! Form::select('user_id',$deliveryUser,$orderAssignDelivery->user_id, ['placeholder' => '--Select One --','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('user_id'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('user_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="control-label">Order Assign No.</label>

                                                {{Form::text('assign_no',$value=old('assign_no',$orderAssignDelivery->assign_no), ['class' => 'form-control','required'=>true,'readonly'=>true])}}

                                                @if ($errors->has('assign_no'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('assign_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Delivery Target Date <sup class="text-danger">*</sup></label>

                                                {{Form::text('target_delivery_date',$value=old('target_delivery_date'), ['id'=>'deliveryTargetDate','class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('target_delivery_date'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('target_delivery_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>


                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Delivery Target Time <sup class="text-danger">*</sup></label>

                                                {{Form::time('target_delivery_time',$value=old('target_delivery_time',$orderAssignDelivery->target_delivery_time), ['class' => 'form-control','required'=>true])}}

                                                @if ($errors->has('target_delivery_time'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('target_delivery_time') }}</strong>
                                                </span>
                                                @endif
                                            </div>



                                            <div class="form-group ">
                                                <label for="example-text-input" class="control-label">Note</label>
                                                <textarea name="note" rows="3" class="form-control" placeholder="Note here">{{old('note',$orderAssignDelivery->note)}}</textarea>

                                                @if ($errors->has('note'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('note') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group company-input">
                                                <label for="example-text-input" class="col-form-label">Payment Received From Delivery Man <sup class="text-danger">*</sup></label>
                                                {!! Form::select('receive_from_delivery',$paymentReceivedStatus,$orderAssignDelivery->receive_from_delivery, ['placeholder' => '--Select One --','class' => 'form-control','required'=>true]) !!}

                                                @if ($errors->has('receive_from_delivery'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('receive_from_delivery') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="checkout-content confirm-section">
                                                <div class="confirm-order">
                                                    <button type="submit" class="btn btn-success button confirm-button">Update</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                    </div>

                </div><!-- End Row -->
            {!! Form::close() !!}


        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

@section('script')

    {{--<script>--}}
        {{--document.forms['orderEdit'].elements['order_status'].value='{{$order->order_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_status'].value='{{$order->payment_status}}';--}}
        {{--document.forms['orderEdit'].elements['payment_gateway'].value='{{$order->payment_gateway}}';--}}
    {{--</script>--}}


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{asset('/tagging/js/jquery-1.12.1-ui.min.js')}}"></script>
    <script src="{{asset('/tagging/js/tag-it.min.js')}}"></script>

    <script>
        $(function(){
            $('#orderIDFieldUl').tagit({
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: false,
                singleFieldNode: $('#orderIDField'),
                allowSpaces: true,
                fieldName:"order_id_no",
                tagLimit:1,
                placeholderText:'Search Order',
                //autocomplete: {source:country_list},
                autocomplete: {
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{URL::to('/admin/search-order-by-orderId')}}",
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function( data ) {
                                console.log(data)
                                response( data );
                            }
                        });
                    },

                },

            });
        });
    </script>


    <link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>

    <script>
        $(function() {
            $('#deliveryTargetDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                //maxDate: new Date(),
                minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#deliveryTargetDate').val("{{date('m/d/Y',strtotime($orderAssignDelivery->target_delivery_date))}}");
        });
    </script>





@endsection