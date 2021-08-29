<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OnlinePaymentDetails;
use App\Models\Auth\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Payments;
use App\RecurringPayments;
use App\Invoice;
use App\PaymentDetailOnline;



class ExportCsvController extends Controller
{
    public function exportCsvLinks(){
        $fileName = uniqid().'.csv';
        // dd(auth()->user()->id);
        if (isSuperAdmin()) {
            $onlines = OnlinePaymentDetails::all();
            // $get_data = $payments;
        }else{
            $onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
        }

        $onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
  
                //  dd($onlines);
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('Sr no', 'Name', 'Link', 'Is Enable', 'Created At');
     
             $callback = function() use($onlines, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach ($onlines as $online) {
                     $row['Sr no']  = $online->id;
                     $row['Name']    = $online->name;
                     $row['Link']    = $online->hash;
                     $row['Is Enable']  = $online->is_enable;
                     $row['Created At']  = $online->created_at;
     
                     fputcsv($file, array($row['Sr no'], $row['Name'], $row['Link'], $row['Is Enable'], $row['Created At']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
     
    }

    public function exportCsvUser(){

        $fileName = uniqid().'.csv';
        // dd(auth()->user()->id);

        if (isSuperAdmin()) {
            $users = User::all();
            // $get_data = $payments;
        }else{
            $auth_user  = Auth::user();
            $company_id = 0;
            if (!empty($auth_user)) {
                
                    $user_id = $auth_user->id;
                  
                   // dd($query);
                    // })->sortable(['email' => 'asc']);
                    $user_role_id = $auth_user['roles'][0]->id;
                    if ($user_role_id == 1) { // Super User
                    } elseif ($user_role_id == 2) { // Admin User
                        // dd('super');
                        $allcompanies = \App\CompanySetting::get();
                        $companyusers=0;
                        $companyid= 0;
                        // dd($allcompanies);
    
                        foreach ($allcompanies as $u) {
                            $decoded = json_decode($u->user_id);
                            if (in_array($auth_user->id, $decoded)) {
                                $companyusers=1;
                                $companyid= $u->id;
                                $companyname=$u->company_name;
                            }
                        }
                     
                    }
                
            }
    
                    // dd($companyid);
                  
                    $users = DB::table('users')
                ->join('company_users', 'users.id', '=', 'company_users.user_id')
                ->where('company_users.company_id', '=', $companyid)
                ->get()->toArray();
            
            }

        
// dd($users);

                //$onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
    //  dd($onlines);
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('Sr no', 'Name', 'Email', 'Active', 'Created At');
     
             $callback = function() use($users, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach ($users as $user) {
                     $row['Sr no']  = $user->id;
                     $row['Name']    = $user->name;
                     $row['Email']    = $user->email;
                     $row['Active']  = $user->active;
                     $row['Created At']  = $user->created_at;
     
                     fputcsv($file, array($row['Sr no'], $row['Name'], $row['Email'], $row['Active'], $row['Created At']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
     
    }
    public function exportCsvInvoice(){
        $fileName = uniqid().'.csv';
        // dd(auth()->user()->id);

        if (isSuperAdmin()) {
            $invoices = Invoice::all();
            // $get_data = $payments;
        }else{
        
            $auth_user  = Auth::user();
            $company_id = 0;
            if (!empty($auth_user)) {
                
                    $user_id = $auth_user->id;
                   
                   // dd($query);
                    // })->sortable(['email' => 'asc']);
                    $user_role_id = $auth_user['roles'][0]->id;
                    if ($user_role_id == 1) { // Super User
                    } elseif ($user_role_id == 2) { // Admin User
                        // dd('super');
                        $allcompanies = \App\CompanySetting::get();
                        $companyusers=0;
                        $companyid= 0;
                        // dd($allcompanies);
    
                        foreach ($allcompanies as $u) {
                            $decoded = json_decode($u->user_id);
                            if (in_array($auth_user->id, $decoded)) {
                                $companyusers=1;
                                $companyid= $u->id;
                                $companyname=$u->company_name;
                            }
                        }
                     
                    }
                
            }
    
                    // dd($companyid);
                  
                    $invoices = DB::table('invoices')
                ->join('company_invoices', 'invoices.id', '=', 'company_invoices.invoice_id')
                ->where('company_invoices.company_id', '=', $companyid)
                ->get()->toArray();
        }

        
// dd($users);
// dd($invoices);

                //$onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
    //  dd($onlines);
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('Invoice no', 'Invoice Title', 'Amount', 'Due Date', 'Invoice Date', 'Invoice Status', 'Is Recurring', 'Created At');
     
             $callback = function() use($invoices, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach ($invoices as $invoice) {
                     $row['Invoice no']  = $invoice->invoice_number;
                     $row['Invoice Title']    = $invoice->invoice_title;
                     $row['Amount']    = $invoice->amount;
                     $row['Due Date']  = $invoice->due_date;
                     $row['Invoice Date']  = $invoice->invoice_date;
                     $row['Invoice Status']  = $invoice->status;
                     $row['Is Recurring']  = $invoice->is_recurring;
                     $row['Created At']  = $invoice->created_at;
     
                     fputcsv($file, array($row['Invoice no'], $row['Invoice Title'], $row['Amount'], $row['Due Date'], $row['Invoice Date'], $row['Invoice Status'], $row['Is Recurring'], $row['Created At']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
     
    }
    public function exportCsvPayment(){
        $fileName = uniqid().'.csv';
        // dd(auth()->user()->id);

        $auth_user  = Auth::user();
        $company_id = 0;
        if (!empty($auth_user)) {
            
                $user_id = $auth_user->id;
               
               // dd($query);
                // })->sortable(['email' => 'asc']);
                $user_role_id = $auth_user['roles'][0]->id;
                if ($user_role_id == 1) { // Super User
                } elseif ($user_role_id == 2) { // Admin User
                    // dd('super');
                    $allcompanies = \App\CompanySetting::get();
                    $companyusers=0;
                    $companyid= 0;
                    // dd($allcompanies);

                    foreach ($allcompanies as $u) {
                        $decoded = json_decode($u->user_id);
                        if (in_array($auth_user->id, $decoded)) {
                            $companyusers=1;
                            $companyid= $u->id;
                            $companyname=$u->company_name;
                        }
                    }
                 
                }
            
        }
        $payments = Payments::where('sender_id', $user_id)->get();


                // dd($companyid);
              
            
// dd($users);
// dd($payments);

                //$onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
    //  dd($onlines);
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
            // dd($payments);

             $columns = array('Transaction Id', 'Email', 'Amount', 'Payment Type', 'Payment Status', 'Description', 'Is Recurring', 'Created At');
    //  dd($payments);
             $callback = function() use($payments, $columns) {
                 $file = fopen('php://output', 'w');
     //  
                 fputcsv($file, $columns);
                //  dd($payments);
     
                 foreach ($payments as $payment) {
                     $row['Transaction Id']  = $payment->transaction_id;
                     $row['Email']    = $payment->email;
                     $row['Amount']    = $payment->payment_amount;
                     $row['Payment Type']  = $payment->payment_type;
                     $row['Payment Status']  = $payment->payment_status;
                     $row['Description']  = $payment->description;
                     $row['Is Recurring']  = $payment->is_reoccuring;
                     $row['Created At']  = $payment->created_at;
     
                     fputcsv($file, array($row['Transaction Id'], $row['Email'], $row['Amount'], $row['Payment Type'], $row['Payment Status'], $row['Description'], $row['Is Recurring'], $row['Created At']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
     
    }

    public function exportCsvSchedule(){
        // dd('s');
        $fileName = uniqid().'.csv';
        // dd(auth()->user()->id);

        $auth_user  = Auth::user();
        $company_id = 0;
        if (!empty($auth_user)) {
            
                $user_id = $auth_user->id;
               
               // dd($query);
                // })->sortable(['email' => 'asc']);
                $user_role_id = $auth_user['roles'][0]->id;
                if ($user_role_id == 1) { // Super User
                } elseif ($user_role_id == 2) { // Admin User
                    // dd('super');
                    $allcompanies = \App\CompanySetting::get();
                    $companyusers=0;
                    $companyid= 0;
                    // dd($allcompanies);

                    foreach ($allcompanies as $u) {
                        $decoded = json_decode($u->user_id);
                        if (in_array($auth_user->id, $decoded)) {
                            $companyusers=1;
                            $companyid= $u->id;
                            $companyname=$u->company_name;
                        }
                    }
                 
                }
            
        }
        // $payments = Payments::where('sender_id', $user_id)->get();

        $payments = RecurringPayments::where('user_id', auth()->user()->id)->get();
                // dd($companyid);
              
            
// dd($users);
// dd($payments);

                //$onlines = OnlinePaymentDetails::where('user_id', auth()->user()->id)->get();
    //  dd($onlines);
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
            // dd($payments);

             $columns = array('Transaction Id', 'Email', 'Amount', 'Payment Interval', 'Start Date', 'End Date', 'Created At');
    //  dd($payments);
             $callback = function() use($payments, $columns) {
                 $file = fopen('php://output', 'w');
     //  
                 fputcsv($file, $columns);
                //  dd($payments);
     
                 foreach ($payments as $payment) {
                     $row['Transaction Id']  = $payment->id;
                     $row['Email']    = $payment->email;
                     $row['Amount']    = $payment->payment_amount;
                     $row['Payment Interval']  = $payment->intervals;
                     $row['Start Date']  = $payment->start_date;
                     $row['End Date']  = $payment->end_date;
                     $row['Created At']  = $payment->created_at;
     
                     fputcsv($file, array($row['Transaction Id'], $row['Email'], $row['Amount'], $row['Payment Interval'], $row['Start Date'], $row['End Date'],  $row['Created At']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
     
    }

    public function receive_payment($id){
        // dd($id);
        $payment = PaymentDetailOnline::find($id);

        return view('admin.payments.online.received-view', compact('payment'));    
    }

    //
}
