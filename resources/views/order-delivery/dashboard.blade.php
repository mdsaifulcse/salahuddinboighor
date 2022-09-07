@extends('layouts.vmsapp')
@section('title')
    Delivery System Dashboard
@endsection

@section('content')
    <style>
        .pending{
            color: #ffd185;
        }
        .received{
            color: #49ff8d;
        }
        .cancel{
            color: #ff163d;
        }
        .shipping{
            color: #bbc2ff;
        }
        .complete{
            color: #3b79ff;
        }
        .total{
            color: #000000;
        }

        .kt-widget17__item{
            text-align:center;
        }

    </style>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">   Delivery System Dashboard</h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    {{--<span class="kt-subheader__desc">#XRS-45670</span>--}}
                    {{--<a href="#" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">--}}
                        {{--Add New--}}
                    {{--</a>--}}
                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                        <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="flaticon2-search-1"></i></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

                    <!--begin:: Widgets/Activity-->
                    <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                        <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Today ({{date('D-M-Y')}}) Order Delivery Summery
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-widget17">
                                <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
                                    <div class="kt-widget17__chart" style="height:140px;">
                                        <canvas id="kt_chart_activities"></canvas>
                                    </div>
                                </div>
                                <div class="kt-widget17__stats">

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::PENDING)}}" target="_blank">
                                                <span class="kt-widget17__icon">
                                                <i class="la la-hourglass-2 la-2x pending"></i>
                                            </span>
                                                <span class="kt-widget17__subtitle">
                                                Pending Orders
                                            </span>
                                                <span class="kt-widget17__desc">
                                                {{$todayPendingOrders}}
                                            </span>
                                            </a>
                                        </div>
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::RECEIVED)}}" target="_blank">
                                            <span class="kt-widget17__icon">
                                                <i class="la la-heart-o la-2x received"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Received Order
                                            </span>
                                            <span class="kt-widget17__desc">
                                                {{$todayReceivedOrders}}
                                            </span>
                                            </a>
                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::CANCELLED)}}" target="_blank">
															<span class="kt-widget17__icon">
																<i class="la la-times la-2x cancel"></i>
																</svg> </span>
                                            <span class="kt-widget17__subtitle">
																Cancel Order
															</span>
                                            <span class="kt-widget17__desc">
																{{$todayCancelOrders}}
															</span>
                                            </a>
                                        </div>

                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::SHIPPING)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-truck 2x shipping"></i>
                                                             </span>
                                            <span class="kt-widget17__subtitle">
																Shipping Order
															</span>
                                            <span class="kt-widget17__desc">
                                                                {{$todayShippingOrders}}
															</span>
                                            </a>

                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::COMPLETE)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-check-square-o 2x complete"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Complete
															</span>
                                            <span class="kt-widget17__desc">
																{{$todayCompleteOrders}}
															</span>
                                            </a>
                                        </div>

                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'today=1')}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-archive 2x total"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Total
															</span>
                                            <span class="kt-widget17__desc">
																{{$todayTotalOrders}}
															</span>
                                            </a>
                                        </div>

                                    </div> <!-- ned kt-widget17__items -->

                                </div>
                            </div>
                        </div>

                    </div>

                    <!--end:: Widgets/Activity-->
                </div>

                <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

                    <!--begin:: Widgets/Activity-->
                    <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                        <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    This Month ({{date('M-Y')}}) Order Delivery Summery
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-widget17">
                                <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #16d900">
                                    <div class="kt-widget17__chart" style="height:140px;">
                                        <canvas id="kt_chart_activities"></canvas>
                                    </div>
                                </div>
                                <div class="kt-widget17__stats">

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::PENDING)}}" target="_blank">
                                            <span class="kt-widget17__icon">
                                                <i class="la la-hourglass-2 la-2x pending"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                    Pending Orders
                                                </span>
                                            <span class="kt-widget17__desc">
																{{$thisMonthPendingOrders}}
															</span>
                                            </a>
                                        </div>
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::RECEIVED)}}" target="_blank">
															<span class="kt-widget17__icon">
																<i class="la la-heart-o la-2x received"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Received Order
															</span>
                                            <span class="kt-widget17__desc">
																{{$thisMonthReceivedOrders}}
															</span>
                                            </a>
                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::CANCELLED)}}" target="_blank">
															<span class="kt-widget17__icon">
																<i class="la la-times la-2x cancel"></i>
                                                                </svg> </span>
                                            <span class="kt-widget17__subtitle">
																Cancel Order
															</span>
                                            <span class="kt-widget17__desc">
																{{$thisMonthReceivedOrders}}
															</span>
                                            </a>
                                        </div>
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::SHIPPING)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-truck 2x shipping"></i>
                                                             </span>
                                            <span class="kt-widget17__subtitle">
																Shipping Order
															</span>
                                            <span class="kt-widget17__desc">
                                                                {{$thisMonthShippingOrders}}
															</span>
                                            </a>
                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1'.'&delivery_status='.\App\Models\OrderAssignDelivery::COMPLETE)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-check-square-o 2x complete"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Complete
															</span>
                                            <span class="kt-widget17__desc">
																{{$thisMonthCompleteOrders}}
															</span>
                                            </a>
                                        </div>

                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'this_month=1')}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-archive 2x total"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Total
															</span>
                                            <span class="kt-widget17__desc">
																{{$thisMonthTotalOrders}}
															</span>
                                            </a>
                                        </div>

                                    </div> <!-- ned kt-widget17__items -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Activity-->
                </div>

                <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

                    <!--begin:: Widgets/Activity-->
                    <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                        <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Total Order Delivery Summery
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-widget17">
                                <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #69b3fd">
                                    <div class="kt-widget17__chart" style="height:140px;">
                                        <canvas id="kt_chart_activities"></canvas>
                                    </div>
                                </div>
                                <div class="kt-widget17__stats">

                                    <div class="kt-widget17__items">

                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'delivery_status='.\App\Models\OrderAssignDelivery::PENDING)}}" target="_blank">
                                            <span class="kt-widget17__icon">
                                                <i class="la la-hourglass-2 la-2x pending"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                    Pending Orders
                                                </span>
                                            <span class="kt-widget17__desc">
															{{$pendingOrders}}
															</span>
                                            </a>
                                        </div>

                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'delivery_status='.\App\Models\OrderAssignDelivery::RECEIVED)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-heart-o la-2x received"></i>
                                                              </span>
                                            <span class="kt-widget17__subtitle">
																Received Order
															</span>
                                            <span class="kt-widget17__desc">
																{{$receivedOrders}}
															</span>
                                            </a>
                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'delivery_status='.\App\Models\OrderAssignDelivery::CANCELLED)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                            <i class="la la-times la-2x cancel"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Cancel Order
															</span>
                                            <span class="kt-widget17__desc">
																{{$cancelOrders}}
															</span>
                                            </a>
                                        </div>
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'delivery_status='.\App\Models\OrderAssignDelivery::SHIPPING)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                 <i class="la la-truck 2x shipping"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Shipping Order
															</span>
                                            <span class="kt-widget17__desc">
                                                                {{$shippingOrders}}
															</span>
                                            </a>
                                        </div>
                                    </div> <!-- ned kt-widget17__items -->

                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/order-assign?".'delivery_status='.\App\Models\OrderAssignDelivery::COMPLETE)}}" target="_blank">
															<span class="kt-widget17__icon">
                                                                <i class="la la-check-square-o 2x complete"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Complete
															</span>
                                            <span class="kt-widget17__desc">
																{{$completeOrders}}
															</span>
                                            </a>
                                        </div>
                                        <div class="kt-widget17__item">
                                            <a href="{{URL::to("admin/orders")}}" target="_blank">
															<span class="kt-widget17__icon">
                                                           <i class="la la-archive 2x total"></i>
                                                            </span>
                                            <span class="kt-widget17__subtitle">
																Total
															</span>
                                            <span class="kt-widget17__desc">
																{{$totalOrders}}
															</span>
                                            </a>
                                        </div>

                                    </div> <!-- ned kt-widget17__items -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Activity-->
                </div>

            </div>

            <!--End::Row-->

            <!--Begin::Row-->


            <!--End::Row-->

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    @endsection