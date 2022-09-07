<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory,SoftDeletes;

    const SAVING='Saving';
    const CURRENT='Current';

    const ACTIVE='Active';
    const INACTIVE='Inactive';
    const OTHER='Other';
    const DRAFT='Draft';

    protected $table='bank_accounts';
    protected $fillable=['bank_name','bank_branch','account_number','account_title','balance','account_type','address',
        'status','serial_num','created_by','updated_by'];

}
