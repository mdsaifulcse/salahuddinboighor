<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LengthUnit extends Model
{
    use HasFactory,SoftDeletes;

    use HasFactory;
    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    protected $table='length_units';
    protected $fillable=['length_unit','link','status','serial_num','icon_photo','description','created_by','updated_by'];

}
