<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    protected $table='tags';
    protected $fillable=['tag','link','status','serial_num','description','created_by','updated_by'];

}
