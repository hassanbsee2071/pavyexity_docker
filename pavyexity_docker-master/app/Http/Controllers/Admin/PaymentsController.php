<?php

namespace App\Http\Controllers\admin;

use Session;
use DataTables;
use App\CsvData;
use App\helpers;
use App\Payments;
use App\PaymentDetailOnline;
use Carbon\Carbon;
use App\Transactions;
use App\Mail\Payalert;
use App\CompanySetting;
use App\CompanyUser;
use App\PaymentDetails;
use App\EmailManagement;
use App\Mail\InviteUsers;
use App\RecurringPayments;
use Illuminate\Support\Str;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\OnlinePaymentDetails;
use App\Mail\SendDynamicEmail;
use App\Models\Auth\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Models\Payments\OnlinePaymentLinks;
use Redirect;
use DB;

use Mail;
use App\Mail\SendPaymentLinkMail;
use App\Mail\SendPaymentLinkMailUnreg;
use App\Mail\SchedulePaymentMail;


class PaymentsController extends Controller
{
    //
    public function creditview(){

        return view('admin.payments.card');

    }

    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            if (isSuperAdmin()) {
                $payments = Payments::select(['email','payment_amount', 'transaction_id', 'payment_type', 'payment_status', 'created_at', 'updated_at', 'deleted_at']);
                $get_data = $payments;
            } elseif (isAdmin()) {
                $payments = Payments::select(['email','payment_amount', 'transaction_id', 'payment_type', 'payment_status', 'created_at', 'updated_at', 'deleted_at'])->where('sender_id', Auth::user()->id);
                $get_data = $payments;
            } else {
                $payments = Payments::select(['email','payment_amount', 'transaction_id', 'payment_type', 'payment_status', 'created_at', 'updated_at', 'deleted_at','payment_details_id'])->where('email', Auth::user()->email);
                $get_data = $payments;
            }
            return Datatables::of($get_data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
              $btn="";
              if(Auth::user()->hasRole('User') && $row->payment_details_id==0 && $row->payment_status != 'completed' ){
                $id = \Crypt::encrypt($row->transaction_id);
                $edtURL = url('/payment-method?id='. $id);

                $btn .= ' <a href="'.$edtURL.'"  class="btn btn-primary btn-sm" >Accept</a>';
            }
            return $btn;
        })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.payments.show');
    }

    public function createCardPayment()
    {
        return view('admin.payments.card2');
    }

    public function createOnetimePayment(Request $request)
    {
        return view('admin.payments.onetimepayment');
    }

    public function sendPayment(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'payment_amount'   => 'required',
        ]);

        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

        $user = User::where('email',$request->email)->first();
if($user) {

    
    $user = User::where('email', $request->email)->first();
    $userid = Auth::user()->id;
    $mail = $request->email;
    if ($user) {
        $message = "Payment Awaiting User Approval";
    } else {
        $message = "Payment Inviation Sent";
    }
    $transactions_id = createTransaction($message, $request->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
    insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $request->payment_amount, $request->email, 0, 1, $message, $request->description);

    if ($user) {
        $data['slug'] = 'PayAlert';
        $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
        $data['paymentType'] = 'SendPayment';
        $data['email'] = $mail;
        // Mail::to($mail)->send(new SendDynamicEmail($data));

        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'send payment',
            'action' => 'payment sent to user',
        );
        $logs = LogActivity::addToLog($log_data);
    } else {
        $data['slug'] = 'InvitationMail';
        $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
        $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
        // Mail::to($mail)->send(new SendDynamicEmail($data));

        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'send payment',
            'action' => 'payment sent',
        );
        $logs = LogActivity::addToLog($log_data);
    }



    $data['user']  = 'User';
    $data['sender']  = auth()->user()->email;
    $data['link']  = route('login');

    $mail = $request->email;
    Mail::to($mail)->send(new SendPaymentLinkMail($data));
    return redirect()->back()->withFlashSuccess('Payment sent!');

}else{


    $userid = Auth::user()->id;
    $mail = $request->email;

    // if ($user) {
        // $message = "Payment Awaiting User Approval";
    // } else {
        $message = "Payment Inviation Sent";
    // }
    $transactions_id = createTransaction($message, $request->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
    insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $request->payment_amount, $request->email, 0, 1, $message, $request->description);

        $data['slug'] = 'InvitationMail';
        $id = \Crypt::encrypt($transactions_id);
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

        $mail = $request->email;
        Mail::to($mail)->send(new SendPaymentLinkMailUnreg($data));
        return redirect()->back()->withFlashSuccess('Payment sent!');
}


//         if($request->someone == 'on'){
//     // $user = User::where('email', $request->email)->first();
//     $userid = Auth::user()->id;
//     $mail = $request->email;
//     // if ($user) {
//         // $message = "Payment Awaiting User Approval";
//     // } else {
//         $message = "Payment Inviation Sent";
//     // }
//     $transactions_id = createTransaction($message, $request->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
//     insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $request->payment_amount, $request->email, 0, 1, $message, $request->description);

//         $data['slug'] = 'InvitationMail';
//         $id = \Crypt::encrypt($transactions_id);
//         $edtURL = url('/payment-method?id='. $id);
        
//         // $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
//         $data['Registerlink'] = $edtURL; 
     
//         // $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
//         // Mail::to($mail)->send(new SendDynamicEmail($data));

//         $log_data = array(
//             'user_id' => auth()->user()->id,
//             'logtype' => 'send payment',
//             'action' => 'payment sent',
//         );
//         $logs = LogActivity::addToLog($log_data);

//         $data['user']  = 'User';
//         $data['sender']  = auth()->user()->email;
//         $data['link']  = route('login');

//         $mail = $request->email;
//         Mail::to($mail)->send(new SendPaymentLinkMailUnreg($data));
//         return redirect()->back()->withFlashSuccess('Payment sent!');

// }
// else{


//         $user = User::where('email', $request->email)->first();
//         $userid = Auth::user()->id;
//         $mail = $request->email;
//         if ($user) {
//             $message = "Payment Awaiting User Approval";
//         } else {
//             $message = "Payment Inviation Sent";
//         }
//         $transactions_id = createTransaction($message, $request->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
//         insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $request->payment_amount, $request->email, 0, 1, $message, $request->description);

//         if ($user) {
//             $data['slug'] = 'PayAlert';
//             $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
//             $data['paymentType'] = 'SendPayment';
//             $data['email'] = $mail;
//             // Mail::to($mail)->send(new SendDynamicEmail($data));

//             $log_data = array(
//                 'user_id' => auth()->user()->id,
//                 'logtype' => 'send payment',
//                 'action' => 'payment sent to user',
//             );
//             $logs = LogActivity::addToLog($log_data);
//         } else {
//             $data['slug'] = 'InvitationMail';
//             $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
//             $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
//             // Mail::to($mail)->send(new SendDynamicEmail($data));

//             $log_data = array(
//                 'user_id' => auth()->user()->id,
//                 'logtype' => 'send payment',
//                 'action' => 'payment sent',
//             );
//             $logs = LogActivity::addToLog($log_data);
//         }



//         $data['user']  = 'User';
//         $data['sender']  = auth()->user()->email;
//         $data['link']  = route('login');

//         $mail = $request->email;
//         Mail::to($mail)->send(new SendPaymentLinkMail($data));
//         return redirect()->back()->withFlashSuccess('Payment sent!');


