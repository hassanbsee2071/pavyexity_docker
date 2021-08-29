<?php

namespace App\Http\Controllers\Admin;

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


class InvoiceController extends Controller {

    /**
    * Repository
    *
    * @var object
    */
    protected $repository;

    /**
    * Construct
    *
    */
    public function __construct() {
        //$this->repository = new EloquentUserRepository;
    }

    /**
    * Invoice listing
    */
    public function index(Request $request) {
        // dd('sdsdsd');
        // $user               = Auth::user();
        // $user_id            = $user->id;
        // $invoice_status     = (($request->filled('invoice_status') && in_array($request->invoice_status, ['paid','sent'])) ? $request->invoice_status : "");
        // $invoice_list_query = Invoice::getAdminInvoiceQueryObj(['user_id' => $user_id]);
        // if (!empty($invoice_status)) {
        //     $invoice_list_query->where('invoices.status', '=', $invoice_status);
        // }
        // $all_invoice                = $invoice_list_query->select('invoices.*','ci.user_id')->paginate();
        // $request_arr                = array();
        // $request_arr['all_invoice'] = $all_invoice;
        // return view('admin.invoice.index', $request_arr);

        $auth_user  = auth()->user();
        
        $company_id = 0;

        if (!empty($auth_user)) {
                if($request->ajax()){
                $user_id = $auth_user->id;
                $invoice_status     = (($request->filled('invoice_status') && in_array($request->invoice_status, ['paid','sent'])) ? $request->invoice_status : "");
                $invoice_list_query = Invoice::getAdminInvoiceQueryObj(['user_id' => $user_id]);
                if (!empty($invoice_status)) {
                    $invoice_list_query->where('invoices.status', '=', $invoice_status);
                }
                $all_invoice                = $invoice_list_query->select('invoices.*','ci.user_id');
                $request_arr                = array();
                $request_arr['all_invoice'] = $all_invoice;

                return Datatables::of($all_invoice)
                    ->addIndexColumn()
                    ->addColumn('client_name', function ($invoice) {    
                        $clientName = $invoice->user_id;
                        if (is_numeric($clientName) ) {
                            $clientName = getUserInfoById($invoice->user_id);
                        }
                        return $clientName;
                    })
                    ->addColumn('action', function ($invoice) {
                        $btn = '';
                        $btn .= '<a class="btn btn-xs btn-info" href="' . route('admin.company.invoice.edit', [$invoice->id]) . '" data-toggle="tooltip" data-placement="top" data-title="' .  __('views.admin.company.invoice.index.edit') . '"><i class="fa fa-pencil"></i></a>';
                        $btn .= '<a href="' . route('admin.company.invoice.destroy', [$invoice->id]) . '" class="btn btn-xs btn-danger user_destroy" onclick=\'return check()\' "><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }else{
                return view('admin.invoice.index');
            }
        }
    }

    public function add(Request $request) {
        $user                     = Auth::user();
        $user_id                  = $user->id;
        $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user->id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                }
            }
       // $company_id               = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
    //    dd($decoded);

       $user_list                = User::select('users.*');
        if(!isSuperAdmin()){
            // $user_list->join('company_users as cu', 'users.id', '=', 'cu.user_id')
            // ->where('cu.company_id', '=', $companyid);
       $user_list                = null;

            $user_list = getCompanyAdmins($decoded);


        }
        if(isSuperAdmin()){
            $user_list->where('users.id', '!=', $user_id);
        }
        //dd($user_list);
        // $user_list = $user_list->whereNull('users.deleted_at')
        // ->where('users.active', '=', 1)
        // ->orderBy(DB::raw('concat(users.first_name, " ", users.last_name)'), 'ASC')
        // ->get()
        // ->toArray();
        $request_arr              = array();
        $request_arr['all_users'] = $user_list;
        //dd($request_arr);
        return view('admin.invoice.add', $request_arr);
    }

