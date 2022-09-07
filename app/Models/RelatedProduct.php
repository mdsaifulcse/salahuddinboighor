<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedProduct extends Model
{

    use HasFactory,SoftDeletes;

    protected $table='related_products';
    protected $fillable=['product_id','child_id'];

    public function products()
    {
        return $this->belongsTo(Product::class,'child_id','id');
    }
}
