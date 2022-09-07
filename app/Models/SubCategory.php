<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='sub_categories';
    protected $fillable=['category_id','sub_category_name','sub_category_name_bn','link','status','serial_num','icon_photo','icon_class','short_description','created_by','updated_by'];

    public function thirdSubCategory(){
        return $this->hasMany(ThirdSubCategory::class,'sub_category_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>ThirdSubCategory::ACTIVE]);
    }

    public function thirdSubAsThirdSubMenu(){
        return $this->hasMany(ThirdSubCategory::class,'sub_category_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'subcategory_id','id')->where('status',Product::PUBLISHED)
            ->where('subcategory_id','!=','NULL');
    }
}
