<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdjustMent;
use App\Models\AdjustMentItem;
use App\Models\Product;
use App\Models\ProductInventoryStock;
use App\Models\TmpProductPurchase;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class AdjustMentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Adjustment List';
        return view('admin.adjustment.index',compact('title'));
    }

    public function getProductPurchaseData()
    {

        $allData=AdjustMent::select('adjust_ments.id','adjust_ments.ref_no','adjust_ments.sub_total',
                'adjust_ments.net_total','adjust_ments.adjustment_date','adjust_ments.adjustment_type')
            ->orderBy('adjust_ments.id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Adjustment Type','
                    @if($adjustment_type==\App\Models\AdjustMentItem::IN)
                        <button class="btn btn-success btn-sm">{{$adjustment_type}}</button>
                         @elseif($adjustment_type==\App\Models\AdjustMentItem::OUT)
                            <button class="btn btn-warning btn-sm">{{$adjustment_type}}</button>
                            @else
                            <button class="btn btn-default btn-sm">{{$adjustment_type}}</button>
                        @endif
                ')

            ->addColumn('Adjustment Date','
                    <?php echo date(\'M/d/Y H:i A\',strtotime($adjustment_date)) ;?>
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'product-adjustment.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                
                
                <a href="{{route(\'product-adjustment.show\',$id)}}" class="btn btn-info btn-sm" title="Click here to view"><i class="la la-eye"></i> </a>
               
                
                @can(\'product-purchase-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            ')
            ->rawColumns(['Adjustment Type','Adjustment Date','action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Product Adjustment';
        $setting=DataLoad::setting();

        $adjustMentType=[
            AdjustMent::IN=>AdjustMent::IN,
            AdjustMent::OUT=>AdjustMent::OUT,
            AdjustMent::DAMAGE=>AdjustMent::DAMAGE
        ];

        $maxId=AdjustMent::max('id')+1;

        $refNo=AdjustMent::REFNO+$maxId;
        $refNo='Adjm-'.$refNo;

        return view('admin.adjustment.create',compact('title','setting','adjustMentType','refNo'));
    }


    public function getProductData(Request $request)
    {
        return $products=Product::select('name','id')
            ->where('name', 'like', '%' .$request->q. '%')->pluck('name');
    }

    public function addProductToAdjustmentList(Request $request)
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

        if (!is_null($request->price))
        {
            $searchProduct['cost_price']=$request->price;
        }

        if (!is_null($request->sale_price))
        {
            $searchProduct['sale_price']=$request->sale_price;
        }

        if ($request->update==1)
        {
            $type=TmpProductPurchase::ADJUSTMENTUPDATE;
        }else{
            $type=TmpProductPurchase::ADJUSTMENTSTORE;
        }


        if (!empty($searchProduct))
        {

            $tmpProductExist=TmpProductPurchase::where(['type'=>$type,'user_id'=>auth()->user()->id,'product_name'=>$searchProduct->name])->first();

            if (empty($tmpProductExist))
            {
                $saveTmpPurchase=TmpProductPurchase::create([
                    'user_id'=>auth()->user()->id,
                    'product_id'=>$searchProduct->id,
                    'product_name'=>$searchProduct->name,
                    'qty'=>$searchProduct->qty,
                    'cost_price'=>$searchProduct->cost_price,
                    'sale_price'=>$searchProduct->sale_price,
                    'item_total'=>$searchProduct->cost_price*$searchProduct->qty,
                    'type'=>$type,
                ]);
            }else{
                $tmpProductExist->update([
                    'qty'=>$searchProduct->qty,
                    'cost_price'=>$searchProduct->cost_price,
                    'sale_price'=>$searchProduct->sale_price,
                    'item_total'=>$searchProduct->cost_price*$searchProduct->qty,
                    'type'=>$type,
                ]);
            }
        }

        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>$type,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        if ($request->update==1)
        {
            return view('admin.adjustment.edit-tem-adjustment-product-list',compact('setting','tmpPurchaseProducts'));
        }else{
            return view('admin.adjustment.tem-adjustment-product-list',compact('setting','tmpPurchaseProducts'));
        }


    }

    public function removeProductFromAdjustmentList(Request $request)
    {
        $deleteTmpPurchaseProduct=TmpProductPurchase::where(['id'=>$request->id])->orderBy('id','ASC')->delete();


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::ADJUSTMENTSTORE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        return view('admin.adjustment.tem-adjustment-product-list',compact('setting','tmpPurchaseProducts'));
    }

    public function removeProductFromUpdateAdjustmentList(Request $request)
    {
        $deleteTmpPurchaseProduct=TmpProductPurchase::where(['id'=>$request->id])->orderBy('id','ASC')->delete();


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::ADJUSTMENTUPDATE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();
        $setting=DataLoad::setting();

        return view('admin.adjustment.edit-tem-adjustment-product-list',compact('setting','tmpPurchaseProducts'));
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
            'ref_no' => 'required|unique:adjust_ments,ref_no,NULL,id,deleted_at,NULL',
            'adjustment_type' => 'required',
            'sub_total' => 'required',
            'net_total' => 'required',
            'note' => 'nullable|max:400',

        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $tmpPurchaseProducts=TmpProductPurchase::where(['type'=>TmpProductPurchase::ADJUSTMENTSTORE,'user_id'=>auth()->user()->id])->orderBy('id','ASC')->get();

        if (count($tmpPurchaseProducts)<=0)
        {
            return redirect()->back()->with('error','Error, At least one product is required');
        }

        DB::beginTransaction();
        try{

            $subTotal=$this->temProductSubTotal(TmpProductPurchase::ADJUSTMENTSTORE);

            $input['created_by']=\Auth::user()->id;
            $input['sub_total']=$subTotal;
            $input['net_total']=$subTotal-$request->discount;


            if (!is_null($request->adjustment_date))
            {
                $input['adjustment_date']=date('Y-m-d',strtotime($request->adjustment_date));
            }

            $productAdjustment=AdjustMent::create($input);

            foreach ($tmpPurchaseProducts as $key=>$tmpProduct) {

                $adjustMentItem = AdjustMentItem::create([
                    'adjust_ment_id' => $productAdjustment->id,
                    'product_id' => $tmpProduct->product_id,
                    'qty' => $tmpProduct->qty,
                    'price' => $tmpProduct->cost_price,
                ]);

                $this->inventoryStockUpdate($tmpProduct,$request->adjustment_type);

            }


            TmpProductPurchase::where(['type'=>TmpProductPurchase::ADJUSTMENTSTORE,'user_id'=>auth()->user()->id])
                ->orderBy('id','ASC')->delete();

            DB::commit();
            return redirect()->back()->with('success','Data Successfully Save');

        }catch(Exception $e){

            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    public function inventoryStockUpdate($tmpProduct,$adjustmentType)
    {
        $productInventoryStock=ProductInventoryStock::where(['product_id'=>$tmpProduct->product_id,'updated_by'=>auth()->user()->id])->first();

        if ($adjustmentType==AdjustMent::IN)
        {
            $updatedQty=$productInventoryStock->qty+$tmpProduct->qty;
        }else{ // damage or out
            $updatedQty=$productInventoryStock->qty-$tmpProduct->qty;
        }


        $productInventoryStock->update([
            'qty' =>$updatedQty ,
            'cost_price' => $tmpProduct->cost_price,
            'sale_price' => $tmpProduct->sale_price,
            'updated_by' => auth()->user()->id,
        ]);

    }


    public function temProductSubTotal($type)
    {
        return TmpProductPurchase::where(['type'=>$type])->sum('item_total');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjustMent  $adjustMent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title='Adjustment';
        $setting=DataLoad::setting();
        $adjustment=AdjustMent::with('adjustmentItem','adjustmentItem.product')->findOrFail($id);

        return view('admin.adjustment.show',compact('setting','title','adjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjustMent  $adjustMent
     * @return \Illuminate\Http\Response
     */
    public function edit(AdjustMent $adjustMent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjustMent  $adjustMent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdjustMent $adjustMent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjustMent  $adjustMent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdjustMent $adjustMent)
    {
        //
    }
}
