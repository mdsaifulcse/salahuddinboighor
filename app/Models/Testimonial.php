<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory,SoftDeletes;


    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table = 'testimonials';
    protected $fillable = ['related_with','rating','name','content','image','image_small','url','serial_num','status','created_by','updated_by'];

}
