<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad,Session;
use Yajra\DataTables\DataTables;

class FrontendOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setting=DataLoad::setting();
        return view('client.order.order-history',compact('setting','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $allData=Order::where(['user_id'=>auth()->user()->id])->orderBy('created_at', 'DESC')
            ->orderBy('id','desc');


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
                        <button class="btn btn-default btn-sm">{{$payment_status}}</button>
                    @endif
                ')
            ->addColumn('Order Date','
                    {{date(\'M-d-Y h:i A\',strtotime($created_at))}}
                ')
            ->addColumn('Action','
                 {!! Form::open(array(\'route\' => [\'orders.remove\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}

                    <a href="{{URL::to(\'/orders/\'.$id)}}" data-toggle="tooltip" title="" class="btn btn-info btn-sm" data-original-title="View Order Details">
                        <i class="fa fa-eye"></i></a>
                    @if($order_status!=\App\Models\Order::COMPLETE && $payment_status==\App\Models\Order::UNPAID)
                        <a href="#" onclick=\'return deleteConfirm("deleteForm{{$id}}")\' data-toggle="tooltip" title="" class="btn btn-default btn-sm" data-original-title="Click here to remove order">
                            <i class="fa fa-trash"></i></a>
                    @endif
                    {!! Form::close() !!}
            ')
            ->rawColumns(['number_of_product','order_status','payment_status','Order Date','Action'])
            ->toJson();
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
                'address_id' => 'required',
                'billing_name' => 'required_if:address_id,==,other_address|max:100',
                'billing_email' => 'required_if:address_id,==,other_address|email|max:100',
                'billing_phone' => 'required_if:address_id,==,other_address|min:11|max:15',
                'billing_city' => 'required_if:address_id,==,other_address|max:150',
                'billing_post' => 'required_if:address_id,==,other_address|max:150',
                'billing_post_code' => 'required_if:address_id,==,other_address|max:20',
                'billing_street_address' => 'required_if:address_id,==,other_address|max:250',

                'shipping_name' => 'nullable|max:100',
                'shipping_email' => 'nullable|email|max:100',
                'shipping_phone' => 'nullable|min:11|max:15',
                'shipping_city' => 'nullable|max:150',
                'shipping_post' => 'nullable|max:150',
                'shipping_post_code' => 'nullable|max:20',
                'shipping_street_address' => 'nullable|max:220',
                'note' => 'nullable|max:220',
                //'product_id' => 'required|exists:products,id',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
                //return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            $sessionId='';
            if (Session::has('sessionId')) {
                $sessionId = Session::get('sessionId');
            }

            $cartProducts=CartProduct::where(['session_id'=>$sessionId,'type'=>CartProduct::ORDER])->get();

            if (count($cartProducts)<=0){
                return redirect()->back()->with('error','Your Shopping Cart Is Empty');
            }

            if ($request->address_id=='other_address'){

                $userAddress=$this->saveUserAddress($request);
            }else{
                $userAddress=UserAddress::findOrFail($request->address_id);
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
                'order_id'=>Order::latest()->first()?Order::latest()->first()->id+Order::STARTORDERID:1+Order::STARTORDERID,
                'user_id'=>auth()->user()->id,
                'subtotal'=>$subTotal,
                'shipping_cost'=>$shippingCost,
                'vat_tax_amount'=>$totalVatTaxAmount,
                'total'=>$subTotal+$shippingCost+$totalVatTaxAmount,
                'net_total'=>$subTotal+$shippingCost+$totalVatTaxAmount,
                'payment_gateway'=>Order::PAYMENT_GATEWAY,

                'billing_name'=>$userAddress->name,
                'billing_email'=>$userAddress->email,
                'billing_phone'=>$userAddress->phone,
                'billing_city'=>$userAddress->city,
                'billing_post'=>$userAddress->post,
                'billing_post_code'=>$userAddress->post_code,
                'billing_street_address'=>$userAddress->address1,

                'shipping_name'=>$request->shipping_name,
                'shipping_email'=>$request->shipping_email,
                'shipping_phone'=>$request->shipping_phone,
                'shipping_city'=>$userAddress->shipping_city,
                'shipping_post'=>$userAddress->shipping_post,
                'shipping_post_code'=>$userAddress->shipping_post_code,
                'shipping_street_address'=>$request->shipping_street_address,
                'shipping_id'=>$shipping_id,
                'note'=>$request->note,
                'cart_items'=>serialize($cartProducts),
                'created_by'=>auth()->user()->id,
            ];

            if ($request->has('shipping_same_as_billing'))
            {
                $input['shipping_name']=$userAddress->name;
                $input['shipping_email']=$userAddress->email;
                $input['shipping_phone']=$userAddress->phone;
                $input['shipping_city']=$userAddress->city;
                $input['shipping_post']=$userAddress->post;
                $input['shipping_post_code']=$userAddress->post_code;
                $input['shipping_street_address']=$userAddress->address1;
            }


            $orderId=Order::create($input)->id;

            CartProduct::where(['session_id'=>$sessionId,'type'=>CartProduct::ORDER])->delete();

            Session::forget('sessionId');
            DB::commit();

            return redirect('orders/'.$orderId)->with('success','Your Order Successfully Placed');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function saveUserAddress($request){

       return UserAddress::create([
           'user_id'=>auth()->user()->id,
           'name'=>$request->billing_name,
           'email'=>$request->billing_email,
           'phone'=>$request->billing_phone,
           'city'=>$request->billing_city,
           'post'=>$request->billing_post,
           'post_code'=>$request->billing_post_code,
           'address1'=>$request->billing_street_address,
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::with('user','user.profile','shippingMethod')->where(['user_id'=>auth()->user()->id,'id'=>$id])->first();

        if (empty($order))
        {
            return redirect()->back()->with('error','Order Data Not Found !');
        }

        $cartItems= unserialize($order->cart_items);

        $setting=DataLoad::setting();

        return view('client.order.order-details',compact('order','setting','cartItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{

            $order=Order::where(['user_id'=>auth()->user()->id,'id'=>$id])->first();

            if (empty($order))
            {
                return redirect()->back()->with('error','Order Data Not Found !');
            }


            if ($order->payment_status==Order::PAID || $order->order_status==Order::COMPLETE || $order->order_status==Order::SHIPPING)
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
