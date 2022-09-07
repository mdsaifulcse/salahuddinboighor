<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromotion extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='DRAFT';

    protected $table='product_promotions';
    protected $fillable=['product_id','org_price','promotion_by_percent','promotion_by_value','promotion_price',
        'date_start','date_end','status','created_by','updated_by'];
}
