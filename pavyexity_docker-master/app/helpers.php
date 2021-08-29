<?php

use App\Payments;
use App\CompanyUser;
use App\Transactions;
use App\CompanySetting;
use App\PaymentDetails;
use App\OnlinePaymentDetails;
use App\Models\Auth\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Global helpers file with misc functions.
 */
if (!function_exists('gravatar')) {

    /**
     * Access the gravatar helper.
     *
     * @return \Creativeorange\Gravatar\Gravatar|\Illuminate\Foundation\Application|mixed
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('to_js')) {

    /**
     * Access the javascript helper.
     */
    function to_js($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('tojs');
        }

        if (is_array($key)) {
            return app('tojs')->put($key);
        }

        return app('tojs')->get($key, $default);
    }
}

if (!function_exists('meta')) {

    /**
     * Access the meta helper.
     */
    function meta()
    {
        return app('meta');
    }
}

if (!function_exists('meta_tag')) {

    /**
     * Access the meta tags helper.
     */
    function meta_tag($name = null, $content = null, $attributes = [])
    {
        return app('meta')->tag($name, $content, $attributes);
    }
}

if (!function_exists('meta_property')) {

    /**
     * Access the meta tags helper.
     */
    function meta_property($name = null, $content = null, $attributes = [])
    {
        return app('meta')->property($name, $content, $attributes);
    }
}

if (!function_exists('protection_context')) {

    /**
     * @return \NetLicensing\Context
     */
    function protection_context()
    {
        return app('netlicensing')->context();
    }
}

if (!function_exists('protection_context_basic_auth')) {

    /**
     * @return \NetLicensing\Context
     */
    function protection_context_basic_auth()
    {
        return app('netlicensing')->context(\NetLicensing\Context::BASIC_AUTHENTICATION);
    }
}

if (!function_exists('protection_context_api_key')) {

    /**
     * @return \NetLicensing\Context
     */
    function protection_context_api_key()
    {
        return app('netlicensing')->context(\NetLicensing\Context::APIKEY_IDENTIFICATION);
    }
}

if (!function_exists('protection_shop_token')) {

    /**
     * @param \App\Models\Auth\User\User $user
     * @param null $successUrl
     * @param null $cancelUrl
     * @param null $successUrlTitle
     * @param null $cancelUrlTitle
     * @return \App\Models\Protection\ProtectionShopToken
     */
    function protection_shop_token(\App\Models\Auth\User\User $user, $successUrl = null, $cancelUrl = null, $successUrlTitle = null, $cancelUrlTitle = null)
    {
        return app('netlicensing')->createShopToken($user, $successUrl, $cancelUrl, $successUrlTitle, $cancelUrlTitle);
    }
}

if (!function_exists('protection_validate')) {

    /**
     * @param \App\Models\Auth\User\User $user
     * @return \App\Models\Protection\ProtectionValidation
     */
    function protection_validate(\App\Models\Auth\User\User $user)
    {
        return app('netlicensing')->validate($user);
    }
}

if (!function_exists('__trans_choice')) {

    /**
     * Translates the given message based on a count from json key.
     *
     * @param $key
     * @param $number
     * @param array $replace
     * @param null $locale
     * @return string
     */
    function __trans_choice($key, $number, array $replace = [], $locale = null)
    {
        return trans_choice(__($key), $number, $replace, $locale);
    }
}

if (!function_exists('isSuperAdmin')) {

    /**
     * Is Admin
     *
     * @return bool
     */
    function isSuperAdmin($default = '/')
    {
        $user = \Auth::user();

        return $user->hasRole('Super User');
    }
}

if (!function_exists('isAdmin')) {

    /**
     * Is Admin
     *
     * @return bool
     */
    function isAdmin($default = '/')
    {
        $user = \Auth::user();

        return $user->hasRole('Admin User');
    }
}

