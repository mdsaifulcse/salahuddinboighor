<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory,SoftDeletes;


    const PUBLISH='Publish';
    const UNPUBLISH='Unpublish';

    protected $table='product_reviews';
    protected $fillable=['product_id','user_id','content','rating','serial_num','status'];

}
