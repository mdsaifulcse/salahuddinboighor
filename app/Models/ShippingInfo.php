<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingInfo extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='shipping_info';
    protected $fillable=['name','fee','link','status','serial_num','icon_photo','description','created_by','updated_by'];

}
