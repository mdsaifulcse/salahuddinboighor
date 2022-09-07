<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory;

    const HOME='Home';
    const OFFICE='Office';
    const OTHER='Other';

    const YES='Yes';
    const NO='No';

    protected $table = 'user_addresses';
    protected $fillable = ['user_id','name','email','phone','city','post','post_code',
        'address1','address2','map_address','latitude','longitude','type','is_default'];

}
