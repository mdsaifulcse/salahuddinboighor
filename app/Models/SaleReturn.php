<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends Model
{
    use HasFactory,SoftDeletes;

    const SALERETURNNO=100;

    protected $table='sale_returns';
    protected $fillable=['user_id','order_id','sale_return_no','total_amount','return_amount','return_date',
        'note','created_by','updated_by'];

    public function orderUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function returnItems()
    {
        return $this->hasMany(SaleReturnItem::class,'sale_return_id','id');
    }
}
