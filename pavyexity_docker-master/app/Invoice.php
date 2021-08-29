<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function getAdminInvoiceQueryObj($param = array()) {
        $user_id = ((!empty($param['user_id'])) ? $param['user_id'] : "");
        $q       = "";
        if (!empty($user_id)) {

            $login_user  = auth()->user();
                                    $allcompanies = \App\CompanySetting::get();
                                            foreach( $allcompanies as $u){
                                            
                                                $decoded = json_decode($u->user_id);
                                                if(in_array($login_user->id, $decoded)){
                                                $companyusers=1;
                                                $company_id= $u->id;
                                                }
                                            }
                        
            // $company_id = \App\CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
            
            if (!empty($company_id)) {
                $q = Invoice::join('company_invoices as ci', 'invoices.id', '=', 'ci.invoice_id')
                        // ->join('users as u', 'u.id', '=', 'ci.user_id')
                        ->where('ci.company_id', '=', $company_id)
                        ->whereNull('invoices.deleted_at');
            }else{
                $q = Invoice::join('company_invoices as ci', 'invoices.id', '=', 'ci.invoice_id')
                ->join('users as u', 'u.id', '=', 'ci.user_id')
                ->whereNull('invoices.deleted_at');
            }
        }
        return $q;
    }

    public function getDueDateAttribute($value) {
        return date('m-d-y', strtotime($value));
    }

    public function getInvoiceDateAttribute($value) {
        return date('m-d-y', strtotime($value));
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
