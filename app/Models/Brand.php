<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    const YES='Yes';
    const NO='No';

    protected $table = 'brands';
    protected $fillable = ['brand_name','link','description','icon_photo','icon_class','show_home','serial_num','status','created_by','updated_by'];

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id','id')->where('status',Product::PUBLISHED);
    }

}
