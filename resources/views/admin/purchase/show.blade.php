@extends('layouts.vmsapp')

@section('title')
    {{$title}} #{{$productPurchase->purchase_no}} | {{auth()->user()->name}}
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('/')}}/print/print.css" />
    <style>
        .billing-head{
            padding-bottom:20px;
            border-bottom: 1px solid #414141;
        }
        .billing-to,.shipping-to{
            padding-left:10%;
        }
        .signature address{
            margin-top: 25px;
        }


    </style>
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} #{{$productPurchase->purchase_no}}
@endsection

@section('subheader-action')
    <a href="javascript:void(0)" class="btn btn-danger pull-right" title="Click to create new product" id="doPrint">
        <i class="la la-print "></i> Print
    </a>
    {{--@can('product-create')--}}
        <a href="{{ url()->previous() }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-angle-left"></i> Back
        </a>
    {{--@endcan--}}
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" style="background-color: #ffffff;padding: 15px;
    border: 1px solid #535353;color: #474747;">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >

            <!--Begin::Row-->

            <?php $currency=$setting->currency;?>

            <div class="billing-head">
                <div class="row">

                    <div class="col-md-4 col-lg-4 order-status">
                        <h3>From</h3>
                        <address class="small-text">

                            <b> Supplier</b>: {{$productPurchase->vendor->name}}<br>
                            <b>Mobile</b>: {{$productPurchase->vendor->mobile}} <br>
                            <b>Email</b>: {{$productPurchase->vendor->email}} <br>
                            <b>Address</b>: {{nl2br($productPurchase->vendor->office_address)}}<br>
                        </address>

                    </div>

                    <div class="col-md-4 col-lg-4 billing-to">
                        <h3>Purchase Info</h3>

                        <address class="small-text">
                            <b> Purchase No.:</b>: #{{$productPurchase->purchase_no}}<br>
                            <b>PO Reference</b>: {{$productPurchase->po_ref}} <br>
                            <b>Payment Terms</b>: {{$productPurchase->payment_term}} <br>
                            <b>Purchase Date</b>: {{date('M-d-Y',strtotime($productPurchase->purchase_date))}} <br>
                            <b>Due Date</b>: {{date('M-d-Y',strtotime($productPurchase->due_date))}} <br>
                        </address>

                    </div>
                    <div class="col-md-4 col-lg-4 shipping-to">
                        <h3>To</h3>

                        <address class="small-text">
                           <b> Company:</b> {{$setting->company_name}}<br>
                            <b>Mobile</b>: {{$setting->mobile_no1}} <br>
                            <b>Address</b>: {{nl2br($setting->address1)}}<br>
                        </address>

                    </div>

                </div>
            </div>

            <div class="header-lined">
                <h1> </h1>
            </div>


            <div class="header-lined">
                <h3> Purchase Invoice No.: #{{$productPurchase->purchase_no}} </h3>
                <div class="checkout-content checkout-cart">
                    <div class="box-inner">
                        <div class="table-responsive checkout-product" id="tableLoad">
                            <table id="productList" class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th class="text-left name">Product Name</th>
                                    <th class="text-center quantity">Qty</th>
                                    <th class="text-center price">Unit Price</th>
                                    <td class="text-left">Item Total</td>
                                </tr>
                                </thead>

                                <?php $currency=$setting->currency;?>
                                <tbody>

                                @forelse($productPurchase->purchaseItem as $key=>$product)

                                    <tr>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->qty}}</td>
                                        <td>{{$product->cost_price}}</td>

                                        <td>{{$product->item_total}}</td>
                                       </tr>

                                @empty


                                @endforelse



                                </tbody>

                            </table>


                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 payment-calculation-blank"></div>

                            <div class="col-md-6 col-lg-6 payment-calculation">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <td colspan="2" style="background-color:rgba(81,82,114,0.46);">Payment Calculation</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Sub-Total:</strong></td>
                                        <td class="text-left">{{$currency.' '.$productPurchase->sub_total}}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><strong>Discount :</strong></td>

                                        <td class="text-left">{{$currency}} {{$productPurchase->discount}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><strong>Net Total :</strong></td>

                                        <td class="text-left">{{$currency}} {{$productPurchase->net_total}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                Note: {{$productPurchase->note}}
                            </div>
                        </div>
                        <br>

                        <div class="signature">
                            <div class="row">

                                <div class="col-md-4 col-lg-4 order-status">
                                    <h6>Prepared By: ___________________</h6>
                                    <address class="small-text">

                                        <b> Date</b>: {{date('M-d-Y')}}<br>
                                    </address>

                                </div>

                                <div class="col-md-4 col-lg-4 billing-to">
                                    <h6>Checked By: ______________</h6>

                                    <address class="small-text">
                                        <b> Date: </b>___________________ <br>
                                    </address>

                                </div>
                                <div class="col-md-4 col-lg-4 shipping-to">
                                    <h6>Approved By: ______________</h6>

                                    <address class="small-text">
                                        <b> Date: </b>___________________ <br>
                                    </address>

                                </div>

                            </div>
                        </div>


                        </div><!-- end box-inner -->
                </div>
            </div>

        </div>
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
                $.print("#kt_content");
            });
        });


    </script>

@endsection