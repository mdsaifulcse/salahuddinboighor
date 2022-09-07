<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory,SoftDeletes;


    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table='divisions';
    protected $fillable=['division','division_bn','link','status','serial_num','icon_photo','icon_class','show_at_home'];


    public function districtData(){
        return $this->hasMany(District::class,'division_id','id');
    }

}
