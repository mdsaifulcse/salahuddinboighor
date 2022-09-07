<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    const STARTORDERID=100;
    const PENDING='Pending';
    const REVIEW='Review';
    const CANCELLED='Cancelled';
    const RECEIVED='Received';
    const PROCESSING='Processing';
    const SHIPPING='Shipping';
    const DELIVERED='Delivered';
    const COMPLETE='Complete';

    const UNPAID='UNPAID';
    const PAID='PAID';
    const PARTIAL='PARTIAL';

    const REGULAR='Regular';
    const EMI='EMI';

    const PAYMENT_GATEWAY='Cash On Delivery';
    const BKASH='Bkash';
    const ROCKET='Rocket';
    const NAGAD='Nagad';
    const BANK='Bank';

    protected $table = 'orders';
    protected $fillable = ['order_id','user_id','subtotal','coupon_discount','shipping_cost','shipping_id','vat_tax_percent','vat_tax_amount',
        'total','net_total','total_pay','tender_pay','order_status','payment_status','delivery_date','payment_date','transaction_id',
        'payment_track','payment_gateway','payment_type','reason','note',
        'billing_name','billing_email','billing_phone','billing_street_address','billing_city','billing_post','billing_post_code',
        'shipping_name','shipping_email','shipping_phone','shipping_street_address','shipping_city','shipping_post','shipping_post_code',
        'coupon_code','cart_items','created_by','updated_by'
    ];

//    public function getOrderIdAttribute()
//    {
//        return $this->id + 100;
//    }

    public function scopeFilterOrder($query,$useId=null,$order_status=null,$dateLength='all',$payment_status=null )
    {
        $today = \Carbon\Carbon::today()->subDays(0);

        $thisMonty = \Carbon\Carbon::now()->startOfMonth()->subMonth(0);

        if (!is_null($useId))
        {
            $query->where(['user_id'=>$useId]);
        }

        if (!is_null($order_status))
        {
            $query->where(['order_status'=>$order_status]);
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


    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class,'shipping_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }




}