//     }
    }
    
    public function processGuestPaymentforPayee(Request $request)
    {
        // dd($request->name.' '.$request->lname);
        if ($request->payment_method == "bank_account") {
            $validator = Validator::make($request->all(), [
                'account_number'   => 'required|numeric',
                'routing_number'   => 'required|numeric',
                'account_type'     => 'required',
                // 'bank_account_name'  => 'required|max:255',
                // 'email'      => 'required|email|max:255',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

            // $bankinformation['merchantObjectID'] = '5AA7ED88-0A69-479F-9792-D0EBADA5BAD7';
            $bankinformation['AccountNumber'] = $request->account_number;
            $bankinformation['RoutingNumber'] = $request->routing_number;
            $bankinformation['AccountType'] = $request->account_type;
            $bankinformation['BankAccountName'] = $request->first_name.' '.$request->last_name ;
            $bankinformation['companyid'] = $request->cId;

            $json_parameters = json_encode($bankinformation);
            // dd($json_parameters);
            Session::flash('errorMessage', "Missing Credentials");
            return redirect()->back()->withFlashDanger('Payment Failed!');
            
            $accountcreate = createGuestBankAccount($json_parameters);
            $response = json_decode($accountcreate);
                    //  dd($response);

            if ($response->status == "success") {
                if ( isset($response->result->status->ResponseCode) && $response->result->status->ResponseCode == "Ok") {
                   
                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                    if ($account_paymentMethodobjectId != "") {

                        $json_parameters = array();
                        $paymentinformation['merchantObjectID'] = '5AA7ED88-0A69-479F-9792-D0EBADA5BAD7';
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['actionType'] = "2";
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                        // dd($request->all());
                       $paymentinformation['companyid'] = $request->cId;

                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreateGuestPayment($json_parameters);
                        $response = json_decode($process_payment);
                        //  dd($response->result->status->Message);
                        if ($response->result->status->ResponseCode == "Ok") {
//acc_email;            
                            //   dd('ok');  
                            $paymentdetails_id = insertGuestPaymentDetailsBank("bank_account", 'test@user.com', $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createGuestTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message, "successful", "one time payment", "bank_account");

                            insertGuestPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@user.com', 0, 1, "successful", "");

                            $log_data = array(
                                'user_id' => 0,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment successful',
                            );
                            $logs = LogActivity::addToLog($log_data);
                                $amount = $request->payment_amount;
                            return view('admin.payments.success', compact('transactions_id','amount'));
                        } else {
                            // dd(' not ok');  

         
                            $paymentdetails_id = insertGuestPaymentDetailsBank("bank_account",  'test@user.com', $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createGuestTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "No paymentRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                            insertGuestPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@user.com', 0, 1, "failed", "");

                            $log_data = array(
                                'user_id' => auth()->user() ? auth()->user()->id : 0 ,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment failed',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            Session::flash('errorMessage', $response->result->status->Message);
                            return redirect()->back()->withFlashDanger('Payment Failed!');

                        }
                    } else {

                        Session::flash('errorMessage', "Please check your account credentials");
                        return redirect()->back()->withFlashDanger('Payment Failed!');

                        $paymentdetails_id = insertGuestPaymentDetailsBank("bank_account", 'test@user.com', $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                        $transactions_id = createGuestTransaction($response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                        insertGuestPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@user.com', 0, 1, "failed", "");

                        $log_data = array(
                            'user_id' => 1,
                            'logtype' => 'processPayment',
                            'action' => 'Process payment failed',
                        );
                        $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashDanger('Payment Failed!');
                    }
                } else {
                    Session::flash('errorMessage', "Please check your account credentials");
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                    $paymentdetails_id = insertGuestPaymentDetailsBank("bank_account", 'test@user.com', $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                    $transactions_id = createGuestTransaction("Failed to get response", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                    insertGuestPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@gmail.com', 0, 1, "failed", "");

                    $log_data = array(
                        'user_id' => 1,
                        'logtype' => 'processPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {
                Session::flash('errorMessage', "Please check your account credentials");
                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        } elseif ($request->payment_method == "credit_card") {
            $validator = Validator::make($request->all(), [
                //'transaction_id' => 'required',
                'name'   => 'required',
                'payment_amount'     => 'required',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();
            //$bankinformation['PayeeName'] = $request->name;
            //$bankinformation['amount'] = $request->payment_amount;
            $bankinformation['merchantObjectID'] = '5AA7ED88-0A69-479F-9792-D0EBADA5BAD7';
            //$bankinformation['companyid'] = $request->cId;
            $bankinformation['cardHolderName'] = $request->name;
            $bankinformation['cardNumber'] = '370000000000002';
            $bankinformation['cardAddress1'] = $request->address;
            $bankinformation['cardCity'] = $request->city;
            $bankinformation['cardState'] = 'TXA';
            $bankinformation['cardCountry'] = 'USA';
            $bankinformation['cardZipCode'] = $request->zip;
            $bankinformation['cardCVV'] = $request->cvv;
            $bankinformation['cardExpiryMonth'] = '11';
            $bankinformation['cardExpiryYear'] = '23';




            $json_parameters = json_encode($bankinformation);
            //dd($json_parameters);
            
            Session::flash('errorMessage', "Missing Credentials");
            return redirect()->back()->withFlashDanger('Payment Failed!');

            $accountcreate = createCard($json_parameters);
            $response = json_decode($accountcreate);
            $email = auth()->user()->email;
            $id = auth()->user()->id;

        if ($response->status == "success") {
                if ( isset($response->result->status->ResponseCode) && $response->result->status->ResponseCode == "Ok") {
                   
                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                    if ($account_paymentMethodobjectId != "") {

                        $json_parameters = array();
                        $paymentinformation['merchantObjectID'] = '5AA7ED88-0A69-479F-9792-D0EBADA5BAD7';
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['actionType'] = "2";
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                       $paymentinformation['companyid'] = $request->cId;

                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreateGuestPayment($json_parameters);
                        $response = json_decode($process_payment);
                        if ($response->result->status->ResponseCode == "Ok") {

                            $paymentdetails_id = insertPaymentDetailsCard("credit_card", $email ? $email : 'test@user.com', $request->payment_amount,$request->name, $request->credit_card_number, $request->expiry_date, $request->cvv, $request->address, $request->city,$request->state , $request->zip);

                            $transactions_id = createGuestTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message, "successful", "one time payment", "credit_card");

                            insertGuestPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $email ? $email :  'test@user.com', 0, 1, "successful", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment successful',
                            );
                            $logs = LogActivity::addToLog($log_data);
                                $amount = $request->payment_amount;
                            return view('admin.payments.success', compact('transactions_id','amount'));
                        } else {
                            Session::flash('errorMessage', "Missing Credentials");
                            return redirect()->back()->withFlashDanger('Payment Failed!');

                            $paymentdetails_id = insertPaymentDetailsCard("credit_card", $email ? $email : 'test@user.com', $request->payment_amount,$request->name, $request->credit_card_number, $request->expiry_date, $request->cvv, $request->address, $request->city,$request->state , $request->zip);

                            $transactions_id = createGuestTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "No paymentRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                            insertGuestPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@user.com', 0, 1, "failed", "");

                            $log_data = array(
                                'user_id' => $id ? $id : 1,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment failed',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }
                    } else {

                        Session::flash('errorMessage', "Missing Credentials");
                        return redirect()->back()->withFlashDanger('Payment Failed!');
                        $paymentdetails_id = insertPaymentDetailsCard("credit_card", $email ? $email : 'test@user.com', $request->payment_amount,$request->name, $request->credit_card_number, $request->expiry_date, $request->cvv, $request->address, $request->city,$request->state , $request->zip);

                        $transactions_id = createGuestTransaction($response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                        insertGuestPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@user.com', 0, 1, "failed", "");

                        $log_data = array(
                            'user_id' => $id ? $id : 1,
                            'logtype' => 'processPayment',
                            'action' => 'Process payment failed',
                        );
                        $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashDanger('Payment Failed!');
                    }
                } else {
                    Session::flash('errorMessage', "Missing Credentials");
                    return redirect()->back()->withFlashDanger('Payment Failed!');

                    // $paymentdetails_id = insertGuestPaymentDetailsBank("bank_account", 'test@user.com', $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                    // $transactions_id = createGuestTransaction("Failed to get response", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                    // insertGuestPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, 'test@gmail.com', 0, 1, "failed", "");

                   

                    $log_data = array(
                        'user_id' => $id ? $id : 1,
                        'logtype' => 'processPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {
                Session::flash('errorMessage', "Missing Credentials");
                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        }
    }
    public function delete_process($name)
    {
        $delete = CsvData::where('csv_filename',$name)->delete();

        return Redirect::to('admin/payments')->with('success', 'Data has been Deleted'); 
    }
    public function processPaymentforPayee(Request $request)
    {
        // dd($request->all());
        
        if ($request->payment_method == "bank_account") {
            $validator = Validator::make($request->all(), [
                'account_number'   => 'required|numeric',
                'routing_number'   => 'required|numeric',
                'account_type'     => 'required',
                'bank_account_name'  => 'required|max:255',
                // 'email'      => 'required|email|max:255',
            ]);
            

            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();
            
            $bankinformation['AccountNumber'] = $request->account_number;
            $bankinformation['RoutingNumber'] = $request->routing_number;
            $bankinformation['AccountType'] = $request->account_type;
            $bankinformation['BankAccountName'] = $request->bank_account_name;
            $bankinformation['Transaction_id'] =$request->tId;
            $json_parameters = json_encode($bankinformation);
            $accountcreate = createBankAccount($json_parameters);
            $response = json_decode($accountcreate);
           
            if ($response->status == "success") {
                if ( isset($response->result->status->ResponseCode) && $response->result->status->ResponseCode == "Ok") {
                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                    if ($account_paymentMethodobjectId != "") {
                        $json_parameters = array();
                        // $paymentinformation['merchantObjectID'] = $merchantId;
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['actionType'] = "2";
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreatePayment($json_parameters);
                        $response = json_decode($process_payment);
                       
                        if ($response->result->status->ResponseCode == "Ok") {

                            $paymentdetails_id = insertPaymentDetailsBank("bank_account", auth()->user()->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message, "successful", "one time payment", "bank_account");

                            insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "successful", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment successful',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            $transaction = Transactions::find($request->tId);
                                // dd($transaction);
                                $transaction->transaction_status = 'successful';
                                $transaction->save();

                                $payment = Payments::where('transaction_id', $request->tId)->first();
                                $payment->payment_status =  'completed';
                                $payment->save();
                                            return redirect()->back()->withFlashSuccess('Payment Successfully!');
                        } else {

                            $paymentdetails_id = insertPaymentDetailsBank("bank_account",  auth()->user()->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "No paymentRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                            insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment failed',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->route('admin.payments')->withFlashSuccess('Payment Failed!');
                            
                        }
                    } else {


                        $paymentdetails_id = insertPaymentDetailsBank("bank_account", auth()->user()->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                        $transactions_id = createTransaction($response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                        insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                        $log_data = array(
                            'user_id' => auth()->user()->id,
                            'logtype' => 'processPayment',
                            'action' => 'Process payment failed',
                        );
                        $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashSuccess('Payment Failed!');
                    }
                } else {
                    $paymentdetails_id = insertPaymentDetailsBank("bank_account", $request->email ? $request->email: auth()->user()->email , $request->payment_amount, $request->account_number, $request->routing_number, 1, $request->bank_account_name);

                    $transactions_id = createTransaction("Failed to get response", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                    insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount,  $request->email ? $request->email: auth()->user()->email, 0, 1, "failed", "");

                    $log_data = array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'processPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashSuccess('Payment Failed!');
                }
            } else {
                return redirect()->back()->withFlashSuccess('Payment Failed!');
            }
        } elseif ($request->payment_method == "credit_card") {
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required',
                'name'   => 'required',
                'payment_amount'     => 'required',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

            $cardInformation['PayeeName'] = $request->name;
            $cardInformation['amount'] = $request->payment_amount;
            $cardInformation['companyid'] = $request->cId;
            $json_parameters = json_encode($cardInformation);
            $accountcreate = createCard($json_parameters);
            $response = json_decode($accountcreate);
            if ($response->result->status->ResponseCode == "Ok") {
                $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                if ($account_paymentMethodobjectId != "") {
                    $json_parameters = array();
                    $carddeatails = $response;
                    $log_data = array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'processVirtualCardPayment',
                        'action' => 'Process payment Success',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    $paymentdetails = new PaymentDetails();
                    $paymentdetails->payment_method = 'credit_card';
                    $paymentdetails->email = auth()->user()->email;
                    $paymentdetails->payment_amount = $response->result->cardAmountBalance;
                    $paymentdetails->card_holder_name = $response->result->nameOnCard;
                    $paymentdetails->card_number = $response->result->pan;
                    $paymentdetails->zipcode = $response->result->zipcode;
                    $paymentdetails->CVV = $response->result->cvv;
                    $paymentdetails->month =date('m',strtotime($response->result->exp));
                    $paymentdetails->year =date('Y',strtotime($response->result->exp));
                    $paymentdetails->user_id = auth()->user()->id;
                    $paymentdetails->save();
                    $transaction_id = \Crypt::decrypt($request->transaction_id);

                    $Payments = Payments::where('transaction_id',$transaction_id)->first();

                    $Payments->payment_details_id = $paymentdetails->id;
                    $Payments->payment_type = 'credit_card';
                    $Payments->payment_status = 'Process payment Success';
                    $Payments->save();

                    return view('admin.payments.card', compact('carddeatails'))->withFlashSuccess('Process payment Success');;
                } else {
                    $log_data = array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'processVirtualCardPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);
                    return redirect()->back()->withFlashSuccess('Payment Failed!');
                }
            } else {
                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'processVirtualCardPayment',
                    'action' => 'Process payment failed',
                );
                $logs = LogActivity::addToLog($log_data);
                return redirect()->back()->withFlashSuccess('Payment Failed!');
            }
        }elseif($request->payment_method == 'virtual_card'){
            //   dd($request->all());
            $vCardInfo['PayeeName'] = $request->name;
            $vCardInfo['amount'] = $request->payment_amount;
          if($request->tId != null){
            $vCardInfo['tId'] = $request->tId;
          }

            $json_parameters = json_encode($vCardInfo);
            $vcardcreate = createVirtualCard($json_parameters);


            $response = json_decode($vcardcreate);
            // dd($response);
            $data = $response->result;
            $date = date_create_from_format('Y-m-d', $data->exp);
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
                $transaction->save();

                $payment = Payments::where('transaction_id', $request->tId)->first();
                $payment->payment_status =  'completed';
                $payment->save();

                return view('admin.payments.card2', compact('data','year','mon', 'amount'));

        }
    }


    public function processMakePayment(Request $request)
    {
        $merchantId = "5AA7ED88-0A69-479F-9792-D0EBADA5BAD7";
        if (env('MERCHANT_ID')) {
            $merchantId = env('MERCHANT_ID');
        }
        if ($request->payment_method == "bank_account") {
            $validator = Validator::make($request->all(), [
                'account_number'   => 'required|numeric',
                'routing_number'   => 'required|numeric',
                'account_type'     => 'required',
                'bank_account_name'  => 'required|max:255',
                'email'      => 'required|email|max:255',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();
            $bankinformation['merchantObjectID'] = $merchantId;
            $bankinformation['AccountNumber'] = $request->account_number;
            $bankinformation['RoutingNumber'] = $request->routing_number;
            $bankinformation['AccountType'] = $request->account_type;
            $bankinformation['BankAccountName'] = $request->bank_account_name;
            $json_parameters = json_encode($bankinformation);
            $accountcreate = createBankAccount($json_parameters);
            $response = json_decode($accountcreate);
            if ($response->status == "success") {
                if ($response->result->status->ResponseCode == "Ok") {
                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                    if ($account_paymentMethodobjectId != "") {
                        $json_parameters = array();
                        $paymentinformation['merchantObjectID'] = $merchantId;
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['actionType'] = "2";
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreatePayment($json_parameters);
                        $response = json_decode($process_payment);
                        if ($response->result->status->ResponseCode == "Ok") {

                            $paymentdetails_id = insertPaymentDetailsBank("bank_account", $request->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message, "successful", "one time payment", "bank_account");

                            insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "successful", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment successful',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashSuccess('Payment Successfully!');
                        } else {

                            $paymentdetails_id = insertPaymentDetailsBank("bank_account", $request->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                            $transactions_id = createTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "No paymentRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                            insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment failed',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }
                    } else {


                        $paymentdetails_id = insertPaymentDetailsBank("bank_account", $request->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                        $transactions_id = createTransaction($response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                        insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                        $log_data = array(
                            'user_id' => auth()->user()->id,
                            'logtype' => 'processPayment',
                            'action' => 'Process payment failed',
                        );
                        $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashDanger('Payment Failed!');
                    }
                } else {
                    $paymentdetails_id = insertPaymentDetailsBank("bank_account", $request->email, $request->payment_amount, $request->account_number, $request->routing_number, $request->account_type, $request->bank_account_name);

                    $transactions_id = createTransaction("Failed to get response", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                    insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                    $log_data = array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'processPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {
                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        } elseif ($request->payment_method == "credit_card") {

            $validator = Validator::make($request->all(), [
                'card_number'   => 'required|numeric',
                'payment_amount'     => 'required',
                'card_holder_name'  => 'required|max:255',
                'email'      => 'required|email|max:255',
                'card_address1' => 'required',
                'card_city' => 'required',
                'card_state' => 'required',
                'card_country' => 'required',
                'card_zipcode' => 'required',
                'card_cvv' => 'required',
                'card_expiry_month' => 'required',
                'card_expiry_year' => 'required',
            ]);

            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();


            $bankinformation['merchantObjectID'] = $merchantId;
            $bankinformation['cardHolderName'] = $request->card_holder_name;
            $bankinformation['cardNumber'] = $request->card_number;
            $bankinformation['cardAddress1'] = $request->card_address1;
            if ($request->card_address2 != "") {
                $bankinformation['cardAddress2'] = $request->card_address2;
            }
            $bankinformation['cardCity'] = $request->card_city;
            $bankinformation['cardState'] = $request->card_state;
            $bankinformation['cardCountry'] = $request->card_country;
            $bankinformation['cardZipCode'] = $request->card_zipcode;
            $bankinformation['cardCVV'] = $request->card_cvv;
            $bankinformation['cardExpiryMonth'] = $request->card_expiry_month;
            $bankinformation['cardExpiryYear'] = $request->card_expiry_year;

            $json_parameters = json_encode($bankinformation);
            $accountcreate = createCard($json_parameters);
            $response = json_decode($accountcreate);
            if ($response->status == "success") {

                if ($response->result->status->ResponseCode == "Ok") {

                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;

                    if ($account_paymentMethodobjectId != "") {
                        $json_parameters = array();
                        $paymentinformation['merchantObjectID'] = $merchantId;
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreatePayment($json_parameters);
                        $response = json_decode($process_payment);

                        if ($response->result->status->ResponseCode == "Ok") {

                            $paymentdetails_id = insertPaymentDetailsCard("credit_card", $request);

                            $transactions_id = createTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message, "successful", "one time payment", "credit_card");

                            insertPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "successful", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment successful',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashSuccess('Payment Successfully!');
                        } else {

                            $paymentdetails_id = insertPaymentDetailsCard("credit_card", $request);

                            $transactions_id = createTransaction($response->result->paymentRefID, $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                            insertPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                            $log_data = array(
                                'user_id' => auth()->user()->id,
                                'logtype' => 'processPayment',
                                'action' => 'Process payment failed',
                            );
                            $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }
                    } else {
                        $transactions = new Transactions();
                        // $transactions->transaction_id = $response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID";
                        $transactions->transaction_amount = $request->payment_amount;
                        $transactions->transaction_description = $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message";
                        $transactions->transaction_status = "failed";
                        $transactions->transaction_name = "one time payment";
                        $transactions->transaction_type = "credit_card";
                        $transactions->save();


                        $payments = new Payments();
                        $payments->payment_type = "credit_card";
                        $payments->transaction_id = $transactions->id;
                        $payments->payment_amount = $request->payment_amount;
                        $payments->email = $request->email;
                        $payments->is_reoccuring = 0;
                        $payments->is_guest = 1;
                        $payments->payment_status = "failed";
                        $payments->save();



                        $paymentdetails_id = insertPaymentDetailsCard("credit_card", $request);

                        $transactions_id = createTransaction($response->result->paymentMethodRefID, $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                        insertPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                        $log_data = array(
                            'user_id' => auth()->user()->id,
                            'logtype' => 'processPayment',
                            'action' => 'Process payment failed',
                        );
                        $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashDanger('Payment Failed!');
                    }
                } else {
                    $paymentdetails_id = insertPaymentDetailsCard("credit_card", $request);

                    $transactions_id = createTransaction($response->result->paymentMethodRefID, $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                    insertPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                    $log_data = array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'processPayment',
                        'action' => 'Process payment failed',
                    );
                    $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {

                $paymentdetails_id = insertPaymentDetailsCard("credit_card", $request);

                $transactions_id = createTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "Unable to reach payemnt api server", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "credit_card");

                insertPayment("credit_card", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'processPayment',
                    'action' => 'Process payment failed',
                );
                $logs = LogActivity::addToLog($log_data);

                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        }
    }

    

    public function bulkImportCSV(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        
        if ($request->has('header')) {
            $csvData = file_get_contents($request->csv_file);
            $lines = explode(PHP_EOL, $csvData);
            $csvHeaders = $lines[0];
            $csvHeadersArray = explode(',', $csvHeaders);
            $csvHeadersArray = array_map('trim', $csvHeadersArray);
            unset($lines[0]);
            $data = array();
            foreach ($lines as $key => $line) {
                $getCSVData = explode(',', $line);
                $getCSVData = array_map('trim', $getCSVData);
                if (count($csvHeadersArray) == count($getCSVData)) {
                    $trmpArray = array();
                    $data[] = array_combine($csvHeadersArray, $getCSVData);
                }
            }
        } else {
            $csvData = file_get_contents($request->csv_file);
            $lines = explode(PHP_EOL, $csvData);
            $csvHeaders = $lines[0];
            $csvHeadersArray = explode(',', $csvHeaders);
            $csvHeadersArray = array_map('trim', $csvHeadersArray);
            unset($lines[0]);
            $data = array();
            foreach ($lines as $key => $line) {
                $getCSVData = explode(',', $line);
                $getCSVData = array_map('trim', $getCSVData);
                if (count($csvHeadersArray) == count($getCSVData)) {
                    $trmpArray = array();
                    $data[] = array_combine($csvHeadersArray, $getCSVData);
                }
            }

        }
        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $value;
                }
            }
         $fata =   mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            $arr = json_encode($data);
        // dd($arr);


            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => stripslashes(json_encode($fata)),
                'user_id' => Auth::user()->id,
            ]);

            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'bulkImportCSV',
                'action' => 'CSV imported successfully',
            );
            $logs = LogActivity::addToLog($log_data);
        } else {
            return redirect()->back();
        }
        $csv_header_fields = $csvHeadersArray;
        $csv_data = $data;

        return view('admin.csv.import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));
    }

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $json = mb_convert_encoding($data->csv_data, "UTF-8");
        $csv_data = json_decode($json);

        $message = "Payment recieve invitation send";
        if($csv_data == null){
        return redirect()->route('admin.payments')->withFlashSuccess('CSV Importing Failed!');
        }
        foreach ($csv_data as $row) {
        if(isset($row->email) && isset($row->payment_amount) && isset($row->description))
        {
            $user = User::where('email', $row->email)->first();
            $userid = Auth::user()->id;
            $mail = $row->email;
            if ($user) {
                $message = "Payment Awaiting User Approval";
            } else {
                $message = "Payment Inviation Sent";
            }
            $transactions_id = createTransaction($message, $row->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
            insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $row->payment_amount, $row->email, 0, 1, $message, $row->description);
    
            if ($user) {
                $data['slug'] = 'PayAlert';
                $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($row->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
                $data['paymentType'] = 'SendPayment';
                $data['email'] = $mail;
                // Mail::to($mail)->send(new SendDynamicEmail($data));
    
                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'send payment',
                    'action' => 'payment sent to user',
                );
                $logs = LogActivity::addToLog($log_data);
            } else {
                $data['slug'] = 'InvitationMail';
                $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
                $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($request->email . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
                // Mail::to($mail)->send(new SendDynamicEmail($data));
    
                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'send payment',
                    'action' => 'payment sent',
                );
                $logs = LogActivity::addToLog($log_data);
            }
    
    
    
            $data['user']  = 'User';
            $data['sender']  = auth()->user()->email;
            $data['link']  = route('login');
    
            $mail = $row->email;
            Mail::to($mail)->send(new SendPaymentLinkMail($data));
        
        }else{
            // dd('Data Not set');
            return redirect()->route('admin.payments')->withFlashSuccess('CSV Data Importing Failed!');
        }
           


        // $user = User::where('email', $row->email)->first();
        //     if ($user) {
        //         $message = "Payment waiting for approval from user.";
        //     }

        //     $transactions_id = createTransaction($message, $row->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", $message);

        //     insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $$row->payment_amount, $row['email'], 0, 1, $message, $request->description);
        }
        return redirect()->route('admin.payments')->withFlashSuccess('CSV Added Successfully!');

        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'processImport',
            'action' => 'CSV Added successfully',
        );
        $logs = LogActivity::addToLog($log_data);

        return redirect()->route('admin.payments')->withFlashSuccess('CSV Added Successfully!');
        // return view('import_success');
    }

    public function viewPayment(Request $request)
    {
        // $payments = RecurringPayments::where('user_id',Auth::user()->id)->get();
        // $get_data = $payments;

        // return view('admin.payments.scheduled-payments.view-schedule-payment', compact('get_data'));
        if ($request->ajax()) {
            if (isSuperAdmin()) {
                $payments = RecurringPayments::get();
            } else {
                $payments = RecurringPayments::where('user_id', auth()->user()->id)->get();
            }
            $get_data = $payments;
            return Datatables::of($get_data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                    // $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteMailtemplate">Delete</a>';
                    // return $btn;
                $edtURL = url('admin/payments/schedule/' . $row->id . '/edit');
                $delURL = url('admin/payments/schedule/' . $row->id . '/delete');
                $actionBtn = '<a href="' . $edtURL . '" class="edit btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>';
                    // if (!$user_role_id == 1){
                $actionBtn = $actionBtn . '<a href="' . $delURL . '"  class="delete btn btn-danger btn-sm" onclick=\'return check()\'><i class="fa fa-trash"></i></a>'; 
                    // }

                return $actionBtn;
            })

            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.payments.scheduled-payments.view-schedule-payment');
    }

    public function schedulePayment(Request $request)
    {
        return view('admin.payments.scheduled-payments.schedule-a-payment');
    }

    public function addSchedulePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email|max:255',
            'schedule_interval'   => 'required',
            'start_date'     => 'required',
            'end_date' => 'required',
            'payment_amount'  => 'required|numeric',
        ]);
        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

        
        $recurring_payments = new RecurringPayments;
        $recurring_payments->email = $request->email;
        $recurring_payments->intervals = $request->schedule_interval;
        $recurring_payments->payment_amount = $request->payment_amount;
        $recurring_payments->start_date = Carbon::createFromFormat('m-d-Y',$request->start_date)->format('Y-m-d');
        $recurring_payments->end_date = Carbon::createFromFormat('m-d-Y',$request->end_date)->format('Y-m-d');
        if (isset($request->description) && $request->description != "") {
            $recurring_payments->description = $request->description;
        }
        $recurring_payments->user_id = Auth::user()->id;;
        if ($recurring_payments->save()) {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'addSchedulePayment',
                'action' => 'Payment Scheduled Successfully',
            );
            $logs = LogActivity::addToLog($log_data);
$data = [];
                                       $data['sender']  = auth()->user()->email;
                                        $data['name']  = $request->email;
                                        $data['amount']  = $request->payment_amount;
                                        $data['type']  = $request->schedule_interval;
                                    
                                        // $mail = $request->email;
                                        Mail::to($request->email)->send(new SchedulePaymentMail($data));
            return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('Payment Scheduled Successfully!');
        } else {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'addSchedulePayment',
                'action' => 'Payment Schedule Failed',
            );
            $logs = LogActivity::addToLog($log_data);
            return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Payment Schedule Failed!');
        }
    }

    public function editSchedulePayment(Request $request)
    {
        if ($request->segment(4) != "" && is_numeric($request->segment(4))) {
            $get_data = RecurringPayments::where('id', $request->segment(4))->get();
            // dd($get_data);
            $start_date = \Carbon\Carbon::parse($get_data[0]->start_date)->format('m/d/Y');
            $end_date = \Carbon\Carbon::parse($get_data[0]->end_date)->format('m/d/Y');
            
            if (count($get_data)) {
                return view('admin.payments.scheduled-payments.edit-schedule-payment', compact('get_data','start_date','end_date'));
            } else {
                return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Something went wrong!');
            }
        } else {
            return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Something went wrong!');
        }
    }

    public function updateSchedulePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'email'   => 'required|email|max:255',
            'schedule_interval'   => 'required',
            'start_date'     => 'required',
            'end_date' => 'required',
            'payment_amount'  => 'required|numeric',
        ]);
        if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

        $start_date = Carbon::createFromFormat('m-d-Y',$request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m-d-Y',$request->end_date)->format('Y-m-d');;
        

        $recurring_payments = RecurringPayments::find($request->id);
        $recurring_payments->email = $request->email;
        $recurring_payments->intervals = $request->schedule_interval;
        $recurring_payments->payment_amount = $request->payment_amount;
        $recurring_payments->start_date = $start_date;
        $recurring_payments->end_date = $end_date;
        if (isset($request->description) && $request->description != "") {
            $recurring_payments->description = $request->description;
        }
        $recurring_payments->user_id = Auth::user()->id;;
        if ($recurring_payments->save()) {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'updateSchedulePayment',
                'action' => 'Payment Schedule Edited Successfully',
            );
            $logs = LogActivity::addToLog($log_data);
            return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('Payment Schedule Edited Successfully!');
        } else {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'updateSchedulePayment',
                'action' => 'Payment Schedule Edit Failed',
            );
            $logs = LogActivity::addToLog($log_data);
            return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Payment Schedule Edit Failed!');
        }
    }

    public function deleteSchedulePayment(Request $request)
    {
        if ($request->segment(4) != "" && is_numeric($request->segment(4))) {
            $recurring_payments = RecurringPayments::find($request->segment(4));
            if ($recurring_payments->delete()) {
                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'deleteSchedulePayment',
                    'action' => 'Payment Schedule Deleted Successfully',
                );
                $logs = LogActivity::addToLog($log_data);
                return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('Payment Schedule Deleted Successfully!');
            } else {
                $log_data = array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'deleteSchedulePayment',
                    'action' => 'Payment Schedule Delete Failed',
                );
                $logs = LogActivity::addToLog($log_data);
                return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Payment Schedule Delete Failed!');
            }
        } else {
            return redirect()->route('admin.payments.schedule.view')->withFlashDanger('Something went wrong!');
        }
    }


    public function bulkImportScheduleCSV(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        if ($request->has('header')) {
            $csvData = file_get_contents($request->csv_file);
            $lines = explode(PHP_EOL, $csvData);
            $csvHeaders = $lines[0];
            $csvHeadersArray = explode(',', $csvHeaders);
            $csvHeadersArray = array_map('trim', $csvHeadersArray);
            unset($lines[0]);
            $data = array();
            foreach ($lines as $key => $line) {
                $getCSVData = explode(',', $line);
                $getCSVData = array_map('trim', $getCSVData);
                if (count($csvHeadersArray) == count($getCSVData)) {
                    $trmpArray = array();
                    $data[] = array_combine($csvHeadersArray, $getCSVData);
                }
            }
        } else {
            $csvData = file_get_contents($request->csv_file);
            $lines = explode(PHP_EOL, $csvData);
            $csvHeaders = $lines[0];
            $csvHeadersArray = explode(',', $csvHeaders);
            $csvHeadersArray = array_map('trim', $csvHeadersArray);
            unset($lines[0]);
            $data = array();
            foreach ($lines as $key => $line) {
                $getCSVData = explode(',', $line);
                $getCSVData = array_map('trim', $getCSVData);
                if (count($csvHeadersArray) == count($getCSVData)) {
                    $trmpArray = array();
                    $data[] = array_combine($csvHeadersArray, $getCSVData);
                }
            }

        }
        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $value;
                }
            }
         $fata =   mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            $arr = json_encode($data);
        // dd($arr);


            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => stripslashes(json_encode($fata)),
                'user_id' => Auth::user()->id,
            ]);

            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'bulkImportCSV',
                'action' => 'CSV imported successfully',
            );
            $logs = LogActivity::addToLog($log_data);
        } else {
            return redirect()->back();
        }
        $csv_header_fields = $csvHeadersArray;
        $csv_data = $data;

        return view('admin.csv.import_schedule_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));
    }

    public function processScheduleImport(Request $request)
    {

        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $recurring_payments = new RecurringPayments;
            $recurring_payments->email = $row['email'];
            $recurring_payments->intervals = $row['intervals'];
            $recurring_payments->payment_amount = $row['payment_amount'];
            $recurring_payments->start_date = Carbon::parse($row['start_date'])->format('Y/m/d');
            $recurring_payments->user_id = Auth::user()->id;;
            $recurring_payments->save();
        }
        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'processScheduleImport',
            'action' => 'Uploaded CSV Scheduled Successfully',
        );
        $logs = LogActivity::addToLog($log_data);
        return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('Uploaded CSV Scheduled Successfully!');
    }

    public function processScheduleImportRec(Request $request) //recrec
    {
        $data = CsvData::find($request->csv_data_file_id);
        $json = mb_convert_encoding($data->csv_data, "UTF-8");
        $csv_data = json_decode($json);
        $message = "Payment recieve invitation send";
        if($csv_data == null){
        return redirect()->route('admin.payments')->withFlashSuccess('CSV Importing Failed!');
        }
        foreach ($csv_data as $row) {
        if(isset($row->email) && isset($row->payment_amount)&& isset($row->intervals)&& isset($row->start_date)&& isset($row->end_date) && isset($row->description))
        {
            $recurring_payments = new RecurringPayments;
        $recurring_payments->email = $row->email;
        $recurring_payments->intervals = $row->intervals;
        $recurring_payments->payment_amount = $row->payment_amount;
        $recurring_payments->start_date = Carbon::createFromFormat('Y-m-d',$row->start_date)->format('Y-m-d');
        $recurring_payments->end_date = Carbon::createFromFormat('Y-m-d',$row->end_date)->format('Y-m-d');
        $recurring_payments->description = $row->description;
        $recurring_payments->user_id = Auth::user()->id;;
        if ($recurring_payments->save()) {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'addSchedulePayment',
                'action' => 'Payment Scheduled Successfully',
            );
            $logs = LogActivity::addToLog($log_data);
        }else{
            // dd('Data Not set');
            return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('CSV Data Importing Failed!');
        }
           


        // $user = User::where('email', $row->email)->first();
        //     if ($user) {
        //         $message = "Payment waiting for approval from user.";
        //     }

        //     $transactions_id = createTransaction($message, $row->payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", $message);

        //     insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $$row->payment_amount, $row['email'], 0, 1, $message, $request->description);
        }
    }
        return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('CSV Added Successfully!');

        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'processImport',
            'action' => 'CSV Added successfully',
        );
        $logs = LogActivity::addToLog($log_data);

        return redirect()->route('admin.payments')->withFlashSuccess('CSV Added Successfully!');
    }

    public function paymentMethod(Request $request)
    {
if(
    auth()->user() == null
){
    $transaction_id = $request->id;
    $id = \Crypt::decrypt($request->id);
    $Transactions = Transactions::where('id',$id)->first();

    return view('admin.payments.receivepayment-unreg',compact('Transactions','transaction_id'));

}else {
    if($request->id) {
        
        $transaction_id = $request->id;
        $id = \Crypt::decrypt($request->id);
        $Transactions = Transactions::where('id',$id)->first();
        // $u_id = $Transactions->user_id;
        // $payments = Payments::where('transaction_id',$u_id)->first();
        if($Transactions)
            return view('admin.payments.receivepayment',compact('Transactions','transaction_id'));
        else
            return redirect()->route('admin.dashboard')->withFlashDanger('Payment Link expired !');
    } else {
        return redirect()->route('admin.dashboard')->withFlashDanger('Payment Link expired !');
    }
}
        
    }

    public function viewCard(Request $request)
    {
        $name = $request->Name;
        $amount = $request->Amount;
        $json_parameters = array();
        $paymentinformation['Payee'] = $name;
        $paymentinformation['Amount'] = $amount;
        $json_parameters = json_encode($paymentinformation);
        $process_payment = createVirtualCard($json_parameters);
        // dd($process_payment);
        return view('admin.payments.card', compact('name', 'amount'));
    }

    public function paymentlink($id) {
        // dd('yes');
       $id = \Crypt::decryptString($id);
       $arr = explode("@@", $id);
       // dd($arr);

       $data['if_amount'] = 0;
       if($arr[0]!='global') {
           $data['if_amount'] = 1;
           $data['amount'] = $arr[0];
       }
       $data['payment_token'] =  \Crypt::encryptString($arr[2]);
       return view('admin.payments.global',$data);
       // dd($id);
   }

   public function getPaymentLinks(Request $request)
   {
        $auth_user  = \Auth::user();
        $company_id = 0;
        $userid = Auth::user()->id;
        //dd($userid);
        if (isSuperAdmin()) {
        if (!empty($auth_user)) {
            if ($request->ajax()) {
                $links = OnlinePaymentLinks::get();
                return Datatables::of($links)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($link) {
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.show', ['id' => $link->id]) .'"><i class="fa fa-eye"></i></a></button>';
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.edit', ['id' => $link->id]) .'"><i class="fa fa-pencil"></i></a></button>';
                        $btn = '<a class="btn btn-xs btn-info" href="'. route('online.payment.links.edit', ['id' => $link->id]) .'" ><i class="fa fa-pencil"></i></a>';
                        // $btn .= '<form action="' . route('online.payment.links.destroy', $link->id).'" method="POST">' . method_field('DELETE') . csrf_field() . '<button onclick=\'return check()\'><i class="fa fa-trash" ></i></button></form>';
                        $btn .= '<a href="' . route('online.payment.links.destroy', [$link->id]) . '" class="btn btn-xs btn-danger user_destroy" onclick=\'return check()\' "><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })
                    ->addColumn('link', function ($link) {
                        return $link->hash;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            } else {
                $links = OnlinePaymentLinks::get();
                return view('admin.payments.online.links', compact('links'));
            }
        }
    }
    if (isAdmin()) {
    $allcompanies = \App\CompanySetting::get();

        
        foreach( $allcompanies as $u){
                                            
            $decoded = json_decode($u->user_id);
            if(in_array($auth_user->id, $decoded)){
            $companyusers=1;
            $companyid= $u->id;
            $companyname = $u->company_name;
            }
        }
        // dd($companyid);


        if (!empty($auth_user)) {
            if ($request->ajax()) {
                $links = OnlinePaymentLinks::where('company_id', $companyid);
                return Datatables::of($links)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($link) {
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.show', ['id' => $link->id]) .'"><i class="fa fa-eye"></i></a></button>';
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.edit', ['id' => $link->id]) .'"><i class="fa fa-pencil"></i></a></button>';
                        $btn = '<a class="btn btn-xs btn-info" href="'. route('online.payment.links.edit', ['id' => $link->id]) .'" ><i class="fa fa-pencil"></i></a>';
                        // $btn .= '<form action="' . route('online.payment.links.destroy', $link->id).'" method="POST">' . method_field('DELETE') . csrf_field() . '<button onclick=\'return check()\'><i class="fa fa-trash"></i></button></form>';
                        $btn .= '<a href="' . route('online.payment.links.destroy', [$link->id]) . '" class="btn btn-xs btn-danger user_destroy" onclick=\'return check()\' "><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })
                    ->addColumn('link', function ($link) {
                        return $link->hash;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            } else {
                $links = OnlinePaymentLinks::get();
                return view('admin.payments.online.links', compact('links'));
            }
        }
    }
    if (!isSuperAdmin() && !isAdmin()) {
        if (!empty($auth_user)) {
            if ($request->ajax()) {
                $links = OnlinePaymentLinks::where('user_id', $userid);
                return Datatables::of($links)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($link) {
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.show', ['id' => $link->id]) .'"><i class="fa fa-eye"></i></a></button>';
                        // $btn = '<button type="button" class="log-request"><a href="'. route('online.payment.links.edit', ['id' => $link->id]) .'"><i class="fa fa-pencil"></i></a></button>';
                        $btn = '<a class="btn btn-xs btn-info" href="'. route('online.payment.links.edit', ['id' => $link->id]) .'" ><i class="fa fa-pencil"></i></a>';
                        // $btn .= '<form action="' . route('online.payment.links.destroy', $link->id).'" method="POST">' . method_field('DELETE') . csrf_field() . '<button onclick=\'return check()\'><i class="fa fa-trash"></i></button></form>';
                        $btn .= '<a href="' . route('online.payment.links.destroy', [$link->id]) . '" class="btn btn-xs btn-danger user_destroy" onclick=\'return check()\' "><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })
                    ->addColumn('link', function ($link) {
                        return $link->hash;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            } else {
                $links = OnlinePaymentLinks::get();
                return view('admin.payments.online.links', compact('links'));
            }
        }
    }
   }

   public function showPaymentLink($id)
   {
        return 'This is show links';
   }

   public function editPaymentLink($id)
   {
        $paymentLink = OnlinePaymentLinks::findOrFail($id);
        return view('admin.payments.online.edit-link', compact('paymentLink'));
   }

   public function updatePaymentLink($id, Request $request)
   {
        $validator = Validator::make($request->all(), [
            'name'   => 'required'
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
        try {
            $paymentLink = OnlinePaymentLinks::findOrFail($id);
            // $paymentLink->user_id = auth()->user()->id;
            $paymentLink->name = $request->name;
            // $paymentLink->hash = Str::random(32);
            $paymentLink->is_enable = $request->is_enable === 'on' ? 1 : 0;
            $paymentLink->save();
            return redirect()->route('online.payment.links')->withFlashSuccess('Payment Link Updated Successfully!');
        } catch (\Exception $ex) {
            echo $ex->getmessage();
        }
   }

   public function createPaymentLink()
   {

       return view('admin.payments.online.create-link');
   }
   public function guestpaymentlink($id) {

    $id = \Crypt::decryptString($id);
    $arr = explode("@@", $id);
    
    if(Auth::user()){
        $login_user  = Auth::user();

    }else {
        $login_user  = 0;

    }

    // dd($id);
    // $payment_links = OnlinePaymentDetails::where('id',$id)->first();

    $allcompanies = \App\CompanySetting::get();
            $companyusers=0;
            $companyid= 0;
            foreach( $allcompanies as $u){
                $decoded = json_decode($u->user_id);
                if(Auth::user()){
                    if(in_array($login_user->id, $decoded)){
                        $companyusers=1;
                        $companyid= $u->id;
                        $companyname=$u->company_name;
                      }
                }else{
                    $companyusers=1;
                    $companyid= $arr[4];
                    $companyname=$u->company_name;
                }
            }
// $companyname = CompanySetting::where('user_id',auth()->user()->id)->first();

    $amount = '';
    $data['is_fixed'] = $arr[3];
    $data['if_amount'] = 0; 
    $data['companyname']  = $arr[4];
    $data['companyid']  = $companyid;

    // dd($data);
    if($arr[0]!='global') {
        $data['if_amount'] = 1; 
        
        $data['amount'] = $arr[0]; 

        $amount = $arr[0];
        //dd($data);
        //$data['amount'] = 90; 
    }
 
    $data['payment_token'] =  \Crypt::encryptString($arr[2]); 

    return view('admin.payments.guest-global',$data);
}

public function generatepaymentlink(Request $request){
                        // dd($request->all());
                        $validator = Validator::make($request->all(), [
                            'name'   => 'required',
                        ]);
                                   $login_user  = Auth::user();

                                    $allcompanies = \App\CompanySetting::get();
                                            $companyusers=0;
                                            $companyid= 0;
                                            $companyname= '';
                                   if(isSuperAdmin() || isAdmin()){

                                            foreach( $allcompanies as $u){
                                            
                                                $decoded = json_decode($u->user_id);
                                                if(in_array($login_user->id, $decoded)){
                                                $companyusers=1;
                                                $companyid= $u->id;
                                                $companyname = $u->company_name;
                                                }
                                            }
                                            // dd($companyid);
                                   }else{
                                    $cpUser = CompanyUser::where('user_id',$login_user->id)->first();
                                    $companyusers=1;
                                    $companyid= $cpUser->company_id; 
                                    $companySetting = \App\CompanySetting::find($companyid); 

                                    $companyname = $companySetting ->company_name;
               
                                    // dd($companyid);
                                    
                                }

                        
                         $link = '';  
                        if($request->is_guest == 'on' && $request->is_fixed == 'off'){
                            $link = route('paymentlink', ['id'=>\Crypt::encryptString($request->amount_req . '@@' .'GlobalPayment' . '@@' . auth()->user()->id. '@@0' . '@@' . $companyname.'@@'.$companyid)]);
                        }else if($request->is_fixed == 'on'){
                            $link = route('paymentlink', ['id'=>\Crypt::encryptString($request->amount_req . '@@' .'GlobalPayment' . '@@' . auth()->user()->id. '@@1' . '@@' . $companyname.'@@'.$companyid)]);
                        }else{
                            $link = route('paymentlink', ['id'=>\Crypt::encryptString($request->amount_req . '@@' .'GlobalPayment' . '@@' . auth()->user()->id. '@@0' . '@@' . $companyname.'@@'.$companyid)]);
                        }
                    
                        $values = array('user_id' => auth()->user()->id,'company_id' => $companyid,'name' => $request->name,'amount_req' => $request->amount_req, 'hash' => $link,'is_enable' => $request->is_enable === 'on' ? 1 : 0,'is_fixed' => $request->is_fixed === 'on' ? 1 : 0, 'is_guest' => $request->is_guest === 'on' ? 1 : 0);
                        
                        DB::table('online_payment_links')->insert($values);
                        // $paymentLink = new OnlinePaymentLinks();
                        // $paymentLink->user_id = auth()->user()->id;
                        // $paymentLink->name = $request->name;
                        // $paymentLink->hash = $link;
                        // $paymentLink->is_enable = $request->is_enable === 'on' ? 1 : 0;
                        // $paymentLink->is_guest = $request->is_guest === 'on' ? 1 : 0;
                        // $paymentLink->save();
                        return redirect()->route('online.payment.links')->withFlashSuccess('Payment Link Created Successfully!');
                    }
   public function savePaymentLink(Request $request)
   {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
        try {
            $paymentLink = new OnlinePaymentLinks();
            $paymentLink->user_id = auth()->user()->id;
            $paymentLink->name = $request->name;
            $paymentLink->hash = Str::random(32);
            $paymentLink->is_enable = $request->is_enable === 'on' ? 1 : 0;
            $paymentLink->is_guest = $request->is_guest === 'on' ? 1 : 0;
            $paymentLink->save();
            return redirect()->route('online.payment.links')->withFlashSuccess('Payment Link Created Successfully!');
        } catch (\Exception $ex) {
            echo $ex->getmessage();
        }
   }

   public function deletePaymentLink($id)
   {
       try {
           $paymentLink = OnlinePaymentLinks::findOrFail($id);
           if ($paymentLink->delete()) {
                return redirect()->route('online.payment.links')->withFlashSuccess('Payment Link Deleted Successfully!');
           }
       } catch (\Exception $ex) {
            echo $ex->getmessage();
       }
   }

   public function showOnlinePayment($hash, $token)
   {
       //dd($hash);
        $token = \Crypt::decryptString($token);
        $partials = explode("@@", $token);

        $link = OnlinePaymentLinks::whereHash($hash)->first();

        if (!$link->is_enable) {
            abort(404);
        }

        if ((int) $link->user_id === (int) $partials[2]) {
            $data['if_amount'] = 0;
            $data['amount'] = 0;
            $data['company_id'] = $link->user_id;
            return view('admin.payments.online.global', $data);
        }

        // dd($partials);
       // dd($arr);

    //    $data['if_amount'] = 0;
    //    if($arr[0]!='global') {
    //        $data['if_amount'] = 1;
    //        $data['amount'] = $arr[0];
    //    }
    //    $data['payment_token'] =  \Crypt::encryptString($arr[2]);

   }

   public function makeOnlinePayment(Request $request)
    {
        if ($request->payment_method == "bank_account") {
            $validator = Validator::make($request->all(), [
                'account_number'   => 'required|numeric',
                'routing_number'   => 'required|numeric',
                'account_type'     => 'required',
                'bank_account_name'  => 'required|max:255',
                'company_id' => 'required'
                // 'email'      => 'required|email|max:255',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();
            $bankinformation['AccountNumber'] = $request->account_number;
            $bankinformation['RoutingNumber'] = $request->routing_number;
            $bankinformation['AccountType'] = $request->account_type;
            $bankinformation['BankAccountName'] = $request->bank_account_name;
            $json_parameters = json_encode($bankinformation);
            $accountcreate = createBankAccount($json_parameters, $request->company_id);
            $response = json_decode($accountcreate);
            if ($response->status == "success") {
                if ( isset($response->result->status->ResponseCode) && $response->result->status->ResponseCode == "Ok") {
                    $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                    $email = null;
                    if (auth()->check()) {
                        $email = auth()->user()->email;
                    }
                    if ($account_paymentMethodobjectId != "") {
                        $json_parameters = array();
                        // $paymentinformation['merchantObjectID'] = $merchantId;
                        $paymentinformation['paymentMethodobjectId'] = $account_paymentMethodobjectId;
                        $paymentinformation['actionType'] = "2";
                        $paymentinformation['Amount'] = $request->payment_amount;
                        $paymentinformation['ServiceFee'] = 0;
                        $json_parameters = json_encode($paymentinformation);
                        $process_payment = CreatePayment($json_parameters, $request->company_id);
                        $response = json_decode($process_payment);
                        if ($response->result->status->ResponseCode == "Ok") {

                            $paymentdetails_id = insertOnlinePaymentDetails([
                                'payment_method' => 'bank_account',
                                'email' => $email,
                                'payment_amount' => $request->payment_amount,
                                'account_number' => $request->account_number,
                                'routing_number' => $request->routing_number,
                                'account_type' => $request->account_type,
                                'bank_account_name' => $request->bank_account_name
                            ]);

                            // $transactions_id = createTransaction(
                            //     $response->result->paymentRefID,
                            //     $request->payment_amount,
                            //     $response->result->status->Message,
                            //     "successful",
                            //     "one time payment",
                            //     "bank_account"
                            // );

                            // insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "successful", "");

                            // $log_data = array(
                            //     'user_id' => auth()->user()->id,
                            //     'logtype' => 'processPayment',
                            //     'action' => 'Process payment successful',
                            // );
                            // $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashSuccess('Payment Successfully!');
                        } else {

                            $paymentdetails_id = insertOnlinePaymentDetails([
                                'payment_method' => 'bank_account',
                                'email' => $email,
                                'payment_amount' => $request->payment_amount,
                                'account_number' => $request->account_number,
                                'routing_number' => $request->routing_number,
                                'account_type' => $request->account_type,
                                'bank_account_name' => $request->bank_account_name
                            ]);

                            // $transactions_id = createTransaction($response->result->paymentRefID != null ? $response->result->paymentRefID : "No paymentRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                            // insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                            // $log_data = array(
                            //     'user_id' => auth()->user()->id,
                            //     'logtype' => 'processPayment',
                            //     'action' => 'Process payment failed',
                            // );
                            // $logs = LogActivity::addToLog($log_data);

                            return redirect()->back()->withFlashDanger('Payment Failed!');
                        }
                    } else {


                        $paymentdetails_id = insertOnlinePaymentDetails([
                            'payment_method' => 'bank_account',
                            'email' => $email,
                            'payment_amount' => $request->payment_amount,
                            'account_number' => $request->account_number,
                            'routing_number' => $request->routing_number,
                            'account_type' => $request->account_type,
                            'bank_account_name' => $request->bank_account_name
                        ]);

                        // $transactions_id = createTransaction($response->result->paymentMethodRefID != null ? $response->result->paymentMethodRefID : "No paymentMethodRefID", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                        // insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                        // $log_data = array(
                        //     'user_id' => auth()->user()->id,
                        //     'logtype' => 'processPayment',
                        //     'action' => 'Process payment failed',
                        // );
                        // $logs = LogActivity::addToLog($log_data);

                        return redirect()->back()->withFlashDanger('Payment Failed!');
                    }
                } else {

                    $paymentdetails_id = insertOnlinePaymentDetails([
                        'payment_method' => 'bank_account',
                        'email' => $email,
                        'payment_amount' => $request->payment_amount,
                        'account_number' => $request->account_number,
                        'routing_number' => $request->routing_number,
                        'account_type' => $request->account_type,
                        'bank_account_name' => $request->bank_account_name
                    ]);

                    // $transactions_id = createTransaction("Failed to get response", $request->payment_amount, $response->result->status->Message != null || $response->result->status->Message != "" ? $response->result->status->Message : "No Message", "failed", "one time payment", "bank_account");

                    // insertPayment("bank_account", $transactions_id, $paymentdetails_id, $request->payment_amount, $request->email, 0, 1, "failed", "");

                    // $log_data = array(
                    //     'user_id' => auth()->user()->id,
                    //     'logtype' => 'processPayment',
                    //     'action' => 'Process payment failed',
                    // );
                    // $logs = LogActivity::addToLog($log_data);

                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {
                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        } elseif ($request->payment_method == "credit_card") {
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required',
                'name'   => 'required',
                'payment_amount'     => 'required',
            ]);
            if ($validator->fails())  return redirect()->back()->withErrors($validator->errors())->withInput();

            $bankinformation['PayeeName'] = $request->name;
            $bankinformation['amount'] = $request->payment_amount;
            $json_parameters = json_encode($bankinformation);
            $accountcreate = createVirtualCard($json_parameters, $request->company_id);
            $response = json_decode($accountcreate);
            if ($response->result->status->ResponseCode == "Ok") {
                $account_paymentMethodobjectId = $response->result->paymentMethodRefID;
                if ($account_paymentMethodobjectId != "") {
                    $json_parameters = array();
                    $carddeatails = $response;
                    // $log_data = array(
                    //     'user_id' => auth()->user()->id,
                    //     'logtype' => 'processVirtualCardPayment',
                    //     'action' => 'Process payment Success',
                    // );
                    // $logs = LogActivity::addToLog($log_data);

                    $paymentdetails = new OnlinePaymentDetails();
                    $paymentdetails->payment_method = 'credit_card';
                    $paymentdetails->email = auth()->user() ? auth()->user()->email : null;
                    $paymentdetails->payment_amount = $response->result->cardAmountBalance;
                    $paymentdetails->card_holder_name = $response->result->nameOnCard;
                    $paymentdetails->card_number = $response->result->pan;
                    $paymentdetails->zipcode = $response->result->zipcode;
                    $paymentdetails->CVV = $response->result->cvv;
                    $paymentdetails->month =date('m',strtotime($response->result->exp));
                    $paymentdetails->year =date('Y',strtotime($response->result->exp));
                    $paymentdetails->user_id = auth()->user()? auth()->user()->id : null;
                    $paymentdetails->save();

                    $transaction_id = \Crypt::decrypt($request->transaction_id);

                    $Payments = Payments::where('transaction_id',$transaction_id)->first();

                    $Payments->payment_details_id = $paymentdetails->id;
                    $Payments->payment_type = 'credit_card';
                    $Payments->payment_status = 'Process payment Success';
                    $Payments->save();

                    return view('admin.payments.card', compact('carddeatails'))->withFlashSuccess('Process payment Success');;
                } else {
                    // $log_data = array(
                    //     'user_id' => auth()->user()->id,
                    //     'logtype' => 'processVirtualCardPayment',
                    //     'action' => 'Process payment failed',
                    // );
                    // $logs = LogActivity::addToLog($log_data);
                    return redirect()->back()->withFlashDanger('Payment Failed!');
                }
            } else {
                // $log_data = array(
                //     'user_id' => auth()->user()->id,
                //     'logtype' => 'processVirtualCardPayment',
                //     'action' => 'Process payment failed',
                // );
                // $logs = LogActivity::addToLog($log_data);
                return redirect()->back()->withFlashDanger('Payment Failed!');
            }
        }
    }

   public function getReceivedPayments (Request $request)
   {
    //    dd('sds');
        $auth_user  = auth()->user();
        // dd(auth()->user()->id);
        // $company_id = 41;
        if (!empty($auth_user)) {
            // dd('sd');

            if ($request->ajax()) {
                $details = PaymentDetailOnline::get();
              
                return Datatables::of($details)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($detail) {
                        $btn = '';
                        $edtURL = url('/payment/received/view/'. $detail->id);

                        // $btn .= '<button type="button" class="log-request"><a href="'.$edtURL.'"><i class="fa fa-eye"></i></a></button>';
                        $btn .= '<a class="btn btn-xs btn-info" href="'.$edtURL.'"><i class="fa fa-eye"></i></a>';
                        // $btn .= '<button type="button" class="log-request"><a href="#"><i class="fa fa-pencil"></i></a></button>';
                        // $btn .= '<button type="button" class="log-request"><a href="#"><i class="fa fa-trash"></i></a></button>';
                        return $btn;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            } else {
              
                $details = PaymentDetailOnline::get();
        
            //  dd($details);
                return view('admin.payments.online.received', compact('details'));
            }
        }
   }
}
