@extends('layouts.vmsapp')

@section('title')
    {{$title}} Voucher
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} Voucher
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />

    <style>
        table tr td{
            border:none !important;
            padding: 0.2rem !important;
        }

        table.footer tr td{
            padding: 0.2rem !important;
        }

        table.footer td.total-balance{
            border-top: 1px solid #000000 !important;
        }
        table.footer td.expense-amount{
            border-bottom: 1px solid #000000 !important;
        }
        table.footer td.signature{
            padding-top:30px!important;
        }
    </style>

@endsection

@section('subheader-action')
    {{--@can('vendor-payment-list')--}}
        <a href="{{ route('expenditures.index') }}" class="btn btn-success pull-right">
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
                                <h1 class="kt-portlet__head-title">
                                     Expense Voucher
                                </h1>

                            </div>
                            <h5 class="pull-right" style="margin-top:20px;">Expense Date : {{date('d-M-Y',strtotime($expenditure->expense_date))}}</h5>
                        </div>

                         <div class="kt-portlet__body">
                             <h1 class="text-center">Expense Voucher</h1>

                             <table class="table center_table">
                                 <tbody>

                                 <tr>
                                     <td class="text-center"><b>Voucher No. : </b> {{$expenditure->voucher_no}}</td>
                                 </tr>
                                 <tr>
                                     <td class="text-center"><b>Expense Date : </b> {{date('d-M-Y',strtotime($expenditure->expense_date))}}</td>
                                 </tr>
                                 <tr>
                                     <td class="text-center"><b>Created By. : </b> {{$expenditure->createdBy->name.'-'.$expenditure->createdBy->mobile}}</td>
                                 </tr>

                                 <tr>
                                     <td class="text-center"> <b>Expense Head :</b> {{$expenditure->head->head_title}} </td>
                                 </tr>

                                 <tr>
                                     <td class="text-center"><b>Sub Head</b> : {{$expenditure->subHead?$expenditure->subHead->sub_head_title:''}}</td>
                                 </tr>

                                 <tr>
                                     <td class="text-center"><b>Branch</b> :  {{'Head Office'}} </td>
                                 </tr>



                                 @if(!empty($expenditure->bankAccount))

                                 <tr>
                                     <td class="text-center"><b>Account</b> :  {{$expenditure->expense_method}} </td>
                                 </tr>

                                 <tr>
                                     <td class="text-center"><b>Check No.</b> :  {{$expenditure->check_no}} & AccNo. {{$expenditure->bankAccount->account_number.'-'.$expenditure->bankAccount->account_title}} </td>
                                 </tr>


                                 @elseif($expenditure->payment_method=="{{\App\Models\VendorPayment::BKASH}}" || $expenditure->payment_method=="{{\App\Models\VendorPayment::ROCKET}}" || $expenditure->payment_method=="{{\App\Models\VendorPayment::NAGAD}}")

                                     <tr>
                                         <td class="text-center"><b>Transaction ID</b> : {{$expenditure->payment_trxId}} & {{$expenditure->expense_method}} </td>
                                     </tr>

                                     @else
                                     <tr>
                                         <td class="text-center"><b>Account</b> : {{$expenditure->expense_method}}  </td>
                                     </tr>

                                   @endif

                                 <tr>
                                     <td class="text-center"><b>Expenses</b> : {{$expenditure->amount}}</td>
                                 </tr>

                                 </tbody>
                             </table>

                             <table class="table center_table footer">
                                 <tbody>
                                 <tr>
                                     <td class="text-center total-balance"><b>Total Balance : </b></td>
                                     <td class="text-left total-balance"> {{$expenditure->amount}} /=</td>
                                 </tr>
                                 <tr>
                                     <td class="text-center "><b>Expense : </b></td>
                                     <td class="text-left"> {{$expenditure->amount}} /=</td>
                                 </tr>

                                 <tr>
                                     <td class="text-center expense-amount" colspan="2">{{$expenditure->note}}</td>
                                 </tr>


                                 <tr>
                                     <td class="text-right"><b>In Word : </b></td>
                                     <td class="text-left"> <b>{{\MyHelper::taka($expenditure->amount)}}</b></td>
                                 </tr>

                                 <tr>
                                     <td class="text-center signature"><b>---------------- </b></td>
                                     <td class="text-center signature"> ----------------------- <br> Authorized Person </td>
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
