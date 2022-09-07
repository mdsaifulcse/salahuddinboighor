<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturn extends Model
{
    use HasFactory,SoftDeletes;

    const PURCHASERETURNNO=100;

    protected $table='purchase_returns';
    protected $fillable=['vendor_id','product_purchase_id','purchase_return_no','total_amount','return_amount','vendor_total_due','due_after_return','return_date',
        'note','created_by','updated_by'];

    public function productPurchase()
    {
        return $this->belongsTo(ProductPurchase::class,'product_purchase_id','id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }

    public function returnItems()
    {
        return $this->hasMany(PurchaseReturnItems::class,'purchase_return_id','id');
    }

}
