<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

//models
use App\CompanySetting;
use App\CompanyUser;

use App\Transactions;
use App\Payments;
use App\PaymentDetails;
use App\PaymentDetailOnline;
use App\Helpers\LogActivity;
use App\OnlinePaymentDetails;

use App\Models\Auth\User\User;

//custom
use Mail;
use App\Mail\SendPaymentLinkMail;
use App\Mail\ReceivePayment;
use App\Mail\SendPaymentLinkMailUnreg;

class UpdatedPaymentsController extends Controller
{
    public function processGuestPaymentforPayee(Request $request){
        // dd($request->all());
        if ($request->payment_method == "bank_account") 
        {
            $validator = Validator::make($request->all(), [
                'account_number'   => 'required|numeric',
                'routing_number'   => 'required|numeric',
                'account_type'     => 'required',
                // 'bank_account_name'  => 'required|max:255',
                // 'email'      => 'required|email|max:255',
                ]);
        
                if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();
        
                // $transaction = Transactions::find($request->tId);
        
                $company = CompanySetting::where('company_name',$request->cId)->first();
//dd($company);
                if($company == null){
                $company = CompanySetting::find($request->cId);
                }

                // dd($company);

                if($company == null){
                    Session::flash('errorMessage', 'We cann\'t find any company associated');
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
               // dd($company->api_user);
        
        
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/EnsembleLogin",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "Apikey=".$company->api_key."&Username=".$company->api_user."&Password=".$company->api_password,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    "postman-token: 229a03dd-7b70-0d2e-6453-377d4304923e"
                ),
                ));
        
