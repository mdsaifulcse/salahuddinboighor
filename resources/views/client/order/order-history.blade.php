@extends('client.layouts.master')

@section('head')
    <title> Order History | {{auth()->user()->name}} </title>
    <meta name="description" content="Register New User , Create Account, Sign Up " />
    <meta name="keywords" content="Register New User , Create Account, Sign Up" />
    @endsection


@section('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    @endsection

@section('content')

    <div id="account-account" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/account/account')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="javascript:;">Order History</a></li>
        </ul>

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>
            Success: {{Session::get('success')}}
        </div>
        @endif

        <div class="row">

            <div class="col-md-9 col-lg-9 pull-md-center pull-lg-right">
                <?php $currency=$setting->currency;?>

                <div class="header-lined">
                    <h1>My Order History </h1>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="ordersData" width="100%">
                            <thead>
                            <tr>
                                <td class="text-center">SL</td>
                                <td class="text-center">Order ID</td>
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
                </div>


            </div>



            <div class="col-md-3 col-lg-3 pull-md-left pull-lg-left ">

                @include('client.layouts.partials.user-account-aside')

            </div>

        </div>
    </div>

@endsection

<?php
    $today=$request->today;
    $thisMonth=$request->this_month;
    $order_status=$request->order_status;
    $paymentStatus=$request->payment_status;

?>

@section('script')

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#ordersData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[25,50, 100, 200,500, -1], [25,50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("orders/create") }}',
                ajax: '<?php echo url("orders/create?".'today='.$today.'&this_month='.$thisMonth.'&order_status='.$order_status.'&payment_status='.$paymentStatus) ?>',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'order_id',name:'orders.order_id'},
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
    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>
    @endsection

