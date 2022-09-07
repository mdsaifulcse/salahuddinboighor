<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Http\Request;
use DB,Auth,Validator,DataLoad;

class CheckoutController extends Controller
{

    public function showCheckOutPage()
    {

        $shippingMethods=ShippingMethod::where(['status'=>ShippingMethod::ACTIVE])->orderBy('serial_num','ASC')->get();

        $cartProducts=CartProduct::filterCartProducts(CartProduct::ORDER)->get();

        $setting=DataLoad::setting();
        $user=User::with('profile','relUserAddress')->findOrFail(auth()->user()->id);
        return view('client.checkout',compact('shippingMethods','cartProducts','setting','user'));
    }



    public function addShippingCost($shippingId)
    {
        try{

            $cartProducts=CartProduct::filterCartProducts(CartProduct::ORDER)->get();

            $setting=DataLoad::setting();

            $shippingCost='';
            if ($shippingId!=0)
            {
                 $shippingCost=ShippingMethod::select('cost')->findOrFail($shippingId);
            }

            return view('client.checkout-product-update',compact('cartProducts','setting','shippingCost'));
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    public function update($id,$qty,$shippingId=null)
    {

        try{

            $cartProduct=CartProduct::where(['user_id'=>auth()->user()->id,'id'=>$id,'type'=>CartProduct::ORDER])->first();

            $cartProduct->update(['qty'=>$qty]);

            $cartProducts=CartProduct::filterCartProducts(CartProduct::ORDER)->get();
            $setting=DataLoad::setting();

            $shippingCost='';
            if ($shippingId!=0)
            {
                 $shippingCost=ShippingMethod::select('cost')->findOrFail($shippingId);
            }

            return view('client.checkout-product-update',compact('cartProducts','setting','shippingCost'));
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$shippingId)
    {
        try{

            $cartProduct=CartProduct::findOrFail($id);
            $cartProduct->delete();

            $cartProducts=CartProduct::filterCartProducts(CartProduct::ORDER)->get();;

            $setting=DataLoad::setting();

            $shippingCost='';
            if ($shippingId!=0)
            {
                $shippingCost=ShippingMethod::select('cost')->findOrFail($shippingId);
            }

            return view('client.checkout-product-update',compact('cartProducts','setting','shippingCost'));

        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }



}
