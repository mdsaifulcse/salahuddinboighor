<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeExpenseSubHead extends Model
{
    use HasFactory,SoftDeletes;

    const INCOME='Income';
    const EXPENSE='Expense';

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='income_expense_sub_heads';
    protected $fillable=['income_expense_head_id','sub_head_title','link','short_description',
        'status','serial_num','created_by','updated_by'];

    public function incomeExpenseHead()
    {
        return $this->belongsTo(IncomeExpenseHead::class,'income_expense_head_id','id');
    }
}
