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


class ImportController extends Controller
{
    public function getImport()
    {
        
        return view('admin.payments.csv.import');
    }

    public function getImport2()
    {
        
        return view('admin.payments.csv.import2');
    }

    public function parseImport(Request $request)
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
        }else {
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
if(
   !Str::contains($csvHeaders,'email') || !Str::contains($csvHeaders,'amount' ) || !Str::contains($csvHeaders,'description'))
{

    Session::flash('errorMessage', 'CSV is not valid! Please check email, amount & description in csv file.'); 
    return view('admin.payments.csv.import');
}

// dd(Str::contains($csvHeaders,'email'));
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
    // dd($csv_header_fields);
        $csv_data = array_slice($data, 0, 2);
        return view('admin.payments.csv.import_fields', compact('csv_data','csv_data_file','csv_header_fields'));
    
        // To be continued...
    }
    public function parseImport2(Request $request)
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
        }else {
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
if(
   !Str::contains($csvHeaders,'email') || !Str::contains($csvHeaders,'amount' ) || !Str::contains($csvHeaders,'description') || !Str::contains($csvHeaders,'intervals') || !Str::contains($csvHeaders,'start_date') || !Str::contains($csvHeaders,'end_date'))
{

    Session::flash('errorMessage', 'CSV is not valid! Please check email, amount, intervals, start_date, end_date & description in csv file.'); 
    return view('admin.payments.csv.import2');
}

// dd(Str::contains($csvHeaders,'email'));
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
    // dd($csv_header_fields);
        $csv_data = array_slice($data, 0, 2);
        return view('admin.payments.csv.import_fields2', compact('csv_data','csv_data_file','csv_header_fields'));
    
        // To be continued...
    }
