<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturnItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='sale_return_items';
    protected $fillable=['sale_return_id','product_id','order_item_qty','return_item_qty','sale_price','item_total_price','item_return_price'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