if (!function_exists('redirectToDashboad')) {

    /**
     * Redirect To Dashboard
     *
     * @param string $default
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirectToDashboad($default = '/')
    {
        if (isAdmin()) {
            return redirect('/admin');
        }

        return redirect($default);
    }
}

/**
 * This method is used to get auto generated Invoice ID...
 */
function generateInvoiceNumber($inv_len = 7)
{
    $max_inv_id = \App\Invoice::max('id');
    if (empty($max_inv_id))
        $max_inv_id = 1;
    return $dbValue    = str_pad($max_inv_id, $inv_len, "0", STR_PAD_LEFT);
}

/**
 * Module permission helper
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 */
if (!function_exists('hasModulepermission')) {
    /**
     * Creates a API log
     *
     * @author Md Abu Ahsan Basir <maab.career@gmail.com>
     * @return void
     */
    function hasModulepermission($module)
    {
        $user = \Auth::user();
        return $user->hasPermissionToModule($module);
    }
}

/**
 * Make api log helper
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 */
if (!function_exists('makeApiLog')) {
    /**
     * Creates a API log
     *
     * @author Md Abu Ahsan Basir <maab.career@gmail.com>
     * @return void
     */
    function makeApiLog($data)
    {
        $log = new \App\Repositories\Activity\API\Log;
        $log->add($data);
    }
}


if (!function_exists('createBankAccount')) {

    /**
     * Creates a bank account
     *
     * @return bool
     */
    function createBankAccount($parameters, $company_id = null)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreateBankAccount";
        $url = $baseurl . $apiurl;
        $curl = curlPOSTrequest($url, $parameters, $company_id);
    //   dd(auth()->user()->name);
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'CreateBankAccount',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);

        return $curl;
    }
}

if (!function_exists('createCard')) {

    /**
     * Creates a bank account
     *
     * @return bool
     */
    function createCard($parameters, $company_id = null )
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreateCard";
        $url = $baseurl . $apiurl;
        $curl = curlPOSTrequest($url, $parameters, $company_id);
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'CreateCard',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);

        return $curl;
    }
}

if (!function_exists('createVirtualCard')) {

    /**
     * Creates a bank account
     *
     * @return bool
     */
    function createVirtualCard($parameters, $company_id = null)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreateVirtualCard";
        $url = $baseurl . $apiurl;
        $curl = curlGuestPOSTrequest($url, $parameters, 1);
        // Store API log
        // dd('sdsd');
        makeApiLog([
            'customer_name' => ' User',
            'api_name' => 'CreateVirtualCard',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);
        return $curl;
    }
}

if (!function_exists('CreatePayment')) {
    /**
     * Creates a payment based on bank account or credit card object id
     */

    function CreatePayment($parameters, $company_id = null)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreatePayment";
        $url = $baseurl . $apiurl;
        $curl = curlPOSTrequest($url, $parameters, $company_id);
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'CreatePayment',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);

        return $curl;
    }
}


if (!function_exists('MerchantLogin')) {
    /**
     * Creates a payment based on bank account or credit card object id
     */

    function MerchantLogin($parameters)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/EnsembleLogin";
        $url = $baseurl . $apiurl;

        $response = array();
        $curl = curl_init();

        $headerarray = array(
            'Content-Type: application/json'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_HTTPHEADER => $headerarray,
        ));
        $curlresponse = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response['status'] = "error";
            $response['result'] = "cURL Error #:" . $err;
        } else {
            $response['status'] = "success";
            $response['result'] = isJson($curlresponse) ? json_decode($curlresponse) : false;
        }
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'EnsembleLogin',
            'request' => json_decode($parameters),
            'response' => $response,
        ]);
        // dd( $parameters);

        return json_decode(json_encode($response));
    }
}


