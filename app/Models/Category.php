<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    const YES='Yes';
    const NO='No';

    protected $table='categories';
    protected $fillable=['category_name','category_name_bn','link','status','show_home','serial_num','short_description','icon_photo',
        'icon_class','created_by','updated_by'];


    public function subCategoryData(){
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function subCatAsSubMenu(){
        return $this->hasMany(SubCategory::class,'category_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>SubCategory::ACTIVE]);
    }


    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id')->where('status',Product::PUBLISHED);
    }

//    public function scopeCategoryAsMenu($query,$status=null)
//    {
//        if (!is_null($status)){
//            $query->where(['status'=>$status]);
//        }else{
//            $query;
//        }
//
//    }
}
