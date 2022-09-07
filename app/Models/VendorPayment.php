<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorPayment extends Model
{
    use HasFactory,SoftDeletes;

    const YES='Yes';
    const NO='No';

    const DUE='Due';
    const PAID='Paid';

    const CASH='Cash';
    const BKASH='Bkash';
    const ROCKET='Rocket';
    const NAGAD='Nagad';
    const BANK='Bank';

    protected $table='vendor_payments';
    protected $fillable=['vendor_id','bank_account_id','adjust_advance','payment_method','payment_mobile','check_no','payment_trxId','payable',
        'payment','due','payment_date','note','status','created_by','updated_by'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class,'bank_account_id','id');
    }

}
