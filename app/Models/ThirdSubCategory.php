<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdSubCategory extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='third_sub_categories';
    protected $fillable=['sub_category_id','third_sub_category','third_sub_category_bn','link','status','serial_num','icon_photo','icon_class','description','created_by','updated_by'];

    public function thirdSubCategoryOfFourth(){
        return $this->hasMany(FourthSubCategory::class,'third_sub_category_id','id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'third_category_id','id')->where('status',Product::PUBLISHED)
            ->where('third_category_id','!=','NULL');
    }

}
