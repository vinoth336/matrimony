<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberEducation;
use App\Models\MemberFamily;
use App\Models\MemberHoroscope;
use App\Models\MemberLocation;
use App\Models\MemberOccupation;
trait SaveMemberDetails {

    public function saveEducation(Request $request, $member)
    {
        $memberEducation = $member->educations();
        $ids = [];
        $degrees = $request->input('degree') ?? [];

        foreach($degrees as $key => $degree) {
            $degreeId = $request->input('degree.' . $key);
            $education = $memberEducation->where("degree_id", $degreeId)->first() ?? new MemberEducation();
            $education->member_id = $member->id;
            $education->degree_id = $degreeId;

            if($degreeId == DEGREE_OTHERS) {
                $education->remarks = $request->input('degree_remarks');
            }
            $education->save();

            array_push($ids, $education->id);
        }
        $member->educations()->whereNotIn('id', $ids)->delete();

        return $member->educations;
    }

    public function saveOccupation(Request $request, $member)
    {
        $occupation = $member->occupation ?? new MemberOccupation();
        $occupation->member_id = $member->id;
        $occupation->organisation = $request->input('organisation_details');
        $occupation->role = $request->input('role');
        $occupation->organisation_details = $request->input('organisation_details');
        $occupation->job_location = $request->input('job_location');
        $occupation->employee_in_id = $request->input('employee_in');
        $occupation->annual_income = ANNUAL_INCOME_RANGE_KEY_VALUE[$request->input('annual_income')] ?? null;
        $occupation->save();

        return $occupation;
    }

    public function saveFamily(Request $request, $member)
    {
        $family = $member->family ?? new MemberFamily;
        $family->member_id = $member->id;
        $family->family_type_id = $request->input('family_type');
        $family->father_name = $request->input('father_name');
        $family->mother_name = $request->input('mother_name');
        $family->brothers = $request->input('brothers');
        $family->sisters = $request->input('sisters');
        $family->remarks = $request->input('family_remarks');
        $family->save();

        return $family;
    }

    public function saveLocation(Request $request, $member)
    {
        $location = $member->location ?? new MemberLocation();
        $location->member_id = $member->id;
        $location->address = $request->input('address');
        $location->city_id = $request->input('city');
        $location->state_id = $request->input('state');
        $location->pincode = $request->input('pincode');
        $location->landmark = $request->input('landmark');
        $location->save();

        return $location;
    }

    public function saveHoroscope(Request $request, Member $member)
    {
        $memberHoroscope = $member->horoscope ?? new MemberHoroscope();
        $memberHoroscope->member_id = $member->id;
        $memberHoroscope->rasi_id = $request->input('rasi');
        $memberHoroscope->star_id = $request->input('star');
        $memberHoroscope->lagnam = $request->input('lagnam');
        $memberHoroscope->save();

        $image = $request->has('horoscope_image') ? $request->file('horoscope_image') : null;
        $memberHoroscope->storeImage($image);
        $memberHoroscope->save();

        return $memberHoroscope;
    }
}
