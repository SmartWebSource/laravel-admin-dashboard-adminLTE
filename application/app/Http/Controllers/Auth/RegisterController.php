<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use \Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;
use Carbon;

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
    protected $redirectTo = '/dashboard';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request){

        $recaptcha = new ReCaptcha ( env('RECAPTCHA_SECRET') );
        $resp = $recaptcha->verify ( $request->input ( 'g-recaptcha-response' ), $_SERVER ['REMOTE_ADDR'] );
        if (!$resp->isSuccess ()) {
            return redirect()->back()->withErrors(['g-recaptcha-response'=>'Recaptcha is required.'])->withInput($request->all());
        }

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:16|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:13|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }else{
            $phone = $request->phone_operator.$request->phone;
            if(User::wherePhone($phone)->count() > 0){
                return redirect()->back()->withErrors(['phone'=>'Phone already exists.'])->withInput($request->all());
            }
        }

        $phone = $request->phone_operator.$request->phone;

        $user = new User();
        $user->name = trim($request->name);
        $user->username = trim($request->username);
        $user->email = trim($request->email);
        $user->phone = $phone;
        $user->password = bcrypt($request->password);
        $user->role = 'admin';

        if($user->save()){

            try{

                //encode    
                $iat = Carbon::now()->timestamp;

                $exp = $iat+3600;

                $token = [
                    "resource" => $user->id,
                    "iss" => env('APP_HOST'),
                    "iat" => $iat,
                    "exp" => $exp
                ];

                $jwtToken = \Firebase\JWT\JWT::encode($token, env('JWT_SECRET'));

                $data = [
                    'blade' => 'new-registration',
                    'body'  =>  [
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => trim($request->password),
                        'token'  => $jwtToken,
                    ],
                    'toUser'    =>  trim($request->email),
                    'toUserName'    =>  $user->name,
                    'subject'   =>  env('APP_NAME') . ' New Account Confirmation!',
                ];

                \App\Helpers\Classes\EmailSender::send($data);

                $message = message('success','info-circle', 'An activation link has been sent to your email.');
                session()->flash('flash-message',$message);
                return redirect('login');

            }catch(\Exception $e){
                notify2Slack('exception', $e);
                return redirect()->back()->withErrors(['status'=>'Error.'])->withInput($request->all());
            }            
        }else{
            return redirect()->back()->withErrors(['status'=>'Error.'])->withInput($request->all());
        }
    }
}
