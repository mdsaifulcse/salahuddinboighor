<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductInventoryStock;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Sale Return";
        return view('admin.sale-return.index',compact('title'));
    }

    public function getSaleReturnData()
    {
        $allData=PurchaseReturn::leftJoin('vendors','purchase_returns.vendor_id','vendors.id')
            ->leftJoin('product_purchases','purchase_returns.product_purchase_id','product_purchases.id')
            ->select('product_purchases.purchase_no','vendors.name','purchase_returns.*')
            ->orderBy('purchase_returns.id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Return Date','
                    <?php echo date(\'M-d-Y H:i A\',strtotime($return_date)) ;?>
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'product-purchases.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
               
                
                <a href="{{route(\'purchase-return.show\',$id)}}" class="btn btn-info btn-sm" title="Click here to view"><i class="la la-eye"></i> </a>
                
            {!! Form::close() !!}
            ')
            ->rawColumns(['Return Date','action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title='Sale Return';
        $suppliers=DataLoad::vendorList();
        $setting=DataLoad::setting();

        return view('admin.sale-return.create',compact('title','suppliers','setting'));
    }


    public function getOrderDetailData($orderId)
    {
        $order=Order::with('user','user.profile','shippingMethod')->where(['order_id'=>$orderId])->first();

        $cartItems=[];
        if (!empty($order))
        {
            $cartItems= unserialize($order->cart_items);
        }


        $setting=DataLoad::setting();
        return view('admin.sale-return.order-product-info',compact('order','cartItems','setting'));
    }


    public function getCompleteOrderData(Request $request)
    {
        return Order::where(['order_status'=>Order::COMPLETE,'payment_status'=>Order::PAID])
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
            'order_id' => 'required|exists:orders,order_id',
            'total_amount' => 'required|max:999999999',
            'return_amount' => 'required|max:999999999',
            'note' => 'max:400',

        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orderData=Order::where(['order_status'=>Order::COMPLETE,'payment_status'=>Order::PAID])->first();

        if (empty($orderData))
        {
            return redirect()->back()->with('error','No order data found due to order status not complete or payment status unpaid');
        }

        $saleReturnByOrderId=SaleReturn::where(['order_id'=>$orderData->id])->first();

        if (!empty($saleReturnByOrderId)){
            return redirect()->back()->with('error','Already return');
        }

        $returnItemCount=0;
        foreach ($request->return_item_qty as $key=>$returnItemQty) {

            if ($request->return_item_qty[$key]>0){
                $returnItemCount+=1;
            }
        }

        if ($returnItemCount<=0)
        {
            return redirect()->back()->with('error','At Least One Need To Return');
        }

        DB::beginTransaction();
        try{

            $maxId=SaleReturn::max('id')+1;
            $saleReturnNo=SaleReturn::SALERETURNNO+$maxId;
            $saleReturnNo='SR-'.$saleReturnNo;

            $input['sale_return_no']=$saleReturnNo;
            $input['user_id']=$orderData->user_id;
            $input['order_id']=$orderData->id;
            $input['return_date']=Carbon::now();
            $input['created_by']=\Auth::user()->id;

            $saleReturn=SaleReturn::create($input);

            $this->returnItemCreate($request,$saleReturn->id);

            $this->productInventoryStock($request);


            DB::commit();
            return redirect()->back()->with('success','Sale Return Successfully Save');

        }catch(\Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }


    public function returnItemCreate($request,$saleReturnId)
    {
        foreach ($request->return_item_qty as $key=>$returnItemQty) {
            if ($request->return_item_qty[$key]>0){
                $returnItems[$key]=[
                    'sale_return_id'=>$saleReturnId,
                    'product_id'=>$request->product_id[$key],
                    'order_item_qty'=>$request->order_item_qty[$key],
                    'return_item_qty'=>$request->return_item_qty[$key],
                    'sale_price'=>$request->sale_price[$key],
                    'item_total_price'=>$request->sale_price[$key]*$request->return_item_qty[$key],
                    'item_return_price'=>$request->item_return_price[$key],
                ];
            }
        } // --- end foreach
        SaleReturnItem::insert($returnItems);
    }

    public function productInventoryStock($request)
    {
        foreach ($request->return_item_qty as $key=>$returnItemQty) {

            if ($request->return_item_qty[$key]>0){

                $productId=$request->product_id[$key];
                $returnItemQty=$request->return_item_qty[$key];

                $productStock=ProductInventoryStock::where(['product_id'=>$productId])->first();

                $productStock->update(['sold_return_qty'=>$productStock->sold_return_qty+$returnItemQty,'updated_by'=>auth()->user()->id]);
            }
        } // --- end foreach
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title='Sale Return';
        $saleReturn= SaleReturn::with('returnItems','returnItems.product','orderUser','orderUser.profile','order')->findOrFail($id);
        $setting=DataLoad::setting();
        return view('admin.sale-return.show',compact('title','saleReturn','setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleReturn $saleReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleReturn $saleReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleReturn $saleReturn)
    {
        //
    }
}
