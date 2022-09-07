<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table = 'faqs';
    protected $softDelete = true;

    protected $fillable =['question','answer','image','serial_num','status'];

}
