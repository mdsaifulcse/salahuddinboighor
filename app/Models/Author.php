<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';
    const Yes='Yes';
    const No='No';

    protected $table='authors';
    protected $fillable=['name','name_bn','email','mobile','photo','contact','link','address1','address2','bio','show_home','status','serial_num','created_by','updated_by'];

}
