<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvSample extends Model
{
    //
    protected $table = 'csvsample';
    protected $fillable = ['email', 'payment_amount', 'description'];

}
