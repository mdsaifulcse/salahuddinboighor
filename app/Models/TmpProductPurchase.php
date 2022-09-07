<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpProductPurchase extends Model
{
    use HasFactory;

    CONST STORE='Store';
    CONST UPDATE='update';

    CONST ADJUSTMENTSTORE='AdjustmentStore';
    CONST ADJUSTMENTUPDATE='AdjustmentUpdate';

    protected $table='tmp_product_purchases';
    protected $fillable=['user_id','product_id','product_name','qty','cost_price','sale_price','item_total','type'];

    public function subTotal()
    {
        return TmpProductPurchase::sum('item_total');
    }

}
