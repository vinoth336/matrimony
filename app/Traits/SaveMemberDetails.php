<?php

namespace App\Traits;

use App\Models\Degree;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberEducation;
use App\Models\MemberFamily;
use App\Models\MemberHoroscope;
use App\Models\MemberLocation;
use App\Models\MemberOccupation;
use App\Models\MemberProfilePhoto;

trait SaveMemberDetails
{

    public function saveEducation(Request $request, $member)
    {
        $memberEducation = $member->educations();
        $ids = [];

        if($request->input('degree') && !is_array($request->input('degree'))) {
            $degrees[] = $request->degree;
        } else {
            $degrees = $request->input('degree') ?? [];
        }
        foreach ($degrees as $key => $degree) {
            $degreeId = $degrees[$key];
            $education = $memberEducation->where("degree_id", $degreeId)->first() ?? new MemberEducation();
            $education->member_id = $member->id;
            $education->degree_id = $degreeId;

            if ($degreeId == DEGREE_OTHERS) {
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
        $family->about_father = $request->input('about_father');
        $family->mother_name = $request->input('mother_name');
        $family->about_mother = $request->input('about_mother');
        $family->brothers = $request->input('brothers');
        $family->about_brothers = $request->input('about_brothers');
        $family->sisters = $request->input('sisters');
        $family->about_sisters = $request->input('about_sisters');
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
        $memberHoroscope->remarks = $request->input('horoscope_remark');
        $memberHoroscope->save();

        $image = $request->has('horoscope_image') ? $request->file('horoscope_image') : null;
        $memberHoroscope->storeImage($image);
        $memberHoroscope->save();

        if ($request->input('dhosam')) {
            $member->doshams()->sync($request->input('dhosam'));
        } else {
            $member->doshams()->detach();
        }

        $member->horoscope_lock = $request->horoscope_lock ?? ONLY_ACCEPTED_PROFILES;
        $member->dhosam_remarks = $request->dhosam_remarks ?? null;
        $member->save();

        return $memberHoroscope;
    }

    public function createDegree($degreeName)
    {
        if($degreeName == null) {
            return null;
        }
        $degrees = explode(",", $degreeName);
        $ids = [];
        $totalRecord = Degree::count() + 1;
        foreach($degrees as $degree) {
            $degree = Degree::firstOrCreate([
                    'name' => $degree
                ], [
                    'order' => $totalRecord++
                ]);
            $ids[] = $degree->id;
        }
        return $ids;
    }

    public function updateMemberPhotos($request, $member)
    {
            $portfolioImageCount = $member->member_photos()->count() + 1;
            $images = $request->file('profile_photos');
            $isProfilePhoto = $request->input('is_profile_photo');
            $removeImage = $request->input('remove_photos');
            $totalRows = $request->input('rowno');
            foreach ($totalRows as $key => $value) {
                $image = $images[$key] ?? null;
                $existingFileName = '';
                $ProfileImage = MemberProfilePhoto::find($key) ?? new MemberProfilePhoto();
                if($ProfileImage->id) {
                    $existingFileName = $ProfileImage->profile_photo;
                }
                if (!isset($removeImage[$key])) {
                    if($image) {
                        $ProfileImage->storeImage($image, ['width' => 500, 'height' => 500]);
                        $ProfileImage->is_profile_photo = $isProfilePhoto == $key ? true : false;
                        $member->member_photos()->save($ProfileImage);
                    }
                } else {
                    if ($existingFileName) {
                        $ProfileImage->unlinkExistingImage($existingFileName);
                    }
                        $ProfileImage->delete();
                }
            }
            $member->profile_photo_lock = $request->profile_photo_lock ?? ONLY_ACCEPTED_PROFILES;
            $member->save();

    }
}
