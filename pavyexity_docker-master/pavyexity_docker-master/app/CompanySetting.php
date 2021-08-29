<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySetting extends Model {

    use SoftDeletes;

    protected $table = 'company_settings';
    protected $dates = ['deleted_at'];
  
    public static function getAdminCompanyId($param = array()) {
        $user_id      = ((!empty($param['user_id'])) ? $param['user_id'] : "");
        $company_id   = 0;
        $user_company = CompanySetting::where('user_id', '=', $user_id)->first();
        if (!empty($user_company)) {
            $company_id = $user_company->id;
        }
        return $company_id;
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

    public function getCompanyAdmins($value) {
        
        return date('m-d-y', strtotime($value));
    }
    

}
