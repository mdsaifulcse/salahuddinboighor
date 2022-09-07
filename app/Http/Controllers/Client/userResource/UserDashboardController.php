<?php

namespace App\Http\Controllers\Client\userResource;

use App\Http\Controllers\Controller;
use App\Models\Biggapon;
use App\Models\MostReadNews;
use App\Models\News;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\VisitorTrack;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

use EasyBanglaDate\Types\BnDateTime ;
use DataLoad;


class UserDashboardController extends Controller
{
    public function index()
    {

         $order= Order::filterOrder(auth()->user()->id);
         $totalOrders=$order->count();

         $completeOrders=$order->where('order_status',Order::COMPLETE)->count();
         $pendingOrders=Order::filterOrder(auth()->user()->id, Order::PENDING)->count();
         $receivedOrders=Order::filterOrder(auth()->user()->id, Order::RECEIVED)->count();
         $shippingOrders=Order::filterOrder(auth()->user()->id, Order::SHIPPING)->count();
         $cancelOrders=Order::filterOrder(auth()->user()->id, Order::CANCELLED)->count();

        $recentOrders=Order::where(['user_id'=>auth()->user()->id])->orderBy('created_at', 'DESC')->take(10)->get();
        foreach ($recentOrders as $key=>$recentOrder){
            $recentOrders[$key]['cart_items']=unserialize($recentOrder->cart_items);
        }
        $setting=DataLoad::setting();
        return view('client.user.dashboard',compact('totalOrders','completeOrders','pendingOrders','receivedOrders','shippingOrders','cancelOrders','recentOrders','setting'));
    }



    public function singleProductDetails($productId,$productName=null)
    {
        return view('client.single-product');
    }


}
