<?php

namespace App\Http\Controllers\Members;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberLoginRequest;
use Illuminate\Support\Facades\Redirect;

class MemberLoginController extends Controller
{

    public function showLoginForm()
    {
        if(auth()->guard('member')->check()) {
            return Redirect::to('dashboard');
        }
        return view('public.login');
    }


    public function login(MemberLoginRequest $request)
    {
        if (Auth::guard('member')->attempt($request->only('username', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            if($request->input('redirectTo')) {
                $url = route('member.profile') . "?successNavigation=dashboard";

                return redirect()
                 ->to($url)
                 ->with('status', 'You are Logged in Successfully');
            }
            return redirect()
                 ->intended(route('member.dashboard'))
                 ->with('status', 'You are Logged in Successfully');
        }

        //Authentication failed...
        return $this->loginFailed();
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        return redirect()
            ->route('public.index');
    }

    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'username'    => 'required|username|exists:members,username',
            'password' => 'required|string|min:4|max:255',
        ];

        //validate the request.
        $request->validate($rules);
    }
}
