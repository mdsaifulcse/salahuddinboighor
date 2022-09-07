<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightUnit extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    protected $table='weight_units';
    protected $fillable=['weight_unit','link','status','serial_num','icon_photo','description','created_by','updated_by'];

}
