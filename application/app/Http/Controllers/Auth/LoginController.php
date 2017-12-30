<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use \Illuminate\Http\Request;
use Auth, Carbon, Validator;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        if($request->isMethod('post')){
            $rules = [
                'email' => 'required|string',
                'password' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            //process login
            if (Auth::attempt(['email' => trim($request->email), 'password' => $request->password], $request->remember)) {

                $user = Auth::user();

                if(!$user->active){
                    Auth::logout();
                    $message = message('danger','info-circle', 'Your account is not active yet.');
                    session()->flash('flash-message',$message);
                    return redirect()->back()->withInput($request->all());
                }

                session()->put([
                    'name' => $user->name,
                    'role' => $user->role,
                    'last_login' => Carbon::parse($user->last_login)->format('d M, Y @ h:i:s A'),
                ]);

                $user->last_login = Carbon::now();
                $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
                $user->save();

                return redirect('dashboard');
            }else{
                $message = message('danger','info-circle', 'Invalid email or password.');
                session()->flash('flash-message',$message);
                return redirect()->back()->withInput($request->all());
            }

        }else{
            return view('auth.login');
        }
    }

    public function logout(Request $request){
        
        Auth::logout();
        $request->session()->invalidate();
        return redirect('login');
    }
}
