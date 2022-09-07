<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAssignDelivery extends Model
{
    use HasFactory,SoftDeletes;

    const ASSIGNSTARTNO=100;

    const YES='Yes';
    const NO='No';

    const PENDING='Pending';
    const CANCELLED='Cancelled';
    const RECEIVED='Received';
    const SHIPPING='Shipping';
    const COMPLETE='Complete';

    protected $table = 'order_assign_deliveries';
    protected $fillable = ['order_id','user_id','assign_no','target_delivery_date','target_delivery_time','delivery_status','payment_gateway',
        'order_amount','shipping_cost','receive_from_delivery','note','created_by','updated_by'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function scopeFilterAssignOrder($query,$useId=null,$delivery_status=null,$dateLength='all',$payment_status=null )
    {
        $today = \Carbon\Carbon::today()->subDays(0);

        $thisMonty = \Carbon\Carbon::now()->startOfMonth()->subMonth(0);

        if (!is_null($useId))
        {
            $query->where(['user_id'=>$useId]);
        }

        if (!is_null($delivery_status))
        {
            $query->where(['delivery_status'=>$delivery_status]);
        }

        if ($dateLength=='today')
        {
            $query->whereDate('updated_at', '=', $today);
        }
        elseif($dateLength=='this_month')
        {
            $query->whereMonth('updated_at', '=', $thisMonty);
        }



        if (!is_null($payment_status))
        {
            $query->where(['payment_status'=>$payment_status]);
        }

    }

}
