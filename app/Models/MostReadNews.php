<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MostReadNews extends Model
{
    use HasFactory;

    protected $table='most_read_news';
    protected $fillable=['news_id','read_number','category_id'];
}