                $response = curl_exec($curl);
                //dd($response);
                if(!isJson($response)){
                    Session::flash('errorMessage', 'Api Internal Server Issue');
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
        
                $jsonResponse = json_decode($response);
        
                //  dd($response);
                $err = curl_error($curl);
                curl_close($curl);
        // dd($err);
                if ($err) {
        
                Session::flash('errorMessage', $err);
                return redirect()->back()->withFlashDanger('Payment Failed!');
                }
        
                if ($response == "\"Login Faulted\"" || $jsonResponse->AuthenticationToken == null) {
                    Session::flash('errorMessage', "Login Faulted! Api Credentials are Wrong");
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
                // dd($jsonResponse->AuthenticationToken);
            $authToken = $jsonResponse->AuthenticationToken;
       // dd($request->name." ".$request->lname);
        
                $company->token = $jsonResponse->AuthenticationToken;
                $company->token_expired_at= date('Y-m-d H:i:s',strtotime($jsonResponse->expireDate));
                $company->save();
        
                $curl = curl_init();
        // dd($request->account_type);
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/CreateBankAccount",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&AccountNumber=".$request->account_number."&RoutingNumber=".$request->routing_number."&AccountType=".$request->account_type."&BankAccountName=".$request->name." ".$request->lname,
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: bearer ".$authToken,
                                    "cache-control: no-cache",
                                    "content-type: application/x-www-form-urlencoded"
                                    // "postman-token: 30ab8a3e-016d-ef94-4590-b3c305625ceb"
                                ),
                                ));
        
                                $response = curl_exec($curl);
        // dd($authToken);

                                if(!isJson($response)){
                                    Session::flash('errorMessage', 'Api Internal Server Issue');
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                                $jRes = json_decode($response);
    //   dd($jRes);
                                if(isSet($jRes->Message) && $jRes->Message == 'An error has occurred.'){
                                    Session::flash('errorMessage', 'Api Internal Server Issue');
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
                             
// dd($jRes);
                                // dd($jRes->paymentMethodRefID);
                                // dd($jRes);
                                $err = curl_error($curl);
                                
                                 curl_close($curl);
        
        
                                if ($err) {
        
                               Session::flash('errorMessage', $err);
                               return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                                if ($jRes->status->ResponseCode != "Ok" || $jRes->paymentMethodRefID == null) {
                                    Session::flash('errorMessage', $jRes->status->Message);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                 $paymentMethodRefID = $jRes->paymentMethodRefID;
        
        // dd($paymentMethodRefID);
                                         $curl = curl_init();
        
                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/CreatePayment",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&paymentMethodobjectId=".$paymentMethodRefID."&actionType=2&Amount=".$request->payment_amount."&ServiceFee=0",
                                        CURLOPT_HTTPHEADER => array(
                                            "authorization: bearer ".$authToken,
                                            "cache-control: no-cache",
                                            "content-type: application/x-www-form-urlencoded",
                                            "postman-token: 0553256c-c1ee-1d41-a648-2a07fe49830f"
                                        ),
                                        ));
        
                                        $response = curl_exec($curl);
        
                                        if(!isJson($response)){
                                            Session::flash('errorMessage', 'Api Internal Server Issue');
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
        
                                        $jsonRes = json_decode($response);
                                        // dd($jsonRes);
                                        $err = curl_error($curl);
        
                                        curl_close($curl);
        
                                        if ($err) {
                                            Session::flash('errorMessage', $err);
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
                                       
                                        if ($jsonRes->status->ResponseCode != "Ok" || $jsonRes->paymentRefID == null || $jsonRes->status->ErrorCode != null ) {
                                            // dd($jsonRes);
                                         
                                            Session::flash('errorMessage', "Api Internel server error Message received is: ".$jsonRes->status->Message);
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
        

                                        $data['name']  = $company->company_name;
                                        $data['sender']  = $request->email;
                                        $data['amount']  = $request->payment_amount;
                                    
                                        // $mail = $request->email;
                                        Mail::to($company->email)->send(new ReceivePayment($data));



                                        //payment received code
                                        $received = new PaymentDetailOnline;
                                        $received->payment_method = 'bank';
                                        $received->email =  $request->email;
                                         $received->user_id =  $company->id;
                                        $received->payment_amount =  $request->payment_amount;
                                        $received->account_number =  $request->account_number;
                                        $received->routing_number =  $request->routing_number;
                                        $received->account_type =  $request->account_type;
                                        $received->bank_account_name =  $request->name.' '.$request->lname ;
                                        // $received->card_holder_name =  $request->name.' '.$request->lname ;
                                        $received->address_line_1 =  $request->address ;
                                        $received->city =  $request->city;
                                        $received->state =  $request->state;
                                        $received->zipcode =  $request->zip;


                                        $received->save();


                                        //payment received code here




                                        makeApiLog([
                                            'customer_name' => $request->name,
                                            'api_name' => 'Bank Payment Received',
                                            'request' => json_encode($request->all()),
                                            'response' => json_encode($response),
                                        ]);




                                        Session::flash('successMessage', "Payment is Successfully Completed! ");
                                        $company_name = $company->company_name;
                                        $amount = $request->payment_amount;
                                        return view('admin.Response.success', compact('paymentMethodRefID','company_name','amount'));

                                        // return redirect()->back()->withFlashSuccess('Payment is Successfully Completed!');
        

        }elseif($request->payment_method == "credit_card"){
            //dd($request->all());
            $validator = Validator::make($request->all(), [
                'cvv'   => 'required|numeric',
                'credit_card_number'   => 'required',
                'expiry_date'     => 'required',
                'zip'     => 'required',
                'state'     => 'required',
                'city'     => 'required',
                'address'     => 'required',
                'lname'     => 'required',
                'name'     => 'required',
                'payment_amount'     => 'required',

                // 'bank_account_name'  => 'required|max:255',
                // 'email'      => 'required|email|max:255',
                ]);
        
                if ($validator->fails()) { 
                    dd($validator->errors());
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
        
                // $transaction = Transactions::find($request->tId);
        
                $company = CompanySetting::where('company_name',$request->cId)->first();

                // dd($company);
                if($company == null){
                $company = CompanySetting::find($request->cId);
                }

                // dd($company);

                if($company == null){
                    Session::flash('errorMessage', 'We cann\'t find any company associated');
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
        
        
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/EnsembleLogin",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "Apikey=".$company->api_key."&Username=".$company->api_user."&Password=".$company->api_password,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    "postman-token: 229a03dd-7b70-0d2e-6453-377d4304923e"
                ),
                ));
        
                $response = curl_exec($curl);
                // dd($response);
                if(!isJson($response)){
                    Session::flash('errorMessage', 'Api Internal Server Issue');
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
        
                $jsonResponse = json_decode($response);
        
                //  dd($response);
                $err = curl_error($curl);
                curl_close($curl);
        // dd($err);
                if ($err) {
        
                Session::flash('errorMessage', $err);
                return redirect()->back()->withFlashDanger('Payment Failed!');
                }
        
                if ($response == "\"Login Faulted\"" || $jsonResponse->AuthenticationToken == null) {
                    Session::flash('errorMessage', "Login Faulted! Api Credentials are Wrong");
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
                // dd($jsonResponse->AuthenticationToken);
            $authToken = $jsonResponse->AuthenticationToken;
        
        
                $company->token = $jsonResponse->AuthenticationToken;
                $company->token_expired_at= date('Y-m-d H:i:s',strtotime($jsonResponse->expireDate));
                $company->save();
        
                $curl = curl_init();
                                                                                                                                                                                                                                                                                                                    
                              
                        $month = substr($request->expiry_date, 0, 2);
                        $year = substr($request->expiry_date, 3, 5);

                                curl_setopt_array($curl, array(
                                CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/CreateCard",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&cardHolderName=".$request->name."&cardNumber=".$request->credit_card_number."&cardAddress1=".$request->address."&cardCity=".$request->city."&cardState=".$request->state."&cardCountry=".$request->country."&cardZipCode=".$request->zip."&cardCVV=".$request->cvv."&cardExpiryMonth=".$month."&cardExpiryYear=".$year,
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: bearer ".$authToken,
                                    "cache-control: no-cache",
                                    "content-type: application/x-www-form-urlencoded",
                                    "postman-token: 30ab8a3e-016d-ef94-4590-b3c305625ceb"
                                ),
                                ));
        
                                $response = curl_exec($curl);
        // dd($response);
                                if(!isJson($response)){
							//		dd(' asa');
                                    Session::flash('errorMessage', 'Api Internal Server Issue');
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                                $jRes = json_decode($response);
       //  dd($jRes);
       if(isSet($jRes->Message) && $jRes->Message == 'An error has occurred.'){
        Session::flash('errorMessage', 'Api Internal Server Issue');
        return redirect()->back()->withFlashDanger('Payment Failed!');
    }
                                $err = curl_error($curl);
                                
                                 curl_close($curl);
        
        
                                if ($err) {
        
                               Session::flash('errorMessage', $err);
                               return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                                if ($jRes->status->ResponseCode != "Ok" || $jRes->paymentMethodRefID == null) {
                                    Session::flash('errorMessage', $jRes->status->Message);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
        
                 $paymentMethodRefID = $jRes->paymentMethodRefID;
        
        // dd($paymentMethodRefID);
                                         $curl = curl_init();
        
                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => $company->api_endpoint. "/ACHEnsemble/api/Ensemble/CreatePayment",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&paymentMethodobjectId=".$paymentMethodRefID."&actionType=2&Amount=".$request->payment_amount."&ServiceFee=0",
                                        CURLOPT_HTTPHEADER => array(
                                            "authorization: bearer ".$authToken,
                                            "cache-control: no-cache",
                                            "content-type: application/x-www-form-urlencoded",
                                            "postman-token: 0553256c-c1ee-1d41-a648-2a07fe49830f"
                                        ),
                                        ));
        
                                        $response = curl_exec($curl);
        //dd($response);
                                        if(!isJson($response)){
                                            Session::flash('errorMessage', 'Api Internal Server Issue');
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
        
                                        $jsonRes = json_decode($response);
                                        // dd($jsonRes);
                                        // dd($response);
                                        $err = curl_error($curl);
        
                                        curl_close($curl);
        
                                        if ($err) {
                                            Session::flash('errorMessage', $err);
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
                                       
                                        if ($jsonRes->status->ResponseCode != "Ok" || $jsonRes->paymentRefID == null || $jsonRes->status->ErrorCode != null ) {
                                            // dd($jsonRes);
                                         
                                            Session::flash('errorMessage', "Api Internel server error Message received is: ".$jsonRes->status->Message);
                                            return redirect()->back()->withFlashDanger('Payment Failed!');
                                        }
        
        
                                        $data['name']  = $company->company_name;
                                        $data['sender']  = $request->email;
                                        $data['amount']  = $request->payment_amount;
                                    
                                        // $mail = $request->email;
                                        Mail::to($company->email)->send(new ReceivePayment($data));

// dd('sadasdsad');
                                        $received = new PaymentDetailOnline;
                                        $received->payment_method = 'credit_card';
                                        $received->email =  $request->email;
                                         $received->user_id =  $company->id;
                                        $received->payment_amount =  $request->payment_amount;
                                        $received->card_holder_name =  $request->name.' '.$request->lname ;
                                        // $received->card_holder_name =  $request->name.' '.$request->lname ;
                                        $received->card_number =  $request->credit_card_number ;

                                        $received->city =  $request->city;
                                        $received->state =  $request->state;
                                        $received->country =  $request->country;
                                        $received->address_line_1 =  $request->address;

                                        $received->zipcode =  $request->zip;
                                        $received->CVV =  $request->cvv;
                                        $received->month =  $request->month;
                                        $received->year =  $request->year;
                               
                               
                                        $received->save();
// dd('sadasdsad');


                                        makeApiLog([
                                            'customer_name' => $request->name,
                                            'api_name' => 'Bank Payment Received',
                                            'request' => json_encode($request->all()),
                                            'response' => json_encode($response),
                                        ]);

                                        Session::flash('successMessage', "Payment is Successfully Completed! ");
                                        // return view('admin.Response.success', compact('paymentMethodRefID'));
                                        return view('admin.Response.success', compact('paymentMethodRefID','company_name','amount'));


                                        // return redirect()->back()->withFlashSuccess('Payment is Successfully Completed!');
        


        }//endcreditcard
        
    }
    public function processPaymentforAcceptence(Request $request){
        //   dd($request->all());
          
          
        $transaction = Transactions::find($request->tId);

        if($transaction == null){
            Session::flash('errorMessage', 'There is some error in transaction');
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        
if($transaction->transaction_status == 'successful'){
    Session::flash('errorMessage', 'You have already completed this transaction');
    return redirect()->back()->withFlashDanger('Payment Failed!');
}


        if ($request->payment_method == "bank_account") 
        {
        $validator = Validator::make($request->all(), [
        'account_number'   => 'required|numeric',
        'routing_number'   => 'required|numeric',
        'account_type'     => 'required',
        'bank_account_name'  => 'required|max:255',
        // 'email'      => 'required|email|max:255',
        ]);

        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

        $transaction = Transactions::find($request->tId);

        $company = CompanySetting::find($transaction->company_id);

            //dd($transaction);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/EnsembleLogin",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "Apikey=".$company->api_key."&Username=".$company->api_user."&Password=".$company->api_password,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: 229a03dd-7b70-0d2e-6453-377d4304923e"
        ),
        ));

        $response = curl_exec($curl);

        if(!isJson($response)){
            Session::flash('errorMessage', 'Api Internal Server Issue');
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        $jsonResponse = json_decode($response);

        $parameters['ApiKey'] = $company->api_key;
        $parameters['Username'] = $company->api_user;
        $parameters['Password'] = $company->api_password;

        $pms = json_encode($parameters);

        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
            'api_name' => 'EnsembleLogin',
            'request' => json_decode($pms),
            'response' => json_decode($response),
        ]);


        //  dd($response);
        $err = curl_error($curl);
        curl_close($curl);
// dd($err);
        if ($err) {

        Session::flash('errorMessage', $err);
        return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        if ($response == "\"Login Faulted\"" || $jsonResponse->AuthenticationToken == null) {
            Session::flash('errorMessage', "Login Faulted! Api Credentials are Wrong");
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }
        // dd($jsonResponse->AuthenticationToken);
    $authToken = $jsonResponse->AuthenticationToken;


        $company->token = $jsonResponse->AuthenticationToken;
        $company->token_expired_at= date('Y-m-d H:i:s',strtotime($jsonResponse->expireDate));
        $company->save();

        $curl = curl_init();

                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/CreateBankAccount",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&AccountNumber=".$request->account_number."&RoutingNumber=".$request->routing_number."&AccountType=".$request->account_type."&BankAccountName=".$request->bank_account_name,
                        CURLOPT_HTTPHEADER => array(
                            "authorization: bearer ".$authToken,
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded"
                        ),
                        ));

                        $response = curl_exec($curl);

                        $jsonResponse = json_decode($response);

                        $parameters2['AccountNumber'] = $request->account_number;
                        $parameters2['RoutingNumber'] = $request->routing_number;
                        $parameters2['AccountType'] = $request->account_type;
                        $parameters2['AccountType'] = $request->account_type;
                        $parameters2['BankAccountName'] = $request->bank_account_name;
                
                        $pms = json_encode($parameters2);
                
                        makeApiLog([
                            'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
                            'api_name' => 'Bank Account',
                            'request' => json_decode($pms),
                            'response' => json_decode($response),
                        ]);

                        if(!isJson($response)){
                            Session::flash('errorMessage', 'Api Internal Server Issue');
                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

                        $jRes = json_decode($response);

                        $err = curl_error($curl);
                        
                         curl_close($curl);


                        if ($err) {

                       Session::flash('errorMessage', $err);
                       return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

                        if ($jRes->status->ResponseCode != "Ok" || $jRes->paymentMethodRefID == null) {
                            Session::flash('errorMessage', "Api Internel server error");
                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

         $paymentMethodRefID = $jRes->paymentMethodRefID;

// dd($paymentMethodRefID);
                                 $curl = curl_init();

                                curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/CreatePayment",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&paymentMethodobjectId=".$paymentMethodRefID."&actionType=1&Amount=".$request->payment_amount."&ServiceFee=0",
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: bearer ".$authToken,
                                    "cache-control: no-cache",
                                    "content-type: application/x-www-form-urlencoded",
                                    "postman-token: 0553256c-c1ee-1d41-a648-2a07fe49830f"
                                ),
                                ));

                                $response = curl_exec($curl);

                                
                        $parameters3['paymentMethodobjectId'] = $paymentMethodRefID;
                        $parameters3['actionType'] = '1';
                        $parameters3['Amount'] = $request->payment_amount;
                        $parameters3['ServiceFee'] = '0';
                
                        $pms = json_encode($parameters3);
                
                        makeApiLog([
                            'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
                            'api_name' => 'PaymentApi',
                            'request' => json_decode($pms),
                            'response' => json_decode($response),
                        ]);
                                if(!isJson($response)){
                                    Session::flash('errorMessage', 'Api Internal Server Issue');
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }

                                $jsonRes = json_decode($response);
                                // dd($response);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {
                                    Session::flash('errorMessage', $err);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
                               
                                if ($jsonRes->status->ResponseCode != "Ok" || $jsonRes->paymentRefID == null || $jsonRes->status->ErrorCode != null ) {
                                    // dd($jsonRes);
                                 
                                    Session::flash('errorMessage', "Api Internel server error Message received is: ".$jsonRes->status->Message);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }

                                $transaction = Transactions::find($request->tId);
                                // dd($transaction);
                                $transaction->transaction_status = 'successful';
                                $transaction->transaction_type = 'bank_account';
                                $transaction->transaction_id = $paymentMethodRefID;


                                $transaction->save();

                                $paymentDetail = new PaymentDetails;
                                $paymentDetail->payment_method = 'bank_account';
                                $paymentDetail->payment_method = 'bank_account';
                                $paymentDetail->email = auth()->user() ? auth()->user()->email : $request->email;
                                $paymentDetail->payment_amount = $request->payment_amount;
                                $paymentDetail->account_number = $request->account_number;
                                $paymentDetail->routing_number = $request->routing_number;
                                $paymentDetail->account_type = $request->account_type;
                                $paymentDetail->bank_account_name = $request->bank_account_name;


                                if($paymentDetail->save()){
                                    $payment = Payments::where('transaction_id', $request->tId)->first();
                                    $payment->payment_status =  'completed';
                                    $payment->payment_type =  'bank_account';
                                    $payment->payment_details_id =  $paymentDetail->id;
                                    $payment->save();
    
                                }


                                return redirect()->back()->withFlashSuccess('Payment is Successfully Completed!');

                        // dd('proceed');

    }//end bank account
   elseif($request->payment_method == "virtual_card"){
// dd($request->all());
    $validator = Validator::make($request->all(), [
        'name'   => 'required',
        'payment_amount'   => 'required',
        // 'email'      => 'required|email|max:255',
        ]);

        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

        $transaction = Transactions::find($request->tId);

        $company = CompanySetting::find($transaction->company_id);


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/EnsembleLogin",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "Apikey=".$company->api_key."&Username=".$company->api_user."&Password=".$company->api_password,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: 229a03dd-7b70-0d2e-6453-377d4304923e"
        ),
        ));

        $response = curl_exec($curl);

        
        $parameters4['ApiKey'] = $company->api_key;
        $parameters4['Username'] = $company->api_user;
        $parameters4['Password'] = $company->api_password;

        $pms = json_encode($parameters4);

        makeApiLog([
            'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
            'api_name' => 'EnsembleLogin',
            'request' => json_decode($pms),
            'response' => json_decode($response),
        ]);


        if(!isJson($response)){
            Session::flash('errorMessage', 'Api Internal Server Issue');
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        $jsonResponse = json_decode($response);

        //  dd($response);
        $err = curl_error($curl);
        curl_close($curl);
// dd($err);
        if ($err) {

        Session::flash('errorMessage', $err);
        return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        if ($response == "\"Login Faulted\"" || $jsonResponse->AuthenticationToken == null) {
            Session::flash('errorMessage', "Login Faulted! Api Credentials are Wrong");
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }
        // dd($jsonResponse->AuthenticationToken);
    $authToken = $jsonResponse->AuthenticationToken;


        $company->token = $jsonResponse->AuthenticationToken;
        $company->token_expired_at= date('Y-m-d H:i:s',strtotime($jsonResponse->expireDate));
        $company->save();

        $curl = curl_init();

                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/CreateVirtualCard",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&PayeeName=".$request->name."&amount=".$request->payment_amount,
                        CURLOPT_HTTPHEADER => array(
                            "authorization: bearer ".$authToken,
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded",
                            "postman-token: 30ab8a3e-016d-ef94-4590-b3c305625ceb"
                        ),
                        ));

                        $response = curl_exec($curl);
                       // dd($response);
                        $parameters5['PayeeName'] = $request->name;
                        $parameters5['amount'] = $request->payment_amount;
                
                        $pms = json_encode($parameters5);
                
                        makeApiLog([
                            'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
                            'api_name' => 'Virtual Card',
                            'request' => json_decode($pms),
                            'response' => json_decode($response),
                        ]);
                        // dd($response);
                        if(!isJson($response)){
                            Session::flash('errorMessage', 'Api Internal Server Issue');
                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

                        $jRes = json_decode($response);
// dd($jRes);
                        $err = curl_error($curl);
                        
                         curl_close($curl);


                        if ($err) {

                       Session::flash('errorMessage', $err);
                       return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

                        if ($jRes->status->ResponseCode != "Ok" || $jRes->paymentMethodRefID == null) {
                            Session::flash('errorMessage', "Api Internel server error");
                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }

         $paymentMethodRefID = $jRes->paymentMethodRefID;

// dd($paymentMethodRefID);
                                 $curl = curl_init();

                                curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/CreatePayment",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "merchantObjectID=BBF7B97D-9858-4EFB-8217-D9264D0C7436&paymentMethodobjectId=".$paymentMethodRefID."&actionType=1&Amount=".$request->payment_amount."&ServiceFee=0",
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: bearer ".$authToken,
                                    "cache-control: no-cache",
                                    "content-type: application/x-www-form-urlencoded",
                                    "postman-token: 0553256c-c1ee-1d41-a648-2a07fe49830f"
                                ),
                                ));

                                $response = curl_exec($curl);
