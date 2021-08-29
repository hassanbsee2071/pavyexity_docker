<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\CompanySetting;
use Illuminate\Http\Request;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use App\Models\Auth\User\User;
use DB;
Use DataTables;
use Mail;
use App\Mail\CompanyAccountCreatedMail;

class CompanySettingController extends Controller {
    
    public function index(Request $request) {

    
        
        if($request->ajax()){
            $get_data = CompanySetting::get();
          //dd($get_data);

            //$get_data = CompanySetting::select(DB::raw('CONCAT(u.first_name," ",u.last_name) AS company_admin'), 'company_settings.*');
            return Datatables::of($get_data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $editCompany = url('admin/company/'.$row->id);
                    $delCompany = url('admin/company/'.$row->id.'/delete');
                    $actionBtn = '<a href="'.$editCompany.'" class="edit btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>';
                    // if (!$user_role_id == 1){
                        $actionBtn = $actionBtn.'<a href="'.$delCompany.'" class="delete btn btn-danger btn-sm" onclick=\'return check()\'><i class="fa fa-trash"></i></a>';
                    // }
                    return $actionBtn;
            })
            ->addColumn('company_admin', function($row){
                $someagain =''; 
                    $decoded = json_decode($row->user_id);
                    $some = '';
                    foreach( $decoded as $decod){
                        $user = User::where('id', $decod)->first(); 
                        if($user){
                            $some = $some.$user->first_name." ".$user->last_name.",";
                        }
                       
                    }
                  $someagain= $some;
                return $someagain;
        })

            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.company.index');
    }

    public function edit($id) {
        $user               = Auth::user();
        $return_arr         = array();
        $return_arr['user'] = $user;
        if (isAdmin()) {

            // $company = CompanySetting::where('user_id', '=', $user->id)->where('id', '=', $id)->first();
            $company = CompanySetting::find($id);

        }
        else if (isSuperAdmin()) {
            // dd('je');

            $company = CompanySetting::find($id);
            // dd('je');

        }
        if (empty($company)) {
            return redirect(url('/'))->withFlashWarning('Invalid access!');
        }

        $company_admin         = $company->user_id;
        $decoded_id = json_decode($company_admin);
// dd($decoded_id);
        
        
        $return_arr['company'] = $company;
        $return_arr['global_link_fix'] = route('paymentlink', ['id'=>\Crypt::encryptString($company->global_link . "@@" . 'GlobalPayment' . '@@' .$company->user_id)]);
        $return_arr['global_link'] = route('paymentlink', ['id'=>\Crypt::encryptString('global' . '@@' .'GlobalPayment' . '@@' .$company->user_id)]);
        if (isSuperAdmin()) {

            $company_data = getCompanyAdmins($decoded_id);
            // dd($company_data);
// dd('sds');


// $cc = CompanySetting::with('users')->get();
// dd($cc);                
// $company_data = User::select('users.*')
            //         ->with('roles')->whereHas('roles', function ($query) {
            //             $query->where('roles.name', '=', 'Admin User');
            //         })
            //         ->leftJoin('company_settings as cs', function($join) {
            //             $join->on('users.id', '=', 'cs.user_id');
            //             $join->whereNull('users.deleted_at');
            //         })
            //         ->where(function($where) use($company_admin) {
            //              $where->whereNull('cs.user_id');
            //             $where->orWhere('cs.user_id', $company_admin);
            //         })
            //         ->sortable(['name' => 'asc'])
            //         ->get();
// dd('sds');
          
                    $return_arr['company_data'] = $company_data;
            $return_arr['decoded_id'] = $decoded_id;
        }
        //dd($return_arr['company_data']);
        return view('admin.company.edit', $return_arr);
    }

