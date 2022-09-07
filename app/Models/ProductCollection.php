<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCollection extends Model
{
    use HasFactory,SoftDeletes;


    protected $table='product_collections';
    protected $fillable=['product_id','collection_id'];
}
