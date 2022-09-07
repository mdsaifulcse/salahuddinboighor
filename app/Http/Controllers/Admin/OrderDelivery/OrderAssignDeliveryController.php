<?php

namespace App\Http\Controllers\Admin\OrderDelivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAssignDelivery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class OrderAssignDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title='Order Assign';
        return view('admin.order-assign.index',compact('request','title'));
    }


    public function getOrderAssignData(Request $request)
    {
        $allData=OrderAssignDelivery::with('order','user')->select('order_assign_deliveries.*')
            ->orderBy('order_assign_deliveries.id','desc');

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

                return '<a href="'.url('admin/orders/'.$orderAssignDelivery->order->id).'" target="_blank"  class="btn btn-info btn-sm" title="Click here to view"><i class="la la-eye"></i> </a>';
            })

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'order-assign.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                
                
                <a href="{{route(\'order-assign.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to view"><i class="la la-edit"></i> </a>
                
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                
            {!! Form::close() !!}
            ')
            ->rawColumns(['target_delivery_date','Delivery Status','order_id_no','Assign To','Payment Received','Order Detail','action'])
            ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Order Assign';

        $deliveryStatus=DataLoad::deliveryStatus();

        $maxId=OrderAssignDelivery::max('id')+1;

        $assignNo=OrderAssignDelivery::ASSIGNSTARTNO+$maxId;
        $assignNo='OAN-'.$assignNo;

        $deliveryUser = User::with('profile')->role(['delivery_system'])->where('id','!=',1)->orderBy('id', 'DESC')->pluck('name','id');

        return view('admin.order-assign.create',compact('title','deliveryStatus','assignNo','deliveryUser'));
    }

    public function getOrderDataByOrderId(Request $request)
    {
        return $orders=Order::select('order_id','id')
            ->where('order_id', 'like', '%' .$request->q. '%')->pluck('order_id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'assign_no' => 'required|unique:order_assign_deliveries,assign_no,NULL,id,deleted_at,NULL',
            'order_id_no' => 'required',
            'user_id' => 'required|exists:users,id',
            'target_delivery_date' => 'required',
            'target_delivery_time' => 'required',
            'note' => 'nullable|max:400',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $order=Order::where(['order_id'=>$request->order_id_no])->first();

        if (empty($order))
        {
            return redirect()->back()->with('error','Error, Order Not Found');
        }


        $assignOrder=OrderAssignDelivery::where(['order_id'=>$order->id])->first(); // search order primary key ---

        if (!empty($assignOrder))
        {
            return redirect()->back()->with('error','Error, Order Already Assign');
        }


        DB::beginTransaction();
        try{

            if ($order->payment_gateway==Order::PAYMENT_GATEWAY)
            {
                $input['receive_from_delivery']=OrderAssignDelivery::NO;
            }


            $input['order_id']=$order->id;
            $input['payment_gateway']=$order->payment_gateway;
            $input['order_amount']=$order->net_total;
            $input['shipping_cost']=$order->shipping_cost;
            $input['created_by']=\Auth::user()->id;


            if (!is_null($request->target_delivery_date))
            {
                $input['target_delivery_date']=date('Y-m-d',strtotime($request->target_delivery_date));
            }

            OrderAssignDelivery::create($input);

            DB::commit();
            return redirect()->back()->with('success','Data Successfully Save');

        }catch(Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderAssignDelivery  $orderAssignDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(OrderAssignDelivery $orderAssignDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderAssignDelivery  $orderAssignDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderAssignDelivery=OrderAssignDelivery::with('order')->findOrFail($id);
        $title='Edit Order Assign';

        $deliveryStatus=DataLoad::deliveryStatus();

        $maxId=OrderAssignDelivery::max('id')+1;

        $deliveryUser = User::with('profile')->role(['delivery_system'])->where('id','!=',1)->orderBy('id', 'DESC')->pluck('name','id');

        $paymentReceivedStatus=[
            OrderAssignDelivery::YES=>OrderAssignDelivery::YES,
            OrderAssignDelivery::NO=>OrderAssignDelivery::NO,
        ];

        return view('admin.order-assign.edit',compact('orderAssignDelivery','title','deliveryStatus','deliveryUser','paymentReceivedStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderAssignDelivery  $orderAssignDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orderAssignDelivery=OrderAssignDelivery::findOrFail($id);

        $validator = Validator::make($request->all(), [

            'assign_no' => "required|unique:order_assign_deliveries,assign_no,$id,id,deleted_at,NULL",
            'order_id_no' => 'required',
            'user_id' => 'required|exists:users,id',
            'target_delivery_date' => 'required',
            'target_delivery_time' => 'required',
            'note' => 'nullable|max:400',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $order=Order::where(['order_id'=>$request->order_id_no])->first();
        if (empty($order))
        {
            return redirect()->back()->with('error','Error, Order Not Found');
        }

        DB::beginTransaction();
        try{

            $input=$request->all();

            $input['receive_from_delivery']=$request->receive_from_delivery;


            $input['order_id']=$order->id;
            $input['payment_gateway']=$order->payment_gateway;
            $input['order_amount']=$order->net_total;
            $input['shipping_cost']=$order->shipping_cost;

            if (!is_null($request->target_delivery_date))
            {
                $input['target_delivery_date']=date('Y-m-d',strtotime($request->target_delivery_date));
            }


            $input['updated_by']=auth()->user()->id;

            $orderAssignDelivery->update($input);

            DB::commit();

            return redirect()->back()->with('success','Data Successfully Update');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderAssignDelivery  $orderAssignDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id )
    {
        $orderAssignDelivery=OrderAssignDelivery::findOrFail($id);
        DB::beginTransaction();
        try{


            $orderAssignDelivery->delete();

            DB::commit();

            return redirect()->back()->with('success','Your Order Successfully Removed');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