if (!function_exists('curlPOSTrequest')) {
    function curlPOSTrequest($url, $parameters, $company_id = null )
    {
        $user = \Auth::user();
        $ApiDetails = [];
        $data =  json_decode($parameters);
        $pay = Payments::where('transaction_id',$data->Transaction_id)->first();
        $sender_id = $pay->sender_id;
        $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($sender_id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                }
            }
            // dd($companyid);
         
        $ApiDetails = CompanySetting::where('id', $companyid)->first();
        //  $company_id = 14;
        //  dd($company_id);
        if ($company_id) {
            // $ApiDetails = CompanySetting::where('id', $company_id)->first();
        } else {
            if(isAdmin()){
                // $ApiDetails = CompanySetting::where('user_id',$user->id)->first();
            } else {
                // $CompanyUser = CompanyUser::where('user_id',$user->id)->first();
               // $ApiDetails = CompanySetting::where('id',$CompanyUser->company_id)->first();
            }
        }
        //dd($ApiDetails);

        if(empty($ApiDetails->token)) {
            $login = [
                'Apikey'=>$ApiDetails->api_key,
                'Username'=>$ApiDetails->api_user,
                'Password'=>$ApiDetails->api_password
            ];
            $result = MerchantLogin(json_encode($login));


            if($result->status=='success' && isset($result->result->AuthenticationToken) && !empty($result->result->AuthenticationToken)) {
                $ApiDetails->token = $result->result->AuthenticationToken;
                $ApiDetails->token_expired_at= date('Y-m-d H:i:s',strtotime($result->result->expireDate));
                $ApiDetails->save();
                Session::put('MerchantAuthenticationToken', $result->result->AuthenticationToken);
                $_SESSION['MerchantAuthenticationToken']=$result->result->AuthenticationToken;
            }

        } else {
            $getTime =  date_default_timezone_get();
            date_default_timezone_set("GMT");
            $datetime1 = new DateTime(date('Y-m-d H:i:s'));
            $datetime2 = new DateTime($ApiDetails->token_expired_at);
            date_default_timezone_set($getTime);
            if ($datetime1 < $datetime2) {
                Session::put('MerchantAuthenticationToken', $ApiDetails->token);

            } else {
                $login = [
                    'Apikey'=>$ApiDetails->api_key,
                    'Username'=>$ApiDetails->api_user,
                    'Password'=>$ApiDetails->api_password
                ];
                $result = MerchantGuestLogin(json_encode($login));

                if($result->status=='success' && isset($result->result->AuthenticationToken) && !empty($result->result->AuthenticationToken)) {
                    $ApiDetails->token = $result->result->AuthenticationToken;
                    $ApiDetails->token_expired_at= date('Y-m-d H:i:s',strtotime($result->result->expireDate));
                    $ApiDetails->save();
                    Session::put('MerchantAuthenticationToken', $result->result->AuthenticationToken);
                }
            }
        }
        $response = array();
        $curl = curl_init();
        $headerarray = array();
        $headerarray = array(
            'Authorization: bearer ' . $ApiDetails->token,
            'Content-Type: application/json'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_HTTPHEADER => $headerarray,
        ));
        $curlresponse = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            $response['status'] = "error";
            $response['result'] = "cURL Error #:" . $err;
        } else {
            $response['status'] = "success";
            $response['result'] = isJson($curlresponse) ? json_decode($curlresponse) : false;
        }
        return json_encode($response);
    }
}



if (!function_exists('createTransaction')) {

    function createTransaction($paymentRefID, $payment_amount, $Message, $transaction_status, $transaction_name, $transaction_type)
    {
        $transactions = new Transactions();
        $transactions->transaction_id = $paymentRefID;
        // dd($payment_amount);
        $transactions->transaction_amount = $payment_amount;
        $transactions->transaction_description = $Message != "" ? $Message : "No Message";
        $transactions->transaction_status = $transaction_status;
        $transactions->transaction_name = $transaction_name;
        $transactions->transaction_type = $transaction_type;
        $transactions->user_id = Auth::user()->id;
        if ($transactions->save()) {
            return ($transactions->id);
        } else {
            return false;
        }
    }
}


