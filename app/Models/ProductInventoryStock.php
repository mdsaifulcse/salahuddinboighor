<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventoryStock extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='product_inventory_stocks';

    protected $fillable=['product_id','qty','cost_price','sale_price','sold_qty','sold_return_qty','purchase_return_qty','created_by','updated_by'];
}
