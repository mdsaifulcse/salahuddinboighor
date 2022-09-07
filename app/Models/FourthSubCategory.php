<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FourthSubCategory extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='fourth_sub_categories';
    protected $fillable=['third_sub_category_id','fourth_sub_category','fourth_sub_category_bn','link','status','serial_num','icon_photo','icon_class','description','created_by','updated_by'];

    public function thirdSubCategory()
    {
        return $this->belongsTo(ThirdSubCategory::class,'third_sub_category_id','id');
    }

}
