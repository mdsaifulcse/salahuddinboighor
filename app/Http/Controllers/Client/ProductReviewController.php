<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Validator;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|min:1:max:5',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }




            $productReview=ProductReview::where(['user_id'=>auth()->user()->id,'product_id'=>$request->product_id])->first();

            if (empty($productReview))
            {
                ProductReview::create([
                    'user_id'=>auth()->user()->id,
                    'product_id'=>$request->product_id,
                    'rating'=>$request->rating,
                    'status'=>ProductReview::PUBLISH,
                    ]);
            }else{
                $productReview->update([
                    'rating'=>$request->rating,
                ]);
            }

            return redirect()->back()->with('success','Your Rating Successfully Placed');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }
}
