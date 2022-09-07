<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    const PUBLISHED='Published';
    const UNPUBLISHED='Unpublished';
    const DRAFT='Draft';

    const YES='Yes';
    const NO='No';

    protected $table='products';
    protected $fillable=['name','name_bn','isbn','edition','number_of_page','topic','keyword','link','sku','short_description','description','specification','installation_gide',
        'video_url','status','serial_num','is_feature','is_new','added_reading_list','is_most_popular','is_top_rated','show_home','origin_id','pack_size_unit_id',
        'category_id','subcategory_id','third_category_id', 'fourth_category_id','brand_id','vat_tax_id','weight_unit_id',
        'weight','length_unit_id','length','height','width','promotion','created_by','updated_by','language_id','country_id','publisher_id'];


    public function originProducts()
    {
        return $this->belongsTo(Origin::class,'origin_id','id');
    }

    public function packSizeUnitProducts()
    {
        return $this->belongsTo(PackSizeUnit::class,'pack_size_unit_id','id');
    }

    public function categoryProducts()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subCategoryProducts()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

    public function thirdCategoryProducts()
    {
        return $this->belongsTo(ThirdSubCategory::class,'third_category_id','id');
    }

    public function brandProducts()
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function productVatTax()
    {
        return $this->belongsTo(VatTax::class,'vat_tax_id','id');
    }


    public function scopeStatusFilterProducts($query,$whereStatus)
    {
        $query->with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->where($whereStatus);
    }

    public function scopeFilterTopRatedProducts($query,$whereStatus)
    {
        $query->with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->where($whereStatus)->whereHas('productStock',function ($q){
                $q->orderBy('product_inventory_stocks.sale_price','DESC');
            });
    }

    public function scopeFilterCategoryProducts($query,$whereStatus,$catLinkArr)
    {
        $query->with('categoryProducts','subCategoryProducts','thirdCategoryProducts','productImages','productStock',
            'brandProducts','productPromotion') ->withCount('productReview')->withAvg('productReview','rating')
            ->where($whereStatus)->whereHas('categoryProducts',function ($q)use($catLinkArr){
                $q->whereIn('categories.link',$catLinkArr);
            });
    }

    public function scopeFilterProducts($query, $relation,$table,$column,$columnValue, $orderBy=null)
    {
        $query->whereHas($relation,function ($q) use ($table,$column,$columnValue){
            $q->where("$table.$column",$columnValue);
        });
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class,'product_tags')->whereNull('product_tags.deleted_at');
    }

    public function productTags()
    {
        return $this->hasMany(ProductTag::class,'product_id','id');
    }

    public function productCollections()
    {
        return $this->hasMany(ProductCollection::class,'product_id','id');
    }

    public function productStock()
    {
        return $this->hasOne(ProductInventoryStock::class,'product_id','id');
    }

    public function productPromotion()
    {
        return $this->hasOne(ProductPromotion::class,'product_id','id')->orderBy('id','DESC');
    }

    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class,'product_id','')->with('products','products.productImages')
            ->whereNull('related_products.deleted_at');

//        return $this->belongsToMany(Product::class,'related_products')->with('productImages')->withPivot('child_id')
//            ->whereNull('related_products.deleted_at');
    }

    public function relProductAuthors(){
        return $this->hasMany(BookAuthor::class,'product_id','id');
    }

    public function relProductAuthorsName(){
        return $this->belongsToMany(Author::class,'book_authors')->whereNull('book_authors.deleted_at');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class,'publisher_id','id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id','id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class,'product_id','id')->orderBy('is_thumbnail','DESC');
    }

    public function productReview()
    {
        return $this->hasMany(ProductReview::class,'product_id','id')->where('status',ProductReview::PUBLISH);
    }



}
