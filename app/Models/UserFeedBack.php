<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeedBack extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='user_feed_backs';
    protected $fillable = [
        'name','mobile','email','message','image'
    ];
}
