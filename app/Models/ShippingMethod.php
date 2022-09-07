<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const YES='Yes';
    const NO='No';

    protected $table = 'shipping_methods';
    protected $fillable = ['title','title_bn','description','lang','cost','order','is_default','icon_photo','icon_class','serial_num',
        'status','created_by','updated_by'];

}
