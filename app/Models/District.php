<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table='districts';
    protected $fillable=['division_id','district','district_bn','link','status','serial_num','icon_photo','icon_class','show_at_home'];

}
