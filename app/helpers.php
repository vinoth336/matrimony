<?php

use App\Models\Member;
use Illuminate\Support\Facades\DB;

function createText($field)
{
    $field = json_decode($field, true);
    print_r($field, true);
    exit;
    $errors = $field->errors;
    $input = '<input class="form-control' . $errors->has($field->name) ? ' is-invalid' : '' . '
    name="' . $field->name . '" id="input-' . $field->name . '" type="text"
    placeholder="' . $field->label . '" value="' . old($field->name, $field->value) . '" required="true"
    aria-required="true" />';

    if ($field->errors) {
        $input .= '<span id="name-error" class="error text-danger"
        for="input-contact_person">' . $errors->first($field->name) . '</span>';
    }

    return $input;
}


function passedOut()
{
    $from = 2000;
    $to = date("Y");
    $passedOut = [];
    while ($from <= $to) {
        $passedOut[] = $from++;
    }

    return $passedOut;
}

function familyType()
{
    return DB::table('family_type')->orderBy('order')->select('id', 'name')->get();
}


function generateMemberCodeNumber()
{
    $code = mt_rand(1000000000, 9999999999); // better than rand()
    if($code <= 0) {
        $code = $code * -1;
    }
    $code = str_pad($code,8,'0',STR_PAD_LEFT);
    // call the same function if the MemberCode exists already
    if (MemberCodeNumberExists($code)) {
        return generateMemberCodeNumber();
    }

    // otherwise, it's valid and can be used
    return $code;
}

function MemberCodeNumberExists($code)
{
    // query the database and return a boolean
    // for instance, it might look like this in Laravel
    return Member::whereMemberCode($code)->exists();
}

function canShowContent($interestStatus, $content = null)
{
    $user = auth()->user();
    $isAdminUser = $user->isAdminUser();
    if($isAdminUser) {
        return $content;
    }
    if($content) {
        return $interestStatus ? $content : 'Need Approval';
    } else {
        return $interestStatus;
    }

}

function whatsappShareContent($profile)
{
    $profileEducations = $profile->educations;
    $profileOccupation = $profile->occupation ?? null;
    $profileFamily = $profile->family ?? null;
    $profileLocation = $profile->location ?? null;
    $profileHoroscope = $profile->horoscope ?? null;


    $rasi =  $profileHoroscope ? $profileHoroscope->rasi()->first() : null;
    $rasi = $rasi ? $rasi->name : null;
    $star =  $profileHoroscope ? $profileHoroscope->star()->first() : null;
    $star = $star ? $star->name : null;
    $dhosam = $profile->dhosam()->first();
    $dhosam = $dhosam ? $dhosam->name : null;
    $content = "Name : " . $profile->name . "%0aAge : " . $profile->age . "%0aDob : " . $profile->dob . "%0a" ;
    if($rasi) {
        $content .= "Rasi : " . $rasi ?? null;
    }
    if($star) {
        $content .= "%0aStar : " . $star ?? null;
    }
    if($dhosam) {
        $content .= "%0aDhosam : " . $dhosam;
    }
    $content .="%0aView Profile : " . route('member.view_profile', $profile->member_code) ;
    $content .= "%0a*Shared By * %0a*"  . config('app.name') . "*%0a" . config('app.url');

    return $content;
}

function shareMyPhoneNumberLabel($member, $toMember)
{

    return "Show Phone Number";

}

function showPhoneNumberRequestStatus($profile)
{
    $user = auth()->user();
    $isAdminUser = $user->isAdminUser();
    $requestStatus = $user->share_my_phone_number()->where('to_member_id', $profile->id)->first();
    $status = $requestStatus->status ?? null;
    if ($isAdminUser) {
        return "<a href='tel:$profile->phone_no'>" . $profile->phone_no . "</a>";
    }

    if ($status == 'request') {
        return "<button class='btn btn-warning  mx-4'>" . __('Request In progress') . "</button>";
    } elseif ($status == 'sent') {
        return "<button class='btn btn-warning  mx-4'>" . __('Request Sent') . "</button>";
    }  elseif ($status == 'discussed') {
        return "<button class='btn btn-warning  mx-4'>" . __('Informed To Their Family') . "</button>";
    } elseif ($status == 'not-interest') {
        return "<button class='btn btn-danger  mx-4'>" . __('Not Interested') . "</button>";
    } elseif ($status == 'accepted') {
        return "<a href='tel:$profile->phone_no'>" . $profile->phone_no . "</a>";
    } else {
        return '<button class="btn btn-primary btn-sm text-white mx-4 share_my_phone_number" ><i class="icon-share2"></i>'
            .  shareMyPhoneNumberLabel($user, $profile) .
            '</button>';
    }
}