    public function add2(Request $request) {
        $user                     = Auth::user();
        $user_id                  = $user->id;
        $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user->id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                }
            }
       // $company_id               = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
        $user_list                = User::select('users.*');
        if(!isSuperAdmin()){
            $user_list->join('company_users as cu', 'users.id', '=', 'cu.user_id')
            ->where('cu.company_id', '=', $companyid);
        }
        if(isSuperAdmin()){
            $user_list->where('users.id', '!=', $user_id);
        }
        //dd($user_list);
        $user_list = $user_list->whereNull('users.deleted_at')
        ->where('users.active', '=', 1)
        ->orderBy(DB::raw('concat(users.first_name, " ", users.last_name)'), 'ASC')
        ->get()
        ->toArray();
        $request_arr              = array();
        $request_arr['all_users'] = $user_list;
        //dd($request_arr);
        return view('admin.invoice.add2', $request_arr);
    }
    public function save(Request $request) {
        // dd($request->all());
        $validator              =   Validator::make($request->all(), [
            // 'user_id'       => 'required',
            'invoice_title' => 'required|max:255',
            'due_date'      => 'required',
            'invoice_date'  => 'required',
            // 'amount'        => 'required',
            'item.*'        => 'required',
            'quantity.*'     => 'required',
            'rate.*'        => 'required',
            'amounts.*'      => 'required',

            ]);

            $amounts = $request->amounts; 
            foreach( $amounts as $key => $index)
            {
                $amounts[$key] = ltrim($amounts[$key], '$');          
            }
            if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();

            $touser = User::where('email',$request->user_mail)->first();
if($touser){
$getInvoiceUserId = $touser->id;
            // $invoice_amount = $request->amount;
            $user                   = Auth::user();
            $invoice_number = generateInvoiceNumber();
            $invoice_title = $request->invoice_title;
            $user_id                = $user->id;
            $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user->id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                }
            }
            //$company_id             = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
            
            $folder = storage_path('invoice/' . $companyid .'/');
            $filename = time() . '.pdf';
            $isRecurring = $request->input('is_recurring');
            $tmp_due_dt             = explode("/", $request->due_date);
            $tmp_inv_dt             = explode("/", $request->invoice_date);
            //json data
            $resultdata         = [];
            // $resultdata["status"] = 1;
            $jsndata = [
                'item' => $request->item,
                'quantity' => $request->quantity,
                'rate' => $request->rate,
                'amounts' => $amounts
            ];
            $resultdata['content'] = $jsndata;

            $JSONdata = json_encode($resultdata);

            $invoice_amount = array_sum($jsndata['amounts']);

            

            if(isset($request->recurrring_end_date)){
                $tmp_recurring_dt             = explode("/", $request->recurrring_end_date);
      
            }
            $due_dt                 = $tmp_due_dt[2] . "-" . $tmp_due_dt[1] . "-" . $tmp_due_dt[0];

            $inv_dt                 = $tmp_inv_dt[2] . "-" . $tmp_inv_dt[1] . "-" . $tmp_inv_dt[0];
            if(isset($request->recurrring_end_date)){
            $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
             }
        
        
                $due_date = Carbon::createFromFormat('m/d/Y',$request->due_date)->format('Y-m-d');
                $end_date = Carbon::createFromFormat('m/d/Y',$request->invoice_date)->format('Y-m-d');
                if(isset($request->recurrring_end_date)){
                    $recurring_date = Carbon::createFromFormat('m/d/Y',$request->recurrring_end_date)->format('Y-m-d');
                }
                
              
            $invObj                 = new Invoice();
            $invObj->invoice_number = $invoice_number;
            $invObj->invoice_title  = $invoice_title;
            if(isset($request->recurrring_end_date)){
                $invObj->recurrring_end_date  = $recurring_date;
            }
          
            $invObj->due_date       = $due_date;
            $invObj->jsondata      = $JSONdata;
                if($isRecurring==1){
                $invObj->is_recurring = '1';
                $invObj->recurring_period = $request->input('recurring_period');
            }
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
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice save',
                    'action' => 'Invoice Added successfully',
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
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice save',
                    'action' => 'Invoice Added successfully',
                );
                $logs = \LogActivity::addToLog($log_data);
            }

            // Generate PDF for invoice
            $getFromCompanyInfo = CompanySetting::find($companyid);
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

                        $login_user  = Auth::user();
                        $allcompanies = \App\CompanySetting::get();
                                $companyusers=0;
                                $companyid= 0;
                                $companyname= '';
                                foreach( $allcompanies as $u){
                                
                                    $decoded = json_decode($u->user_id);
                                    if(in_array($login_user->id, $decoded)){
                                    $companyusers=1;
                                    $companyid= $u->id;
                                    $companyname = $u->company_name;
                                    }
                                }
            
                            $link = '';  
                           
                            $link = route('paymentlink', ['id'=>\Crypt::encryptString($invoice_amount . '@@' .'GlobalPayment' . '@@' . auth()->user()->id. '@@1' . '@@' . $companyname.'@@'.$companyid)]);
                           


                    $data['slug'] = 'Invoice-A';
                    $data['user']  = $username;
                    $data['file_path']  =$folder.$filename;
                    $data['paymentlink']  =$link;
                    Mail::to($mail)->send(new InvoiceAlertMail($data));
            }

        return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invoice Added Successfully!');
}
else{
    // $getInvoiceUserId = $touser->user_id;
    $getInvoiceUserMail = $request->user_mail;

    // $invoice_amount = $request->amount;
    $user                   = Auth::user();
    $invoice_number = generateInvoiceNumber();
    $invoice_title = $request->invoice_title;
    $user_id                = $user->id;
    $allcompanies = \App\CompanySetting::get();
      $companyusers=0;
      $companyid= 0;
      foreach( $allcompanies as $u){
      
        $decoded = json_decode($u->user_id);
        if(in_array($user->id, $decoded)){
          $companyusers=1;
          $companyid= $u->id;
        }
    }
    //$company_id             = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
    
    $folder = storage_path('invoice/' . $companyid .'/');
    $filename = time() . '.pdf';
    $isRecurring = $request->input('is_recurring');
    $tmp_due_dt             = explode("/", $request->due_date);
    $tmp_inv_dt             = explode("/", $request->invoice_date);
    //json data
    $resultdata         = [];
    // $resultdata["status"] = 1;
    $jsndata = [
        'item' => $request->item,
        'quantity' => $request->quantity,
        'rate' => $request->rate,
        'amounts' => $amounts
    ];
    $resultdata['content'] = $jsndata;

    $JSONdata = json_encode($resultdata);

    $invoice_amount = array_sum($jsndata['amounts']);

    // $newArray = array();
    // $item = $request->item;
    // $quantity = $request->quantity;
    // $rate = $request->rate;
    // $amount = $request->amount;

    // foreach ($item as $key => $single) {
    // // $newArray[$single] = $priceArray[$key];
    // $newArray[$single] = $quantity[$key];
    // $newArray[$single] = $rate[$key];
    // $newArray[$single] = $amount[$key];
    // }
    // $jsonFormatData = [];
    // $jdata[] = $jsonFormatData;
    // $jsonFormatData = json_encode($newArray);

    // dd(json_encode($resultdata));
    if(isset($request->recurrring_end_date)){
        // $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
        $tmp_recurring_dt             = explode("/", $request->recurrring_end_date);

    }
    $due_dt                 = $tmp_due_dt[2] . "-" . $tmp_due_dt[1] . "-" . $tmp_due_dt[0];

    $inv_dt                 = $tmp_inv_dt[2] . "-" . $tmp_inv_dt[1] . "-" . $tmp_inv_dt[0];
    if(isset($request->recurrring_end_date)){
        // $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
        $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
 
    }

        $due_date = Carbon::createFromFormat('m/d/Y',$request->due_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m/d/Y',$request->invoice_date)->format('Y-m-d');
        if(isset($request->recurrring_end_date)){
            $recurring_date = Carbon::createFromFormat('m/d/Y',$request->recurrring_end_date)->format('Y-m-d');
        }
      
    $invObj                 = new Invoice();
    $invObj->invoice_number = $invoice_number;
    $invObj->invoice_title  = $invoice_title;
    if(isset($request->recurrring_end_date)){
        $invObj->recurrring_end_date  = $recurring_date;
    }
     $invObj->due_date       = $due_date;
    $invObj->jsondata      = $JSONdata;
        if($isRecurring==1){
        $invObj->is_recurring = '1';
        $invObj->recurring_period = $request->input('recurring_period');
    }
    $invObj->amount         = $invoice_amount;
    $invObj->invoice_date   = $end_date;
    $invObj->file_name      = $filename;
    $invObj->save();
    // dd($invObj->save());
    $inv_id                 = $invObj->id;

    if(is_int($getInvoiceUserMail)){
        $newuser = new User;

        $newuser->name = 'Guest';
        $newuser->email = $getInvoiceUserMail;
        $newuser->password = 'Admin';
        $newuser->active = 0;
        $newuser->first_name = 'Guest';
        $newuser->last_name = 'User';
        $newuser->save();

        $compInvObj             = new CompanyInvoice();
        $compInvObj->invoice_id = $inv_id;
        $compInvObj->company_id = $companyid;
        $compInvObj->user_id = $newuser->id;

        $compInvObj->user_mail    = $getInvoiceUserMail;
        $compInvObj->save();

        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'invoice save',
            'action' => 'Invoice Added successfully',
        );
        $logs = \LogActivity::addToLog($log_data);

    }else{
        $newuser = new User;

        $newuser->name = 'Guest';
        $newuser->email = $getInvoiceUserMail;
        $newuser->password = 'Admin';
        $newuser->active = 0;
        $newuser->first_name = 'Guest';
        $newuser->last_name = 'User';
        $newuser->save();



        $compInvObj             = new CompanyInvoice();
        $compInvObj->invoice_id = $inv_id;
        $compInvObj->company_id = $companyid;
        $compInvObj->user_id = $newuser->id;
// dd('dd');
        $compInvObj->user_mail    = $getInvoiceUserMail;
        $compInvObj->save();

        //logs
        $log_data= array(
            'user_id' => $newuser->id,
            'logtype' => 'invoice save',
            'action' => 'Invoice Added successfully',
        );
        $logs = \LogActivity::addToLog($log_data);
    }

    // Generate PDF for invoice
    $getFromCompanyInfo = CompanySetting::find($companyid);
    // Get To user info
    // $decodeJSON = json_encode($JSONdata);
    // foreach (json_encode($JSONdata) as $single) {
    //  print_r($single);die;

    // }
    // dd($decodeJSON);

    if(isset($getInvoiceUserId)){
        $getUserInfo = User::find($getInvoiceUserId);
        $invoice_data = array('company_data'=>$getFromCompanyInfo,'user_info'=>$getUserInfo,'invoice_number'=>$invoice_number,'due_date'=>$due_dt,"invoice_date"=>$inv_dt,'invoice_title'=>$invoice_title,'invoice_amount'=>$invoice_amount,'jsondata'=>$JSONdata);
    }else{
        $invoice_data = array('company_data'=>$getFromCompanyInfo,'user_email'=>$getInvoiceUserMail,'invoice_number'=>$invoice_number,'due_date'=>$due_dt,"invoice_date"=>$inv_dt,'invoice_title'=>$invoice_title,'invoice_amount'=>$invoice_amount,'jsondata'=>$JSONdata);
    }

    $data = array();
    $pdf = PDF::loadView('admin.invoice.pdf',$invoice_data);

    if (!\File::exists($folder)) {
        \File::makeDirectory($folder, 0775, true, true);
    }
    $pdf->save($folder."/".$filename);

    // Send email with attached invoice
    if(isset($getInvoiceUserId)){
        $user = User::find($getInvoiceUserId);
        $userid = "";
        $mail=$user->email;
        $username = $user->firstname." ".$user->lastname;
    }else{
        $mail=$getInvoiceUserMail;
        $username = $getInvoiceUserMail;
    }
    if($user){
            $data['slug'] = 'Invoice-A';
            $data['user']  = $getInvoiceUserMail;
            $data['file_path']  =$folder.$filename;
            $data['paymentlink']  =route('login');
            // Mail::to($mail)->send(new InvoiceAlertMail($data));
    }else {
        $data['slug'] = 'Invoice-A';
        $data['user']  = $getInvoiceUserMail;
        $data['file_path']  =$folder.$filename;
        $data['paymentlink']  =route('login');
    }
    $login_user  = Auth::user();
    $allcompanies = \App\CompanySetting::get();
            $companyusers=0;
            $companyid= 0;
            $companyname= '';
            foreach( $allcompanies as $u){
            
                $decoded = json_decode($u->user_id);
                if(in_array($login_user->id, $decoded)){
                $companyusers=1;
                $companyid= $u->id;
                $companyname = $u->company_name;
                }
            }

        $link = '';  
       
        $link = route('paymentlink', ['id'=>\Crypt::encryptString($invoice_amount . '@@' .'GlobalPayment' . '@@' . auth()->user()->id. '@@1' . '@@' . $companyname.'@@'.$companyid)]);
       
        $data['paymentlink']  = $link;

    Mail::to($mail)->send(new InvoiceAlertMail($data));

return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invoice Added Successfully!');

}
            
    }

    public function save2(Request $request) {
        // dd($request->all());
        $validator              =   Validator::make($request->all(), [
            // 'user_id'       => 'required',
            'invoice_title' => 'required|max:255',
            'due_date'      => 'required',
            'invoice_date'  => 'required',
            // 'amount'        => 'required',
            'item.*'        => 'required',
            'quantity.*'     => 'required',
            'rate.*'        => 'required',
            'amounts.*'      => 'required',

            ]);

            if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
            $getInvoiceUserId = $request->user_id;
            $getInvoiceUserMail = $request->user_mail;

            // $invoice_amount = $request->amount;
            $user                   = Auth::user();
            $invoice_number = generateInvoiceNumber();
            $invoice_title = $request->invoice_title;
            $user_id                = $user->id;
            $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user->id, $decoded)){
                  $companyusers=1;
                  $companyid= $u->id;
                }
            }
            //$company_id             = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
            
            $folder = storage_path('invoice/' . $companyid .'/');
            $filename = time() . '.pdf';
            $isRecurring = $request->input('is_recurring');
            $tmp_due_dt             = explode("/", $request->due_date);
            $tmp_inv_dt             = explode("/", $request->invoice_date);
            //json data
            $resultdata         = [];
            // $resultdata["status"] = 1;
            $jsndata = [
                'item' => $request->item,
                'quantity' => $request->quantity,
                'rate' => $request->rate,
                'amounts' => $request->amounts
            ];
            $resultdata['content'] = $jsndata;

            $JSONdata = json_encode($resultdata);

            $invoice_amount = array_sum($jsndata['amounts']);

            // $newArray = array();
            // $item = $request->item;
            // $quantity = $request->quantity;
            // $rate = $request->rate;
            // $amount = $request->amount;

            // foreach ($item as $key => $single) {
            // // $newArray[$single] = $priceArray[$key];
            // $newArray[$single] = $quantity[$key];
            // $newArray[$single] = $rate[$key];
            // $newArray[$single] = $amount[$key];
            // }
            // $jsonFormatData = [];
            // $jdata[] = $jsonFormatData;
            // $jsonFormatData = json_encode($newArray);

            // dd(json_encode($resultdata));

            $tmp_recurring_dt             = explode("/", $request->recurrring_end_date);
            $due_dt                 = $tmp_due_dt[2] . "-" . $tmp_due_dt[1] . "-" . $tmp_due_dt[0];

            $inv_dt                 = $tmp_inv_dt[2] . "-" . $tmp_inv_dt[1] . "-" . $tmp_inv_dt[0];
            $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
        
        
                $due_date = Carbon::createFromFormat('m/d/Y',$request->due_date)->format('Y-m-d');
                $end_date = Carbon::createFromFormat('m/d/Y',$request->invoice_date)->format('Y-m-d');
                $recurring_date = Carbon::createFromFormat('m/d/Y',$request->recurrring_end_date)->format('Y-m-d');
              
            $invObj                 = new Invoice();
            $invObj->invoice_number = $invoice_number;
            $invObj->invoice_title  = $invoice_title;
            $invObj->recurrring_end_date  = $recurring_date;
            $invObj->due_date       = $due_date;
            $invObj->jsondata      = $JSONdata;
                if($isRecurring==1){
                $invObj->is_recurring = '1';
                $invObj->recurring_period = $request->input('recurring_period');
            }
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
                $compInvObj->user_mail    = $getInvoiceUserMail;
                $compInvObj->save();

                //logs
                $log_data= array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice save',
                    'action' => 'Invoice Added successfully',
                );
                $logs = \LogActivity::addToLog($log_data);

            }else{
                $compInvObj             = new CompanyInvoice();
                $compInvObj->invoice_id = $inv_id;
                $compInvObj->company_id = $companyid;
                $compInvObj->user_mail    = $getInvoiceUserMail;
                $compInvObj->save();

                //logs
                $log_data= array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice save',
                    'action' => 'Invoice Added successfully',
                );
                $logs = \LogActivity::addToLog($log_data);
            }

            // Generate PDF for invoice
            $getFromCompanyInfo = CompanySetting::find($companyid);
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
                $invoice_data = array('company_data'=>$getFromCompanyInfo,'user_email'=>$getInvoiceUserMail,'invoice_number'=>$invoice_number,'due_date'=>$due_dt,"invoice_date"=>$inv_dt,'invoice_title'=>$invoice_title,'invoice_amount'=>$invoice_amount,'jsondata'=>$JSONdata);
            }

            $data = array();
            $pdf = PDF::loadView('admin.invoice.pdf',$invoice_data);

            if (!\File::exists($folder)) {
                \File::makeDirectory($folder, 0775, true, true);
            }
            $pdf->save($folder.$filename);

            // Send email with attached invoice
            if(is_numeric($getInvoiceUserId)){
                $user = User::find($getInvoiceUserId);
                $userid = "";
                $mail=$user->email;
                $username = $user->firstname." ".$user->lastname;
            }else{
                $mail=$getInvoiceUserMail;
                $username = $getInvoiceUserMail;
            }
            if($user){
                    $data['slug'] = 'Invoice-A';
                    $data['user']  = $getInvoiceUserMail;
                    $data['file_path']  =$folder.$filename;
                    $data['paymentlink']  =route('login');
                    // Mail::to($mail)->send(new InvoiceAlertMail($data));
            }else {
                $data['slug'] = 'Invoice-A';
                $data['user']  = $getInvoiceUserMail;
                $data['file_path']  =$folder.$filename;
                $data['paymentlink']  =route('login');
                // Mail::to($getInvoiceUserMail)->send(new InvoiceAlertMail($data));
            }

        return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invoice Added Successfully!');
    }
    public function edit(Request $request) {
        $id = (($request->id) ? $request->id : 0);
        $invObj                = Invoice::find($id);
        //dd($invObj);
        if (empty($id) || empty($invObj)) {
            return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invalid request!');
        }
        else {
            $user                        = Auth::user();
            $user_id                     = $user->id;
            $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($user->id, $decoded)){
                  $companyusers=1;
                  $company_id= $u->id;
                }
            }
            //$company_id                  = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
            $user_list                   = User::select('users.*');
            if(!isSuperAdmin()){
                $user_list->join('company_users as cu', 'users.id', '=', 'cu.user_id')
                ->where('cu.company_id', '=', $company_id);
            }
            if(isSuperAdmin()){
                $user_list->where('users.id', '!=', $user_id);
            }
            $user_list=$user_list->whereNull('users.deleted_at')
            ->where('users.active', '=', 1)
            //->orderBy(DB::raw('concat(users.first_name, " ", users.last_name)'), 'ASC')
            ->get()
            ->toArray();
            $invoice_data                = Invoice::getAdminInvoiceQueryObj(['user_id' => $user_id]);
            ///dd($invoice_data);
            $result                      = $invoice_data->where('invoices.id', '=', $id)->first();
            $amountanditems = json_decode($result->jsondata);
            $request_arr                 = array();
            $request_arr['all_users']    = $user_list;
            $request_arr['invoice_data'] = $result;
            // dd($result);
           
            $request_arr['invoice_id'] = $id;
            // dd($amountanditems);
            $request_arr['items'] = $amountanditems;
            
            // dd($request_arr);
            return view('admin.invoice.edit', $request_arr );
        }
    }

    public function update(Request $request) {
        //   dd($request->amounts[0]);

        $validator          = Validator::make($request->all(), [
            // 'user_id'       => 'required',
            'invoice_title' => 'required|max:255',
            'due_date'      => 'required',
            'invoice_date'  => 'required',
            // 'amount'        => 'required',
            'invoice_id'        => 'required'
            ]);
            if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
            $id                 = $request->invoice_id;
            $user               = Auth::user();
            $user_id            = $user->id;
            $company_id         = CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
            $invoice_list_query = Invoice::getAdminInvoiceQueryObj(['user_id' => $user_id]);
            $result             = $invoice_list_query->where('invoices.id', '=', $id)->first();
            $isRecurring = $request->input('is_recurring');
            if (!empty($result)) {
              
                $due_date = Carbon::createFromFormat('m/d/Y',$request->due_date)->format('Y-m-d');
                $end_date = Carbon::createFromFormat('m/d/Y',$request->invoice_date)->format('Y-m-d');
              if($request->recurrring_end_date != null)
{
    $recurring_date = Carbon::createFromFormat('m/d/Y',$request->recurrring_end_date)->format('Y-m-d');
}    
              
                $invObj                = Invoice::find($id);
                // $tmp_due_dt            = explode("/", $request->due_date);
                // dd($tmp_due_dt);
                // $tmp_inv_dt            = explode("/", $request->invoice_date);
                // $tmp_recurring_dt             = explode("/", $request->recurrring_end_date);
                // $due_dt                = $tmp_due_dt[2] . "-" . $tmp_due_dt[1] . "-" . $tmp_due_dt[0];
                // $inv_dt                = $tmp_inv_dt[2] . "-" . $tmp_inv_dt[1] . "-" . $tmp_inv_dt[0];
                // $recuring_end_dt        = $tmp_recurring_dt[2] . "-" . $tmp_recurring_dt[1] . "-" . $tmp_recurring_dt[0];
                $invObj->invoice_title = $request->invoice_title;
                $invObj->due_date      = $due_date;
               if($request->amounts[0] != null){
                $invObj->amount    = $request->amounts[0];
               }
               if($request->recurrring_end_date != null){
                $invObj->recurrring_end_date  = $recurring_date;

               }
               
                if(!empty($request->invoice_status)){
                    $invObj->status    = $request->invoice_status;
                }else{
                    $invObj->status    = 'sent';
                }

                if($isRecurring==1){
                    $invObj->is_recurring = '1';
                    $invObj->recurring_period = $request->input('recurring_period');
                }else{
                    $invObj->is_recurring = '0';
                    $invObj->recurring_period = null;
                }
                $invObj->invoice_date  = $end_date;
                $jsndata = [
                    'item' => $request->item,
                    'quantity' => $request->quantity,
                    'rate' => $request->rate,
                    'amounts' => $request->amounts? $request->amounts : 00
                ];
                $resultdata['content'] = $jsndata;
    
                $JSONdata = json_encode($resultdata);
                $invObj->jsondata =$JSONdata;
                $invObj->save();



                $compInvObj = CompanyInvoice::where('invoice_id', '=', $id)->first();
                if (empty($compInvObj)) {
                    $compInvObj             = new \App\CompanyInvoice();
                    $compInvObj->invoice_id = $id;
                    $compInvObj->company_id = $company_id;
                }
                $user_mail = $request->user_mail;
                $iUser = User::where('email',$user_mail)->first();
            //    dd($iUser->id);
                $compInvObj->user_id = $iUser->id;
               
                $compInvObj->save();
                 //logs
                 $log_data= array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice update',
                    'action' => 'Invoice Updated successfully',
                );
                $logs = \LogActivity::addToLog($log_data);
                return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invoice Updated Successfully!');
            }
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param  int $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id) {
            $user               = Auth::user();
            $user_id            = $user->id;
            $invoice_list_query = Invoice::getAdminInvoiceQueryObj(['user_id' => $user_id]);
            $result             = $invoice_list_query->where('invoices.id', '=', $id)->first();
            if (!empty($result)) {
                $invObj = Invoice::find($id);
                if ($invObj->delete()) {
                    //logs
                    $log_data= array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'invoice destroy',
                        'action' => 'Invoice Deleted successfully',
                    );
                   // dd($log_data);
                    $logs = \LogActivity::addToLog($log_data);
                    return redirect()->route('admin.company.invoices.list')->withFlashSuccess('Invoice Deleted Successfully!');
                }
                else {
                    $log_data= array(
                        'user_id' => auth()->user()->id,
                        'logtype' => 'invoice destroy',
                        'action' => 'Unable to Delete Invoice',
                    );
                    $logs = \LogActivity::addToLog($log_data);
                    return redirect()->route('admin.company.invoices.list')->withFlashDanger('Unable to Delete Invoice!');
                }
            }
            else {
                $log_data= array(
                    'user_id' => auth()->user()->id,
                    'logtype' => 'invoice destroy',
                    'action' => 'Unable to Delete Invoice',
                );
                $logs = \LogActivity::addToLog($log_data);
                return redirect()->route('admin.company.invoices.list')->withFlashDanger('Unable to Delete Invoice!');
            }
        }

        public function invoicepdf() {
            return view('admin.invoice.pdf');
        }

    }

                ?>
