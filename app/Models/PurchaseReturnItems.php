<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturnItems extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='purchase_return_items';
    protected $fillable=['purchase_return_id','product_id','invoice_item_qty','balance_item_qty','return_item_qty','cost_price','item_total_price',
        'item_return_price'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
