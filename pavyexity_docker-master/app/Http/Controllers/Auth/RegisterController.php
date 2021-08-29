<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\Role\Role;
use App\Notifications\Auth\ConfirmEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Auth\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'companyuser' => 'required'
        ];

        if (config('auth.captcha.registration')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    protected function create(array $data)
    {
        /** @var  $user User */
        $user = User::create([
            'name' => $data['first_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => false
        ]);

        $roles = Role::whereIn('name', ['User', 'authenticated'])->get();
        $user->roles()->attach($roles);
        $userid = base64_decode($data['companyuser']);
        $user_company = \App\CompanySetting::where('user_id', '=', $userid)->first();
        if (!empty($user_company)) {
            $company_id = $user_company->id;
        }
        $compUserObj             = new \App\CompanyUser();
        $compUserObj->user_id    = $user->id;

        $compUserObj->company_id = $company_id;
        
        $compUserObj->save();
        return $user;
    }
    public function showRegistrationForm($data)
    {

        $decrypt = explode('+++',Crypt::decryptString($data));
        $email = $decrypt[0];
        $paymentType = $decrypt[1];
        $transactionid = $decrypt[2];  
        $companyuserid = base64_encode($decrypt[3]);   
        Session::put('email',$decrypt[0]);
        Session::put('payment_type',$decrypt[1]);
        Session::put('transaction_id',$decrypt[2]);
        Session::put('company_id',$decrypt[3]);
        // dd($decrypt[3]); 
        $checkuser_exists = User::where('email', $email)->get()->count();
        if($checkuser_exists<1){
            return view('auth.register', compact('email','companyuserid','paymentType','transactionid'));    
        }else{
            $data = array(
                "email" => $email,
                "paymentType"=>$paymentType,
                "transactionid"=>$transactionid,
            );
            return redirect('login')->with($data);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if (config('auth.users.confirm_email') && !$user->confirmed) {

            $this->guard()->logout();

            $user->notify(new ConfirmEmail());

            return redirect(route('login'));
        }
    }
}
