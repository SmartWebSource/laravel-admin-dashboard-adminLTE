<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;

class AccountActivationController extends Controller
{
    public function active(Request $request){

        if(empty($request->token)){
            $message = message('danger','info-circle', 'Account Activation: Invalid Request.');
            session()->flash('flash-message',$message);
            return redirect('login');
        }

        try {
            $data = \Firebase\JWT\JWT::decode($request->token, env('JWT_SECRET'), ['HS256']);

            if(empty($data->resource)){
                $message = message('danger','info-circle', 'Account Activation: Invalid Request.');
                session()->flash('flash-message',$message);
                return redirect('login');
            }

            if(User::whereId($data->resource)->whereActive(true)->count() > 0){
                $message = message('danger','info-circle', 'Account Activation: Your account already active, login using your email and password.');
                session()->flash('flash-message',$message);
                return redirect('login');
            }

            if(Auth::loginUsingId($data->resource)){

                User::whereId($data->resource)->update(['active'=>true]);
                
                User::setLoginSession();

                return redirect('home');
            }else{
                $message = message('danger','info-circle', 'Account Activation: Invalid Request.');
                session()->flash('flash-message',$message);
                return redirect('login');
            }

        } catch (\Firebase\JWT\ExpiredException $e) {
            $message = message('danger','info-circle', 'Account Activation: Invalid Request.');
            session()->flash('flash-message',$message);
            return redirect('login');
        } catch (\Exception $e) {
            $message = message('danger','info-circle', 'Account Activation: Invalid Request.');
            session()->flash('flash-message',$message);
            return redirect('login');
        }
    }
}
