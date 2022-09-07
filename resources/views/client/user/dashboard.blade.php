@extends('client.layouts.master')

@section('head')
    <title> Dashboard | {{auth()->user()->name}} </title>
    <meta name="description" content="Register New User , Create Account, Sign Up " />
    <meta name="keywords" content="Register New User , Create Account, Sign Up" />
    @endsection


@section('style')

    @endsection


@section('content')

    <div id="account-account" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/account/account')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="javascript:;">My Account</a></li>
        </ul>

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>
            Success: {{Session::get('success')}}
        </div>
        @endif

        <div class="row">

            <div class="col-md-9 col-lg-9 pull-md-right pull-lg-right">
                <div class="header-lined text-center">
                    <h1>Welcome Back, {{auth()->user()->name}} </h1>
                </div>

                <?php $currency=$setting->currency;?>

                <div class="tiles clearfix">
                    <div class="row">
                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history")}}" target="_blank">
                                <div class="icon"><i class="fa fa-cube"></i></div>
                                <div class="stat">{{$totalOrders}}</div>
                                <div class="title">Total Order</div>
                                <div class="highlight bg-color-blue"></div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history?".'order_status='.\App\Models\Order::COMPLETE)}}" target="_blank">
                                <div class="icon"><i class="fa fa-check-square-o" aria-hidden="true"></i></div>
                                <div class="stat">{{$completeOrders}}</div>
                                <div class="title">Complete Order</div>
                                <div class="highlight bg-color-success"></div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history?".'order_status='.\App\Models\Order::PENDING)}}" target="_blank">
                                <div class="icon"><i class="fa fa-filter" aria-hidden="true"></i></div>
                                <div class="stat">{{$pendingOrders}}</div>
                                <div class="title">Pending Order</div>
                                <div class="highlight bg-color-gold "></div>
                            </a>
                        </div>

                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history?".'order_status='.\App\Models\Order::RECEIVED)}}" target="_blank">
                                <div class="icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                                <div class="stat">{{$receivedOrders}}</div>
                                <div class="title">Received Order</div>
                                <div class="highlight bg-color-received "></div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history?".'order_status='.\App\Models\Order::SHIPPING)}}" target="_blank">
                                <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                                <div class="stat">{{$shippingOrders}}</div>
                                <div class="title">Shipping Order</div>
                                <div class="highlight bg-color-shipping "></div>
                            </a>
                        </div>

                        <div class="col-sm-2 col-xs-6 tile" onclick="window.location='javascript:vaid(0)'">
                            <a href="{{URL::to("orders/history?".'order_status='.\App\Models\Order::CANCELLED)}}" target="_blank">
                                <div class="icon"><i class="fa fa-trash " aria-hidden="true"></i></div>
                                <div class="stat">{{$cancelOrders}}</div>
                                <div class="title">Cancelled </div>
                                <div class="highlight bg-color-cancel"></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="header-lined">
                    <h1>My Recent Order </h1>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <td class="text-center">Sl</td>
                                <td class="text-center">Orde Id</td>
                                <td class="text-center">No. of Products</td>
                                <td class="text-center">Total.{{$currency}}</td>
                                <td class="text-center">Order Status</td>
                                <td class="text-center">Payment Status</td>
                                <td class="text-center">Order Date</td>
                                <td class="text-center">Detail</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentOrders as $key=>$recentOrder)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-center">{{$recentOrder->order_id}}</td>
                                <td class="text-center">{{count($recentOrder->cart_items)}}</td>
                                <td class="text-center">{{$currency  }}{{$recentOrder->total}}</td>
                                <td class="text-center">
                                    @if($recentOrder->order_status==\App\Models\Order::COMPLETE)
                                    <button class="btn btn-success btn-sm">{{$recentOrder->order_status}}</button>
                                    @elseif($recentOrder->order_status==\App\Models\Order::SHIPPING)
                                        <button class="btn btn-default btn-sm">{{$recentOrder->order_status}}</button>
                                    @else
                                    <button class="btn btn-warning btn-sm">{{$recentOrder->order_status}}</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($recentOrder->payment_status==\App\Models\Order::PAID)
                                        <button class="btn btn-success btn-sm">{{$recentOrder->payment_status}}</button>
                                    @else
                                        <button class="btn btn-default btn-sm">{{$recentOrder->payment_status}}</button>
                                    @endif
                                </td>

                                <td class="text-center">{{date('M-d-Y',strtotime($recentOrder->created_at))}}</td>
                                <td class="text-center">

                                    {!! Form::open(array('route' => ['orders.remove',$recentOrder->id],'method'=>'DELETE','id'=>"deleteForm$recentOrder->id")) !!}

                                    <a href="{{URL::to('/orders/'.$recentOrder->id)}}" data-toggle="tooltip" title="" class="btn btn-info btn-sm" data-original-title="View Order Details">
                                        <i class="fa fa-eye"></i></a>
                                    @if($recentOrder->payment_status==\App\Models\Order::UNPAID)
                                        <a href="javascript:vaid(0)" onclick='return deleteConfirm("deleteForm{{$recentOrder->id}}")' data-toggle="tooltip" title="" class="btn btn-default btn-sm" data-original-title="Click here to remove order">
                                            <i class="fa fa-trash"></i></a>
                                    @endif
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                                @empty
                            @endforelse
                            </tbody>
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

@section('script')

    <script>
        $(document).ready(function() {


            $('[data-toggle="collapse"]').click(function() {
                $(this).toggleClass( "in" );
                if ($(this).hasClass("collapsed")) {

                    $(this).empty().addClass("fa fa-chevron-up panel-minimise pull-right ");
                } else {
                    $(this).empty().addClass("fa fa-chevron-down panel-minimise pull-right");
                }
            });


// document ready
        });
    </script>

    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>
    @endsection

