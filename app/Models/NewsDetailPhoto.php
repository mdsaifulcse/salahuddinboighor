<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsDetailPhoto extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table='news_detail_photos';
    protected $fillable=['news_id','photo','caption','description','status'];

}
