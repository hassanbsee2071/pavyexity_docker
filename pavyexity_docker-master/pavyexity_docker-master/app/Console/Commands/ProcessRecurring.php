<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Repositories\Access\User\EloquentUserRepository;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use App\InvoiceDetail;
use App\CompanyInvoice;
use App\CompanySetting;
use PDF;
use Mail;
use App\Mail\SendDynamicEmail;
use App\Mail\InvoiceAlertMail;
use DataTables;

class ProcessRecurring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $invoices = Invoice::all();


        if($invoices){

            foreach($invoices as $invoice){
                if($invoice->is_recurring == 1){
                    if($invoice->recurring_period == 'weekly'){
                        $date = new Carbon;
                        $end_date = new Carbon($invoice->recurrring_end_date);

                        if($date > $end_date)
                        {
                        // $this->info('Invoice Expired');
                        }
                     else {
                        // $this->info($invoice->id);

                        $company_invoice = CompanyInvoice::where('invoice_id',$invoice->id)->first();
                        // $this->info($company_invoice->company_id);

                      if($company_invoice){
                    
                        if($company_invoice->user_id != null){
                            $touser = User::find($company_invoice->user_id)->first();
                        // $this->info($touser);

                        }else{
                            $touser = User::where('email',$company_invoice->user_mail)->first();
                            // $this->info($touser);

                        }

                      }
                      
                        if($touser){
                        $getInvoiceUserId = $touser->id;
                                    // $invoice_amount = $request->amount;
                                    // $user                   = Auth::user();
                                    $invoice_number = generateInvoiceNumber();
                                    $invoice_title = $invoice->invoice_title;
                                    // $user_id                = $user->id;
                                    // $allcompanies = \App\CompanySetting::get();
                                    //   $companyusers=0;
                                      $companyid= $company_invoice->company_id;
                                    //   foreach( $allcompanies as $u){
                                      
                                    //     $decoded = json_decode($u->user_id);
                                    //     if(in_array($user->id, $decoded)){
                                    //       $companyusers=1;
                                    //       $companyid= $u->id;
                                    //     }
                                    // }
                                    $company_id             = $company_invoice->company_id;
                                    
                                    $folder = storage_path('invoice/' . $companyid .'/');
                                    $filename = time() . '.pdf';
                                    // $isRecurring = $request->input('is_recurring');
                                    // $tmp_due_dt             = explode("/", $request->due_date);
                                    // $tmp_inv_dt             = explode("/", $request->invoice_date);
                                    //json data
                                    $resultdata         = [];
                                    // $resultdata["status"] = 1;
                                    $js = json_decode($invoice->jsondata);

                                    // $this->info($js->content->amounts);
                                    // $this->info('asdsa');
                                    
                                    $jsndata = [
                                        'item' => $js->content->item,
                                        'quantity' => $js->content->quantity,
                                        'rate' => $js->content->rate,
                                        'amounts' => $js->content->amounts
                                    ];
                                    $resultdata['content'] = $jsndata;
                        
                                    $JSONdata = json_encode($resultdata);
                        
                                    $invoice_amount = array_sum($jsndata['amounts']);
                        
                                    
                        
                                    if(isset($request->recurrring_end_date)){
                                        // $tmp_recurring_dt             = explode("/", $request->recurrring_end_date);
                              
                                    }
                                    $due_dt                 = new Carbon;
                        
                                    $inv_dt                 = new Carbon;
                                    if(isset($invoice->recurrring_end_date)){
                                    $recuring_end_dt        = $invoice->recurrring_end_date ;
                                     }
                                
                                
                                        $due_date = new Carbon;
                                        $end_date = new Carbon;
                                        if(isset($invoice->recurrring_end_date)){
                                            $recurring_date = new Carbon;
                                        }
                                        
                                      
                                    $invObj                 = new Invoice();
                                    $invObj->invoice_number = $invoice_number;
                                    $invObj->invoice_title  = $invoice_title;
                                    if(isset($invoice->recurrring_end_date)){
                                        $invObj->recurrring_end_date  = $recurring_date;
                                    }
                                  
                                    $invObj->due_date       = $due_date;
                                    $invObj->jsondata      = $JSONdata;
                                        // if($isRecurring==1){
                                        $invObj->is_recurring = '0';
                                        $invObj->recurring_period = $invoice->recurring_period;
                                    // }
                                    $invObj->amount         = $invoice_amount;
                                    $invObj->invoice_date   = $end_date;
                                    $invObj->file_name      = $filename;
                                    $invObj->save();
                                    // dd($invObj->save());
                                    $inv_id                 = $invObj->id;
                        
                                    if(is_int($getInvoiceUserId)){
                                        $compInvObj             = new CompanyInvoice();
                                        $compInvObj->invoice_id = $inv_id;
                                        $compInvObj->company_id = $companyid;
                                        $compInvObj->user_id    = $getInvoiceUserId;
                                        $compInvObj->save();
                        
                                        //logs
                                        $log_data= array(
                                            'user_id' => $company_invoice->company_id,
                                            'logtype' => 'invoice save with company id',
                                            'action' => 'Invoice Added successfully from Crons',
                                        );
                                        $logs = \LogActivity::addToLog($log_data);
                        
                                    }else{
                                        $compInvObj             = new CompanyInvoice();
                                        $compInvObj->invoice_id = $inv_id;
                                        $compInvObj->company_id = $companyid;
                                        $compInvObj->user_id    = $getInvoiceUserId;
                                        $compInvObj->save();
                        
                                        //logs
                                        $log_data= array(
                                            'user_id' => $company_invoice->company_id,
                                            'logtype' => 'invoice save',
                                            'action' => 'Invoice Added successfully from Crons',
                                        );
                                        $logs = \LogActivity::addToLog($log_data);
                                    }
                        
                                    // Generate PDF for invoice
                                    $getFromCompanyInfo = CompanySetting::find($companyid);
                                    $companyname = $getFromCompanyInfo->company_name;
                                    // Get To user info
                                    // $decodeJSON = json_encode($JSONdata);
                                    // foreach (json_encode($JSONdata) as $single) {
                                    //  print_r($single);die;
                        
                                    // }
                                    // dd($decodeJSON);
                        
                                    if(is_numeric($getInvoiceUserId)){
                                        $getUserInfo = User::find($getInvoiceUserId);
                                        $invoice_data = array('company_data'=>$getFromCompanyInfo,'user_info'=>$getUserInfo,'invoice_number'=>$invoice_number,'due_date'=>$due_dt,"invoice_date"=>$inv_dt,'invoice_title'=>$invoice_title,'invoice_amount'=>$invoice_amount,'jsondata'=>$JSONdata);
                                    }else{
                                        $invoice_data = array('company_data'=>$getFromCompanyInfo,'user_email'=>$getInvoiceUserId,'invoice_number'=>$invoice_number,'due_date'=>$due_dt,"invoice_date"=>$inv_dt,'invoice_title'=>$invoice_title,'invoice_amount'=>$invoice_amount,'jsondata'=>$JSONdata);
                                    }
                        
                                    $data = array();
                                    $pdf = PDF::loadView('admin.invoice.pdf',$invoice_data);
                        
                                    if (!\File::exists($folder)) {
                                        \File::makeDirectory($folder, 0775, true, true);
                                    }
                                    $pdf->save($folder."/".$filename);
                        
                                    // Send email with attached invoice
                                    if(is_numeric($getInvoiceUserId)){
                                        $user = User::find($getInvoiceUserId);
                                        $userid = "";
                                        $mail=$user->email;
                                        $username = $user->firstname." ".$user->lastname;
                                    }else{
                                        $mail=$getInvoiceUserId;
                                        $username = $getInvoiceUserId;
                                    }
                                    if($user){
                        
                                                // $login_user  = Auth::user();
                                                
                                    
                                                    $link = '';  
                                                   
                                                    $link = route('paymentlink', ['id'=>\Crypt::encryptString($invoice_amount . '@@' .'GlobalPayment' . '@@' . $company_invoice->company_id. '@@1' . '@@' . $companyname.'@@'.$companyid)]);
                                                   
                        
                        
                                            $data['slug'] = 'Invoice-A';
                                            $data['user']  = $username;
                                            $data['file_path']  =$folder.$filename;
                                            $data['paymentlink']  =$link;
                                            Mail::to($mail)->send(new InvoiceAlertMail($data));
                                              $this->info('Invoice Valid And Sent');

                                    }
                          
                        }
                 
                        }
                    }

                }
            }
            // \Log::info("Cron is working fine!");


            // $this->info($recPayments);
        }
        else{
            \Log::info("Cron is working fine! No recurring data found");

        }

        return 0;
    }
}
