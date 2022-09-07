<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     public function showLoginForm() //customer login form -----
    {
        $setting=Setting::first();
        return view('auth.customer-login',['url' => '','setting'=>$setting]);
    }

    public function showStaffLoginForm()
    {
        return view('auth.metroniclogin', ['url' => '/staff']);
    }

    public function showAdminLoginForm()
    {
        $company=\App\Models\Setting::first()->value('company_name');
        return view('auth.metroniclogin', ['url' => '/admin','company'=>$company]);
    }


    public function staffLogin(Request $request) // staff login ---------
    {
//        $this->validate($request, [
//            'mobile'   => 'required|max:50',
//            'password' => 'required|min:8'
//        ]);
//
//        if (Auth::guard('vehicle_staff')->attempt(['mobile' => $request->username, 'password' => $request->password], $request->get('remember'))) {
//
//            return redirect()->intended('/staff');
//        }
//        return back()->withInput($request->only('mobile', 'remember'));
    }



    public function adminLogin(Request $request) // admin login ---------
    {

        $this->validate($request, [
            'mobile'   => 'required|max:50',
            'password' => 'required|min:8'
        ]);



        $logInField='email'; // Check user login with email or mobile
        if (!filter_var($request->mobile, FILTER_VALIDATE_EMAIL)) {
            $logInField='mobile';
        }
;

        if (Auth::attempt(
            [
            $logInField => $request->mobile,
            'password' => $request->password
            ], $request->get('remember')
            )) {

            if(\Auth::user()->roles[0]->name=='general-customer')
            {
                \Auth::logout();
                return redirect('/login')->with('error','As a customer please login here');
            }

            if(\Auth::user()->roles[0]->name=='delivery_system')
            {
                return redirect('/order-delivery/dashboard');
            }

            return redirect()->intended('/admin/home');
        }

        return redirect()->back()->with('error','Your credential does not match to our record ! ');
    }


    public function username()
    {
        $loginType = request()->input('mobile');
        $this->mobile = filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        request()->merge([$this->mobile => $loginType]);
        return property_exists($this, 'mobile') ? $this->mobile : 'email';
    }

}
