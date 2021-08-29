<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RecurringPayments extends Model
{
    //
    use SoftDeletes;
    protected $table = "recurring_payments";
}
