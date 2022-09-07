<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VatTax extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const OTHER='Other';
    const DRAFT='Draft';

    const VAT='Vat';
    const TAX='Tax';

    protected $table='vat_taxes';
    protected $fillable=['vat_tax_name','vat_tax_percent','description','type','status','serial_num','created_by','updated_by'];

}
