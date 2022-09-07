@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
@endsection

@section('subheader-action')
    {{--@can('vendor-payment-list')--}}
        <a href="{{ route('vendor-payments.index') }}" class="btn btn-success pull-right">
            {{$title}} List
        </a>
    {{--@endcan--}}
    <a href="javascript:void(0)" class="btn btn-danger pull-right" title="Click to create new product" id="doPrint">
        <i class="la la-print "></i> Print
    </a>
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->


        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                    <div class="kt-portlet">
                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                     {{$title}} Report
                                </h3>

                            </div>
                            <h5 class="pull-right" style="margin-top:20px;">Payment Date : {{date('d-M-Y',strtotime($vendorPayment->payment_date))}}</h5>
                        </div>

                         <div class="kt-portlet__body">

                             <table class="table table-striped table-hover table-bordered center_table">
                                 <tbody>

                                 <tr>
                                     <td>Supplier Name</td>
                                     <td> {{$vendorPayment->vendor->name}} </td>
                                 </tr>

                                 <tr>
                                     <td>Total Due</td>
                                     <td> {{$vendorPayment->payable}} </td>
                                 </tr>
                                 <tr>
                                     <td>Total Payment</td>
                                     <td> {{$vendorPayment->payment}} </td>
                                 </tr>

                                 <tr>
                                     <td>Deu Remaining</td>
                                     <td> {{$vendorPayment->due}} </td>
                                 </tr>

                                 <tr>
                                     <td>Payment Method</td>
                                     <td> {{$vendorPayment->payment_method}} </td>
                                 </tr>

                                 @if(!empty($vendorPayment->bankAccount))
                                 <tr>
                                     <td>Account</td>
                                     <td> {{$vendorPayment->bankAccount->account_number.'-'.$vendorPayment->bankAccount->account_title}} </td>
                                 </tr>
                                 <tr>
                                     <td>Check No.</td>
                                     <td> {{$vendorPayment->check_no}} </td>
                                 </tr>

                                 @elseif($vendorPayment->payment_method=="{{\App\Models\VendorPayment::BKASH}}" || $vendorPayment->payment_method=="{{\App\Models\VendorPayment::ROCKET}}" || $vendorPayment->payment_method=="{{\App\Models\VendorPayment::NAGAD}}")
                                 <tr>
                                     <td>Transaction ID</td>
                                     <td> {{$vendorPayment->payment_trxId}} </td>
                                 </tr>
                                   @endif

                                 <tr>
                                     <td>Payment Date</td>
                                     <td> {{date('d-M-Y',strtotime($vendorPayment->payment_date))}} </td>
                                 </tr>
                                 <tr>
                                     <td>Payment Note</td>
                                     <td> {{$vendorPayment->note}} </td>
                                 </tr>

                                 </tbody>
                             </table>

                             </div>

                        </div> <!-- end kt-portlet__body -->

                    </div>
            </div>

        </div><!-- kt-container -->
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->

@endsection

@section('script')

    <script src="{{asset('/')}}/print/jQuery.print.js" type="text/javascript"></script>

    <script>

        $(function(){
            $('#doPrint').on('click', function() {

                //Print ele2 with default options
                $.print(".kt-portlet");
            });
        });


    </script>

@endsection

<!-- Good -->
