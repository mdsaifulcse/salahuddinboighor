<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPurchase extends Model
{
    use HasFactory,SoftDeletes;

    const STARTPURCHASENO=500;
    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const DUE='Due';
    const PAID='Paid';
    const PARTIALPAID='PartialPaid';

    const PURCHASED='purchase';
    const PURCHASED_ORDER='PURCHASEDOrder';

    protected $table='product_purchases';
    protected $fillable=['vendor_id','purchase_no','po_ref','payment_term','payment_status','purchase_date','purchase_status','due_date',
        'sub_total','discount','net_total','pay_amount','due_amount','note','status','created_by','updated_by'];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }

    public function purchaseItem()
    {
        return $this->hasMany(ProductInventory::class,'product_purchase_id','id');
    }
}
