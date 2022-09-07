<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorTrack extends Model
{
    use HasFactory;
    protected $table='visitor_tracks';
    protected $fillable = [
        'visit_url','ip_address','total_visit','visit_date','user_id'
    ];


    public function scopeVisitorCountByDateRange($q,$dataRange)
    {
        //$q->$dataRange;
    }
}