if (!function_exists('insertPaymentDetailsBank')) {

    function insertPaymentDetailsBank($paymentmethod, $email, $payment_amount, $account_number, $routing_number, $account_type, $bank_account_name)
    {
        $paymentdetails = new PaymentDetails();
        $paymentdetails->payment_method = $paymentmethod;
        $paymentdetails->email = $email;
        $paymentdetails->payment_amount = $payment_amount;
        $paymentdetails->account_number = $account_number;
        $paymentdetails->routing_number = $routing_number;
        $paymentdetails->account_type = $account_type;
        $paymentdetails->bank_account_name = $bank_account_name;

      
        if ($paymentdetails->save()) {
            return ($paymentdetails->id);
        } else {
            return false;
        }
    }
}

if (!function_exists('insertOnlinePaymentDetails')) {

    function insertOnlinePaymentDetails($data)
    {
        $onlinePaymentdetails = new OnlinePaymentDetails();
        if (is_array($data) && sizeof($data) > 0) {
            foreach ($data as $field => $value) {
                $onlinePaymentdetails->{$field} = $value;
            }

            if ($onlinePaymentdetails->save()) {
                return ($onlinePaymentdetails->id);
            } else {
                return false;
            }
        }
        return false;

    }
}

if (!function_exists('insertPaymentDetailsCard')) {
    function insertPaymentDetailsCard($payment_method,$email, $payment_amount,$name ,$credit_card_number, $expiry_date,$cvv, $address, $city, $state, $zip)
    {
        $paymentdetails = new PaymentDetails();
        $paymentdetails->payment_method = $payment_method;
        $paymentdetails->email = $email;
        $paymentdetails->payment_amount = $payment_amount;
        $paymentdetails->card_holder_name = $name;
        $paymentdetails->card_number = $credit_card_number;
        $paymentdetails->address_line_1 = $address;
        if ($request->card_address2 != "") {
            $paymentdetails->address_line_2 = $address;
        }
        $paymentdetails->city = $city;
        $paymentdetails->state = $state;
        $paymentdetails->country = $request->card_country;
        $paymentdetails->zipcode = $zip;
        $paymentdetails->CVV = $cvv;
        $paymentdetails->month = $expiry_date;
        $paymentdetails->year = $expiry_date;
        if ($paymentdetails->save()) {
            return $paymentdetails->id;
        } else {
            return false;
        }
    }
}


