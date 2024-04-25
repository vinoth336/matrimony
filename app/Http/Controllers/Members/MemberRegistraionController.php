<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRegistrationSaveRequest;
use App\Mail\SendRegistrationEmailVerification;
use App\Models\Member;
use App\Models\MemberHoroscope;
use App\Models\MemberLocation;
use App\Models\MemberRegistrationRequest;
use App\Models\RepresentBy;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class MemberRegistraionController extends Controller
{


    public function save(MemberRegistrationSaveRequest $request)
    {

        DB::beginTransaction();

        try {

            $memberRegistrationRequest = MemberRegistrationRequest::create([
                'represent_by_id' => null ,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'dob' => $request->input('dob'),
                'blood_id' => $request->input('blood') ?? null,
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'mother_tongue_id' => $request->input('mother_tongue'),
                'email' => $request->input('email'),
                'phone_no' => $request->input('phone_no'),
                'username' => $request->input('phone_no'),
                'password' => Hash::make($request->input('password')),
                'email_verified_at' => null,
                'phone_number_verified_at' => null,

            ]);

            $member = Member::create([
                'represent_by_id' => $memberRegistrationRequest->represent_by_id,
                'first_name' => $memberRegistrationRequest->first_name,
                'last_name' => $memberRegistrationRequest->last_name,
                'dob' => $memberRegistrationRequest->dob,
                'blood_id' => $memberRegistrationRequest->blood_id ?? null,
                'gender' => $memberRegistrationRequest->gender,
                'religion' => $memberRegistrationRequest->religion,
                'mother_tongue_id' => $memberRegistrationRequest->mother_tongue_id,
                'email' => $memberRegistrationRequest->email,
                'phone_no' => $memberRegistrationRequest->phone_no,
                'username' => $memberRegistrationRequest->phone_no,
                'password' => $memberRegistrationRequest->password,
                'member_code' => generateMemberCodeNumber(),
                'phone_number_verified_at' => null,
                'horoscope_lock' => VISIBLE_TO_ALL,
                'email_verified_at' => null,
            ]);

            $memberHoroscope = $member->horoscope ?? new MemberHoroscope();
            $memberHoroscope->member_id = $member->id;
            $memberHoroscope->rasi_id = $request->input('rasi');
            $memberHoroscope->star_id = $request->input('star');
            $memberHoroscope->save();

            $location = $member->location ?? new MemberLocation();
            $location->member_id = $member->id;
            $location->city_id = $request->input('city');
            $location->state_id = $request->input('state');
            $location->pincode = $request->input('pincode');
            $location->save();

            if ($request->input('dhosam')) {
                $member->doshams()->sync($request->input('dhosam'));
            }
            $member->save();

            //$this->sendVerificationEmail($member);
            DB::commit();


            return redirect()->route('public.login')
                ->with("message", "Registered Successfully");

           /* return redirect()->route('public.registration_success', encrypt($memberRegistrationRequest->id))
            ->with(['status' => 'Registered Successfully, Please check your mail for the next process']);*/

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in MemberRegistraionController@save - ' . $e->getMessage());

            echo 'Cant process';

           // return redirect()->route('public.index')->with(['status' => 'Can\'t Process Request, Please Try Again']);
        }

        exit;
    }

    public function registerationSuccess(Request $request, $hash)
    {
        try
        {
            $id = decrypt($hash);
            $memberRegistrationRequest = MemberRegistrationRequest::findOrFail($id);
            $url = route('public.verify_email', $hash);

            if($memberRegistrationRequest->is_verified) {
                return redirect()->route('public.login')->with('status', 'Email Verified Successfully, Please login to continue the process');
            }

            return view('users.verify_email')
            ->with(['hash' => $hash]);

        } catch (ModelNotFoundException $e) {

            return abort(404);
        } catch (Exception $e) {

            Log::error('Error Occurred in MemberRegistraionController@registerationSuccess - ' . $e->getMessage());
            return abort(500);
        }

    }

    public function resendEmailVerification(Request $request)
    {
        try{
            $hash = $request->input('hash');
            $id = decrypt($hash);
            $memberRegistrationRequest = MemberRegistrationRequest::findOrFail($id);

            if($memberRegistrationRequest->is_verified) {
                return redirect()->route('public.login')->with('status', 'Email Verified Successfully, Please login to continue the process');
            }

            $this->sendVerificationEmail($memberRegistrationRequest);

            return redirect()->route('public.registration_success', $hash)
            ->with([
                'status' => 'Registered Successfully, Please check your mail for the next process',
                'hash' => $hash,
                'resent' => true
            ]);

        } catch (ModelNotFoundException $e) {
            return abort(404);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberRegistraionController@resendEmailVerification - ' . $e->getMessage());
            return abort(500);
        }

    }

    public function verifyEmail(Request $request, $hash)
    {
        DB::beginTransaction();
        try{
            $id = decrypt($hash);
            $member = Member::findOrFail($id);

            if(!$member->email_verified_at) {
                $member->email_verified_at = true;
                $member->save();

                DB::commit();

            } else {
                return view('users.verified');
            }
            $url = route('public.login') . "?redirectTo=profile&successNavigation=dashboard" ;

            return redirect()->to($url)
            ->with('status', 'Email Verified Successfully, Please login to continue the process');
        } catch (ModelNotFoundException $e) {
            return abort(404);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberRegistraionController@verifyEmail - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function setDateAttribute( $value ) {
        $this->attributes['date'] = (new Carbon($value))->format('d-m-Y');
    }

    public function sendVerificationEmail($member)
    {
        if ($member->email) {
            return Mail::send(new SendRegistrationEmailVerification($member));
        }
    }
}
