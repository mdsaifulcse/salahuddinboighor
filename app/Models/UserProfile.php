<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='user_profiles';
    protected $softDelete = true;
    protected $fillable = [
        'user_id','point','discount_percent','avatar','address','contact','company_name','nid','nid_photo','designation','bio','joining_date','salary'
    ];
}
