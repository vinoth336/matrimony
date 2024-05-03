<?php

namespace App\Http\Controllers\Members;

use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberLoginRequest;
use Illuminate\Support\Facades\Redirect;

class MemberLoginController extends Controller
{

    public function showLoginForm()
    {
        if (auth()->guard('member')->check()) {
            return Redirect::to('dashboard');
        }
        return view('public.login');
    }


    public function login(MemberLoginRequest $request)
    {
        if (Auth::guard('member')->attempt($request->only('username', 'password'), 1)) {
            //Authentication passed...
            if ($request->input('redirectTo')) {
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

    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'username' => 'required|username|exists:members,username',
            'password' => 'required|string|min:4|max:255',
        ];

        //validate the request.
        $request->validate($rules);
    }

    public function showVerifyPhoneNumberForm(Request $request)
    {
        $member = auth()->user();
        if ($member->phone_number_verified_at) {

            if ($request->input('redirectTo')) {
                $url = route('member.profile') . "?successNavigation=dashboard";

                return redirect()
                    ->to($url)
                    ->with('status', 'You are Logged in Successfully');
            }
            return redirect()
                ->intended(route('member.dashboard'))
                ->with('status', 'You are Logged in Successfully');
        }

        $otp = Otp::where('phone_number', $member->phone_no)->first();
        if (!$otp || ($otp && $otp->expires_at <= now())) {
            Otp::sendSMS($member->phone_no, $this->generateOtp($member->phone_no));
        }

        return view('public.user.verify_phone_number', ['member' => $member]);
    }

    public function resendPhoneNumberOtp(Request $request)
    {
        $member = auth()->user();

        Otp::sendSMS($member->phone_no, $this->generateOtp($member->phone_no));

        return \redirect()->to(route("phone_number.verify"))->with(
            ['message' => 'OTP Re-Send Successfully']
        );
    }

    public function verifyPhoneNumber(Request $request)
    {
        $member = auth()->user();
        $otp = Otp::where('phone_number', $member->phone_no)->first();
        if (!$otp || $otp->otp !== $request->get('otp') || $otp->expires_at < now()) {

            return redirect()->to(route('phone_number.verify'))
                ->withErrors(["message" => $otp->expires_at < now() ? "OTP was expired" : "Otp Is Not Valid"]);
        } else {
            $member->phone_number_verified_at = now();
            $member->save();
            $otp->delete();

            return redirect()->to(route('member.dashboard'))->with("message", "Phone Number Verified");
        }
    }

    public function generateOtp($phoneNumber)
    {
        // Generate OTP
        $otpNumber = mt_rand(1000, 9999);
        $otpModel = Otp::updateOrCreate(
            [
                'phone_number' => $phoneNumber
            ],

            [
                'phone_number' => $phoneNumber,
                'otp' => $otpNumber,
                'expires_at' => now()->addMinutes(5)
            ]
        );

        return $otpNumber;
    }
}
