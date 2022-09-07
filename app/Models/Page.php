<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table = 'pages';
    protected $softDelete = true;

    protected $guarded =[];


    public function pagePhoto()
    {
        return $this->hasOne(PagePhoto::class);
    }


}