if (!function_exists('insertPayment')) {
    function insertPayment($payment_type, $transaction_id, $payment_details_id, $payment_amount, $email, $is_reoccuring, $is_guest, $payment_status, $description)
    {
        $payments = new Payments();
        $user = User::where('email', $email)->first();
        if ($user) {
            $payments->user_id = $user->id;
        }
        $payments->payment_type = $payment_type;
        $payments->transaction_id = $transaction_id;
        $payments->payment_details_id = $payment_details_id;
        $payments->payment_amount = $payment_amount;
        $payments->email = $email;
        $payments->is_reoccuring = $is_reoccuring;
        $payments->is_guest = $is_guest;
        $payments->payment_status = $payment_status;
        $payments->description = $description != "" ? $description : '';
        $payments->sender_id = Auth::user()->id;
        if ($payments->save()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getUserInfoById')) {
    function getUserInfoById($userId)
    {
        $getUserInfo = User::find($userId);
        return (isset($getUserInfo->first_name) ? $getUserInfo->first_name : '' . " " . isset($getUserInfo->first_name)) ? $getUserInfo->first_name : '';
    }
}

if (!function_exists('isJson')) {
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
if (!function_exists('curlGuestPOSTrequest')) {
    function curlGuestPOSTrequest($url, $parameters)
    {
        $ApiDetails = [];

        $data =  json_decode($parameters);
        // dd($data);

       if(isset($data->companyid)){

        $ApiDetails = CompanySetting::where('company_name', $data->companyid)->first();
        // dd($ApiDetails);

       }
       else{
        $Transaction = Transactions::where('id', $data->tId)->first();
 $user_id = $Transaction->user_id;
 $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user_id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                //   dd('cp');
                }
                $ApiDetails = CompanySetting::where('id', $companyid)->first();
                // dd($companyid);
            }

        // $ApiDetails = CompanySetting::whereJsonContains('user_id', 15)->first();

            // dd($Transaction);       

        }

    //    dd($ApiDetails->token);
        if(empty($ApiDetails->token)) {
            // dd($ApiDetails->api_password);
            $login = [
                'Apikey'=>$ApiDetails->api_key,
                'Username'=>$ApiDetails->api_user,
                'Password'=>$ApiDetails->api_password
            ];
            $result = MerchantGuestLogin(json_encode($login));
            
            if($result->status=='success' && isset($result->result->AuthenticationToken) && !empty($result->result->AuthenticationToken)) {
                $ApiDetails->token = $result->result->AuthenticationToken;
                $ApiDetails->token_expired_at= date('Y-m-d H:i:s',strtotime($result->result->expireDate));
                $ApiDetails->save();
                Session::put('MerchantAuthenticationToken', $result->result->AuthenticationToken);
                $_SESSION['MerchantAuthenticationToken']=$result->result->AuthenticationToken;
            }

        } else {
            $getTime =  date_default_timezone_get();
            date_default_timezone_set("GMT");
            $datetime1 = new DateTime(date('Y-m-d H:i:s'));
            $datetime2 = new DateTime($ApiDetails->token_expired_at);
            date_default_timezone_set($getTime);
            if ($datetime1 < $datetime2) {
                Session::put('MerchantAuthenticationToken', $ApiDetails->token);
                $_SESSION['MerchantAuthenticationToken']=$ApiDetails->token;

            } else {
                $login = [
                    'Apikey'=>$ApiDetails->api_key,
                    'Username'=>$ApiDetails->api_user,
                    'Password'=>$ApiDetails->api_password
                ];
                $result = MerchantGuestLogin(json_encode($login));
                if($result->status=='success' && isset($result->result->AuthenticationToken) && !empty($result->result->AuthenticationToken)) {
                    $ApiDetails->token = $result->result->AuthenticationToken;
                    $ApiDetails->token_expired_at= date('Y-m-d H:i:s',strtotime($result->result->expireDate));
                    $ApiDetails->save();
                    Session::put('MerchantAuthenticationToken', $result->result->AuthenticationToken);
                }
            }
        }


        $response = array();
        $curl = curl_init();
        $headerarray = array();
        $headerarray = array(
            'Authorization: bearer ' . $ApiDetails->token,
            'Content-Type: application/json'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_HTTPHEADER => $headerarray,
        ));
        $curlresponse = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response['status'] = "error";
            $response['result'] = "cURL Error #:" . $err;
        } else {
            $response['status'] = "success";
            $response['result'] = isJson($curlresponse) ? json_decode($curlresponse) : false;
        }
        return json_encode($response);
    }
}



if (!function_exists('MerchantGuestLogin')) {
    /**
     * Creates a payment based on bank account or credit card object id
     */

    function MerchantGuestLogin($parameters)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/EnsembleLogin";
        $url = $baseurl . $apiurl;

        $response = array();
        $curl = curl_init();

        $headerarray = array(
            'Content-Type: application/json'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_HTTPHEADER => $headerarray,
        ));
        $curlresponse = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response['status'] = "error";
            $response['result'] = "cURL Error #:" . $err;
        } else {
            $response['status'] = "success";
            $response['result'] = isJson($curlresponse) ? json_decode($curlresponse) : false;
        }
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'EnsembleLogin',
            'request' => json_decode($parameters),
            'response' => $response,
        ]);

        return json_decode(json_encode($response));
    }
}

if (!function_exists('createGuestBankAccount')) {

    /**
     * Creates a bank account
     *
     * @return bool
     */
    function createGuestBankAccount($parameters)
    {

        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreateBankAccount";
        $url = $baseurl . $apiurl;
        $curl = curlGuestPOSTrequest($url, $parameters);
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'CreateBankAccount',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);

        return $curl;
    }
}

