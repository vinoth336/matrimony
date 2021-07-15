<?php

define('MALE', 1);
define('FEMALE', 2);
define('MEMBER_ACCOUNT_STATUS_ACTIVE', 1);
define('MEMBER_ACCOUNT_STATUS_DEACTIVATE', 0);

define('PAYMENT_STATUS_PAID', 1);
define('PAYMENT_STATUS_NOT_PAID', 0);


//PROFILE INTEREST REQUEST STATUS
define('PROFILE_REQUEST_PENDING', 1);
define('PROFILE_REQUEST_APPROVED', 2);
define('PROFILE_REQUEST_REJECT', 3);

//PROFILE STATUS
define('PROFILE_INTEREST', 1);
define('PROFILE_SHORTLIST', 2);
define('PROFILE_IGNORED', 3);
define('PROFILE_BLOCKED', 4);
define('PROFILE_DELETE_REQUEST', 5);

//DEFAULT FIELD VALUE
define('DEFAULT_FAMILY_TYPE', 2);



//ANNUAL INCOME
define('ANNUAL_INCOME_RANGE', [
    'below_50k' => '10 - 50 K',
    'below_1l' => '50 K - 1 Lakhs',
    'below_2l' => '1 - 2 Lakhs',
    'below_5l' => '2 - 5 Lakhs',
    'below_10l' => '5 - 10 Lakhs',
    'below_50l' => '10 - 50 Lakhs',
    'below_1c' => '50 - 1 Crore',
    'above_1c' => 'Above 1 Crore'
]);

define('ANNUAL_INCOME_RANGE_KEY_VALUE', [
    'below_50k' => '1',
    'below_1l' => '2',
    'below_2l' => '3',
    'below_5l' => '4',
    'below_10l' => '5',
    'below_50l' => '6',
    'below_1c' => '6',
    'above_1c' => '7'
]);


define('DHOSHAMS', [
    'cheevai' => 'Cheevai',
    'surya' => 'Surya',
    'mangalyam' => 'Mangalyam'
]);


//Response Code

define('SUCCESS', 200);
define('PAYMENT_REQUIRED', 402);
define('SERVER_ERROR', 500);
define('UNAUTHORISED', 401);

define('DEGREE_OTHERS', 7);
define('DHOSHAM_OTHERS', 'others');
