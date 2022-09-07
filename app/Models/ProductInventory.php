<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventory extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='product_inventories';
    protected $fillable=['product_purchase_id','product_id','new_add_qty','qty','cost_price','sale_price','created_by','updated_by'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
