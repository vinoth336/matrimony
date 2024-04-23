<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMemberBasicDetailRequest;
use App\Imports\ImportMember;
use App\Models\Blood;
use App\Models\City;
use App\Models\Degree;
use App\Models\Dhosam;
use App\Models\FamilyType;
use App\Models\MaritalStatus;
use App\Models\Member;
use App\Models\MemberEducation;
use App\Models\MemberFamily;
use App\Models\MemberHoroscope;
use App\Models\MemberLocation;
use App\Models\MemberOccupation;
use App\Models\RepresentBy;
use App\Models\Star;
use App\Models\State;
use App\Models\Zodiac;
use App\Traits\SaveMemberDetails;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
class AdminMemberController extends Controller
{
    use SaveMemberDetails;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $member = new Member();
        return $this->createProfilePage($member, 'basic-details');
    }

    public function index(Request $request)
    {
        $members = Member::withoutGlobalScope('active_account_only')->with('represent_by')->orderBy('created_at', 'desc')->get();
        return view('member.list')
            ->with('members', $members);
    }

    public function createMember(Request $request)
    {

        DB::beginTransaction();

        try {
            $member = $this->saveBasicMemberInformation($request, new Member);
            $this->saveEducation($request, $member);
            $this->saveOccupation($request, $member);
            $this->saveFamily($request, $member);
            $this->saveLocation($request, $member);
            $this->saveHoroscope($request, $member);
            $member->checkIsUserCompletedIsProfileEntry();
            $this->updateMemberPhotos($request, $member);

            DB::commit();
            return redirect()->route('admin.member.index');
        } catch (Exception $e) {
            Log::error('Error Occurred in AdminMemberController@createMember - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function edit(Request $request, $member)
    {
        $member = Member::withoutGlobalScope('active_account_only')->where('id', $member)->with(['blood', 'mother_tongue'])->first();

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
        $representBies = RepresentBy::orderBy('sequence')->get();


        return view('member.edit')
            ->with('member', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('activeTab', 'basic-details')
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ->with('representBies', $representBies)
            ;
    }

    public function update(Request $request, $memberId)
    {
        DB::beginTransaction();

        try {
            $member = Member::withoutGlobalScope('active_account_only')->findOrFail($memberId);
            $member = $this->saveBasicMemberInformation($request, $member);
            $this->saveEducation($request, $member);
            $this->saveOccupation($request, $member);
            $this->saveFamily($request, $member);
            $this->saveLocation($request, $member);
            $this->saveHoroscope($request, $member);
            $this->updateMemberPhotos($request, $member);
            $member->checkIsUserCompletedIsProfileEntry();


            DB::commit();

            return redirect()->route('admin.member.index')->with('status', 'Updated Successfully');
        } catch (Exception $e) {
            Log::error('Error Occurred in AdminMemberController@update - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function delete(Request $request, Member $member)
    {
        DB::beginTransaction();

        try {
            $member->educations()->delete();
            $member->occupation()->delete();
            $member->family()->delete();
            $member->location()->delete();
            $memberHoroscope = $member->horoscope;
            if ($memberHoroscope) {
                $memberHoroscope->unlinkImage($memberHoroscope->image);
                $memberHoroscope->delete();
            }
            $member->unlinkImage($member->profile_photo);
            $member->delete();

            DB::commit();

            return redirect()->route('admin.member.index');
        } catch (Exception $e) {
            Log::error('Error Occurred in AdminMemberController@update - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function saveBasicMemberInformation(Request $request, Member $member)
    {
        $maritalStatus = MaritalStatus::where('slug', $request->marital_status)->first();
        $dhosam = Dhosam::where('slug', $request->dhosam)->first();
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->dob = $request->dob;
        $member->blood_id = $request->blood ?? null;
        $member->gender = $request->gender;
        $member->religion = $request->religion;
        $member->mother_tongue_id = $request->mother_tongue;
        $member->email = $request->email;
        $member->phone_no = $request->phone_no;
        $member->secondary_phone_number = $request->secondary_phone_number;
        $member->username = $request->username;
        $member->password = $member->password ?? Hash::make(str_replace("-", "", $member->dob));
        $member->member_code = $member->member_code ?? generateMemberCodeNumber();
        $member->marital_status_id = $maritalStatus->id ?? 1;
        $member->dhosam_id = $dhosam->id ?? 1;
        $member->account_status = $request->account_status ? MEMBER_ACCOUNT_STATUS_ACTIVE : MEMBER_ACCOUNT_STATUS_DEACTIVATE;
        $member->payment_status = $request->payment_status ? PAYMENT_STATUS_PAID : PAYMENT_STATUS_NOT_PAID;
        $representBy = RepresentBy::where('slug', $request->input('represent_by'))->first();
        $member->represent_by_id = $representBy->id;
        $member->degree_details = $request->degree_details;
        $member->profile_photo_lock = $request->profile_photo_lock ?? ONLY_ACCEPTED_PROFILES;
        $member->horoscope_lock = $request->horoscope_lock ?? ONLY_ACCEPTED_PROFILES;
        $member->save();

        $image = $request->has('profile_photo') ? $request->file('profile_photo') : null;
        $member->storeImage($image, ['width' => 192, 'height' => 192]);
        $member->save();

        return $member;
    }

    public function createProfilePage($member, $activeTab = 'basic-details')
    {
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
        $representBies = RepresentBy::orderBy('sequence')->get();


        return view('member.create')
            ->with('basicInformation', $member)
            ->with('bloodGroup', $bloodGroup)
            ->with('activeTab', $activeTab)
            ->with('degrees', $degrees)
            ->with('familyType', $familyType)
            ->with('cities', $cities)
            ->with('states', $states)
            ->with('memberHoroscope', $memberHoroscope)
            ->with('rasies', $rasies)
            ->with('stars', $stars)
            ->with('maritalStatus', $maritalStatus)
            ->with('dhosams', $dhosams)
            ->with('representBies', $representBies)
            ;
    }

    public function importMember(Request $request)
    {
        return view('member.import_member');
    }

    public function uploadMemberProfile()
    {
        ini_set('max_execution_time', 180);
        DB::beginTransaction();
        try {
            Excel::import(new ImportMember, request()->file('member_list'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            die($e->getMessage());
            response(['status' => 'Cannot Import File'], 500);
        }

        return redirect()->route('admin.member.index')->with('status', 'Imported Member List Successfully');
    }

    public function resetMemberPassword(Request $request, Member $member)
    {
        DB::beginTransaction();
        try {
        $member->update([
            "password" => Hash::make(str_replace("-","", $member->dob))
        ]);

        DB::commit();

        return response(["status" => true, "message" => "Password Updated Successfully"], 200);
        } catch (Exception $e) {
            DB::rollback();

            return response(["status" => false, "message" => $e->getMessage()], 500);
        }
    }
}
