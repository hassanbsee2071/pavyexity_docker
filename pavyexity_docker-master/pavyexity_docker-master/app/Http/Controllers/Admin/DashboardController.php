<?php

namespace App\Http\Controllers\Admin;
use App\Invoice;
use App\Models\Auth\User\User;
use App\Models\Auth\Role\Role;
use Arcanedev\LogViewer\Entities\Log;
use Arcanedev\LogViewer\Entities\LogEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()) {
            return redirect('/login');
        } else {
            $auth_user  = Auth::user();
            $user_id = $auth_user->id;
            $user = \DB::table('users');
            $userConfirmed = \DB::table('users')->where('confirmed', false);
            $totalCompany = \DB::table('company_settings')->whereNull('deleted_at');
            $userInactive = \DB::table('users')->where('active', 0);
            // $invoiceAmount = \DB::table('invoices');
            $totalInvoice = \DB::table('invoices');
             // $invoiceSent = \DB::table('invoices')->where('status', 'sent');
            // $invoicePaid = \DB::table('invoices')->where('status', 'paid');
            $paymentAmount = \DB::table('payments');
            $totalPayment = \DB::table('payments');

            if(isAdmin()){


                $paymentAmount = \DB::table('payments')->where('sender_id',$user_id);
                $totalPayment = \DB::table('payments')->where('sender_id',$user_id);
                $invoiceAmount = \DB::table('payments')->where('sender_id',$user_id);
                //dd($invoiceAmount);
                $allcompanies = \App\CompanySetting::get();
                $companyusers=0;
                $companyid= 0;
                foreach( $allcompanies as $u){
                
                  $decoded = json_decode($u->user_id);
                  if(in_array($user_id, $decoded)){
                    $companyusers=1;
                    $company_id= $u;
                  }
              }
  
                //$company_id= \DB::table('company_settings')->where('user_id',$user_id)->first('id');
                // dd($company_id->id);
                $company_invoices= \DB::table('company_invoices')->where('company_id',$company_id->id)->get();
                // dd($company_invoices);
                 // dd($company_invoices);
                $invoiceAmount = null;
                $invoiceSent = null;
                $invoicePaid = null;
                $invoiceSum = null;
                foreach($company_invoices as $all){
                    $invoiceAmount = \DB::table('invoices')
                    ->where('id', $all->invoice_id)->where('deleted_at',NULL);
                    $invoiceSum[] = \DB::table('invoices')
                    ->where('id', $all->invoice_id)->where('deleted_at',NULL)->first();
                    $invoiceSent[] = \DB::table('invoices')->where('status', 'sent')->where('id', $all->invoice_id)->first();
                    $newInvoice = \DB::table('invoices')->where('status', 'sent')->where('id', $all->invoice_id)->first();
                  
                    $invoicePaid = \DB::table('invoices')->where('status', 'paid')->where('id', $all->invoice_id);
                }

                $sum = null;
                // dd('hi');
                if($invoiceSum != null){

                foreach ($invoiceSum as $inv) {
                    // dd($inv->amount);
                    // $invoice = Invoice::where('status', 'sent')->where('id', $inv->id)->where('due_date', '>=', $from)->where('due_date', '<=', $to)->first();
                    // if ($invoice != "") {
                    //     $filter_inv_sent[] = $invoice;
                        
                    // $sum += $inv->amount; use this code
                        
                    $sum = 0;
                    // }
                    
        
                }
            }


                // dd($invoiceSum);

                // dd($newInvoice);
                
                    // ->join('invoices', 'invoices.id', '=', 'company_invoices.id');
                // dd(count($invoiceSent));
            
            
            
            
            }

            elseif(isSuperAdmin()){
                // dd('hello');
                $paymentAmount = \DB::table('payments');
                $totalPayment = \DB::table('payments');
                $invoiceAmount = \DB::table('invoices')->where('deleted_at',NULL);
                // dd($invoiceAmount);
                $invoiceSent = \DB::table('invoices')->where('status', 'sent');
                $invoicePaid = \DB::table('invoices')->where('status', 'paid');
                // dd('hello');
                
            }

            else{
                // dd('hello');

                $paymentAmount = \DB::table('payments')->where('user_id',$user_id);
                $totalPayment = \DB::table('payments')->where('user_id',$user_id);
                 $invoiceAmount = \DB::table('payments')->where('user_id',$user_id);
                $company_id= \DB::table('company_users')->where('user_id',$user_id)->first('user_id');


                if (!empty($company_id)) {
                  



                $company_invoices= \DB::table('company_invoices')->where('user_id',$company_id->user_id)->get();

                // dd($company_id,$company_invoices,$user_id);
                 $invoiceAmount = null;
                 $invoiceSent = null;
                 $invoicePaid = null;
                foreach($company_invoices as $all){
                    $invoiceAmount = \DB::table('invoices')
                    ->where('id', $all->invoice_id)->get()->toArray();
                     $invoiceSent = \DB::table('invoices')->where('status', 'sent')->where('id', $all->invoice_id);
                     $invoicePaid = \DB::table('invoices')->where('status', 'paid')->where('id', $all->invoice_id);
                }
                // dd($invoiceSent);
                } else {
                    auth()->logout();  //logout
                    $errors = "No any company associate with this user";
                    return redirect()->back()
                    ->withErrors($errors);
                  }

                // dd($invoiceAmount,$invoiceSent,$invoicePaid);
                
                

                // $paymentAmount = \DB::table('payments');
                // $totalPayment = \DB::table('payments');
                // $invoiceAmount = \DB::table('invoices');
                // $invoiceSent = \DB::table('invoices')->where('status', 'sent');
                // $invoicePaid = \DB::table('invoices')->where('status', 'paid');
            }


if(isAdmin()){
    if (isset($request->start) && isset($request->end)) {
        //dd($invoiceAmount->count());
        $from = $request->start;
        $to = $request->end;

        $filter_inv_sent = [];
        // dd($from);
$sum = null;
        foreach ($invoiceSent as $inv) {
            $invoice = Invoice::where('status', 'sent')->where('id', $inv->id)->where('due_date', '>=', $from)->where('due_date', '<=', $to)->first();
            if ($invoice != "") {
                $filter_inv_sent[] = $invoice;
                $sum += $invoice->amount;
            }
            

        }
          //  dd($filter_inv_sent);
        // }


        $paymentAmount->whereBetween('created_at', [$from, $to]);
        $totalPayment->whereBetween('created_at', [$from, $to]);
        
        $user->whereBetween('created_at', [$from, $to]);

        $userConfirmed->whereBetween('created_at', [$from, $to]);
        $totalCompany->whereBetween('created_at', [$from, $to]);
        $userInactive->whereBetween('created_at', [$from, $to]);
        ($invoiceAmount == null) ? 0 : $invoiceAmount->whereBetween('due_date', [$from, $to])->where('deleted_at',NULL);
        $totalInvoice->whereBetween('due_date', [$from, $to]);
       // ($invoiceSent == null) ? 0 : $invoiceSent->whereBetween('due_date', [$from, $to]);
        ($invoicePaid == null) ? 0 : $invoicePaid->whereBetween('due_date', [$from, $to]);
        $company_invoices->whereBetween('created_at', [$from, $to]);
        // dd($company_invoices);
    }
}else{
    if (isset($request->start) && isset($request->end)) {
        // dd($request->all());
        $from = $request->start;
        $to = $request->end;
        $company_invoices= \DB::table('company_invoices');
        
        $user->whereBetween('created_at', [$from, $to]);
        $userConfirmed->whereBetween('created_at', [$from, $to]);
        $totalCompany->whereBetween('created_at', [$from, $to]);
        $userInactive->whereBetween('created_at', [$from, $to]);
        ($invoiceAmount == null) ? 0 : $invoiceAmount->whereBetween('due_date', [$from, $to])->where('deleted_at',NULL);
        $totalInvoice->whereBetween('due_date', [$from, $to]);
        ($invoiceSent == null) ? 0 : $invoiceSent->whereBetween('due_date', [$from, $to]);
        ($invoicePaid == null) ? 0 : $invoicePaid->whereBetween('due_date', [$from, $to]);
        $paymentAmount->whereBetween('created_at', [$from, $to]);
        $totalPayment->whereBetween('created_at', [$from, $to]);
        $company_invoices->whereBetween('created_at', [$from, $to]);
    }

}
                // dd('hello');
 
if(!isSuperAdmin()){
    
    // dd($user_id);

    // $company_user = User::with('roles')->whereHas('roles')
    // ->join('company_settings', 'company_settings.user_id', '=', 'users.id')
    // ->where('users.id','=',$user_id)
    // ->count();
    if (isset($company_id->id)) {
        $company_user = \DB::table('company_users')->where('company_id', '=', $company_id->id)
    ->count();
    }
    else{
        $company_user = \DB::table('company_users')->where('user_id', '=', $user_id);
        
        // dd($company_user);
    }
    // dd($company_user);
}else{
    // dd('je');
    $company_user = User::all()->count();
    // dd('je');

}
                // dd('hello');


                                    // dd($company_id->id);
                                    // dd($company_invoices->count());

// dd(count($cpUsers));

                                    if(isAdmin()){
                                        // dd('hello');
                                        // $cpUsers = DB::table('users')
                                        // ->join('company_users as cu', 'users.id', '=', 'cu.user_id')
                                        // ->where('cu.company_id', '=', $company_id->id)->get()->toArray();
                                //  dd($filter_inv_sent);       
                                        $counts = [
        'users' => $company_user,  
        'users_unconfirmed' => $userConfirmed->count(),
        'total_company' => $totalCompany->count(),
        'users_inactive' => $userInactive->count(),
        'invoice_sent' => (isSet($filter_inv_sent)) ? count($filter_inv_sent) : 0,
        // 'invoice_sent' => ($invoiceSent == null) ? 0 : $invoiceSent->count(),
        'invoice_paid' => ($invoicePaid == null) ? 0 : $invoicePaid->count(),
        'protected_pages' => 0,
        // Added By MD Abu Ahsan Basir
        'paymemts_amounts' => $paymentAmount->sum('payment_amount'),
        'total_paymemts' => $totalPayment->count(),
        'invoice_amounts' => (isSet($sum )) ? $sum : 0,
        // 'total_invoices' =>  $totalInvoice->count(),
        'total_invoices' =>  22,//$company_invoices->count(),

    ];

}else{
    // dd($invoiceAmount);
	  $counts = [
        'users' => $user->count(),  
        'users_unconfirmed' => $userConfirmed->count(),
        'total_company' => $totalCompany->count(),
        'users_inactive' => $userInactive->count(),
        // 'invoice_sent' => ($invoiceSent == null) ? 0 : $company_invoices->count(),
        'invoice_sent' => ($invoiceSent == null) ? 0 : $invoiceSent->count(),
        'invoice_paid' => ($invoicePaid == null) ? 0 : $invoicePaid->count(),
        'protected_pages' => 0,
        // Added By MD Abu Ahsan Basir
        'paymemts_amounts' => $paymentAmount->sum('payment_amount'),
        'total_paymemts' => $totalPayment->count(),
        'invoice_amounts' => 0,//($invoiceAmount == null  ) ? 0 : ($invoiceAmount->count() > 1 ? $invoiceAmount->sum('amount') : $invoiceAmount[0]->amount),//(($invoiceAmount == null  ) ? 0 : (count($invoiceAmount) > 1) )? $invoiceAmount->sum('amount') : $invoiceAmount[0]->amount,
        'total_invoices' =>  $totalInvoice->count(),
        // 'total_invoices' =>  $company_invoices->count(),

    ];
    

}
            //                dd($counts);

             // dd($invoiceAmount->sum('amount'));

//             $company_user = User::with('roles')->whereHas('roles')
//                                     ->join('company_settings', 'company_settings.user_id', '=', 'users.id')
//                                     ->where('users.id','=',$user_id)
//                                     ->count();

// $admin_user = \DB::table('company_settings')->join('company_users', 'company_users.company_id', '=', 'company_settings.id')->where('company_settings.user_id','=',$user_id)->count();
//             foreach (\Route::getRoutes() as $route) {
//                 foreach ($route->middleware() as $middleware) {
//                     if (preg_match("/protection/", $middleware, $matches)) $counts['protected_pages']++;
//                 }
//             }
$admin_user = 'na';
            return view('admin.dashboard', compact('company_user', 'counts','admin_user'));
        }
    }


    public function getLogChartData(Request $request)
    {
        \Validator::make($request->all(), [
            'start' => 'required|date|before_or_equal:now',
            'end' => 'required|date|after_or_equal:start',
        ])->validate();

        $start = new Carbon($request->get('start'));
        $end = new Carbon($request->get('end'));

        $dates = collect(\LogViewer::dates())->filter(function ($value, $key) use ($start, $end) {
            $value = new Carbon($value);
            return $value->timestamp >= $start->timestamp && $value->timestamp <= $end->timestamp;
        });


        $levels = \LogViewer::levels();

        $data = [];

        while ($start->diffInDays($end, false) >= 0) {

            foreach ($levels as $level) {
                $data[$level][$start->format('Y-m-d')] = 0;
            }

            if ($dates->contains($start->format('Y-m-d'))) {
                /** @var  $log Log */
                $logs = \LogViewer::get($start->format('Y-m-d'));

                /** @var  $log LogEntry */
                foreach ($logs->entries() as $log) {
                    $data[$log->level][$log->datetime->format($start->format('Y-m-d'))] += 1;
                }
            }

            $start->addDay();
        }

        return response($data);
    }

    public function getRegistrationChartData()
    {

        $data = [
            'registration_form' => User::whereDoesntHave('providers')->count(),
            'google' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'google');
            })->count(),
            'facebook' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'facebook');
            })->count(),
            'twitter' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'twitter');
            })->count(),
        ];

        return response($data);
    }
}
