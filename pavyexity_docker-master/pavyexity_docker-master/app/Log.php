<?php

namespace App;

/**
 * Log Class
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 * @package App
 */

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getDeletedAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getRequestAtAttribute($value) {
        return date('m-d-y', strtotime($value));
    }
}
