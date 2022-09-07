<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackSizeUnit extends Model
{
    use HasFactory,SoftDeletes;

    const UNIT='Unit';
    const PACK_SIZE='Pack Size';

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const DRAFT='Draft';

    protected $table='pack_size_units';
    protected $fillable=['size','label','link','status','serial_num','description','created_by','updated_by'];

}
