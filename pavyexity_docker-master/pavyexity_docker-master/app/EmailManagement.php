<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class EmailManagement extends Model
{
    //
    protected $table = 'email_templates';
    protected $dates = ['deleted_at'];
    use SoftDeletes;

    public  function parse($data)
	{
		$parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
			list($shortCode, $index) = $matches;

			if( isset($data[$index]) ) {
				return $data[$index];
			} else {
				throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);
			}

		}, $this->email_body);

		return $parsed;
	}

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
