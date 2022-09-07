@extends('layouts.vmsapp')

@section('title')
    Order List | {{auth()->user()->name}}
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Order List
@endsection

@section('subheader-action')
    {{--@can('product-create')--}}
        {{--<a href="{{ url('admin/orders/recent') }}" class="btn btn-success pull-right" title="Click to create new product">--}}
            {{--<i class="la la-list"></i> Recent Orders--}}
        {{--</a>--}}
    {{--@endcan--}}
@endsection

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->
            <?php $currency=$setting->currency;?>

            <table id="ordersData" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                <tr class="">
                    <td class="text-center">Sl</td>
                    <td class="text-center">Order ID</td>
                    <td class="text-center">Order By</td>
                    <td class="text-center">Mobile</td>
                    <td class="text-center">Products</td>
                    <td class="text-center">Total.{{$currency}}</td>
                    <td class="text-center">Order Status</td>
                    <td class="text-center">Payment Status</td>
                    <td class="text-center">Order Date</td>
                    <td>Action</td>
                </tr>
                </thead>
            </table>
        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->

    <?php
    $today=$request->today;
    $thisMonth=$request->this_month;
    $orderStatus=$request->order_status;
    $paymentStatus=$request->payment_status;

    ?>
@endsection

@section('script')
    <script>
        $(function() {
            $('#ordersData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '<?php echo url("admin/orders/history-data?".'today='.$today.'&this_month='.$thisMonth.'&order_status='.$orderStatus.'&payment_status='.$paymentStatus) ?>',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'order_id',name:'orders.order_id'},
                    { data: 'Order_by',name:'user.name'},
                    { data: 'Mobile',name:'user.mobile'},
                    { data: 'number_of_product'},
                    { data: 'total',name:'orders.total'},
                    { data: 'order_status',name:'orders.order_status'},
                    { data: 'payment_status',name:'orders.payment_status'},
                    { data: 'Order Date'},
                    { data: 'Action'},
                ]
            });

        });
    </script>

@endsection