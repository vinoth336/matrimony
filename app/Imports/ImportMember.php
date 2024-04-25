<?php

namespace App\Imports;

use App\Models\Blood;
use App\Models\City;
use App\Models\Dosham;
use App\Models\MaritalStatus;
use App\Models\Member;
use App\Models\MotherTongue;
use App\Models\Star;
use App\Models\State;
use App\Models\Zodiac;
use App\Traits\SaveMemberDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportMember implements ToModel, WithHeadingRow
{
    use SaveMemberDetails;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['first_name']) {
            info($row);
            $degreeIds = $this->createDegree($row['degree']);
            $blood = $row['blood_group'] ? Blood::firstOrCreate(['name' => $row['blood_group']]) : Blood::where('name', 'B+')->first();
            $row['blood_group'] = $blood->id;

            $row['role'] = $row['role_name'];
            $row['degree'] = $degreeIds;
            $rasi = $row['rasi'] ? Zodiac::firstOrCreate(['name' => $row['rasi']]) : null;
            $row['rasi'] = $row['rasi'] ? $rasi->id : null;
            $star = $row['star'] ? Star::firstOrCreate(['name' => $row['star']]) : null;
            $row['star'] = $row['star'] ? $star->id : null;
            $city = $row['city'] ? City::firstOrCreate(['name' => $row['city']]) : null;
            $row['city'] = $row['city'] ? $city->id : null;
            $state = $row['state'] ? State::firstOrCreate(['name' => $row['state']]) : null;
            $row['state'] = $row['state'] ? $state->id : null;
            $dhosam = $row['dhosam'] ? Dosham::firstOrCreate(['name' => $row['dhosam']]) : null;
            $row['dhosam'] = $row['dhosam'] ? $dhosam->id : null;
            $maritalStatus = $row['marital_status'] ? MaritalStatus::firstOrCreate(['name' => $row['marital_status']]) : 1;
            $row['marital_status'] = $maritalStatus->id;

            $motherTunge = $row['mother_tongue'] ? MotherTongue::firstOrCreate(['name' => $row['mother_tongue']]) : MotherTongue::first();
            $row['mother_tongue'] = $motherTunge->id ?? 1;
            $request = new Request($row);
            $member = $this->saveMemberBasicDetails($request);
            info("am inside");
            $this->saveEducation($request, $member);
            $this->saveOccupation($request, $member);
            $this->saveFamily($request, $member);
            $this->saveLocation($request, $member);
            $this->saveHoroscope($request, $member);
            $member->checkIsUserCompletedIsProfileEntry();
        }
    }

    public function saveMemberBasicDetails(Request $request)
    {
        $member = Member::where('phone_no', $request->phone_no)->first();
        if ($member == null) {
            $member = new Member();
        }
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->dob =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($request->dob);
        $member->blood_id = $request->blood_group;
        $member->gender = $request->gender == 'Male' ? MALE : FEMALE;
        $member->religion = $request->religion;
        $member->mother_tongue_id = $request->mother_tongue;
        $member->email = $request->email_id;
        $member->phone_no = $request->phone_no;
        $member->secondary_phone_number = $request->secondary_phone_number;
        $member->username = $request->phone_no;
        $member->password = Hash::make(str_replace("-", "", $member->dob));
        $member->member_code = generateMemberCodeNumber();
        $member->marital_status_id = $request->marital_status ?? 1;
        $member->dhosam_id = $request->dhosam ?? 1;
        $member->account_status = MEMBER_ACCOUNT_STATUS_ACTIVE;
        $member->payment_status = $request->payment_status ? PAYMENT_STATUS_PAID : PAYMENT_STATUS_NOT_PAID;
        $member->degree_details = $request->degree_details;
        $member->save();

        return $member;
    }
}
