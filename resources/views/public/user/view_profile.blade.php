@extends('public.app')
@section('content')
    <style>
        .profile_info {
            border-bottom: 1px solid #ccc;
        }
    </style>

    @php
    $profileEducations = $profile->educations;
    $profileOccupation = $profile->occupation ?? optional();
    $profileFamily = $profile->family ?? optional();
    $profileLocation = $profile->location ?? optional();
    $profileHoroscope = $profile->horoscope ?? optional();
    $isInterestAccepted = false;
    $showProfilePhoto = false;
    $showHoroscope = false;
    $isAdminUser = false;

    $profileInterestReceived = $profile->current_user_interest_received()->first();
    $responseStatus = $profileInterestReceived->request_status ?? null;
    $profilePhoneNumberRequestStatus = $profile->phone_number_request_received()->first() ?? null;
    $profileInterestRequest = $profile->current_user_interested_profiles()
    ->where('profile_status', PROFILE_INTEREST)->first();
    $requestStatus = $profileInterestRequest->request_status ?? null;
    $isHavingProfilePhoto = $profile->isHavingProfilePhoto();
    $profilePhotoRequestStatus = $profile->profile_photo_request_status()->count() ? $profile->profile_photo_request_status->request_status : null;
    if($responseStatus == PROFILE_REQUEST_APPROVED ||
            $requestStatus == PROFILE_REQUEST_APPROVED || $profile->profilePhotoIsPubliclyVisible() || $profilePhotoRequestStatus == PROFILE_PHONE_NUMBER_APPROVED) {
        $isInterestAccepted = true;
        $showProfilePhoto = true;
    }

    if($responseStatus == PROFILE_REQUEST_APPROVED ||
            $requestStatus == PROFILE_REQUEST_APPROVED || $profile->horoscopeIsPubliclyVisible()) {
            $showHoroscope = true;
    }

    if($member->isAdminUser()) {
        $showProfilePhoto = true;
        $isAdminUser = true;
        $showHoroscope = true;
        $isInterestAccepted = true;
    }
    @endphp
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-9 profile_container scrollit" style="">
                        <section id="page-title" class="page-title-pattern page-title-dark skrollable skrollable-between" style="background: rgb(34,195,90);
