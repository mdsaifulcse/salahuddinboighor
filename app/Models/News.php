<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,SoftDeletes;

    const PUBLISHED='Published';
    const UNPUBLISHED='Unpublished';

    const YES='Yes';
    const NO='No';

    protected $table='news';
    protected $fillable=['title','feature_photo','feature_medium','feature_small','meta_description','description','topic','photo_caption','video_url','published_status','published_date', 'show_at_homepage','is_cover_news','category_id','sub_cat_id','news_author_id','division_id','district_id','serial_num','created_by','updated_by'];

    public function newsCategory()
    {
        return $this->belongsTo(Category::class,'category_id','id')->withTrashed();
    }

    public function newsSubCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_cat_id','id')->withTrashed();
    }

    public function mostReadNews()
    {
        return $this->hasOne(MostReadNews::class,'news_id','id');
    }

    public function newsAuthor()
    {
        return $this->belongsTo(User::class,'news_author_id','id');
    }

    public function moreNewsPhotos()
    {
        return $this->hasMany(NewsDetailPhoto::class,'news_id','id');
    }

    public function scopeCategoryNews($query, $relation,$table,$column,$columnValue, $orderBy=null)
    {
        $query->whereHas($relation,function ($q) use ($table,$column,$columnValue){
            $q->where("$table.$column",$columnValue);
        });
    }


}