    public function delete($id) {
        $t_id = CompanySetting::find($id);
        $t_id->delete();
        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'company delete',
            'action' => 'Company Deleted successfully',
        );
        $logs = \LogActivity::addToLog($log_data);
        return redirect()->route('admin.company')->withFlashSuccess('Company Deleted Successfully!');
    }

    public function update(request $request, $id) {
        
        if ( $request->input('global_link') == '') {
            $request->global_link = 0;

        }
        $validator = Validator::make($request->all(), [
                    'company_admin'   => 'required',
                    'email'           => 'required|email|max:255|unique:company_settings,email,' . $id,
                    'phone'           => 'required',
                    'company_name'    => 'required|max:255',
                    'city'      => 'required|max:255',
                    'state'       => 'required|max:255',
                    'zipcode'       => 'required|max:255',
                    'EIN'       => 'required|max:255',
                    'api_key'       => 'required|max:255',
                    'api_user'       => 'required|max:255',
                    'address'         => 'required|max:255',
                    'accept_payments' => 'required',
               
        ]);
        $validator->sometimes('api_password', 'min:6', function ($input) {
            return $input->api_password;
        });
        $validator->sometimes('global_link', 'required', function ($input) {
            return $input->global_link;
        });
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();

        //$company_admin         = (($request->filled('company_admin')) ? $request->company_admin : 0);
        $data = CompanySetting::find($id);

        if ($request->filled('company_admin')) {

            $data->user_id = json_encode($request->company_admin);
        }
        $data->email           = $request->email;
        $data->phone           = $request->phone;
        $data->company_name    = $request->company_name;
        $data->city      = $request->city;
        $data->state       = $request->state;
        $data->state       = $request->state;
        $data->zipcode       = $request->zipcode;
        $data->EIN       = $request->EIN;
        $data->api_endpoint       = $request->api_endpoint;
        $data->api_key       = $request->api_key;
        $data->api_user       = $request->api_user;
        $data->address         = $request->address;
        $data->accept_payments = $request->accept_payments;
        $data->global_link = $request->global_link;
        if (! $request->input('api_password') == '') {
            $data->api_password = $request->api_password;
        }
        $data->save();
        //dd($data);
        if (isAdmin()) {
            //logs
            $log_data= array(
                'user_id' => auth()->user()->id,
                'logtype' => 'company update',
                'action' => 'Company Updated successfully',
            );
            $logs = \LogActivity::addToLog($log_data);
            return redirect()->route('admin.company.edit', ['id' => $id])->withFlashSuccess('Company Updated Successfully!');
        }
        else {
            //logs
            $log_data= array(
                'user_id' => auth()->user()->id,
                'logtype' => 'company update',
                'action' => 'Company Updated successfully',
            );
            $logs = \LogActivity::addToLog($log_data);
            return redirect()->route('admin.company')->withFlashSuccess('Company Updated Successfully!');
        }
    }

    public function add() {
        // dd('id');

        $user               = Auth::user();
        $return_arr         = array();
        $return_arr['user'] = $user;
        if (isSuperAdmin()) {
            
            
    $users =        getFreeAdmins();
// dd($users);
            $company_data = User::select('users.*')
            
                    ->with('roles')->whereHas('roles', function ($query) {
                        $query->where('roles.name', '=', 'Admin User');
                    })
                    // ->leftJoin('company_settings as cs', function($join) {
                    //     $join->on('users.id', '=', 'cs.user_id');
                    //     $join->whereNull('users.deleted_at');
                    //     $join->whereNull('cs.deleted_at');
                    // })
                    // ->whereNull('cs.user_id')
                    // ->where('users.active','1')
                    // ->sortable(['name' => 'asc'])
                    ->get();
                    // dd($company_data);
            $return_arr['company_data'] = $users;
        }
        return view('admin.company.add', $return_arr);
    }

    public function save_company(request $request) {
        $validator = Validator::make($request->all(), [
                    'company_admin.*'   => 'required',
                    'email'           => 'required|email|max:255|unique:company_settings',
                    'phone'           => 'required',
                    'company_name'    => 'required|max:255',
                    'city'      => 'required|max:255',
                    'state'       => 'required|max:255',
                    'zipcode'       => 'required|max:255',
                    'EIN'       => 'required|max:255',
                    'api_key'       => 'required|max:255',
                    'api_user'       => 'required|max:255',
                    'address'         => 'required|max:255',
                    'accept_payments' => 'required',
                    'api_password'   => 'required|min:6',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
            // $jsndata = [
            //     'user_id' => $request->company_admin,
            // ];
            // //dd($jsndata);
            // $resultdata= [];
            // $resultdata['content'] = $jsndata;
            // $JSONdata = json_encode($resultdata);
            //dd($JSONdata);


       // $company_admin         = (($request->filled('company_admin')) ? $request->company_admin : 0);
        $data                  = new CompanySetting();
        $data->user_id         = json_encode($request->company_admin);
        $fata =   mb_convert_encoding($request->company_admin, 'UTF-8', 'UTF-8');
        $encoded= json_encode($fata);
        //dd($encoded);
        $data->email           = $request->email;
        $data->phone           = $request->phone;
        $data->company_name    = $request->company_name;
        $data->city      = $request->city;
        $data->state       = $request->state;
        $data->state       = $request->state;
        $data->zipcode       = $request->zipcode;
        $data->EIN       = $request->EIN;
        $data->api_endpoint       = $request->api_endpoint;
        $data->api_key       = $request->api_key;
        $data->api_user       = $request->api_user;
        $data->api_password       = $request->api_password;
        $data->address         = $request->address;
        $data->accept_payments = $request->accept_payments;

        $data->save();

        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'save company',
            'action' => 'Company Added Successfully',
        );
        $logs = \LogActivity::addToLog($log_data);
        
            foreach ($request->company_admin as $cp) {

                $user = User::find($cp);

                $data['name'] = $user->first_name;
                $data['root']  = auth()->user()->name;
                $data['email']  = $request->email;

                $mail = $request->email;


                Mail::to($mail)->send(new CompanyAccountCreatedMail($data));

                # code...
            }




        return redirect()->route('admin.company')->withFlashSuccess('Company Added Successfully!');
    }

}
