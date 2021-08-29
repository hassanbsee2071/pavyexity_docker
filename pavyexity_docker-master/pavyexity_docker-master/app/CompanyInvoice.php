<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInvoice extends Model
{
    //
    protected $table = 'company_invoices';
    protected $fillable = ['invoice_id', 'company_id', 'user_id', 'user_mail'];

    protected $dates = ['deleted_at'];
}
