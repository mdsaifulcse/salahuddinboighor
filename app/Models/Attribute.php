<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory,SoftDeletes;

    use HasFactory;
    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    protected $table='attributes';
    protected $fillable=['title','slug','title_title','is_default','title_slug','link','serial_num','icon_photo','description','created_by','updated_by'];

}