public function processImport(Request $request)
{
    //  dd($request->all());
    $data = CsvData::find($request->csv_data_file_id);
    $csv_data = json_decode($data->csv_data, true);

// dd($csv_data);
    foreach ($csv_data as $row) {
        // $contact = new Contact();
        $user = null;
        $userid = auth()->user()->id;
        $mail = null;
        $message = null;
        $payment_amount = null;
        $description = null;

        foreach (config('app.db_fields') as $index => $field) {
        if($field == 'email'){
          
            $user = User::where('email', $row[$request->fields[$field]])->first();
            $mail = $row[$request->fields[$field]];
            if ($user) {
                $message = "Payment Awaiting User Approval";
            } else {
                $message = "Payment Inviation Sent";
            }
        }
       elseif($field == 'amount'){
          
            $payment_amount = $row[$request->fields[$field]];
          
            
          
       
        }
        elseif($field == 'description'){
            $description = $row[$request->fields[$field]];
        }else{

        }

        }
        // dd('mail='.$mail.'amount='.$payment_amount.'des='.$description);

if($user){
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

    $company = CompanySetting::find($companyid);



    $transactions = new Transactions();
        $transactions->transaction_id = 'Payment Awaiting User Approval';
        // dd($payment_amount);
        $transactions->transaction_amount = $payment_amount;
        $transactions->transaction_description = $description;
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
                    $payments->payment_amount = $payment_amount;
                    $payments->email = $mail;
                    $payments->is_reoccuring = 0;
                    $payments->is_guest = 0;
                    $payments->payment_status = 'Payment Awaiting User Approval';
                    $payments->description = $description;
                    $payments->sender_id = auth()->user()->id;

                    $payments->save();
                }
    // $transactions_id = createTransaction($message, $payment_amount, "Waiting for user to accept payment request", "processing", "one time payment", "");
    // if($transactions_id){
    //     insertPayment("Awaiting user to select payment method ", $transactions_id, 0, $payment_amount, $mail, 0, 1, $message, $description);
    // }
    if ($user) {
        $data['slug'] = 'PayAlert';
        $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($mail . "+++" . 'ReceivePayment' . '+++' . $transactions->id . '+++' . $userid)]);
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
        $data['Registerlink'] = route('payment', ['email' => Crypt::encryptString($mail . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
        $data['loginlink'] = route('payment', ['email' => Crypt::encryptString($mail . "+++" . 'ReceivePayment' . '+++' . $transactions_id . '+++' . $userid)]);
        // Mail::to($mail)->send(new SendDynamicEmail($data));

        $log_data = array(
            'user_id' => auth()->user()->id,
            'logtype' => 'send payment',
            'action' => 'payment sent',
        );
        $logs = LogActivity::addToLog($log_data);
    }
  if($mail){
    $data['user']  = 'User';
    $data['sender']  = auth()->user()->email;
    $data['link']  = route('login');

    // $mail = $row->email;
    Mail::to($mail)->send(new SendPaymentLinkMail($data));

}
      }else{ //not user

        // $user = User::where('email', $request->email)->first();
    $userid = Auth::user()->id;
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

    $company = CompanySetting::find($companyid);



    $transactions = new Transactions();
        $transactions->transaction_id = 'Payment Awaiting User Approval';
        // dd($payment_amount);
        $transactions->transaction_amount = $payment_amount;
        $transactions->transaction_description = $description;
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
                    $payments->payment_amount = $payment_amount;
                    $payments->email = $mail;
                    $payments->is_reoccuring = 0;
                    $payments->is_guest = 0;
                    $payments->payment_status = 'Payment Awaiting User Approval';
                    $payments->description = $description;
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
        Mail::to($mail)->send(new SendPaymentLinkMailUnreg($data));

      }
        


        // $contact->save();
    }

    return redirect()->route('admin.payments')->withFlashSuccess('CSV Added Successfully!');
}
public function processImport2(Request $request)
{
    //   dd($request->all());
    $data = CsvData::find($request->csv_data_file_id);
    $csv_data = json_decode($data->csv_data, true);

// dd($csv_data);
    foreach ($csv_data as $row) {
        // $contact = new Contact();
        $user = null;
        $userid = auth()->user()->id;
        $mail = null;
        $message = null;
        $payment_amount = null;
        $description = null;


        $message = "Payment recieve invitation send";
        $recurring_payments = new RecurringPayments;
        // dd($row);
        foreach (config('app.schedule_db_fields') as $index => $field) {
        // dd($row[]);

            if($field == 'email'){
                $recurring_payments->email = $row[$field];
                $mail = $row[$field];
                    
            }
       elseif($field == 'amount'){
        $recurring_payments->payment_amount = $row[$field];

        }
        elseif($field == 'description'){
        $recurring_payments->description = $row[$field];
            
        }elseif($field == 'intervals'){
            $recurring_payments->intervals = $row[$field];
        
            
        }elseif($field == 'start_date'){
        $recurring_payments->start_date = Carbon::createFromFormat('Y-m-d',$row[$field])->format('Y-m-d');
            
        }elseif($field == 'end_date'){
        $recurring_payments->end_date = Carbon::createFromFormat('Y-m-d',$row[$field])->format('Y-m-d');
            
        }
        else{
            $recurring_payments->user_id = Auth::user()->id;

        }

        }
        $tosuer = User::where('email',$mail)->first();
        // dd($mail);
        if ($recurring_payments->save()) {
            $log_data = array(
                'user_id' => $tosuer ? $tosuer->id : auth()->user()->id ,
                'logtype' => 'addSchedulePayment',
                'action' => 'Payment Scheduled Successfully',
            );
            $logs = LogActivity::addToLog($log_data);
        }
        // dd('mail='.$mail.'amount='.$payment_amount.'des='.$description);



        


        // $contact->save();
    }

    return redirect()->route('admin.payments')->withFlashSuccess('CSV Added Successfully!');
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
        $recurring_payments->user_id = Auth::user()->id;
        if ($recurring_payments->save()) {
            $log_data = array(
                'user_id' => auth()->user()->id,
                'logtype' => 'addSchedulePayment',
                'action' => 'Payment Scheduled Successfully',
            );
            $logs = LogActivity::addToLog($log_data);
        }else{
            // dd('Data Not set');
            // return redirect()->route('admin.payments.schedule.view')->withFlashSuccess('CSV Data Importing Failed!');
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

    //
}
