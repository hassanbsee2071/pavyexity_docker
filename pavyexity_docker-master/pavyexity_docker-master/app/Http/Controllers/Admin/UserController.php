<?php

namespace App\Http\Controllers\Admin;

use App\Module;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Access\User\EloquentUserRepository;
use Validator;
use Illuminate\Support\Facades\Auth;
Use DataTables;
use Illuminate\Support\Str;
use Mail;
use App\Mail\UserAccountCreatedMail;

class UserController extends Controller {

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
        $this->repository = new EloquentUserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $auth_user  = Auth::user();
        $company_id = 0;
        if (!empty($auth_user)) {
                if($request->ajax()){
                $user_id = $auth_user->id;
                $query   = User::select('users.*')->with('roles')->whereHas('roles', function ($query) {
                            $query->where('roles.name', '!=', 'Super User');
                        });
                        // })->sortable(['email' => 'asc']);
                $user_role_id = $auth_user['roles'][0]->id;
                if ($user_role_id == 1) { // Super User
                    
                }
                else if ($user_role_id == 2) { // Admin User
                    $allcompanies = \App\CompanySetting::get();
                        $companyusers=0;
                        $companyid= 0;
                        foreach( $allcompanies as $u){
                        
                            $decoded = json_decode($u->user_id);
                            if(in_array($auth_user->id, $decoded)){
                            $companyusers=1;
                            $companyid= $u->id;
                            $companyname=$u->company_name;
                            
                            }
                        }
                       
                    //$companyid = \App\CompanySetting::getAdminCompanyId(['user_id' => $user_id]);
                    if (!empty($companyid)) {
                        $query->join('company_users as cu', 'users.id', '=', 'cu.user_id')
                                ->where('cu.company_id', '=', $companyid);
                    }
                    else {
                        $query->whereRaw("1=2");
                    }
                }
                return Datatables::of($query)
                ->addIndexColumn()
                
                ->addColumn('action', function($row) use($user_role_id){
                    $edtURL = url('admin/users/'.$row->id.'/edit');
                    $delURL = url('admin/users/'.$row->id.'/destroy');
                    $actionBtn = '<a href="'.$edtURL.'" class="edit btn btn-success btn-sm">Edit</a>';
                    // if (!$user_role_id == 1){
                        $actionBtn = $actionBtn.'<a href="'.$delURL.'" class="delete btn btn-danger btn-sm" onclick=\'return check()\'>Delete</a>';
                    // }

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }else{
                return view('admin.users.index');
            }
        }

    }


    /**
     * Restore Users
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request) {
        return view('admin.users.restore', ['users' => User::onlyTrashed()->with('roles')->sortable(['email' => 'asc'])->paginate()]);
    }

    /**
     * Restore Users
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restoreUser($id) {
        $status = $this->repository->restore($id);

        if ($status) {
            return redirect()->route('admin.users')->withFlashSuccess('User Restored Successfully!');
        }

        return redirect()->route('admin.users')->withFlashDanger('Unable to Restore User!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $return_arr = array();

        return view('admin.users.add',  [
            'roles' => Role::all(),
            'modules' => Module::Where('name', '!=' ,'Dashboard')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator           = Validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'last_name'  => 'required|max:255',
                    'email'      => 'required|email|max:255|unique:users',
                    'phone'      => 'required',
                    'password'   => 'required'
//            'active' => 'sometimes|boolean',
//            'confirmed' => 'sometimes|boolean',
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
        $login_user          = Auth::user();
        $userObj             = new User();
        $userObj->first_name = $request->first_name;
        $userObj->last_name  = $request->last_name;
        $userObj->email      = $request->email;
        $userObj->phone      = $request->phone;
        $userObj->password   = bcrypt($request->password);
        $userObj->save();

        if (isSuperAdmin()) {
            // $roles = Role::whereIn('name', ['Admin User', 'authenticated'])->get();
            $userObj->roles()->attach($request->roles);
            $userObj->modules()->attach($request->modules);

            $log_data= array(
                'user_id' => auth()->user()->id,
                'logtype' => 'store user',
                'action' => 'User inserted successfully',
            );
            $logs = \LogActivity::addToLog($log_data);


            

            return redirect()->route('admin.users')->withFlashSuccess('User Added Successfully!');
        }
        else if (isAdmin()) {
            $roles = Role::whereIn('name', ['User', 'authenticated'])->get();
            $userObj->roles()->attach($roles);
            $userObj->modules()->attach($request->modules);
            $allcompanies = \App\CompanySetting::get();
              $companyusers=0;
              $companyid= 0;
              foreach( $allcompanies as $u){
              
                $decoded = json_decode($u->user_id);
                if(in_array($login_user->id, $decoded)){
                  $companyusers=1;
                  $company_id= $u->id;
                }
            }
            // $user_company = \App\CompanySetting::where('user_id', '=', $login_user->id)->first();
            
            // if (!empty($user_company)) {
                //$company_id = $user_company->id;
            // }
            $compUserObj             = new \App\CompanyUser();
            $compUserObj->user_id    = $userObj->id;
            $compUserObj->company_id = $company_id;
            $compUserObj->save();
            //logs
            $log_data= array(
                'user_id' => auth()->user()->id,
                'logtype' => 'store user',
                'action' => 'User inserted successfully',
            );
            $logs = \LogActivity::addToLog($log_data);

            $data['email'] = $request->email;
            $data['user']  = $request->first_name;
            $data['sender']  = auth()->user()->email;
            $data['link']  =route('login');
            $data['password']  = $request->password;

            $mail = $request->email;
            Mail::to($mail)->send(new UserAccountCreatedMail($data));
            return redirect()->route('admin.users')->withFlashSuccess('User Added Successfully!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user) {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
//        echo "<pre>";
//        print_r($user);
//        echo "</pre>";
//        exit;
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'modules' => Module::Where('name', '!=', 'Dashboard')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, User $user) {
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'last_name'  => 'required|max:255',
                    'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
                    'phone'      => 'required',
                    'active'     => 'sometimes|boolean',
        ]);
        $validator->sometimes('password', 'min:6', function ($input) {
            return $input->password;
        });
        $validator->sometimes('roles', 'required', function ($input) {
            return $input->roles;
        });
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();

//        $validator = Validator::make($request->all(), [
//                    'name'      => 'required|max:255',
//                    'email'     => 'required|email|max:255',
//                    'active'    => 'sometimes|boolean',
//                    'confirmed' => 'sometimes|boolean',
//        ]);
//        $validator->sometimes('email', 'unique:users', function ($input) use ($user) {
//            return strtolower($input->email) != strtolower($user->email);
//        });
//        if ($validator->fails())
//            return redirect()->back()->withErrors($validator->errors());

        $user->first_name = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
        $user->email      = $request->get('email');
        $user->phone      = $request->get('phone');

        if (! $request->input('password') == '') {
            $user->password = bcrypt($request->get('password'));
        }
        $user->active = $request->get('active', 0);
//        $user->confirmed = $request->get('confirmed', 0);

        $user->save();
        // Attach roels
        if (! $request->get('roles') == '') {
            $user->roles()->sync($request->get('roles'));
        }
        // Attach Modules
        $user->modules()->sync($request->get('modules'));
        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'update user',
            'action' => 'User edited successfully',
        );
        $logs = \LogActivity::addToLog($log_data);

        //roles
//        if ($request->has('roles')) {
//            $user->roles()->detach();
//
//            if ($request->get('roles')) {
//                $user->roles()->attach($request->get('roles'));
//            }
//        }

        return redirect()->intended(route('admin.users'))->withFlashSuccess('User Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $status = $this->repository->destroy($id);

        if ($status) {
            //logs
            $log_data= array(
                'user_id' => auth()->user()->id,
                'logtype' => 'destroy user',
                'action' => 'User deleted successfully',
            );
            $logs = \LogActivity::addToLog($log_data);

            return redirect()->route('admin.users')->withFlashSuccess('User Deleted Successfully!');
        }

        return redirect()->route('admin.users')->withFlashDanger('Unable to Delete User!');
    }

}
