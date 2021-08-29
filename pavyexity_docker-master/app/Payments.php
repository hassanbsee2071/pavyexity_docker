<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    //
    use SoftDeletes;
    protected $table = "payments";

    public function getCreatedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getDeletedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }
}
