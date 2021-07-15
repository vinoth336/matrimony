<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Member;
use App\Models\MemberEducation;
use App\Models\MemberFamily;
use App\Models\MemberHoroscope;
use App\Models\MemberLocation;
use App\Models\MemberOccupation;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use function PHPSTORM_META\map;


$factory->define(Member::class, function (Faker $faker) {

    $data = [
        'first_name' => $faker->firstNameFemale,
        'last_name' => $faker->lastName,
        'username' => $faker->userName,
        'password' => Hash::make('Welcome1'),
        'member_code' => $faker->randomNumber(9),
        'dob' => date("Y-m-d", strtotime("- " . rand(20, 35) . " year")),
        'blood_id' => rand(1,8),
        'gender' => 2,
        'email' => $faker->unique()->safeEmail,
        'religion' => 1,
        'mother_tongue_id' => rand(1,2),
        'phone_no' => $faker->phoneNumber
    ];
    return $data;
});

$factory->afterCreating(Member::class, function($member, Faker $faker) {
        $degreeId = rand(1, 5);
        $education = new MemberEducation();
        $education->member_id = $member->id;
        $education->degree_id = $degreeId;
        $education->course = null;
        $education->institute = null;
        $education->passed_out = 2013;
        $education->save();

        $occupation = new MemberOccupation();
        $occupation->member_id = $member->id;
        $occupation->organisation = $faker->company;
        $occupation->role = 'programmer';
        $occupation->organisation_details = $faker->company;
        $occupation->job_location = 'karur';
        $occupation->save();

        $family = new MemberFamily();
        $family->member_id = $member->id;
        $family->family_type_id = rand(1, 2);
        $family->parents = rand(1,2);
        $family->brothers = rand(0,2);
        $family->sisters = rand(0,2);
        $family->save();

        $location = new MemberLocation();
        $location->member_id = $member->id;
        $location->address = $faker->address;
        $location->city_id = 1;
        $location->state_id = 1;
        $location->pincode = 639002;
        $location->landmark = $faker->streetName;
        $location->save();

        $memberHoroscope = new MemberHoroscope();
        $memberHoroscope->member_id = $member->id;
        $memberHoroscope->rasi_id = rand(1, 12);
        $memberHoroscope->star_id = rand(1,2);
        $memberHoroscope->lagnam = null;
        $memberHoroscope->save();

});
