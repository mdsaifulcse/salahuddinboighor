<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad,Session;

class CartProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartProducts=CartProduct::filterCartProducts(CartProduct::ORDER)->get();

         $setting=$setting=DataLoad::setting();
        return view('client.cart-product',compact('cartProducts','setting'));
    }

    public function getWithListProducts()
    {
        $cartProducts=CartProduct::filterCartProducts(CartProduct::WISHLIST)->get();

         $setting=$setting=DataLoad::setting();
        return view('client.wish-list-product',compact('cartProducts','setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'qty' => 'required|min:1:max:1000',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            $product=Product::findOrFail($request->product_id);

            $salePrice=0;

            if ($product->promotion==Product::YES && isset($product->productPromotion) && $product->productPromotion->date_end>=date('Y-m-d'))
            {
                $salePrice=$product->productPromotion->promotion_price;
            }else{
                $salePrice=$product->productStock->sale_price;
            }

            if (Session::has('sessionId'))
            {
                $sessionId=Session::get('sessionId');
            }else{
                $sessionId=time().rand('10000','99999');
                Session::put('sessionId',$sessionId);
            }

            $type=CartProduct::ORDER;
            $cartProduct=CartProduct::where(['session_id'=>$sessionId,'product_id'=>$request->product_id]);

            if ($this->checkAddToOrderOrWishlist($request)){
                $cartProduct=$cartProduct->where(['type'=>$request->type]);
                $type=$request->type;
            }

            $cartProduct=$cartProduct->first();


            if (empty($cartProduct))
            {
                CartProduct::create([
                    'session_id'=>$sessionId,
                    'user_id'=>auth()->user()?auth()->user()->id:NULL,
                    'product_id'=>$request->product_id,
                    'qty'=>$request->qty,
                    'price'=>$salePrice,
                    'product_name'=>$product->name,
                    'product_image'=>$product->productImages[0]->small,
                    'type'=>$type,
                ]);
            }else{

                if ($this->checkAddToOrderOrWishlist($request)){
                    $qty=1;
                }else{
                    $qty=$cartProduct->qty+$request->qty;
                }

                $cartProduct->update([
                    'user_id'=>auth()->user()?auth()->user()->id:NULL,
                    'qty'=>$qty,
                    'price'=>$salePrice,
                    'product_image'=>$product->productImages[0]->medium,
                    'type'=>$type,
                    'updated_at'=>Carbon::now()
                ]);
            }

            return redirect()->back()->with('success','Product successfully added to your '.$type);
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }


    public function checkAddToOrderOrWishlist($request)
    {
        if ($request->has('type') && !empty($request->type))
        {
            return true;
        }else{
            return false;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $sessionId='';
            if (Session::has('sessionId')) {
                $sessionId = Session::get('sessionId');
            }

            //$cartProduct=CartProduct::where(['user_id'=>auth()->user()->id,'id'=>$id])->first();
            $cartProduct=CartProduct::where(['session_id'=>$sessionId,'id'=>$id,'type'=>CartProduct::ORDER])->first();

            $cartProduct->update(['qty'=>$request->qty]);

            return redirect()->back()->with('success','Cart Product Quantity Successfully Update');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cartProduct=CartProduct::findOrFail($id);
        try{
            $cartProduct->delete();
            return redirect()->back()->with('success','Cart product has been successfully remove!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
