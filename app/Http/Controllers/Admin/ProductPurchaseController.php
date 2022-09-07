<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductInventoryStock;
use App\Models\ProductPurchase;
use App\Models\TmpProductPurchase;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;


class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Purchase List';
        return view('admin.purchase.index',compact('title'));
    }

    public function getProductPurchaseData()
    {

        $allData=ProductPurchase::leftJoin('vendors','product_purchases.vendor_id','vendors.id')
            ->select('product_purchases.id','product_purchases.purchase_no','product_purchases.sub_total','product_purchases.discount',
                'product_purchases.net_total','product_purchases.due_date','vendors.name')
            ->orderBy('product_purchases.id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Due Date','
                    <?php echo date(\'M-d-Y H:i A\',strtotime($due_date)) ;?>
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'product-purchases.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                 @can(\'product-purchase-edit\')
                <a href="{{route(\'product-purchases.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                @endcan
                
                @can(\'product-purchase-show\')
                <a href="{{route(\'product-purchases.show\',$id)}}" class="btn btn-info btn-sm" title="Click here to view"><i class="la la-eye"></i> </a>
                @endcan
                
                @can(\'product-purchase-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            ')
            ->rawColumns(['Due Date','action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Purchase Product';
        $suppliers=DataLoad::vendorList();
        $setting=DataLoad::setting();

        $paymentStatus=[
            ProductPurchase::PAID=>ProductPurchase::PAID,
            ProductPurchase::DUE=>ProductPurchase::DUE
        ];

        $maxId=ProductPurchase::max('id')+1;

        $purchaseNo=ProductPurchase::STARTPURCHASENO+$maxId;
        $purchaseNo='PUR-'.$purchaseNo;

        return view('admin.purchase.create',compact('title','suppliers','setting','paymentStatus','purchaseNo'));
    }


    public function getProductData(Request $request)
    {
        return $products=Product::select('name','id')
            ->where('name', 'like', '%' .$request->q. '%')->pluck('name');
    }

    public function addProductToPurchaseList(Request $request)
    {
         $searchProduct=Product::leftJoin('product_inventory_stocks','products.id','product_inventory_stocks.product_id')
            ->select('name','products.id','cost_price','sale_price')
            ->where('name', $request->product_name)->first();

         if (!is_null($request->qty) && $request->qty>0)
         {
             $searchProduct['qty']=$request->qty;
         }else{
             $searchProduct['qty']=1;
         }

         if (!is_null($request->cost_price))
         {
             $searchProduct['cost_price']=$request->cost_price;
         }
         if (!is_null($request->sale_price))
         {
             $searchProduct['sale_price']=$request->sale_price;
         }

         if ($request->update==1)
         {
             $type=TmpProductPurchase::UPDATE;
         }else{
             $type=TmpProductPurchase::STORE;
         }

         if (!empty($searchProduct))
         {

             TmpProductPurchase::updateOrCreate(
                 [
                     'user_id'   => auth()->user()->id,
                     'product_name'=>$searchProduct->name,
                     'type'=>$type,
                 ],
                 [
                     'user_id'=>auth()->user()->id,
                     'product_id'=>$searchProduct->id,
                     'product_name'=>$searchProduct->name,
                     'qty'=>$searchProduct->qty,
                     'cost_price'=>$searchProduct->cost_price,
                     'sale_price'=>$searchProduct->sale_price,
                     'item_total'=>$searchProduct->cost_price*$searchProduct->qty,
                     'type'=>$type,
                 ]);
         }

        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>$type,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        if ($request->update==1)
        {
            return view('admin.purchase.edit-tem-purchase-product-list',compact('setting','tmpPurchaseProducts'));
        }else{
            return view('admin.purchase.tem-purchase-product-list',compact('setting','tmpPurchaseProducts'));
        }


    }

    public function removeProductFromPurchaseList(Request $request)
    {
        $deleteTmpPurchaseProduct=TmpProductPurchase::where(['id'=>$request->id])->orderBy('id','ASC')->delete();


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::STORE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        return view('admin.purchase.tem-purchase-product-list',compact('setting','tmpPurchaseProducts'));
    }

    public function removeProductFromUpdatePurchaseList(Request $request)
    {
        $deleteTmpPurchaseProduct=TmpProductPurchase::where(['id'=>$request->id])->orderBy('id','ASC')->delete();


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::UPDATE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        return view('admin.purchase.edit-tem-purchase-product-list',compact('setting','tmpPurchaseProducts'));
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
            'purchase_no' => 'required|unique:product_purchases,purchase_no,NULL,id,deleted_at,NULL',
            'po_ref' => 'required|max:150',
            'purchase_date' => 'required',
            'due_date' => 'required',
            //'payment_status' => 'required',
            'payment_term' => 'max:400',

        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::STORE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();

        if (count($tmpPurchaseProducts)<=0)
        {
            return redirect()->back()->with('error','Error, At least one product is required');
        }

        DB::beginTransaction();
        try{
            $subTotal=$this->temProductSubTotal(TmpProductPurchase::STORE);

            $input['created_by']=\Auth::user()->id;
            $input['sub_total']=$subTotal;
            $input['net_total']=$subTotal-$request->discount;

            if (!is_null($request->purchase_date))
            {
                $input['purchase_date']=date('Y-m-d',strtotime($request->purchase_date));
            }

            if (!is_null($request->due_date))
            {
                $input['due_date']=date('Y-m-d',strtotime($request->due_date));
            }

            $productPurchase=ProductPurchase::create($input);

            foreach ($tmpPurchaseProducts as $key=>$tmpProduct) {

                $productInventoryItem = ProductInventory::create([
                    'product_purchase_id' => $productPurchase->id,
                    'product_id' => $tmpProduct->product_id,
                    'qty' => $tmpProduct->qty,
                    'cost_price' => $tmpProduct->cost_price,
                    'sale_price' => $tmpProduct->sale_price,
                    'created_by' => auth()->user()->id,
                ]);

                $this->inventoryStockUpdate($tmpProduct);

            }

            $updateVendorTotalDue=Vendor::where(['id'=>$request->vendor_id])->first();

            $updateVendorTotalDue->update(['total_due'=>$updateVendorTotalDue->total_due+$productPurchase->net_total]);


            TmpProductPurchase::where(['type'=>TmpProductPurchase::STORE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->delete();

            DB::commit();
            return redirect()->back()->with('success','Data Successfully Save');

        }catch(\Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }


    public function temProductSubTotal($type)
    {
        return TmpProductPurchase::where(['type'=>$type])->sum('item_total');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function show($id )
    {
        $title='Purchase Invoice';
        $setting=DataLoad::setting();

        $productPurchase=ProductPurchase::with('vendor','purchaseItem','purchaseItem.product')->findOrFail($id);

        return view('admin.purchase.show',compact('title','setting','productPurchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPurchase $productPurchase)
    {
        $title='Purchase Product';
        $suppliers=DataLoad::vendorList();
        $setting=DataLoad::setting();

        $productInventories=ProductInventory::where(['product_purchase_id'=>$productPurchase->id])->get();

        foreach ($productInventories as $productInventory)
        {
            $product=Product::where(['id'=>$productInventory->product_id])->select('name')->first();

            TmpProductPurchase::updateOrCreate(
                [
                    'user_id'   => auth()->user()->id,
                    'product_name'=>$product->name,
                    'type'=>TmpProductPurchase::UPDATE,
                ],
                [
                'user_id'=>auth()->user()->id,
                'product_id'=>$productInventory->product_id,
                'product_name'=>$product->name,
                'qty'=>$productInventory->qty,
                'cost_price'=>$productInventory->cost_price,
                'sale_price'=>$productInventory->sale_price,
                'item_total'=>$productInventory->cost_price*$productInventory->qty,
                'type'=>TmpProductPurchase::UPDATE,
            ]);
        }

        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::UPDATE,'user_id'=>auth()->user()->id])
            ->orderBy('id','ASC')->get();

        return view('admin.purchase.edit',compact('title','suppliers','setting','productPurchase','tmpPurchaseProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPurchase $productPurchase)
    {
        $input = $request->all();

        $productPurchaseId=$productPurchase->id;
        $validator = Validator::make($input, [
            'vendor_id' => 'required|exists:vendors,id',
            'purchase_no' => "required|unique:product_purchases,purchase_no,$productPurchaseId",
            'po_ref' => 'required|max:150',
            'purchase_date' => 'required',
            'due_date' => 'required',
            'payment_term' => 'max:400',

        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::UPDATE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();

        if (count($tmpPurchaseProducts)<=0)
        {
            return redirect()->back()->with('error','Error, At least one product is required');
        }

        $oldNetTotal=$productPurchase->net_total;
        $currentSubTotal=$this->temProductSubTotal(TmpProductPurchase::UPDATE);
        $currentNetTotal =$currentSubTotal-$request->discount;
        DB::beginTransaction();
        try{

            $oldProductInventories=ProductInventory::where(['product_purchase_id'=>$productPurchase->id])->get();

            // remove ole inventory and inventoryStock ---------
            foreach ($oldProductInventories as $key=>$inventoryItem) // remove old inventory Item qty
            {
                $productInventoryStock=ProductInventoryStock::where(['product_id'=>$inventoryItem->product_id])->first();

                $productInventoryStock->update(['qty'=>$productInventoryStock->qty-$inventoryItem->qty]);

                $inventoryItem->forceDelete();
            }

            $input['created_by']=\Auth::user()->id;
            $input['sub_total']=$currentSubTotal;
            $input['net_total']=$currentNetTotal;

            if (!is_null($request->purchase_date))
            {
                $input['purchase_date']=date('Y-m-d',strtotime($request->purchase_date));
            }

            if (!is_null($request->due_date))
            {
                $input['due_date']=date('Y-m-d',strtotime($request->due_date));
            }

            $productPurchase->update($input);

            foreach ($tmpPurchaseProducts as $key=>$tmpProduct) {

                $productInventoryItem = ProductInventory::create([
                    'product_purchase_id' => $productPurchaseId,
                    'product_id' => $tmpProduct->product_id,
                    'qty' => $tmpProduct->qty,
                    'cost_price' => $tmpProduct->cost_price,
                    'sale_price' => $tmpProduct->sale_price,
                    'created_by' => auth()->user()->id,
                ]);

                $this->inventoryStockUpdate($tmpProduct);

            }

            // vendor total_due calculation
            $updateVendorTotalDue=Vendor::where(['id'=>$productPurchase->vendor_id])->first();

            $vendorTotalDue=$updateVendorTotalDue->total_due-$oldNetTotal+$currentNetTotal;

            $updateVendorTotalDue->update(['total_due'=>$vendorTotalDue]);

            TmpProductPurchase::where(['type'=>TmpProductPurchase::UPDATE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->delete();

            DB::commit();
            return redirect('/admin/product-purchases')->with('success','Data Successfully Update');

        }catch(Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    public function inventoryStockUpdate($tmpProduct)
    {

        $productInventoryStock=ProductInventoryStock::where(['product_id'=>$tmpProduct->product_id,'updated_by'=>auth()->user()->id])->first();

        if (empty($productInventoryStock))
        {
            ProductInventoryStock::create([
                'product_id' => $tmpProduct->product_id,
                'qty' => $tmpProduct->qty,
                'cost_price' => $tmpProduct->cost_price,
                'sale_price' => $tmpProduct->sale_price,
                'created_by' => auth()->user()->id,
            ]);
        }else{
            $updatedQty=$productInventoryStock->qty+$tmpProduct->qty;
            $productInventoryStock->update([
                'qty' =>$updatedQty ,
                'cost_price' => $tmpProduct->cost_price,
                'sale_price' => $tmpProduct->sale_price,
                'updated_by' => auth()->user()->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPurchase $productPurchase)
    {
        DB::beginTransaction();
        try{

            $productInventories=ProductInventory::where(['product_purchase_id'=>$productPurchase->id])->get();

            foreach ($productInventories as $key=>$productItem)
            {
                $productInventoryStock=ProductInventoryStock::where(['product_id'=>$productItem->product_id])->first();

                $productInventoryStock->update(['qty'=>$productInventoryStock->qty-$productItem->qty]);

                $productItem->delete();
            }

            // minus from vendor total_due

            $minusPreviousVendorTotalDue=Vendor::where(['id'=>$productPurchase->vendor_id])->first();
            $minusPreviousVendorTotalDue->update(['total_due'=>$minusPreviousVendorTotalDue->total_due-$productPurchase->net_total]);


            $productPurchase->delete();
            DB::commit();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
