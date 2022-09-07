@extends('layouts.vmsapp')

@section('title')
    {{$title}} List
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} List
@endsection

@section('subheader-action')
    {{--@can('user-create')--}}
        <a href="{{ route('order-assign.create') }}" class="btn btn-success pull-right" title="Click to Create New Product Purchase">
            <i class="la la-plus"></i> Create {{$title}}
        </a>
    {{--@endcan--}}
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table id="productData" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                <tr class=" text-white">
                    <th>No.</th>
                    <th>Assign No.</th>
                    <th>Order ID</th>
                    <th>Delivery Target Date</th>
                    <th>Assign To</th>
                    <th>Delivery Status</th>
                    <th>Payment Received</th>
                    <th>Order Detail</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

<?php
$today=$request->today;
$thisMonth=$request->this_month;
$deliveryStatus=$request->delivery_status;
$paymentStatus=$request->payment_status;

?>

@section('script')
    <script>
        $(function() {
            $('#productData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '<?php echo url("admin/order-assign-data?".'today='.$today.'&this_month='.$thisMonth.'&delivery_status='.$deliveryStatus.'&payment_status='.$paymentStatus) ?>',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'assign_no',name:'order_assign_deliveries.assign_no'},
                    { data: 'order_id_no',name:'order.order_id'},
                    { data: 'target_delivery_date'},
                    { data: 'Assign To',name:'user.name'},
                    { data: 'Delivery Status'},
                    { data: 'Payment Received'},
                    { data: 'Order Detail'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection