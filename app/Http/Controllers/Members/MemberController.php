<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilePhotoRequest;
use App\Models\Blood;
use App\Models\City;
use App\Models\Degree;
use App\Models\Dhosam;
use App\Models\EmployeeIn;
use App\Models\FamilyType;
use App\Models\MaritalStatus;
use App\Models\Member;
use App\Models\MemberViewedProfile;
use App\Models\Star;
use App\Models\State;
use App\Models\Zodiac;
use App\Traits\SaveMemberDetails;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    use SaveMemberDetails;

    protected $redirectTo = '/';

    public function __construct()
    {
    }

    public function dashboard(Request $request)
    {
        $member = auth()->user();
        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $this->getProfiles($request, $member)->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();

        return view('public.user.dashboard')
            ->with('profiles', $profiles)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('showShortListButton', true)
            ->with('showSendInterestButton', true)
            ->with('showIgnoreButton', true)
            ->with('employeeIns', $employeeIns)
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;

    }

    public function getProfiles(Request $request, $member)
    {
        $profiles = Member::whereNotIn('members.id', [$member->id])
            ->doesnthave('interest_sent_profiles')
            ->doesnthave('current_user_interest_received')
            ->where('gender', '!=', $member->gender)->with(['educations' => function ($model) {
                $model->with('degree');
            }, 'occupation', 'location', 'dhosam', 'marital_status', 'horoscope']);

        $profiles = $this->whereCondition($request, $profiles);
        $profiles->inRandomOrder();


        return $profiles;
    }

    public function whereCondition($request, $query)
    {

        $from_age = $request->input('from_age') ?? 20;
        $to_age = $request->input('to_age') ?? 25;
        $maritalStatus = $request->input('marital_status') ?? [1];
        $motherTongues = $request->input('mother_tongues') ?? [1];
        $dhosams = $request->input('dhosams') ?? [1];

        if($request->has('from_age') || $request->has('to_age')) {
            $to_age = $to_age + 1;
            $query->whereRaw('DATEDIFF(CURDATE(), dob)  / 365 >= ' . $from_age);
            $query->whereRaw('DATEDIFF(CURDATE(), dob)  / 365 < ' . $to_age);
        }

        if($request->has('rasies') || $request->has('stars')) {
            $query->join('member_horoscopes', function($join) {
                $join->on('member_horoscopes.member_id', '=', 'members.id');
            });
        }
        if($request->has('rasies')) {
            $query->whereIn('member_horoscopes.rasi_id', $request->input('rasies'));
        }

        if($request->has('stars')) {
            $query->whereIn('member_horoscopes.star_id', $request->input('stars'));
        }

        if($request->has('dhosams')) {
            $query->where('dhosam_id', $dhosams);
        }

        if($request->has('mother_tongues')) {
            $query->whereIn('mother_tongue_id', $motherTongues);
        }

        if($request->has('marital_status')) {
            $query->whereIn('marital_status_id', $maritalStatus);
        }

        return $query;

    }

    public function profile(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();

        return view('public.user.profile')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ->with('employeeIns', $employeeIns)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function viewProfile(Request $request, $memberCode)
    {
        $member = auth()->user();
        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $profile = Member::where('id', '!=', $member->id)
            ->where('member_code', '=', $memberCode)->firstOrFail();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();


        $member->member_viewed_profiles()->updateOrCreate([
            'profile_member_id' => $profile->id
        ]);

        return view('public.user.view_profile')
            ->with('profile', $profile)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('employeeIns', $employeeIns)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    /**
     * Get Profile Viewed by Current User
     *
     */
    public function viewMemberProfileViewed(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->member_viewed_profiles()
            ->with(['member_profile'])
            ->orderBy('updated_at', 'desc')->get();

        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();


        return view('public.user.viewed_profile')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('checkProfileStatus', true)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function viewMemberInterestedProfiles(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->interested_profiles()->with('member_profile')->orderBy('created_at', 'desc');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_REQUEST_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_REQUEST_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_REQUEST_PENDING);
            }
        }
        $profiles = $profiles->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();


        return view('public.user.interest_sent')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('checkProfileStatus', true)
            ->with('activeTab', $request->input('search') ?? null)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function viewMemberShortListedProfiles(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->shortlisted_profiles()
            ->with('member_profile')->orderBy('created_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();


        return view('public.user.shortlisted_profiles')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('checkProfileStatus', true)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function viewMemberIgnoredProfiles(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->ignored_profiles()
            ->with('member_profile')->orderBy('created_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();


        return view('public.user.ignored_profiles')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('checkProfileStatus', true)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function viewInterestReceived(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->interest_received()->with('member');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_REQUEST_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_REQUEST_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_REQUEST_PENDING);
            }
        } else {
            $profiles->where('request_status', PROFILE_REQUEST_PENDING);
        }
        $profiles = $profiles->orderBy('updated_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();

        return view('public.user.interest_received')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('activeTab', $request->input('search') ?? null)
            ->with('checkProfileStatus', true)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }

    public function memberViewedYourProfile(Request $request)
    {
        $member = auth()->user();

        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $profiles = $member->member_profile_viewed()->with('member')->orderBy('created_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();

        return view('public.user.who_viewed_profiles')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('profiles', $profiles)
            ->with('employeeIns', $employeeIns)
            ->with('showCreatedOn', true)
            ->with('checkProfileStatus', true)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }


    public function updateProfile(Request $request)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $member = $this->saveBasicMemberInformation($request, $member);
            $this->saveEducation($request, $member);
            $this->saveOccupation($request, $member);
            $this->saveFamily($request, $member);
            $this->saveLocation($request, $member);
            $this->saveHoroscope($request, $member);
            $member->checkIsUserCompletedIsProfileEntry();
            DB::commit();

            return redirect()->route('member.profile')->with('status', 'Updated Successfully');
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@updateProfile - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function updateProfilePhoto(UpdateProfilePhotoRequest $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $image = $request->has('profile_photo') ? $request->file('profile_photo') : null;
            $member->storeImage($image, ['width' => 192, 'height' => 192]);
            $member->save();

            DB::commit();

            return redirect()->route('member.profile')
                ->with('status', 'Updated Successfully')
                ->with('message', 'Profile Photo Udated Successfully');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error Occurred in MemberController@updateProfilePhoto - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addInterest(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->interested_profiles()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = PROFILE_REQUEST_PENDING;
            $interestedProfile->profile_status = PROFILE_INTEREST;

            $interestedProfile->save();

            DB::commit();

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addInterest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addShortList(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->interested_profiles()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = null;
            $interestedProfile->profile_status = PROFILE_SHORTLIST;
            $interestedProfile->save();

            DB::commit();

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addShortList - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addIgnore(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->interested_profiles()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = null;
            $interestedProfile->profile_status = PROFILE_IGNORED;

            $interestedProfile->save();

            DB::commit();

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addShortList - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function acceptProfileInterest(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->interested_profiles()->where('profile_member_id', $member->id)->firstOrFail();
            $interestedProfile->request_status = PROFILE_REQUEST_APPROVED;
            $interestedProfile->profile_status = PROFILE_INTEREST;
            $interestedProfile->save();

            DB::commit();

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@acceptProfileInterest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function notInterested(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->interested_profiles()->where('profile_member_id', $member->id)->firstOrFail();
            $interestedProfile->request_status = PROFILE_REQUEST_REJECT;
            $interestedProfile->profile_status = PROFILE_INTEREST;
            $interestedProfile->save();

            DB::commit();

            return response(['status' => 'success', 'msg' => 'Updated Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@notInterested  -' . $e->getMessage());
            return abort(500);
        }
    }


    public function removeFromIgnoreList(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $ignoredMember = Member::where('id', '!=', $member->id)
            ->where('member_code', '=', $memberCode)->firstOrFail();
            $profile = $member->ignored_profiles()
            ->where('profile_member_id', $ignoredMember->id)
            ->where('profile_status', PROFILE_IGNORED)->firstOrFail();
            $profile->delete();
            DB::commit();

            return response(['status' => 'success', 'msg' => 'Removed Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@removeFromIgnoreList - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function removeFromShortList(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $ignoredMember = Member::where('id', '!=', $member->id)
            ->where('member_code', '=', $memberCode)->firstOrFail();
            $profile = $member->shortlisted_profiles()
            ->where('profile_member_id', $ignoredMember->id)
            ->where('profile_status', PROFILE_SHORTLIST)->firstOrFail();
            $profile->delete();
            DB::commit();

            return response(['status' => 'success', 'msg' => 'Removed Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@removeFromShortList - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function removeFromInterestList(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $ignoredMember = Member::where('id', '!=', $member->id)
            ->where('member_code', '=', $memberCode)->firstOrFail();
            $profile = $member->interested_profiles()
            ->where('profile_member_id', $ignoredMember->id)
            ->where('profile_status', PROFILE_INTEREST)->firstOrFail();
            $profile->delete();
            DB::commit();

            return response(['status' => 'success', 'msg' => 'Removed Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@removeFromInterestList - ' . $e->getMessage());
            return abort(500);
        }
    }



    public function saveBasicMemberInformation(Request $request, Member $member)
    {
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->dob = $request->dob;
        $member->blood_id = $request->blood;
        $member->religion = $request->religion;
        $member->mother_tongue_id = $request->mother_tongue;
        $member->email = $request->email;
        $maritalStatus = MaritalStatus::where('slug', $request->marital_status)->first();
        $dhosam = Dhosam::where('slug', $request->dhosam)->first();
        $member->marital_status_id = $maritalStatus->id ?? 1;
        $member->dhosam_id = $dhosam->id ?? 1;
        $member->dhosam_remarks = $request->dhosam_remarks;
        $member->save();

        $image = $request->has('profile_photo') ? $request->file('profile_photo') : null;
        $member->storeImage($image, ['width' => 192, 'height' => 192]);
        $member->save();

        return $member;
    }

    public function showActiveAccountMessage(Request $request)
    {
        $member = auth()->user();
        $bloodGroup = Blood::orderBy('id')->get();
        $degrees = Degree::get();
        $familyType = FamilyType::get();
        $cities = City::get();
        $memberHoroscope = $member->horoscope ?? optional();
        $states = State::get();
        $rasies = Zodiac::get();
        $stars = Star::get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dhosam::orderBy('sequence')->get();

        return view('public.user.show_message_profile_view_not_allow')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ;
    }
}
