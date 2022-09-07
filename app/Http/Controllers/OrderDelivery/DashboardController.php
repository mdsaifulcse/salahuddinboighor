<?php

namespace App\Http\Controllers\OrderDelivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAssignDelivery;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today='today';
        $thisMonty='this_month';
        $all='all';
        $userId=auth()->user()->id;

        $todayTotalOrders=OrderAssignDelivery::filterAssignOrder($userId,null,$today)->count();
        $todayPendingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::PENDING,$today)->count();
        $todayReceivedOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::RECEIVED,$today)->count();
        $todayCancelOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::CANCELLED,$today)->count();
        $todayShippingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::SHIPPING,$today)->count();
        $todayCompleteOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::COMPLETE,$today)->count();


        $thisMonthTotalOrders=OrderAssignDelivery::filterAssignOrder($userId,null,$thisMonty)->count();
        $thisMonthPendingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::PENDING,$thisMonty)->count();
        $thisMonthReceivedOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::RECEIVED,$thisMonty)->count();
        $thisMonthCancelOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::CANCELLED,$thisMonty)->count();
        $thisMonthShippingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::SHIPPING,$thisMonty)->count();
        $thisMonthCompleteOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::COMPLETE,$thisMonty)->count();

        $totalOrders=OrderAssignDelivery::filterAssignOrder($userId,null,$all)->count();
        $pendingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::PENDING,$all)->count();
        $receivedOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::RECEIVED,$all)->count();
        $cancelOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::CANCELLED,$all)->count();
        $shippingOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::SHIPPING,$all)->count();
        $completeOrders=OrderAssignDelivery::filterAssignOrder($userId,OrderAssignDelivery::COMPLETE,$all)->count();

        return view('order-delivery.dashboard',compact('todayTotalOrders','todayPendingOrders','todayReceivedOrders','todayCancelOrders','todayShippingOrders','todayCompleteOrders',
            'thisMonthTotalOrders','thisMonthPendingOrders','thisMonthReceivedOrders','thisMonthCancelOrders','thisMonthShippingOrders','thisMonthCompleteOrders',
            'totalOrders','completeOrders','pendingOrders','receivedOrders','shippingOrders','cancelOrders'));
    }



    public function index(Request $request)
    {
        $title='Order Assign';
        return view('order-delivery.index',compact('request','title'));
    }


    public function getOrderAssignData(Request $request)
    {
        $allData=OrderAssignDelivery::with('order','user')->select('order_assign_deliveries.*')
            ->where('user_id',auth()->user()->id)->orderBy('order_assign_deliveries.id','desc');

        if ($request->has('today') && $request->today==1)
        {
            $allData=$allData->whereDate('created_at',Carbon::today());

        }

        if ($request->has('this_month') && $request->this_month==1)
        {
            $allData=$allData->whereDate('created_at','>=',Carbon::now()->startOfMonth()->subMonth(0));

        }

        if ($request->has('delivery_status') && !is_null($request->delivery_status))
        {
            $allData=$allData->where(['delivery_status'=>$request->delivery_status]);
        }


        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')

            ->addColumn('order_id_no',function (OrderAssignDelivery $orderAssignDelivery){
                return $orderAssignDelivery->order->order_id;
            })
            ->addColumn('Delivery Status','
                    @if($delivery_status==\App\Models\OrderAssignDelivery::COMPLETE)
                        <button class="btn btn-success btn-sm">{{$delivery_status}}</button>
                        
                         @elseif($delivery_status==\App\Models\OrderAssignDelivery::CANCELLED)
                            <button class="btn btn-danger btn-sm">{{$delivery_status}}</button>
                            
                            @elseif($delivery_status==\App\Models\OrderAssignDelivery::RECEIVED)
                            <button class="btn btn-info btn-sm">{{$delivery_status}}</button>
                            
                            @elseif($delivery_status==\App\Models\OrderAssignDelivery::SHIPPING)
                            <button class="btn btn-info btn-sm">{{$delivery_status}}</button>
                            
                            @else
                            <button class="btn btn-warning btn-sm">{{$delivery_status}}</button>
                        @endif
                ')
            ->addColumn('Payment Received','
                    @if($receive_from_delivery==\App\Models\OrderAssignDelivery::YES)
                        <button class="btn btn-success btn-sm">{{$receive_from_delivery}}</button>
                      
                            @else
                            <button class="btn btn-warning btn-sm">{{$receive_from_delivery}}</button>
                        @endif
                ')

            ->addColumn('target_delivery_date','
                    <?php echo date(\'M/d/Y\',strtotime($target_delivery_date)) ;?>
                ')
            ->addColumn('Assign To',function (OrderAssignDelivery $orderAssignDelivery){
                return $orderAssignDelivery->user->name;
            })
            ->addColumn('Order Detail',function (OrderAssignDelivery $orderAssignDelivery){

                return '<a href="'.url('order-delivery/order-detail/'.$orderAssignDelivery->order->id).'" target="_blank"  class="btn btn-info btn-sm" title="Click here to view & print order details"><i class="la la-eye"></i> </a>';
            })

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'order-assign.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                
                
                <a href="{{url(\'order-delivery/order-assign-to-me-show/\'.$id)}}" class="btn btn-warning btn-sm" title="Click here to view"><i class="la la-edit"></i> </a>
                
               
                </button>
                
            {!! Form::close() !!}
            ')
            ->rawColumns(['target_delivery_date','Delivery Status','order_id_no','Assign To','Payment Received','Order Detail','action'])
            ->toJson();

    }


    public function changeDeliveryStatus($id)
    {
        $orderAssignDelivery=OrderAssignDelivery::with('order')->where(['id'=>$id,'user_id'=>auth()->user()->id])->first();
        if (empty($orderAssignDelivery))
        {
            return redirect()->back()->with('error','Data Not Found');
        }
        $title='Update Delivery Status';

        $deliveryStatus=DataLoad::deliveryStatus();

        $maxId=OrderAssignDelivery::max('id')+1;


        return view('order-delivery.update-delivery-status',compact('orderAssignDelivery','title','deliveryStatus'));

    }

    public function updateDeliveryStatus(Request $request)
    {

        $id=$request->id;
        $orderAssignDelivery=OrderAssignDelivery::where(['id'=>$id,'user_id'=>auth()->user()->id])->first();

        if (empty($orderAssignDelivery))
        {
            return redirect()->back()->with('error','Data Not Found');
        }

        $validator = Validator::make($request->all(), [
            'delivery_status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try{


            $orderAssignDelivery->update(['delivery_status'=>$request->delivery_status,'updated_by'=>auth()->user()->id]);

            DB::commit();

            return redirect()->back()->with('success','Data Successfully Update');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }




}
