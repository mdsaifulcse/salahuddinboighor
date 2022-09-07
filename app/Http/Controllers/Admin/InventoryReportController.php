<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class InventoryReportController extends Controller
{
    public function getInventoryStockReport(Request $request)
    {

        $title='Inventor Stock Report';
        $categories=DataLoad::categoryList();
        $setting=DataLoad::setting();
        $paymentStatuses=[];

        //return $request;

        $productInventoryStocks=[];

        if (count($request->all()) > 1)
        {
            $productInventoryStocks=Product::with('categoryProducts','productStock');

            if (!empty($request->product_name))
            {
                $productInventoryStocks=$productInventoryStocks->where('products.name',$request->product_name);
            }
            if (!empty($request->category_id))
            {

                $productInventoryStocks=$productInventoryStocks->where('products.category_id',$request->category_id);
            }


           if(!is_null($request->date_start))
            {
                $date_start=date('Y-m-d',strtotime($request->date_start));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s',"$date_start 00:00:00")->format('Y-m-d H:i:s');

                $productInventoryStocks=$productInventoryStocks->whereHas('productStock',function ($q) use ($date_start){
                    $q->whereDate('product_inventory_stocks.updated_at', '=', $date_start);
                });

            }


            $productInventoryStocks=$productInventoryStocks->get();
        }


        return view('admin.inventory-report.inventory-stock-report',compact('title','categories','setting','productInventoryStocks','paymentStatuses','request'));

    }

    public function getProductData(Request $request)
    {
        return $products=Product::select('name','id')
            ->where('name', 'like', '%' .$request->q. '%')->pluck('name');
    }

}
