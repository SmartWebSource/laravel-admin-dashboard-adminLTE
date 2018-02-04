<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,
    Carbon;
use App\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function profile(Request $request) {

        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:13',
            ];

            if (!empty($request->password) || !empty($request->password_confirmation)) {
                $rules['password'] = 'required|string|min:6|confirmed';
                $rules['password_confirmation'] = 'required|string|min:6';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            } else {
                $phone = $request->phone_operator . $request->phone;
                if (User::wherePhone($phone)->where('id', '!=', $request->user()->id)->count() > 0) {
                    return redirect()->back()->withErrors(['phone' => 'Phone already exists.'])->withInput($request->all());
                }
            }

            $phone = $request->phone_operator . $request->phone;

            $user = $request->user();
            $user->name = trim($request->name);
            $user->phone = $phone;
            $user->updated_at = Carbon::now();

            //IF password is set
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            $message = message('success', 'info-circle', 'Your profile has been successfully updated.');
            session()->flash('flash-message', $message);
        }

        $user = $request->user();
        return view('users.profile', compact('user'));
    }

}