if (!function_exists('CreateGuestPayment')) {
    /**
     * Creates a payment based on bank account or credit card object id
     */

    function CreateGuestPayment($parameters)
    {
        $baseurl = "https://extest.achprocessing.com/ACHEnsemble";
        $apiurl = "/api/Ensemble/CreatePayment";
        $url = $baseurl . $apiurl;
        $curl = curlGuestPOSTrequest($url, $parameters);
        // Store API log
        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->name : 'Guest User',
            'api_name' => 'CreatePayment',
            'request' => json_decode($parameters),
            'response' => json_decode($curl),
        ]);
        return $curl;
    }
}

if (!function_exists('createGuestTransaction')) {

    function createGuestTransaction($paymentRefID, $payment_amount, $Message, $transaction_status, $transaction_name, $transaction_type)
    {
        $transactions = new Transactions();
        $transactions->transaction_id = $paymentRefID;
        $transactions->transaction_amount = $payment_amount;
        $transactions->transaction_description = $Message != "" ? $Message : "No Message";
        $transactions->transaction_status = $transaction_status;
        $transactions->transaction_name = $transaction_name;
        $transactions->transaction_type = $transaction_type;
        // $transactions->user_id = Auth::user()->id;
        if ($transactions->save()) {
            return ($transactions->id);
        } else {
            return false;
        }
    }
}

if (!function_exists('insertGuestPaymentDetailsBank')) {

    function insertGuestPaymentDetailsBank($paymentmethod, $email, $payment_amount, $account_number, $routing_number, $account_type, $bank_account_name)
    {
        $paymentdetails = new PaymentDetails();
        $paymentdetails->payment_method = $paymentmethod;
        $paymentdetails->email = $email;
        $paymentdetails->payment_amount = $payment_amount;
        $paymentdetails->account_number = $account_number;
        $paymentdetails->routing_number = $routing_number;
        $paymentdetails->account_type = $account_type;
        $paymentdetails->bank_account_name = $bank_account_name;
        if ($paymentdetails->save()) {
            return ($paymentdetails->id);
        } else {
            return false;
        }
    }
}

if (!function_exists('insertGuestPayment')) {
    function insertGuestPayment($payment_type, $transaction_id, $payment_details_id, $payment_amount, $email, $is_reoccuring, $is_guest, $payment_status, $description)
    {
        $payments = new Payments();
        // $user = User::where('email', $email)->first();
        // if ($user) {
        //     $payments->user_id = $user->id;
        // }
        $payments->payment_type = $payment_type;
        $payments->transaction_id = $transaction_id;
        $payments->payment_details_id = $payment_details_id;
        $payments->payment_amount = $payment_amount;
        $payments->email = $email;
        $payments->is_reoccuring = $is_reoccuring;
        $payments->is_guest = $is_guest;
        $payments->payment_status = $payment_status;
        $payments->description = $description != "" ? $description : '';
        $payments->sender_id = 1;
        if ($payments->save()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('debug_to_console')) {
    function debug_to_console($data) {
        $output = $data;
        // if (is_array($output))
        //     $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
    
}

if (!function_exists('getFreeAdmins')) {
    function getFreeAdmins() {
        // if (is_array($output))
        //     $output = implode(',', $output);
        $cmps = \App\CompanySetting::all();
        $users = \App\Models\Auth\User\User::all();
    
        // $data = new \App\Models\Auth\User\User;
        $data = array();
        $user_ids = array();
       foreach($cmps as $cmp){
        $ids = [];

        $ids = json_decode($cmp->user_id);
        foreach($ids as $id){
            array_push($user_ids,$id);
        }
        }
        foreach($users as $user){
            // $data->append($user->toArray());
            if(!in_array($user->id,$user_ids)){
            array_push($data,$user);
            }
            }
        return $data;
    }
    
}

if (!function_exists('getCompanyAdmins')) {
    function getCompanyAdmins($userIds) {
        // if (is_array($output))
        //     $output = implode(',', $output);
        $users = \App\Models\Auth\User\User::all();
    
        // $data = new \App\Models\Auth\User\User;
        $data = array();
        
        foreach($users as $user){
            // $data->append($user->toArray());
            if(in_array($user->id,$userIds)){
            array_push($data,$user);
            }
            }

        return $data;
    }
    
}

