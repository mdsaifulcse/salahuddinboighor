<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory,SoftDeletes;


    protected $table='setting';

    protected $fillable=['company_name','company_title','company_slogan','logo','favicon','copyright','currency','currency_code','address1',
        'address2','mobile_no1','mobile_no2','email1','email2','short_description','description','meta_description','why_us','map_embed',
        'fb_client_id','fb_client_secret','fb_redirect','google_client_id','google_client_secret','google_redirect','default_lan'];

}