$parameters6['paymentMethodobjectId'] = $paymentMethodRefID;
$parameters6['actionType'] = '1';
$parameters6['Amount'] = $request->payment_amount;
$parameters6['ServiceFee'] = '0';

$pms = json_encode($parameters6);

makeApiLog([
    'customer_name' => auth()->user() ? auth()->user()->email : 'Guest User',
    'api_name' => 'PaymentApi',
    'request' => json_decode($pms),
    'response' => json_decode($response),
]);
                                if(!isJson($response)){
                                    Session::flash('errorMessage', 'Api Internal Server Issue');
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }

                                $jsonRes = json_decode($response);
                                // dd($response);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {
                                    Session::flash('errorMessage', $err);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
                               
                                if ($jsonRes->status->ResponseCode != "Ok" || $jsonRes->paymentRefID == null || $jsonRes->status->ErrorCode != null ) {
                                    // dd($jsonRes);
                                 
                                    Session::flash('errorMessage', "Api Internel server error Message received is: ".$jsonRes->status->Message);
                                    return redirect()->back()->withFlashDanger('Payment Failed!');
                                }
                                $data = $jsonRes;
                                $date = date_create_from_format('Y-m-d', $jsonRes->exp);
            // dd($date);
            $array = array(
                (int)$date->format('Y'),
                (int)$date->format('m'),
                (int)$date->format('d'),
                );

                $year = $array[0];
                $mon = $array[1];
                $amount = $request->payment_amount;


                                $transaction = Transactions::find($request->tId);
                                // dd($transaction);
                                $transaction->transaction_status = 'successful';
                                $transaction->transaction_type = 'bank_account';
                                $transaction->transaction_id = $paymentMethodRefID;


                                $transaction->save();

                                $paymentDetail = new PaymentDetails;
                                // $paymentDetail->payment_method = 'bank_account';
                                $paymentDetail->payment_method = 'virtual_card';
                                $paymentDetail->email = auth()->user()->email;
                                $paymentDetail->payment_amount = $request->payment_amount;
                                $paymentDetail->account_number = $request->account_number;
                                $paymentDetail->routing_number = $request->routing_number;
                                $paymentDetail->account_type = $request->account_type;
                                $paymentDetail->bank_account_name = $request->bank_account_name;


                                if($paymentDetail->save()){
                                    $payment = Payments::where('transaction_id', $request->tId)->first();
                                    $payment->payment_status =  'completed';
                                    $payment->payment_type =  'virtual_Card';
                                    $payment->payment_details_id =  $paymentDetail->id;
                                    $payment->save();
    
                                }


                                return view('admin.payments.card2', compact('data','year','mon', 'amount'));

                        // dd('proceed');


   }//virtual card
    }
    public function EnsembleLogin(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://extest.achprocessing.com/ACHEnsemble/api/Ensemble/EnsembleLogin",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "Apikey=".$company->api_key."&Username=".$company->api_user."&Password=".$company->api_password,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: 229a03dd-7b70-0d2e-6453-377d4304923e"
        ),
        ));

        $response = curl_exec($curl);

        if(!isJson($response)){
            Session::flash('errorMessage', 'Api Internal Server Issue');
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        $jsonResponse = json_decode($response);

        //  dd($response);
        $err = curl_error($curl);
        curl_close($curl);
// dd($err);
        if ($err) {

        Session::flash('errorMessage', $err);
        return redirect()->back()->withFlashDanger('Payment Failed!');
        }

        if ($response == "\"Login Faulted\"") {
            Session::flash('errorMessage', "Login Faulted! Api Credentials are Wrong");
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }
        // dd($jsonResponse->AuthenticationToken);
        $company->token = $jsonResponse->AuthenticationToken;
        $company->token_expired_at= date('Y-m-d H:i:s',strtotime($jsonResponse->expireDate));
        $company->save();



        //api token in place    


        
    }
    public function sendPayment(Request $request){

        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'payment_amount'   => 'required',
            'description'   => 'required'
        ]);
        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();


         $companyid = null;   
        $allcompanies = \App\CompanySetting::get();  
        foreach( $allcompanies as $cp){
            $decoded = json_decode($cp->user_id);
            if(auth()->user()){
                if(in_array(auth()->user()->id, $decoded)){
                    $companyid= $cp->id;
                    $companyname=$cp->company_name;
                  }
            }
        }
        //dd($companyid);

        if($companyid == null){
            $companyUser = CompanyUser::where('user_id',auth()->user()->id)->first();
// dd($companyUser);
            $company = CompanySetting::find($companyUser->company_id);

            // dd(auth()->user()->id);
			$companyid = $company->id;
        }else {
            $company = CompanySetting::find($companyid);
			$companyid = $company->id;
        }

        // dd('sdsdsd');
         //dd($companyid);

        if($company->api_key != null && $company->api_user != null && $company->api_password != null )
        {
//ensemble login

        $user = User::where('email',$request->email)->first();

         if($user){

        $transactions = new Transactions();
        $transactions->transaction_id = 'Payment Awaiting User Approval';
        // dd($payment_amount);
        $transactions->transaction_amount = $request->payment_amount;
        $transactions->transaction_description = $request->description;
        $transactions->transaction_status = 'processing';
        $transactions->transaction_name = 'one time payment';
        // $transactions->transaction_type = $transaction_type;
        $transactions->user_id = auth()->user()->id;
        $transactions->company_id = $companyid;
  
        if($transactions->save()){

                    $payments = new Payments();
                    // $user = User::where('email', $email)->first();
                    if ($user) {
                        $payments->user_id = $user->id;
                    }
                    $payments->payment_type = 'Awaiting user to select payment method';
                    $payments->transaction_id = $transactions->id;
                    $payments->payment_details_id = 0;
                    $payments->payment_amount = $request->payment_amount;
                    $payments->email = $request->email;
                    $payments->is_reoccuring = 0;
                    $payments->is_guest = 0;
                    $payments->payment_status = 'Payment Awaiting User Approval';
                    $payments->description = $request->description;
                    $payments->sender_id = auth()->user()->id;
                   if( $payments->save()){

                    $data['user']  = 'User';
                    $data['sender']  = auth()->user()->email;
                    $data['link']  = route('login');
                
                    $mail = $request->email;
                    Mail::to($mail)->send(new SendPaymentLinkMail($data));
                    return redirect()->back()->withFlashSuccess('Payment sent!');

                   }
                   else{
                    Session::flash('errorMessage', 'Error In making payment');
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                   }
        }else{
            Session::flash('errorMessage', 'Error In making transaction');
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }


        // dd($transactions->id);    
    }else{
// dd('no');

        // $user = User::where('email', $request->email)->first();
        $userid = auth()->user()->id;
        // $mail = $request->email;
        // if ($user) {
            // $message = "Payment Awaiting User Approval";
        // } else {
            $message = "Payment Inviation Sent";
        // }
        
        $allcompanies = \App\CompanySetting::get();  
        foreach( $allcompanies as $cp){
            $decoded = json_decode($cp->user_id);
            if(auth()->user()){
                if(in_array(auth()->user()->id, $decoded)){
                    $companyid= $cp->id;
                    $companyname=$cp->company_name;
                  }
            }
        }

        if($companyid == null){
            $companyUser = CompanyUser::where('user_id',auth()->user()->id)->first();
// dd($companyUser);
            $company = CompanySetting::find($companyUser->company_id);

            // dd(auth()->user()->id);
        }else {
            $company = CompanySetting::find($companyid);

        }
    
        //$company = CompanySetting::find($companyid);
    
    
    
        $transactions = new Transactions();
            $transactions->transaction_id = 'Payment Awaiting User Approval';
            // dd($payment_amount);
            $transactions->transaction_amount = $request->payment_amount;
            $transactions->transaction_description = $request->description;
            $transactions->transaction_status = 'processing';
            $transactions->transaction_name = 'one time payment import';
            // $transactions->transaction_type = $transaction_type;
            $transactions->user_id = auth()->user()->id;
          
            $transactions->company_id = $company->id;
      
            if($transactions->save()){
    
                        $payments = new Payments();
                        // $user = User::where('email', $email)->first();
                        if ($user) {
                            $payments->user_id = $user->id;
                        }
                        $payments->payment_type = 'Awaiting user to select payment method';
                        $payments->transaction_id = $transactions->id;
                        $payments->payment_details_id = 0;
                        $payments->payment_amount = $request->payment_amount;
                        $payments->email = $request->email;
                        $payments->is_reoccuring = 0;
                        $payments->is_guest = 0;
                        $payments->payment_status = 'Payment Awaiting User Approval';
                        $payments->description = $request->description;
                        $payments->sender_id = auth()->user()->id;
    
                        $payments->save();
                    }
        // $transactions_id = createTransaction($message, $payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
        // insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $payment_amount, $mail, 0, 1, $message, $description);
    
            $data['slug'] = 'InvitationMail';
            $id = \Crypt::encrypt($transactions->id);
            $edtURL = url('/payment-method?id='. $id);
            
            // $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
            $data['Registerlink'] = $edtURL; 
         
            // $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
            // Mail::to($mail)->send(new SendDynamicEmail($data));
    
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'send payment',
                'action' => 'payment sent',
            );
            $logs = LogActivity::addToLog($log_data);
    
            $data['user']  = 'User';
            $data['sender']  = auth()->user()->email;
            $data['link']  = route('login');
    
            // $mail = $request->email;
            Mail::to($request->email)->send(new SendPaymentLinkMailUnreg($data));
            return redirect()->back()->withFlashSuccess('Payment sent to unregistered user!');

    }   

        }
        else {
             Session::flash('errorMessage', "Missing API Credentials for Company Account");
            return redirect()->back()->withFlashDanger('Payment Failed!');
        }




    }
    //
}
