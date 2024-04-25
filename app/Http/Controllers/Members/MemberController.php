<?php

namespace App\Http\Controllers\Members;

use App\Models\MemberShareMyPhoneNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeMemberPasswordRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;
use App\Jobs\SendNotificationToUser;
use App\Models\Blood;
use App\Models\City;
use App\Models\Degree;
use App\Models\Dosham;
use App\Models\EmployeeIn;
use App\Models\FamilyType;
use App\Models\MaritalStatus;
use App\Models\Member;
use App\Models\MemberViewedProfile;
use App\Models\Star;
use App\Models\State;
use App\Models\User;
use App\Models\Zodiac;
use App\Traits\SaveMemberDetails;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $profiles = $this->getProfiles($request, $member)->paginate(10)->withQueryString();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dosham::orderBy('sequence')->get();

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
            ->doesnthave('current_user_interest_received');
        if(!$member->isAdminUser()) {
            $profiles->where('gender', '!=', $member->gender);
        }
        $profiles->with(['educations' => function ($model) {
                $model->with('degree');
            }, 'occupation', "location" => function($model) { $model->with(["city", "state"]);}, 'doshams', 'marital_status', 'horoscope']);
        $profiles = $this->whereCondition($request, $profiles);
        ///$profiles->inRandomOrder();
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
            $query->whereIn('dhosam_id', $dhosams);
        }

        if($request->has('mother_tongues')) {
            $query->whereIn('mother_tongue_id', $motherTongues);
        }

        if($request->has('marital_status')) {
            $query->whereIn('marital_status_id', $maritalStatus);
        }

        if($request->has('gender') && auth()->user()->isAdminUser()) {
            $gender = $request->input('gender') == 'male' ? MALE : FEMALE;
            $query->where('gender', $gender);
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
        $dhosams = Dosham::orderBy('sequence')->get();

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
        $dhosams = Dosham::orderBy('sequence')->get();

        if(!$member->isAdminUser()) {
            $member->member_viewed_profiles()->updateOrCreate([
                'profile_member_id' => $profile->id
            ]);
        }

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
            ->with('member', $member)
            ;
    }

    public function searchByProfileId(Request $request)
    {
        try {
            $member = Member::where('member_code', '=', $request->input('profile_id'))->firstOrFail();
            $url = route('member.view_profile', $member->member_code) . "?search=search_by_profile_id&profile_id=" . $member->member_code ."#profile_id_search";
            return redirect()->to($url);
        } catch (ModelNotFoundException $exception)
        {
            abort(404);
        }
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
        $dhosams = Dosham::orderBy('sequence')->get();


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
        $dhosams = Dosham::orderBy('sequence')->get();


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
        $dhosams = Dosham::orderBy('sequence')->get();


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
        $dhosams = Dosham::orderBy('sequence')->get();


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
        $dhosams = Dosham::orderBy('sequence')->get();

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
        $dhosams = Dosham::orderBy('sequence')->get();

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

    public function viewPhoneNumberRequestReceived(Request $request)
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
        $profiles = $member->phone_number_request_received()->with('member');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
            }
        } else {
            $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
        }
        $profiles = $profiles->orderBy('updated_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dosham::orderBy('sequence')->get();

        return view('public.user.phone_number_request_received')
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
            ->with('selected_tab', 'phone_number_request_received')
            ;
    }

    public function viewPhoneNumberRequestSent(Request $request)
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
        $profiles = $member->phone_number_request_sent()->with('member_profile');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
            }
        } else {
            $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
        }
        $profiles = $profiles->orderBy('updated_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dosham::orderBy('sequence')->get();

        return view('public.user.phone_number_request_sent')
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
            ->with('selected_tab', 'phone_number_request_sent')
            ;
    }
    public function viewProfilePhotoRequestReceived(Request $request)
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
        $profiles = $member->profile_photo_request_received()->with('member');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
            }
        } else {
            $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
        }
        $profiles = $profiles->orderBy('updated_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dosham::orderBy('sequence')->get();

        return view('public.user.profile_photo_request_received')
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
            ->with('selected_tab', 'profile_photo_request_received')
            ;
    }

    public function viewProfilePhotoRequestSent(Request $request)
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
        $profiles = $member->profile_photo_request_sent()->with('member_profile');
        if ($request->input('search')) {
            $search = $request->input('search');
            if ($search == 'accepted_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_APPROVED);
            } elseif ($search == 'not_interested_profiles') {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REJECT);
            } else {
                $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
            }
        } else {
            $profiles->where('request_status', PROFILE_PHONE_NUMBER_REQUEST);
        }
        $profiles = $profiles->orderBy('updated_at', 'desc')->get();
        $employeeIns = EmployeeIn::orderBy('name')->get();
        $maritalStatus = MaritalStatus::orderBy('sequence')->get();
        $dhosams = Dosham::orderBy('sequence')->get();

        return view('public.user.profile_photo_request_sent')
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
            ->with('selected_tab', 'profile_photo_request_sent')
            ;
    }


    public function updateProfile(Request $request)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            if ($request->input('current_tab') == 'basic-details') {
                $member = $this->saveBasicMemberInformation($request, $member);
            }

            if ($request->input('current_tab') == 'education-and-occupation-details') {
                $this->saveEducation($request, $member);
                $this->saveOccupation($request, $member);
            }

            if ($request->input('current_tab') == 'family-location-details') {
                $this->saveFamily($request, $member);
                $this->saveLocation($request, $member);
            }

            if ($request->input('current_tab') == 'horoscope-details') {
                $this->saveHoroscope($request, $member);
            }

            if ($request->input('current_tab') == 'photo-details') {
                $this->updateMemberPhotos($request, $member);
            }

            $member->checkIsUserCompletedIsProfileEntry();

            DB::commit();

            return redirect()->to(route('member.profile') . "?next_tab=" . $request->input('next_tab'))
                ->with('status', 'Updated Successfully');
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
            dispatch(new SendNotificationToUser('profile_request_send', auth()->user(), $intrestedMember));

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addInterest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addPhoneNumberRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->add_phone_number_request()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_REQUEST;
            $interestedProfile->save();
            dispatch(new SendNotificationToUser('phone_number_request_received', $member, $intrestedMember));
            DB::commit();

            if($request->ajax()) {
                return response(['status' => 'success', 'msg' => 'Added Successfully']);
            } else {
                return redirect()->back()->with(['status' => 'success', 'msg' => 'Added Successfully']);
            }
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addPhoneNumberRequest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addProfilePhotoRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->add_profile_photo_request()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_REQUEST;
            $interestedProfile->save();
            dispatch(new SendNotificationToUser('photo_request_send', $member, $intrestedMember));
            DB::commit();

            if($request->ajax()) {
                return response(['status' => 'success', 'msg' => 'Added Successfully']);
            } else {
                return redirect()->back()->with(['status' => 'success', 'msg' => 'Added Successfully']);
            }
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@addProfilePhotoRequest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function addHoroscopeRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $member->horoscope_request()->updateOrCreate(['profile_member_id' => $intrestedMember->id]);
            $interestedProfile->request_status = PROFILE_HOROSCOPE_REQUEST;
            $interestedProfile->save();
            DB::commit();

            dispatch(new SendNotificationToUser('horoscope_request_send', auth()->user(), $intrestedMember));

            return redirect()->back()->with(['status' => 'success', 'msg' => 'Added Successfully']);
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

    public function shareMyPhoneNumber(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();

            if ($member->share_my_phone_number()->where('to_member_id', $intrestedMember->id)->exists()) {
                $profile = $member->share_my_phone_number()->where('to_member_id', $intrestedMember->id)->first();

                return response(['status' => 'success',
                    'message' => 'Request Already Sent',
                    'button_label' => showPhoneNumberRequestStatus($intrestedMember)
                ]);
            }

            $interestedProfile = MemberShareMyPhoneNumber::updateOrCreate([
                'from_member_id' => $member->id,
                'to_member_id' => $intrestedMember->id
                ],
                [
                    'from_member_id' => $member->id,
                    'to_member_id' => $intrestedMember->id,
                    'status'=> 'accepted',
                    'comments' => 'Accepted by admin'
                ]
            );
            DB::commit();

            dispatch(new SendNotificationToUser('phone_number_request_sent', auth()->user(), $intrestedMember));

            return response([
                'status' => 'success',
                'message' => 'Added Successfully',
                'button_label' => showPhoneNumberRequestStatus($intrestedMember)
                ]);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@shareMyPhoneNumber - ' . $e->getMessage());
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
            dispatch(new SendNotificationToUser('profile_request_accept', $member, $intrestedMember));

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

    public function acceptPhoneNumberRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->phone_number_request_status()->firstOrFail();
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_APPROVED;
            $interestedProfile->save();
            DB::commit();
            dispatch(new SendNotificationToUser('phone_number_request_accepted', $member, $intrestedMember));
            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@acceptPhoneNumberRequest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function acceptProfilePhotoRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();
        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->profile_photo_request_status()->firstOrFail();
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_APPROVED;
            $interestedProfile->save();
            DB::commit();

            dispatch(new SendNotificationToUser('photo_request_accept', $member, $intrestedMember));

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@acceptProfilePhotoRequest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function rejecPhoneNumberRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->phone_number_request_status()->firstOrFail();
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_REJECT;
            $interestedProfile->save();
            DB::commit();

            return response(['status' => 'success', 'msg' => 'Added Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@rejecPhoneNumberRequest - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function rejecProfilePhotoRequest(Request $request, $memberCode)
    {
        DB::beginTransaction();

        try {
            $member = auth()->user();
            $intrestedMember = Member::where('id', '!=', $member->id)
                ->where('member_code', '=', $memberCode)->firstOrFail();
            $interestedProfile = $intrestedMember->profile_photo_request_status()->firstOrFail();
            $interestedProfile->request_status = PROFILE_PHONE_NUMBER_REJECT;
            $interestedProfile->save();
            DB::commit();

            return response(['status' => 'success', 'msg' => 'Updated Successfully']);
        } catch (Exception $e) {
            Log::error('Error Occurred in MemberController@rejecProfilePhotoRequest - ' . $e->getMessage());
            return abort(500);
        }
    }


    public function saveBasicMemberInformation(Request $request, Member $member)
    {
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->dob = $request->dob;
        $member->blood_id = $request->blood ?? null;
        $member->religion = $request->religion;
        $member->mother_tongue_id = $request->mother_tongue;
        $member->email = $request->email;
        $maritalStatus = MaritalStatus::where('slug', $request->marital_status)->first();
        $dhosam = Dosham::where('slug', $request->dhosam)->first();
        $member->marital_status_id = $maritalStatus->id ?? 1;
        $member->save();

        //$image = $request->has('profile_photo') ? $request->file('profile_photo') : null;
        //$member->storeImage($image, ['width' => 192, 'height' => 192]);
        //$member->save();

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
        $dhosams = Dosham::orderBy('sequence')->get();

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

    public function changeMemberPassword(ChangeMemberPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $member = Member::where('id', $userId)->first();
            if(!$member->show_change_password_popup) {
                if (!Hash::check($request->input('password'), $member->password)) {
                    DB::rollback();
                    return redirect()->back()->withErrors(['password' => 'Entered Current Password Is Invalid']);
                }
            }
            $member->password = Hash::make($request->input('new_password'));
            $member->show_change_password_popup = false;
            $member->save();
            DB::commit();

            return redirect()->back()->with('password_update_successfully', 'Password Update Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error Occurred in MemberController@changePassword - ' . $e->getMessage());
            return abort(500);
        }
    }
}
