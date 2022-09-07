<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenditure extends Model
{
    use HasFactory,SoftDeletes;

    const VOUCHERSTART='100';
    const CASH='Cash';
    const BKASH='Bkash';
    const ROCKET='Rocket';
    const NAGAD='Nagad';
    const BANK='Bank';

    protected $table='expenditures';
    protected $fillable=['voucher_no','income_expense_head_id','income_expense_sub_head_id','bank_account_id','amount','expense_date','note','expense_method',
        'expense_mobile','check_no','expense_trxId','docs_img','created_by','updated_by'];


    public function head()
    {
        return $this->belongsTo(IncomeExpenseHead::class,'income_expense_head_id','id');
    }
    public function subHead()
    {
        return $this->belongsTo(IncomeExpenseSubHead::class,'income_expense_sub_head_id','id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class,'bank_account_id','id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

}
