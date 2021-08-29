<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePaymentDetails extends Model
{
    //
    //use SoftDeletes;
    protected $table = "online_payment_links";
    public $timestamps = true;
}
