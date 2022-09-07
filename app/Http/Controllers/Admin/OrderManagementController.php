<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderAssignDelivery;
use App\Models\OrderInvoice;
use App\Models\ProductInventoryStock;
use App\Models\ShippingMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setting=DataLoad::setting();
        return view('admin.orders.history',compact('request','setting')); //,'today','thisMonth','orderStatus','paymentStatus'
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $allData=Order::with('user')->orderBy('orders.created_at', 'DESC');

        if ($request->has('today') && $request->today==1)
        {
            $allData=$allData->whereDate('created_at',Carbon::today());

        }

        if ($request->has('this_month') && $request->this_month==1)
        {
            $allData=$allData->whereDate('created_at','>=',Carbon::now()->startOfMonth()->subMonth(0));

        }

        if ($request->has('order_status') && !is_null($request->order_status))
        {
            $allData=$allData->where(['order_status'=>$request->order_status]);
        }

        if ($request->has('payment_status') && !is_null($request->payment_status))
        {
            $allData=$allData->where(['payment_status'=>$request->payment_status]);
        }

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Order_by',function (Order $order){
                return $order->user->name;
            })
            ->addColumn('Mobile',function (Order $order){
                return $order->user->mobile;
            })
            ->addColumn('number_of_product','
                     <?php echo count(unserialize($cart_items))?>
                ')
            ->addColumn('order_status','
                     @if($order_status==\App\Models\Order::COMPLETE)
                        <button class="btn btn-success btn-sm">{{$order_status}}</button>
                         @elseif($order_status==\App\Models\Order::PENDING)
                            <button class="btn btn-warning btn-sm">{{$order_status}}</button>
                            @else
                            <button class="btn btn-default btn-sm">{{$order_status}}</button>
                        @endif
                ')
            ->addColumn('payment_status','
                    @if($payment_status==\App\Models\Order::PAID)
                        <button class="btn btn-success btn-sm">{{$payment_status}}</button>
                    @else
                        <button class="btn btn-warning btn-sm">{{$payment_status}}</button>
                    @endif
                ')
            ->addColumn('Order Date','
                    {{date(\'M-d-Y h:i A\',strtotime($created_at))}}
                ')
            ->addColumn('Action','
                 {!! Form::open(array(\'route\' => [\'admin.orders.remove\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}

                    <a href="{{URL::to(\'/admin/orders/\'.$id)}}" class="btn btn-primary btn-sm" title="View Order Details">
                        <i class="fa fa-eye"></i></a>
                        
                    <a href="{{URL::to(\'/admin/orders/edit/\'.$id)}}" class="btn btn-warning btn-sm" title="Click here to Change Order Status">
                    <i class="la la-edit"></i></a>
                        
                    @if($order_status!=\App\Models\Order::COMPLETE)
                        <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}")\' title="Click here to remove order" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i></button>
                    @endif
                {!! Form::close() !!}
            ')
            ->rawColumns(['Order_by','Mobile','number_of_product','order_status','payment_status','Order Date','Action'])
            ->toJson();
    }


    public function orderSearch(Request $request)
    {

        $setting=DataLoad::setting();
        $orderStatuses=[
            Order::PENDING=>Order::PENDING,
            Order::CANCELLED=>Order::CANCELLED,
            Order::RECEIVED=>Order::RECEIVED,
            Order::SHIPPING=>Order::SHIPPING,
            Order::COMPLETE=>Order::COMPLETE,
        ];
        $paymentStatuses=[
            Order::PAID=>Order::PAID,
            Order::UNPAID=>Order::UNPAID,
        ];

        //return $request;

        $orders=[];

        if (count($request->all()) > 1)
        {

            $orders=Order::with('user');

            if ( !is_null($request->date_start) && !is_null($request->date_end))
            {

                $date_start=date('Y-m-d',strtotime($request->date_start));
                $date_end=date('Y-m-d',strtotime($request->date_end));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s',"$date_start 00:00:00")->format('Y-m-d H:i:s');
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s',"$date_end 23:59:59")->format('Y-m-d H:i:s');

                $orders=$orders->whereBetween('created_at',[$date_start,$date_end]);

            }elseif(!is_null($request->date_start))
            {
                $date_start=date('Y-m-d',strtotime($request->date_start));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s',"$date_start 00:00:00")->format('Y-m-d H:i:s');

                $orders=$orders->whereDate('created_at','>=',$date_start);

            }elseif(!is_null($request->date_end))
            {
                $date_end=date('Y-m-d',strtotime($request->date_end));
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s',"$date_end 00:00:00")->format('Y-m-d H:i:s');

                $orders=$orders->whereDate('created_at','<=',$date_end);

            }


            if ($request->has('order_status') && !is_null($request->order_status))
            {
                $orders=$orders->where(['order_status'=>$request->order_status]);
            }


            if ($request->has('payment_status') && !is_null($request->payment_status))
            {
                $orders=$orders->where(['payment_status'=>$request->payment_status]);
            }

            $orders=$orders->orderBy('orders.created_at', 'DESC')->get();
        }


        return view('admin.orders.order-filter.create',compact('setting','orderStatuses','orders','paymentStatuses','request'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                'billing_name' => 'required|max:100',
                'billing_email' => 'required|email|max:100',
                'billing_phone' => 'required|min:11|max:15',
                'billing_street_address' => 'required|max:220',

                'shipping_name' => 'nullable|max:100',
                'shipping_email' => 'nullable|email|max:100',
                'shipping_phone' => 'nullable|min:11|max:15',
                'shipping_street_address' => 'nullable|max:220',
                'note' => 'nullable|max:220',
                //'product_id' => 'required|exists:products,id',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            $cartProducts=CartProduct::where(['user_id'=>auth()->user()->id])->get();



            if (count($cartProducts)<0){
                return redirect()->back()->with('error','Your Shopping Cart Is Empty');
            }

            $shipping_id=Null;
            $shippingCost=0;
            $shippingCost=0;
            $itemAmount=0;
            $subTotal=0;
            $totalAmount=0;
            $vatTaxPercent=0;
            $vatTaxAmount=0;
            $totalVatTaxAmount=0;

            foreach ($cartProducts as $key=>$cartProduct){
                $itemAmount=$cartProduct->price*$cartProduct->qty;
                $subTotal+=$itemAmount;

                if ($cartProduct->product->productVatTax)
                {
                    $vatTaxPercent=$cartProduct->product->productVatTax->vat_tax_percent;
                    $vatTaxAmount=($itemAmount*$vatTaxPercent)/100;
                }
                $totalVatTaxAmount+=$vatTaxAmount;

                $cartProducts[$key]['vat_tax_percent']= $vatTaxPercent;
                $cartProducts[$key]['vat_tax_amount']= $vatTaxAmount;
            }


            $shippingMethod=ShippingMethod::find($request->shipping_method_id);

            if (!empty($shippingMethod))
            {
                $shippingCost=$shippingMethod->cost;
                $shipping_id=$shippingMethod->id;
            }


            $input=[
                'user_id'=>auth()->user()->id,
                'subtotal'=>$subTotal,
                'shipping_cost'=>$shippingCost,
                'vat_tax_amount'=>$totalVatTaxAmount,
                'total'=>$subTotal+$shippingCost+$totalVatTaxAmount,
                'payment_gateway'=>Order::PAYMENT_GATEWAY,

                'billing_name'=>$request->billing_name,
                'billing_email'=>$request->billing_email,
                'billing_phone'=>$request->billing_phone,
                'billing_street_address'=>$request->billing_street_address,

                'shipping_name'=>$request->shipping_name,
                'shipping_email'=>$request->shipping_email,
                'shipping_phone'=>$request->shipping_phone,
                'shipping_street_address'=>$request->shipping_street_address,
                'shipping_id'=>$shipping_id,
                'note'=>$request->note,
                'cart_items'=>serialize($cartProducts),
                'created_by'=>auth()->user()->id,

            ];

            if ($request->has('shipping_same_as_billing'))
            {
                $input['shipping_name']=$request->billing_name;
                $input['shipping_email']=$request->billing_email;
                $input['shipping_phone']=$request->billing_phone;
                $input['shipping_street_address']=$request->billing_street_address;
            }
            $orderId=Order::create($input)->id;

            //CartProduct::where(['user_id'=>auth()->user()->id])->delete();

            DB::commit();

            return redirect('orders/'.$orderId)->with('success','Your Order Successfully Saved');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::with('user','user.profile','shippingMethod')->where(['id'=>$id])->first();

        if (empty($order))
        {
            return redirect()->back()->with('error','Order Data Not Found !');
        }

        $cartItems= unserialize($order->cart_items);

        $setting=DataLoad::setting();

        return view('admin.orders.details',compact('order','setting','cartItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::with('user','user.profile','shippingMethod')->where(['id'=>$id])->first();

        if (empty($order))
        {
            return redirect()->back()->with('error','Order Data Not Found !');
        }


        $discountByUserDiscountPercent=0;
        if ($order->user->profile->discount_percent>0)
        {
            $discountByUserDiscountPercent=ceil( ($order->total*$order->user->profile->discount_percent)/100);
        }

        $cartProducts= unserialize($order->cart_items);


        $setting=DataLoad::setting();
        return view('admin.orders.edit',compact('order','cartProducts','setting','discountByUserDiscountPercent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $order=Order::findOrFail($id);
        DB::beginTransaction();
        try{
            //return $request;
            $validator = Validator::make($request->all(), [
                'billing_name' => 'required|max:100',
                'billing_email' => 'required|email|max:100',
                'billing_phone' => 'required|min:11|max:15',
                'billing_street_address' => 'required|max:220',

                'shipping_name' => 'nullable|max:100',
                'shipping_email' => 'nullable|email|max:100',
                'shipping_phone' => 'nullable|min:11|max:15',
                'shipping_street_address' => 'nullable|max:220',
                'note' => 'nullable|max:220',
                'coupon_discount' => 'max:9999999',
                'payment_status' => 'required|in:'.Order::PAID.','.Order::UNPAID,
                'order_status' => 'required|in:'.Order::PENDING.','.Order::RECEIVED.','.Order::COMPLETE.','.Order::SHIPPING.','.Order::CANCELLED,
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $cartProducts= unserialize($order->cart_items);
            if (count($cartProducts)<0)
            {
                return redirect()->back()->with('error','Order Product Item Is Empty');
            }

            $input=$request->all();

            if ($this->checkStockInventoryChangeAble($request,$order))
            {
                $input['payment_date']=Carbon::now();
                $input['delivery_date']=Carbon::now();
                foreach ($cartProducts as $cartProduct)
                {
                    $inventoryStock=ProductInventoryStock::where('product_id',$cartProduct->product_id)->first();
                    $inventoryStock->update(['sold_qty'=>$inventoryStock->sold_qty+$cartProduct->qty,'updated_by'=>auth()->user()->id]);
                }
            }

            $netTotal=$order->total-$request->coupon_discount;
            $input['net_total']=$netTotal;
            $input['total_pay']=$netTotal;

            $input['updated_by']=auth()->user()->id;

            $order->update($input);


            $this->updateDeliveryInfo($id,$request->payment_status,$request->order_status);
            $this->orderSaleInvoiceGenerate($order,$request->payment_status,$request->order_status);


            DB::commit();

            return redirect('admin/orders/'.$id)->with('success','Order Action Successful Change');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function checkStockInventoryChangeAble($request,$order){
        if (($order->order_status!=Order::COMPLETE || $order->payment_status!=Order::PAID)
            && ($request->order_status==Order::COMPLETE && $request->payment_status==Order::PAID))
        {
            return true;
        }else{
            return false;
        }
    }

    public function updateDeliveryInfo($orderPrimaryId,$paymentStatus,$orderStatus)
    {
        $orderAssignDelivery=OrderAssignDelivery::where(['order_id'=>$orderPrimaryId])->first();

        if (!empty($orderAssignDelivery))
        {
            if ($paymentStatus==Order::PAID) {
                $orderAssignDelivery->update(['receive_from_delivery' => OrderAssignDelivery::YES]);
            }


            if ($orderStatus==Order::COMPLETE) {
                $orderAssignDelivery->update(['delivery_status' => OrderAssignDelivery::COMPLETE]);
            }
        }
    }



    public function orderSaleInvoiceGenerate($order,$paymentStatus,$orderStatus)
    {

        $orderInvoiceByOrderId=OrderInvoice::where(['order_id'=>$order->id])->first();

        if (empty($orderInvoiceByOrderId) && ($paymentStatus==Order::PAID && $orderStatus==Order::COMPLETE))
        {
            $quantity=unserialize($order->cart_items);
            $quantity=count($quantity);

            $invoiceNo=OrderInvoice::INVOICESTART;
            $invoiceNo+=$order->order_id;

            OrderInvoice::create([
                'invoice_no'=>$invoiceNo,
                'user_id'=>$order->user_id,
                'order_id'=>$order->id,
                'shipping_id'=>$order->shipping_id,
                'quantity'=>$quantity,
                'subtotal'=>$order->subtotal,
                'coupon_discount'=>$order->coupon_discount,
                'shipping_cost'=>$order->shipping_cost,
                'vat_tax_percent'=>$order->vat_tax_percent,
                'vat_tax_amount'=>$order->vat_tax_amount,
                'total'=>$order->total,
                'net_total'=>$order->net_total,
                'total_pay'=>$order->total_pay,
                'tender_pay'=>$order->tender_pay,
                'change_amount'=>$order->change_amount,
                'order_status'=>Order::COMPLETE,
                'payment_status'=>Order::PAID,
                'shipping_status'=>Order::COMPLETE,
                'transaction_id'=>$order->transaction_id,
                'payment_track'=>$order->payment_track,
                'payment_gateway'=>$order->payment_gateway,
                'payment_type'=>$order->payment_type,
                'note'=>$order->note,
                'coupon_code'=>$order->coupon_code,
                'invoice_type'=>$order->invoice_type,
                'created_by'=>auth()->user()->id,
                'updated_by'=>auth()->user()->id,
            ]);

        }
    }


    /**
     *
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{

            $order=Order::where(['id'=>$id])->first();

            if (empty($order))
            {
                return redirect()->back()->with('error','Order Data Not Found !');
            }

            //$order->payment_status==Order::PAID ||
            if ( $order->order_status==Order::COMPLETE || $order->order_status==Order::SHIPPING)
            {
                return redirect()->back()->with('error','Sorry,You can not delete this, due to Order on '.$order->order_status);
            }

            $order->update(['updated_at'=>auth()->user()->id]);
            $order->delete();

            DB::commit();

            return redirect()->back()->with('success','Your Order Successfully Removed');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }



}
