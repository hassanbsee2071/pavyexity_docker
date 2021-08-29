<?php

namespace App;

/**
 * Module Class
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 * @package App
 */

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'slug'];
}
