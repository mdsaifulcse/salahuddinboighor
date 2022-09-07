<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductInventoryStock;
use App\Models\ProductPurchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItems;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;


class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Purchase Return";
        return view('admin.purchase-return.index',compact('title'));
    }

    public function getPurchaseReturnData()
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
        $title='Purchase Return';
        $suppliers=DataLoad::vendorList();
        $setting=DataLoad::setting();

        return view('admin.purchase-return.create',compact('title','suppliers','setting'));
    }

    public function getPurchaseInfoByPurchaseId($purchaseId)
    {
        $productPurchase= ProductPurchase::with('purchaseItem','purchaseItem.product','purchaseItem.product.productStock')->findOrFail($purchaseId);
        $setting=DataLoad::setting();
        $vendorTotalDue=DataLoad::vendorRemainingDueCalculation($productPurchase->vendor_id);
        return view('admin.purchase-return.purchase-product-info',compact('productPurchase','setting','vendorTotalDue'));
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
            'vendor_id' => 'required|exists:vendors,id',
            'product_purchase_id' => 'required|exists:product_purchases,id',
            'note' => 'max:400',

        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       $purchaseReturn=PurchaseReturn::where(['product_purchase_id'=>$request->product_purchase_id])->first();

        if (!empty($purchaseReturn)){
            return redirect()->back()->with('error','Already return');
        }

        $returnItem=0;
        foreach ($request->return_item_qty as $key=>$returnItemQty) {

            if ($request->return_item_qty[$key]>0){
                $returnItem+=1;
            }
        }

        if ($returnItem<=0)
        {
            return redirect()->back()->with('error','At Least One Item Need To Return');
        }

        DB::beginTransaction();
        try{

            $maxId=PurchaseReturn::max('id')+1;
            $purchaseReturnNo=PurchaseReturn::PURCHASERETURNNO+$maxId;
            $purchaseReturnNo='PR-'.$purchaseReturnNo;

            $input['created_by']=\Auth::user()->id;
            $input['purchase_return_no']=$purchaseReturnNo;
            $input['return_date']=Carbon::now();


            //return $request;
            $vendorTotalDue=DataLoad::vendorRemainingDueCalculation($request->vendor_id);
            $totalAmount=0;
            $returnAmount=0;
            $dueAfterReturn=0;

            foreach ($request->return_item_qty as $key=>$returnItemQty) {

                $totalAmount+=$request->item_total_price[$key];
                //return $request->return_item_qty[$key];

               if ($request->return_item_qty[$key]>0){
                   $returnAmount+=$request->item_return_price[$key];
               }

            } // --- end foreach

            $input['total_amount']=$totalAmount;
            $input['return_amount']=$returnAmount;
            $input['vendor_total_due']=$vendorTotalDue;
            $input['due_after_return']=$vendorTotalDue-$returnAmount;

            $purchaseReturn=PurchaseReturn::create($input);

            $this->returnItemCreate($request,$purchaseReturn->id);

            $this->productInventoryStock($request);

            $updateVendorTotalDue=Vendor::where(['id'=>$request->vendor_id])->first();

            $updateVendorTotalDue->update(['total_due'=>$updateVendorTotalDue->total_due-$purchaseReturn->return_amount]);


            DB::commit();
            return redirect()->back()->with('success','Purchase Return Successfully Save');

        }catch(\Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }


    public function returnItemCreate($request,$purchaseReturnId)
    {
        foreach ($request->return_item_qty as $key=>$returnItemQty) {
            if ($request->return_item_qty[$key]>0){
                $returnItems[$key]=[
                    'purchase_return_id'=>$purchaseReturnId,
                    'product_id'=>$request->product_id[$key],
                    'invoice_item_qty'=>$request->invoice_item_qty[$key],
                    'balance_item_qty'=>$request->balance_item_qty[$key],
                    'return_item_qty'=>$request->return_item_qty[$key],
                    'cost_price'=>$request->cost_price[$key],
                    'item_total_price'=>$request->cost_price[$key]*$request->return_item_qty[$key],
                    'item_return_price'=>$request->item_return_price[$key],
                ];
            }
        } // --- end foreach
        PurchaseReturnItems::insert($returnItems);
    }

    public function productInventoryStock($request)
    {
        foreach ($request->return_item_qty as $key=>$returnItemQty) {

            if ($request->return_item_qty[$key]>0){

                $productId=$request->product_id[$key];
                $returnItemQty=$request->return_item_qty[$key];

                $productStock=ProductInventoryStock::where(['product_id'=>$productId])->first();

                $productStock->update(['purchase_return_qty'=>$productStock->purchase_return_qty+$returnItemQty,'updated_by'=>auth()->user()->id]);
            }
        } // --- end foreach
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title='Purchase Return';
        $purchaseReturn= PurchaseReturn::with('productPurchase','returnItems','returnItems.product','vendor')->findOrFail($id);
        $setting=DataLoad::setting();
        $vendorTotalDue=DataLoad::vendorRemainingDueCalculation($purchaseReturn->vendor_id);
        return view('admin.purchase-return.show',compact('title','purchaseReturn','setting','vendorTotalDue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        //
    }
}
