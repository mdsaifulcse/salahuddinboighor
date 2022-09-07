<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class CartProduct extends Model
{
    use HasFactory;

   CONST ORDER="Order";
   CONST WISHLIST="WISHLIST";
   CONST COMPARE="Compare";

    protected $table = 'cart_products';
    protected $fillable = ['session_id','user_id','product_id','price','qty','product_name','product_image','type'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function scopeFilterCartProducts($query,$type)
    {
        $sessionId='';
        if (Session::has('sessionId')) {
            $sessionId = Session::get('sessionId');
        }

        $query->with('product','product.productVatTax','product.originProducts','product.packSizeUnitProducts','product.productImages')
            ->where(['session_id'=>$sessionId,'type'=>$type]);
            //->where(['user_id'=>auth()->user()->id]);
    }


}
