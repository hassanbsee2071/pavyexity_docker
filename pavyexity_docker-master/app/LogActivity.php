<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activity';
    protected $fillable = [
        'user_id','logtype','action', 'created_at', 'updated_at'
    ];
}
