<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjustMent extends Model
{
    use HasFactory,SoftDeletes;

    const REFNO=100;
    const IN='In';
    const OUT='Out';
    const DAMAGE='Damage';

    protected $table='adjust_ments';
    protected $fillable=['ref_no','adjustment_type','adjustment_date','sub_total','discount','net_total',
        'note','created_by','updated_by'];

    public function adjustmentItem()
    {
        return $this->hasMany(AdjustMentItem::class,'adjust_ment_id','id');
    }
}
