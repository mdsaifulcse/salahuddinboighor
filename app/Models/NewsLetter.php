<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsLetter extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='news_letters';
    protected $fillable=['email','created_by','updated_by'];
}
