<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Members'], function () {
    Route::get('/', 'PublicController@index')->name('public.index');
    Route::get('/terms', 'PublicController@showTermsAndCondition')->name('public.terms_and_condition');

    //Route::post('enquiry', 'SaveEnquiryController@store')->name('enquiry.store');
    Route::get('/login', 'MemberLoginController@showLoginForm')->name('public.login');
    Route::post('/login', 'MemberLoginController@login');
    Route::post('/logout', 'MemberLoginController@logout')->name('public.logout');
    Route::post('/register', 'MemberRegistraionController@save')->name('public.register');
    Route::get('/register/success/{id}', 'MemberRegistraionController@registerationSuccess')->name('public.registration_success');
    Route::get('/email/verify/{hash}', 'MemberRegistraionController@verifyEmail')->name('public.verify_email');
    Route::post('/email/resend', 'MemberRegistraionController@resendEmailVerification')
        ->middleware('throttle:5,1')
        ->name('public.resend_email_verify');

    Route::get('/verify_phone_number', 'MemberLoginController@showVerifyPhoneNumberForm')->middleware('auth:member')->name('phone_number.verify');
    Route::post('/resend_phone_number_otp', 'MemberLoginController@resendPhoneNumberOtp')->middleware('auth:member')->name('phone_number.resend_otp');
    Route::post('/verify_phone_number', 'MemberLoginController@verifyPhoneNumber')->middleware('auth:member');
    Route::group(['middleware' => ['auth:member', 'verify_phone_number']], function () {
        Route::get('/dashboard', 'MemberController@dashboard')->name('member.dashboard');
        Route::post('/dashboard', 'MemberController@dashboard');
        Route::get('/profile', 'MemberController@profile')->name('member.profile');
        Route::get('/activate_account', 'MemberController@showActiveAccountMessage')->name('member.activate_account');
        Route::put('/profile','MemberController@updateProfile');
        Route::post('/profile/update_profile_photo','MemberController@updateProfilePhoto')->name('member.upload_profile_photo');

        Route::group(['middleware' => 'check_member_account_status'], function() {
            Route::post('/sendinterest/{memberCode}', 'MemberController@addInterest')->name('member.send_interest');
            Route::post('/addPhoneNumberRequest/{memberCode}', 'MemberController@addPhoneNumberRequest')->name('member.phone_number_request');
            Route::post('/add_profile_photo_request/{memberCode}', 'MemberController@addProfilePhotoRequest')->name('member.profile_photo_request');
            Route::post('/addHoroscopeRequest/{memberCode}', 'MemberController@addHoroscopeRequest')->name('member.horoscope_request');
            Route::post('/share_my_phone_number/{memberCode}', 'MemberController@shareMyPhoneNumber')->name('member.share_my_phone_number');

            Route::post('/addshortlist/{memberCode}', 'MemberController@addShortList')->name('member.add_profile_to_shortlist');
            Route::post('/addignore/{memberCode}', 'MemberController@addIgnore')->name('member.add_profile_to_ignore_list');
            Route::post('/accept_profile_interest/{memberCode}', 'MemberController@acceptProfileInterest')->name('member.accept_profile_request');
            Route::post('/not_interest/{memberCode}', 'MemberController@notInterested')->name('member.profile_not_interested');

            Route::post('/remove_from_ignore_list/{memberCode}', 'MemberController@removeFromIgnoreList')->name('member.remove_from_ignore_list');
            Route::post('/remove_from_short_list/{memberCode}', 'MemberController@removeFromShortList')->name('member.remove_from_short_list');
            Route::post('/delete_my_request/{memberCode}', 'MemberController@removeFromInterestList')->name('member.remove_from_interest_list');
            Route::get('/view/{memberCode}', 'MemberController@viewProfile')->name('member.view_profile');
            Route::post('/accept_phone_number_request/{memberCode}', 'MemberController@acceptPhoneNumberRequest')->name('member.accept_phone_number_request');
            Route::post('/accept_profile_photo_request/{memberCode}', 'MemberController@acceptProfilePhotoRequest')->name('member.accept_profile_photo_request');
            Route::post('/reject_phone_number_request/{memberCode}', 'MemberController@rejecPhoneNumberRequest')->name('member.reject_phone_number_request');
            Route::post('/reject_profile_photo_request/{memberCode}', 'MemberController@rejecProfilePhotoRequest')->name('member.reject_profile_photo_request');
            Route::get('/search/profile', 'MemberController@searchByProfileId')->name('member.search_profile_id');
        });
        Route::get('/viewed_profiles', 'MemberController@viewMemberProfileViewed')->name('member.viewed_profile');
        Route::get('/interested_profiles', 'MemberController@viewMemberInterestedProfiles')->name('member.interested_profiles');
        Route::get('/shortlisted_profiles', 'MemberController@viewMemberShortListedProfiles')->name('member.shortlisted_profiles');
        Route::get('/ignored_profiles', 'MemberController@viewMemberIgnoredProfiles')->name('member.ignored_profiles');
        Route::get('/interest_received', 'MemberController@viewInterestReceived')->name('member.interest_received');
        Route::get('/who_viewed_you', 'MemberController@memberViewedYourProfile')->name('member.who_viewed_you');
        Route::get('/phone_number_request_received', 'MemberController@viewPhoneNumberRequestReceived')->name('member.phone_number_request_received');
        Route::get('/phone_number_request_sent', 'MemberController@viewPhoneNumberRequestSent')->name('member.phone_number_request_sent');
        Route::get('/profile_photo_request_received', 'MemberController@viewProfilePhotoRequestReceived')->name('member.profile_photo_request_received');
        Route::get('/profile_photo_request_sent', 'MemberController@viewProfilePhotoRequestSent')->name('member.profile_photo_request_sent');

        Route::patch('/update_password', 'MemberController@changeMemberPassword')->name('member.update_password');

    });
});

Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/member/', 'Admin\AdminMemberController@index')->name('admin.member.index');
        Route::get('/member/create', 'Admin\AdminMemberController@create')->name('admin.member.add');
        Route::post('/member/create','Admin\AdminMemberController@createMember');
        Route::get('/member/{member}','Admin\AdminMemberController@edit')->name('admin.member.edit');
        Route::put('/member/{memberId}','Admin\AdminMemberController@update');
        Route::post('/member/{member}/reset_password','Admin\AdminMemberController@resetMemberPassword')->name("admin.member.reset_password");
        Route::delete('/member/{member}','Admin\AdminMemberController@delete')->name('admin.member.delete');

        Route::get('/member/import/member', 'Admin\AdminMemberController@importMember')->name('member.import_member');
        Route::post('/member/import/member', 'Admin\AdminMemberController@uploadMemberProfile');
        Route::get('/member/import/member_profile_photo', 'Admin\AdminMemberController@importProfilePhoto')->name('member.import_profile_photo');
        Route::post('/member/import/member_profile_photo', 'Admin\AdminMemberController@uploadMemberProfilePhoto');
        Route::get('/member/import/member_horoscope', 'Admin\AdminMemberController@importHoroscope')->name('member.import_horoscope');
        Route::post('/member/import/member_horoscope', 'Admin\AdminMemberController@uploadMemberHoroscope');

        Route::get('/member/export', 'Admin\AdminMemberController@export')->name('member.export');
        Route::get('site_information', 'SiteInformationController@index')->name('site_information.index');
        Route::post('site_information', 'SiteInformationController@store')->name('site_information.store');
        Route::resource('enquiries', 'EnquiriesController')->except('store');
        Route::resource('testimonials', 'TestimonialController');
        Route::put('faqs/update_sequence', 'FaqsController@updateSequence')->name('faqs.update_sequence');
        Route::resource('faqs', 'FaqsController');

        Route::resource('user', 'UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);


        /*
        Route::resource('plan', 'PlanController')->names(
            [
                'index' => 'admin.plan.index',
                'create' => 'admin.plan.create',
                'store' => 'admin.plan.store',
                'update' => 'admin.plan.update',
                'edit' => 'admin.plan.edit',
                'show' => 'admin.plan.show',
                'destroy' => 'admin.plan.destroy',
            ]
        );
        */
    });
});

Route::get('run_pending_verification', function(){
    return Artisan::call('email:user_verification_pending', []);
});