background: linear-gradient(0deg, rgba(34,195,90,0.9752275910364145) 27%, rgba(54,127,173,1) 100%);padding:1rem 0;">

    <div class="container clearfix">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div style="display: inline-block; padding-right:10px;">
                            <a href="{{  $profile->secureFullSizeProfilePhoto() }}" >
                                @if($showProfilePhoto)
                                    <img src="{{ $profile->secureProfilePhoto() }}" alt="{{ $profile->fullName }}"  class="alignCenter img my-0 " style="max-width: 120px;">
                                @else
                                    <img src="{{ $profile->getDefaultProfilePhoto() }}" alt="{{ $profile->fullName }}">
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-top:1.5rem">
                        <div class="heading-block border-0 mb-0" style="display:inline-block;padding-left:1.5rem">
                            <h4 class="alignLeft">{{ $profile->fullName }}</h4>
                            <b >RG{{ $profile->member_code }}</b><br>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="content" class="mb-10">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-12 mt-4">
                    <div class="tabs tabs-bb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-9">
                        <div class="tab-container profile_container" style="margin-top: 20px">
                            <div class="tab-content" id="basic-details">
                                <div class="form-row profile_info">
                                    <div class="col-md-12" style="background: #ccc">
                                        <h5 class="text-center">Basic Details</h5>
                                    </div>
                                </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('First Name') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                                    {{ $profile->first_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Last Name') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                                    {{ $profile->last_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Age') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
                                                    {{ $profile->age }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Gender') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                                                    @if($profile->gender == 1) Male @endif
                                                    @if($profile->gender == 2) Female @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Religion') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('religion') ? ' has-danger' : '' }}">
                                                    Hindu
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Mother Tuge') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('mother_tongue') ? ' has-danger' : '' }}">
                                                        @if($profile->mother_tongue->id == 1) Tamil @endif
                                                        @if($profile->mother_tongue->id == 2) Telugu @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Email') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    {{ canShowContent($isInterestAccepted, $profile->email) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Mobile No') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">

                                                    @if(($profilePhoneNumberRequestStatus && $profilePhoneNumberRequestStatus->request_status == PROFILE_PHONE_NUMBER_APPROVED) || $isAdminUser || true)
                                                        {{  $profile->phone_no }}
                                                    @elseif($isInterestAccepted)
                                                        {{ canShowContent($isInterestAccepted, $profile->phone_no) }}
                                                    @elseif($profilePhoneNumberRequestStatus && $profilePhoneNumberRequestStatus->request_status == PROFILE_PHONE_NUMBER_REQUEST)
                                                        <b>Request Sent</b>
                                                    @else
                                                        @if($profilePhoneNumberRequestStatus && $profilePhoneNumberRequestStatus->request_status == PROFILE_PHONE_NUMBER_REJECT)
                                                            <b class="text-danger">Request Rejected</b> <br>
                                                        @endif
                                                        <form method="POST" action="{{ route('member.phone_number_request', $profile->member_code) }}">
                                                            @csrf
                                                            @method('POST')
                                                        <button class="btn btn-primary" id="send_phone_number_request">
                                                            @if($profilePhoneNumberRequestStatus && $profilePhoneNumberRequestStatus->request_status == PROFILE_PHONE_NUMBER_REJECT)
                                                                Resend Request
                                                            @else
                                                                Send Request
                                                            @endif
                                                        </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-12 form-group"  style="background: #ccc">
                                            <h5 class="text-center">Education And Occupation</h5>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-12 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Qualifications') }}</label>
                                            <div class="col-sm-12">
                                                    @php
                                                        $profileDegrees = $degrees->whereIn('id', $profileEducations->where('degree_id', '!=', DEGREE_OTHERS)->pluck('degree_id'))->pluck('name');
                                                        $profileDegrees = $profileDegrees->toArray();
                                                        $otherDegrees = $profile->educations->whereNotNull('remarks')->pluck('remarks')->toArray();
                                                        $profileDegrees = implode(" , ", array_merge($profileDegrees, $otherDegrees));

                                                    @endphp
                                                   {{ $profileDegrees }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Employee In') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                            @foreach ($employeeIns as $employeeIn )
                                                                    @if($employeeIn->id == old('employee_in', $profileOccupation->employee_in_id))
                                                                        {{ $employeeIn->name }}
                                                                    @endif
                                                            @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Role Name') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                    {{ $profileOccupation->role }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label
                                                class="col-sm-5 col-form-label">{{ __('Organisation Detail') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('organisation_details') ? ' has-danger' : '' }}">
                                                        {{ canShowContent($isInterestAccepted, $profileOccupation->organisation_details) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Job Location') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('job_location') ? ' has-danger' : '' }}">
                                                        {{ canShowContent($isInterestAccepted, $profileOccupation->job_location) }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Annual Income') }}</label>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                    @php
                                                    $profileAnnualIncome = array_search($profileOccupation->annual_income, ANNUAL_INCOME_RANGE_KEY_VALUE);
                                                    @endphp
                                                    @foreach (ANNUAL_INCOME_RANGE as $range => $value )
                                                        @if($range == $profileAnnualIncome))
                                                            {{ $value}}
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-row profile_info">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Family Type') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group{{ $errors->has('family_type') ? ' has-danger' : '' }}">
                                                            @php
                                                                $profileFamilyType = $profileFamily->family_type ?? optional();
                                                            @endphp
                                                            @foreach($familyType as $type)
                                                                @if(old('type', $profileFamilyType->id) == $type->id )
                                                                    {{ $type->name }}
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Parents') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group{{ $errors->has('parents') ? ' has-danger' : '' }}">
                                                            {{ $profileFamily->parents }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row profile_info">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('No Of Brothers') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group{{ $errors->has('brothers') ? ' has-danger' : '' }}">
                                                            {{ $profileFamily->brothers }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('No Of Sisters') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group{{ $errors->has('sisters') ? ' has-danger' : '' }}">
                                                            {{ $profileFamily->sisters }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Remarks') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group">
                                                            {{ $profileFamily->remarks }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-12 form-group"  style="background: #ccc">
                                            <h5 class="text-center">Location Details</h5>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Address') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                                            {{ canShowContent($isInterestAccepted, $profileLocation->address) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('State') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('State') ? ' has-danger' : '' }}">
                                                            @foreach ($states as $state )
                                                                @if(old('state', $profileLocation->state_id) == $state->id)
                                                                    {{ $state->name }}
                                                                @endif
                                                            @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-row profile_info">
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('City') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                                            @foreach ($cities as $city )
                                                                @if(old('city', $profileLocation->city_id) == $city->id)
                                                                    {{ $city->name }}
                                                                @endif
                                                            @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Pin Code') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('pincode') ? ' has-danger' : '' }}">
                                                            {{ canShowContent($isInterestAccepted, $profileLocation->pincode) }}
                                                    </div>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="form-row ">
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('LandMark') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('landmark') ? ' has-danger' : '' }}">
                                                        {{ canShowContent($isInterestAccepted, $profileLocation->landmark) }}
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-12 form-group"  style="background: #ccc">
                                            <h5 class="text-center">Horoscope</h5>
                                        </div>
                                    </div>
                                    <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Rasi') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('rasi') ? ' has-danger' : '' }}">
                                                        @foreach ($rasies as $rasi )
                                                            @if(old('rasi', optional($profileHoroscope->rasi)->id) == $rasi->id)
                                                                {{ $rasi->name }}
                                                            @endif
                                                        @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Lagnam') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('lagnam') ? ' has-danger' : '' }}">
                                                        {{ optional($profileHoroscope->lagnam_rasi)->name }}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-row profile_info">
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Star') }}</label>
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group{{ $errors->has('star') ? ' has-danger' : '' }}">
                                                        @foreach ($stars as $star )
                                                            @if(old('star', optional($profileHoroscope->star)->id) == $star->id)
                                                                {{ $star->name }}
                                                            @endif
                                                        @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="col-sm-5 col-form-label">{{ __('Horoscope Images') }}</label>
                                            <div class="col-sm-12">
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                    @if($showHoroscope)
                                                        @if($profileHoroscope->horoscope_image)
                                                            <a href="{{ asset('site/images/horoscope/' . $profileHoroscope->horoscope_image ) }}" target="_blank">
                                                                View Horoscope
                                                            </a>
                                                        @endif
                                                    @else
                                                        <form method="POST" action="{{ route('member.phone_number_request', $profile->member_code) }}">
                                                            @csrf
                                                            @method('POST')
                                                            <button class="btn btn-primary" id="send_horoscope_request">Send Request</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label class="col-sm-5 col-form-label">{{ __('Dhosam') }}</label>
                                        <div class="col-sm-12">
                                            <div
                                                class="form-group">
                                                 {{ optional($profile->dhosam)->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group @if($profile->dhosam_remarks == null)  hide @endif" >
                                        <label class="col-sm-5 col-form-label">Other Dhosam</label>
                                        <div class="col-sm-12">
                                            {{ $profile->dhosam_remarks }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row profile_info">
                                    <div class="col-md-12 form-group"  style="background: #ccc">
                                        <h5 class="text-center">Photos</h5>
                                    </div>
                                </div>
                                <div class="form-row ">
                                    <div class="clear"></div>
                                    @if($isHavingProfilePhoto)
                                            @if($showProfilePhoto)
                                                @forelse ($profile->member_photos as $profilePhoto)
                                                    <div class="col-md-3">
                                                        <a class="grid-item" href="{{ $profilePhoto->securePhoto() }}" data-lightbox="gallery-item">
                                                        <img src="{{ $profilePhoto->secureProfilePhoto() }}" class="alignCenter img my-0 " alt="Avatar" style="width: 100px; display: inline-block; margin-right: 10px;" />
                                                        </a>
                                                    </div>
                                                @empty
                                                    <h6>Photos Not Updated</h6>
                                                @endforelse
                                            @elseif($profilePhotoRequestStatus == null)
                                                <br>
                                                <button type="btn" class="btn btn-success photo_request_send m-auto" >
                                                    Send Photo Request
                                                </button>
                                            @endif
                                @else
                                            Photos not updated
                                @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
