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
    if($content) {
        return $interestStatus ? $content : 'Need Approval';
    } else {
        return $interestStatus;
    }

}
