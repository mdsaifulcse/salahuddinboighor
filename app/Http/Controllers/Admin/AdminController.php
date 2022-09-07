<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VisitorTrack;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today='today';
        $thisMonty='this_month';
        $all='all';

        $todayTotalOrders=Order::filterOrder(null,null,$today)->count();

        $todayPendingOrders=Order::filterOrder(null,Order::PENDING,$today)->count();
        $todayReceivedOrders=Order::filterOrder(null,Order::RECEIVED,$today)->count();
        $todayCancelOrders=Order::filterOrder(null,Order::CANCELLED,$today)->count();
        $todayShippingOrders=Order::filterOrder(null,Order::SHIPPING,$today)->count();
        $todayCompleteOrders=Order::filterOrder(null,Order::COMPLETE,$today)->count();


        $thisMonthTotalOrders=Order::filterOrder(null,null,$thisMonty)->count();

        $thisMonthPendingOrders=Order::filterOrder(null,Order::PENDING,$thisMonty)->count();
        $thisMonthReceivedOrders=Order::filterOrder(null,Order::RECEIVED,$thisMonty)->count();
        $thisMonthCancelOrders=Order::filterOrder(null,Order::CANCELLED,$thisMonty)->count();
        $thisMonthShippingOrders=Order::filterOrder(null,Order::SHIPPING,$thisMonty)->count();
        $thisMonthCompleteOrders=Order::filterOrder(null,Order::COMPLETE,$thisMonty)->count();

        $totalOrders=Order::filterOrder(null,null,$all)->count();
        $pendingOrders=Order::filterOrder(null,Order::PENDING,$all)->count();
        $receivedOrders=Order::filterOrder(null,Order::RECEIVED,$all)->count();
        $cancelOrders=Order::filterOrder(null,Order::CANCELLED,$all)->count();
        $shippingOrders=Order::filterOrder(null,Order::SHIPPING,$all)->count();
        $completeOrders=Order::filterOrder(null,Order::COMPLETE,$all)->count();

        return view('admin.dashboard',compact('todayTotalOrders','todayPendingOrders','todayReceivedOrders','todayCancelOrders','todayShippingOrders','todayCompleteOrders',
            'thisMonthTotalOrders','thisMonthPendingOrders','thisMonthReceivedOrders','thisMonthCancelOrders','thisMonthShippingOrders','thisMonthCompleteOrders',
            'totalOrders','completeOrders','pendingOrders','receivedOrders','shippingOrders','cancelOrders'));
    }
}
