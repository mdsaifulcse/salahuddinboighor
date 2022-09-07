<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInvoice extends Model
{
    use HasFactory,SoftDeletes;

    const INVOICESTART='100';

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

    const ECOMMERCE='Ecommerce';
    const ADMINSALE='Admin Sale';

    protected $table = 'order_invoices';
    protected $fillable = ['invoice_no','order_id','user_id','subtotal','coupon_discount','shipping_cost','shipping_id','vat_tax_percent','vat_tax_amount',
        'total','net_total','total_pay','tender_pay','order_status','payment_status','delivery_date','payment_date','transaction_id',
        'payment_track','payment_gateway','payment_type','reason','note','billing_name','billing_email','billing_phone','billing_street_address',
        'shipping_name','shipping_email','shipping_phone','shipping_street_address','coupon_code','cart_items','created_by','updated_by'
    ];
}
