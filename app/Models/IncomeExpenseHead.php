<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeExpenseHead extends Model
{
    use HasFactory,SoftDeletes;

    const INCOME='Income';
    const EXPENSE='Expense';

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='income_expense_heads';
    protected $fillable=['head_title','head_type','link','short_description',
        'status','serial_num','created_by','updated_by'];


    public function incomeExpenseSubHead()
    {
        return $this->hasMany(IncomeExpenseSubHead::class,'income_expense_head_id','id');
    }

}
