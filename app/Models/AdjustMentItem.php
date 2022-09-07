<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjustMentItem extends Model
{
    use HasFactory,SoftDeletes;

    const REFNO=100;
    const IN='In';
    const OUT='Out';
    const DAMAGE='Damage';

    protected $table='adjust_ment_items';
    protected $fillable=['adjust_ment_id','product_id','qty','price'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
