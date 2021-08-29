<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\PaymentDetails;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectTo()
    {
        if(Auth::user()->hasRole('Super User'))
        {
            $this->redirectTo = route('dashboard');

            return $this->redirectTo;
        }
        elseif(Auth::user()->hasRole('Admin User'))
        {
            $this->redirectTo = route('dashboard');

            return $this->redirectTo;
        }

        elseif(Auth::user()->hasRole('User'))
        {
            $this->redirectTo = route('dashboard');

            return $this->redirectTo;
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function showLoginForm(Request $request)
    {
      $urlPrevious = url()->previous();
      $urlBase = url()->to('/');
      // $decrypt = explode('+++',Crypt::decryptString(explode('payment/',$urlPrevious)[1]));
      // Session::put('email',$decrypt[0]);
      // Session::put('payment_type',$decrypt[1]);
      // Session::put('transaction_id',$decrypt[2]);
      // Session::put('company_id',$decrypt[3]);
        // Set the previous url that we came from to redirect to after successful login but only if is internal
      if (($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
        session()->put('url.intended', $urlPrevious);
      }
        // dd(Session::all());
      return view('auth.login');
    }


    public function login(Request $request)
    {
      $this->validateLogin($request);
      // dd(Session::all());

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
      if (
        method_exists($this, 'hasTooManyLoginAttempts') &&
        $this->hasTooManyLoginAttempts($request)
      ) {
        $this->fireLockoutEvent($request);

        return $this->sendLockoutResponse($request);
      }

      if ($this->attemptLogin($request)) {
        return $this->sendLoginResponse($request);
      }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
      $this->incrementLoginAttempts($request);

      return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {

      $request->session()->regenerate();

      $this->clearLoginAttempts($request);

      if ($response = $this->authenticated($request, $this->guard()->user())) {
        return $response;
      }

      return $request->wantsJson()
      ? new JsonResponse([], 204)
      : redirect('/admin');
    }

    public function logout(Request $request)
    {
      $this->guard()->logout();

        /*
         * Remove the socialite session variable if exists
         */

        \Session::forget(config('access.socialite_session_name'));

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
      }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
      $errors = [$this->username() => __('auth.failed')];

      if ($request->expectsJson()) {
        return response()->json($errors, 422);
      }

      return redirect()->back()
      ->withInput($request->only($this->username(), 'remember'))
      ->withErrors($errors);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
      $errors = [];

      if (config('auth.users.confirm_email') && !$user->confirmed) {
        $errors = [$this->username() => __('auth.notconfirmed', ['url' => route('confirm.send', [$user->email])])];
      }

      if (!$user->active) {
        $errors = [$this->username() => __('auth.active')];
      }

      if ($errors) {
            auth()->logout();  //logout

            return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
          }

          $user->last_login = now();
          $user->save();
          if (!empty($user->id) && isAdmin()) {


         
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

            //$user_company = \App\CompanySetting::where('user_id', '=', $user->id)->first();
            if ($companyid!=0) {
              Session::put('admin_company_id', $companyid);
            } else {
                auth()->logout();  //logout
                $errors = "Not any company associated with this user";
                return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
              }
            }elseif(!isSuperAdmin()){
              if (base64_decode($request->isPaymentLink) != "_") {
                $paymentmethod = explode("_", base64_decode($request->isPaymentLink));
                $data = array(
                  "email" => $request->email,
                  "payment_type" => $paymentmethod[0],
                  "transaction_id" => $paymentmethod[1],
                );
                return redirect('payment-method')->with($data);
              } else {
                $get_paymnent_method = PaymentDetails::where('email', $request->email)->get()->count();
                if ($get_paymnent_method == 0) {
                  $data = array(
                    "email" => $request->email,
                  );
                  return redirect('payment-method')->with($data);
                }   
              }
            }
            return redirect()->intended($this->redirectPath());
          }
        }
