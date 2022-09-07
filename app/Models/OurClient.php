<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurClient extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE='Active';
    const INACTIVE='Inactive';

    protected $table = 'our_clients';
    protected $softDelete = true;

    protected $guarded =[];
}
