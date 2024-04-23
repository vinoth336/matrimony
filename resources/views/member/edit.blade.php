@extends('layouts.app', ['activePage' => 'member', 'titlePage' => __('Create Member'), 'subPage' => 'viewMemberList'])

@section('content')
@php
$memberEducations = $member->educations ?? optional();
$memberOccupation = $member->occupation ?? optional();
$memberFamily = $member->family ?? optional();
$memberLocation = $member->location ?? optional();
$memberHoroscope = $member->horoscope ?? optional();
@endphp
    <style>
        .hide {
            display: none;
        }

    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Create Member Profile') }}</h4>
                        </div>
                        <div class="card-body ">
                            <ul class="nav nav-pills nav-pills-primary tablist" role="tablist">
                                <li class="active">
                                    <a class="btn @if($activeTab == 'basic-details') btn-success @endif" href="#dashboard" role="tab" data-toggle="basic-details">
                                        <i class="material-icons">dashboard</i>
                                        Basic Details
                                    </a>
                                </li>
                                <li >
                                    <a class="btn @if($activeTab == 'education-and-occupation-details') btn-success @endif" href="#schedule" role="tab"
                                        data-toggle="education-and-occupation-details">
                                        <i class="material-icons">schedule</i>
                                        Education & Occupation
                                    </a>
                                </li>
                                <li >
                                    <a class="btn @if($activeTab == 'family-location-details') btn-success @endif" href="#family-location-details" role="tab" data-toggle="family-location-details">
                                        <i class="material-icons">schedule</i>
                                        Family Details & Location
                                    </a>
                                </li>
                                <li >
                                    <a class="btn @if($activeTab == 'horoscope-details') btn-success @endif" href="#horoscope-details" role="tab" data-toggle="horoscope-details">
                                        <i class="material-icons">schedule</i>
                                        Horoscope
                                    </a>
                                </li>
                                <li>
                                    <a class="btn @if($activeTab == 'profile-photos') btn-success @endif" href="#profile-photos" role="tab" data-toggle="profile-photos">
                                        <i class="material-icons">dashboard</i>
                                        Profile Photos
                                    </a>
                                </li>
                            </ul>
                            @if (session('status'))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="material-icons">close</i>
                                            </button>
                                            <span>{{ session('status') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <form method="post" action="{{ route('admin.member.edit', $member->id) }}" autocomplete="off" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="tab-container">
                                    <div class="tab-content @if($activeTab == 'basic-details') active @else hide  @endif" id="basic-details">
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Member Code') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" disabled value="{{ $member->member_code }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Represent By') }}</label>
                                                <div class="col-sm-7">
                                                    <div
                                                        class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                                        <select name="represent_by" class="selectpicker select form-control">
                                                                @php
                                                                    $memberRepresentBy = $member->represent_by ? $member->represent_by->slug : 'self';
                                                                @endphp
                                                                @foreach($representBies as $representBy)
                                                                    <option value="{{ $representBy->slug }}" @if(old('represent_by', $memberRepresentBy) == $representBy->slug) selected @endif>
                                                                            {{ $representBy->name }}
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                        @if ($errors->has('represent_by'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-represent_by">{{ $errors->first('represent_by') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('First Name') }}</label>
                                                <div class="col-sm-7">
                                                    <div
                                                        class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                                            name="first_name" id="input-first_name" type="text"
                                                            placeholder="{{ __('First Name') }}" value="{{ old('first_name', $member->first_name) }}"
                                                            required="true" aria-required="true" />
                                                        @if ($errors->has('first_name'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-first_name">{{ $errors->first('first_name') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Last Name') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                                            name="last_name" id="input-contact_person" type="text"
                                                            placeholder="{{ __('Last Name') }}" value="{{ old('last_name', $member->last_name) }}"
                                                            required="true" aria-required="true" />
                                                        @if ($errors->has('last_name'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-last_name">{{ $errors->first('last_name') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Date Of Birth') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}"
                                                            name="dob" id="input-contact_person" type="text"
                                                            placeholder="{{ __('Date Of Birth') }}" value="{{ old('dob', $member->dob) }}"
                                                            required="true" aria-required="true" />
                                                        @if ($errors->has('dob'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-dob">{{ $errors->first('dob') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Gender') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                                                        <select class="selectpicker select form-control  {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" required>
                                                            <option value="1" @if(old('gender', $member->gender) == 1) selected @endif>Male</option>
                                                            <option value="2" @if(old('gender', $member->gender) == 2) selected @endif>Female</option>
                                                        </select>
                                                        @if ($errors->has('last_name'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-last_name">{{ $errors->first('last_name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Religion') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('religion') ? ' has-danger' : '' }}">
                                                        <select class="form-control  {{ $errors->has('religion') ? ' is-invalid' : '' }}" name="religion" required>
                                                            <option value="1" @if(old('religion') == 1) selected @endif>Hindu</option>
                                                        </select>
                                                        @if ($errors->has('religion'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-religion">{{ $errors->first('religion') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Mother Tuge') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('mother_tongue') ? ' has-danger' : '' }}">
                                                        <select class="selectpicker select form-control  {{ $errors->has('mother_tongue') ? ' is-invalid' : '' }}" name="mother_tongue" required>
                                                            <option value="1" @if(old('mother_tongue', $member->mother_tongue->id) == 1) selected @endif>Tamil</option>
                                                            <option value="2" @if(old('mother_tongue', $member->mother_tongue->id) == 2) selected @endif>Telugu</option>
                                                        </select>
                                                        @if ($errors->has('mother_tongue'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-mother_tongue">{{ $errors->first('mother_tongue') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            name="email" id="input-email" type="text"
                                                            placeholder="{{ __('Email Id') }}" value="{{ old('email', $member->email) }}"
                                                             />
                                                        @if ($errors->has('email'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-email">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Mobile No') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}"
                                                            name="phone_no" id="input-contact_person" type="text"
                                                            placeholder="{{ __('Mobile No') }}" value="{{ old('phone_no', $member->phone_no) }}"
                                                            required="true" aria-required="true" />
                                                        @if ($errors->has('phone_no'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Secondary Phone No') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('secondary_phone_number') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('secondary_phone_number') ? ' is-invalid' : '' }}"
                                                            name="secondary_phone_number" id="input-contact_person" type="text"
                                                            placeholder="{{ __('Secondary Phone No') }}" value="{{ old('secondary_phone_number',  $member->secondary_phone_number) }}" />
                                                        @if ($errors->has('secondary_phone_number'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-secondary_phone_number">{{ $errors->first('secondary_phone_number') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Marital Status') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                                                        <select class="selectpicker select form-control" name="marital_status" id="input-service" type="text">
                                                            <option value=''>Select Marital Status</option>
                                                            @foreach($maritalStatus as $status)
                                                                <option value="{{ $status->slug }}" @if(old('marital_status', optional($member->marital_status)->slug) == $status->slug))
                                                                selected @endif >{{ $status->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('marital_status'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-marital_status">{{ $errors->first('marital_status') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Account Status') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('account_status') ? ' has-danger' : '' }}">
                                                        <select class="selectpicker select form-control  {{ $errors->has('account_status') ? ' is-invalid' : '' }}" name="account_status" required>
                                                            <option value="{{ MEMBER_ACCOUNT_STATUS_ACTIVE }}" @if(old('account_status', $member->account_status) == MEMBER_ACCOUNT_STATUS_ACTIVE) selected @endif>Active</option>
                                                            <option value="{{ MEMBER_ACCOUNT_STATUS_DEACTIVATE }}" @if(old('account_status', $member->account_status) == MEMBER_ACCOUNT_STATUS_DEACTIVATE) selected @endif>DeActive</option>
                                                        </select>
                                                        @if ($errors->has('account_status'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-account_status">{{ $errors->first('account_status') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Payment Status') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('payment_status') ? ' has-danger' : '' }}">
                                                        <select class="selectpicker select form-control  {{ $errors->has('payment_status') ? ' is-invalid' : '' }}" name="payment_status" required>
                                                            <option value="{{ PAYMENT_STATUS_PAID }}" @if(old('payment_status', $member->payment_status) == PAYMENT_STATUS_PAID) selected @endif>Paid</option>
                                                            <option value="{{ PAYMENT_STATUS_NOT_PAID }}" @if(old('payment_status', $member->payment_status) == PAYMENT_STATUS_NOT_PAID) selected @endif>Not Paid</option>
                                                        </select>
                                                        @if ($errors->has('payment_status'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-payment_status">{{ $errors->first('payment_status') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('UserName') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                                            name="username" id="input-contact_person" type="text"
                                                            placeholder="{{ __('UserName') }}" value="{{ old('username', $member->username) }}"
                                                            required="true" aria-required="true" />
                                                        @if ($errors->has('username'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-username">{{ $errors->first('username') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                                       <a href="Javascript:void(0)" id="reset_password" class="btn btn-primary">Change Password</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="ml-auto">
                                                    <a href="{{ route('admin.member.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>
                                                    <button type="button" data-next="education-and-occupation-details" data-current="basic-details" class="btn btn-primary switch-tab">{{ __('Next') }}</button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-content @if($activeTab == 'education-and-occupation-details') active @else hide  @endif" id="education-and-occupation-details">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>Education</h3>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <label class="col-sm-2 col-form-label">{{ __('Degree') }}</label>
                                                                <div class="col-sm-7">
                                                                    <div class="form-group{{ $errors->has('degree.0') ? ' has-danger' : '' }}">
                                                                        @php
                                                                            $memberDegrees = $memberEducations->pluck('degree_id')->toArray();
                                                                        @endphp
                                                                        <select class="selectpicker select form-control" name="degree[]" id="input-degree" multiple>
                                                                            <option value=''>Select Degree</option>
                                                                                @foreach($degrees as $degree)
                                                                                    <option value="{{ $degree->id }}" @if(old('degree.0') == $degree->id
                                                                                        || in_array($degree->id, $memberDegrees)))
                                                                                        selected @endif>{{ $degree->name }}</option>
                                                                                @endforeach
                                                                        </select>
                                                                        @if ($errors->has('degree.0'))
                                                                            <span id="name-error" class="error text-danger"
                                                                                for="input-degree">{{ $errors->first('degree.0') }}</span>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">{{ __('Degree Details') }}</label>
                                                <div class="col-sm-7">
                                                    <div
                                                        class="form-group{{ $errors->has('degree_details') ? ' has-danger' : '' }}">
                                                        <textarea
                                                            class="form-control{{ $errors->has('degree_details') ? ' is-invalid' : '' }}"
                                                            name="degree_details" id="input-degree_details" type="text" maxlength="500"
                                                            placeholder="{{ __('Degree Details') }}"
                                                            >{{ old('degree_details', $member->degree_details) }}</textarea>
                                                        @if ($errors->has('degree_details'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-degree_details">{{ $errors->first('degree_details') }}</span>
                                                        @endif
                                                        <span class="text-danger text-small">Maximum 500 Characters</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>Occupation</h3>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Role Name') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}"
                                                                    name="role" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('Role Name') }}"
                                                                    value="{{ old('role', $memberOccupation->role) }}" />
                                                                @if ($errors->has('role'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-role">{{ $errors->first('role') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label
                                                            class="col-sm-2 col-form-label">{{ __('Organisation Detail') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('organisation_details') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('organisation_details') ? ' is-invalid' : '' }}"
                                                                    name="organisation_details" id="input-organisation_details" type="text"
                                                                    placeholder="{{ __('Organisation Detail') }}"
                                                                    value="{{ old('organisation_details', $memberOccupation->organisation_details) }}" />
                                                                @if ($errors->has('organisation_details'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-organisation_details">{{ $errors->first('organisation_details') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Job Location') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('job_location') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('job_location') ? ' is-invalid' : '' }}"
                                                                    name="job_location" id="input-job_location" type="text"
                                                                    placeholder="{{ __('Job Location') }}"
                                                                    value="{{ old('job_location', $memberOccupation->job_location) }}" />
                                                                @if ($errors->has('job_location'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-job_location">{{ $errors->first('job_location') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Annual Income') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('annual_income') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('annual_income') ? ' is-invalid' : '' }}"
                                                                    name="annual_income" id="input-annual_income" type="text"
                                                                    placeholder="{{ __('Annual Income') }}"
                                                                    value="{{ old('annual_income', $memberOccupation->annual_income) }}" />
                                                                @if ($errors->has('annual_income'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-annual_income">{{ $errors->first('annual_income') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="ml-auto">
                                                    <button type="type" data-previous="basic-details" data-current="education-and-occupation-details"  class="btn btn-info switch-previous-tab">{{ __('Previous') }}</button>
                                                    <button type="type" data-next="family-location-details" data-current="education-and-occupation-details" class="btn btn-primary switch-tab">{{ __('Next') }}</button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-content @if($activeTab == 'family-location-details') active @else hide @endif" id="family-location-details">
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <h3>Family Details</h3>
                                                    <div class="row hide">
                                                        <label class="col-sm-2 col-form-label">{{ __('Family Type') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('family_type') ? ' has-danger' : '' }}">
                                                                @php
                                                                    $memberFamilyType = $memberFamily->family_type ?? optional();
                                                                @endphp
                                                                <select class="selectpicker select form-control" name="family_type">
                                                                    <option value=''>Select Family Type</option>
                                                                    @foreach($familyType as $type)
                                                                        <option value="{{ $type->id }}" @if(old('type', $memberFamilyType->id) == $type->id ) selected @endif >{{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('family_type'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-family_type">{{ $errors->first('family_type') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Father Name') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('father_name') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}"
                                                                    name="father_name" id="input-father_name" type="text"
                                                                    placeholder="{{ __('Father Name') }}"
                                                                    value="{{ old('father_name', $memberFamily->father_name) }}" />
                                                                @if ($errors->has('father_name'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-father_name">{{ $errors->first('father_name') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('About Father') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('about_father') ? ' has-danger' : '' }}">
                                                                <textarea
                                                                    class="form-control{{ $errors->has('about_father') ? ' is-invalid' : '' }}"
                                                                    name="about_father" id="input-about_father" type="text"
                                                                    placeholder="{{ __('About Father') }}" maxlength="500"
                                                                    >{{ old('about_father', $memberFamily->about_father) }}</textarea>
                                                                @if ($errors->has('about_father'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-about_father">{{ $errors->first('about_father') }}</span>
                                                                @endif
                                                                <span class="text-danger text-small">Maximum 500 Characters</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Mother Name') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('mother_name') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('mother_name') ? ' is-invalid' : '' }}"
                                                                    name="mother_name" id="input-mother_name" type="text"
                                                                    placeholder="{{ __('Mother Name') }}"
                                                                    value="{{ old('mother_name', $memberFamily->mother_name) }}" />
                                                                @if ($errors->has('mother_name'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-mother_name">{{ $errors->first('mother_name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('About Mother') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('about_mother') ? ' has-danger' : '' }}">
                                                                <textarea
                                                                    class="form-control{{ $errors->has('about_mother') ? ' is-invalid' : '' }}"
                                                                    name="about_mother" id="input-about_mother" type="text"
                                                                    placeholder="{{ __('About Mother') }}" maxlength="500"
                                                                    >{{ old('about_mother', $memberFamily->about_mother) }}</textarea>
                                                                @if ($errors->has('about_mother'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-about_mother">{{ $errors->first('about_mother') }}</span>
                                                                @endif
                                                                <span class="text-danger text-small">Maximum 500 Characters</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('No of Brothers') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('brothers') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('brothers') ? ' is-invalid' : '' }}"
                                                                    name="brothers" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('Brothers') }}"
                                                                    value="{{ old('brothers', $memberFamily->brothers) }}" />
                                                                @if ($errors->has('brothers'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-brothers">{{ $errors->first('brothers') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('About Brothers') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('about_brothers') ? ' has-danger' : '' }}">
                                                                <textarea
                                                                    class="form-control{{ $errors->has('about_brothers') ? ' is-invalid' : '' }}"
                                                                    name="about_brothers" id="input-about_brothers" type="text"
                                                                    placeholder="{{ __('About Brothers') }}" maxlength="500"
                                                                    >{{ old('about_brothers', $memberFamily->about_brothers) }}</textarea>
                                                                @if ($errors->has('about_brothers'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-about_brothers">{{ $errors->first('about_brothers') }}</span>
                                                                @endif
                                                                <span class="text-danger text-small">Maximum 500 Characters</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('No of Sisters') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('sisters') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('sisters') ? ' is-invalid' : '' }}"
                                                                    name="sisters" id="input-sisters" type="text"
                                                                    placeholder="{{ __('Sisters') }}"
                                                                    value="{{ old('sisters', $memberFamily->sisters) }}" />
                                                                @if ($errors->has('sisters'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-sisters">{{ $errors->first('sisters') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('About Sisters') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('about_sisters') ? ' has-danger' : '' }}">
                                                                <textarea
                                                                    class="form-control{{ $errors->has('about_sisters') ? ' is-invalid' : '' }}"
                                                                    name="about_sisters" id="input-about_sisters" type="text"
                                                                    placeholder="{{ __('About Sisters') }}"
                                                                    >{{ old('about_sisters', $memberFamily->about_sisters) }}</textarea>
                                                                @if ($errors->has('about_sisters'))
                                                                    <span id="about_sisters-error" class="error text-danger"
                                                                        for="input-about_sisters">{{ $errors->first('about_sisters') }}</span>
                                                                @endif
                                                                <span class="text-danger text-small">Maximum 500 Characters</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>Address Details</h3>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                                    name="address" id="input-address" type="text"
                                                                    placeholder="{{ __('Address') }}"
                                                                    value="{{ old('address', $memberLocation->address) }}" />
                                                                @if ($errors->has('address'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-address">{{ $errors->first('address') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('State') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('State') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="state" >
                                                                    <option value="">Select City</option>
                                                                    @foreach ($states as $state )
                                                                        <option value="{{ $state->id }}" @if(old('state', $memberLocation->state_id) == $state->id) selected @endif>
                                                                            {{ $state->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('state'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-state">{{ $errors->first('state') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('City') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="city" >
                                                                    <option value="">Select City</option>
                                                                    @foreach ($cities as $city )
                                                                        <option value="{{ $city->id }}" @if(old('city', $memberLocation->city_id) == $city->id) selected @endif>
                                                                            {{ $city->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('city'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-city">{{ $errors->first('city') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Pin Code') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('pincode') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}"
                                                                    name="pincode" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('Pin Code') }}"
                                                                    value="{{ old('pincode', $memberLocation->pincode) }}" />
                                                                @if ($errors->has('pincode'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-pincode">{{ $errors->first('pincode') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('LandMark') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('landmark') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('landmark') ? ' is-invalid' : '' }}"
                                                                    name="landmark" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('LandMark') }}" value="{{ old('landmark', $memberLocation->landmark) }}" />
                                                                @if ($errors->has('landmark'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-landmark">{{ $errors->first('landmark') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="ml-auto">
                                                    <button type="type" data-previous="education-and-occupation-details"
                                                    data-current="family-location-details" class="btn btn-info switch-previous-tab">{{ __('Previous') }}</button>
                                                    <button type="type" data-next="horoscope-details" data-current="family-location-details"
                                                    class="btn btn-primary switch-tab">{{ __('NexT') }}</button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-content @if($activeTab == 'horoscope-details') active @else hide  @endif" id="horoscope-details">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>Horoscope Details</h3>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Rasi') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('rasi') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="rasi" >
                                                                    <option value="">Select Rasi</option>
                                                                    @foreach ($rasies as $rasi )
                                                                        <option value="{{ $rasi->id }}" @if(old('rasi', $memberHoroscope->rasi_id) == $rasi->id) selected @endif>
                                                                            {{ $rasi->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('rasi'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-rasi">{{ $errors->first('rasi') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Lagnam') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('lagnam') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('lagnam') ? ' is-invalid' : '' }}"
                                                                    name="lagnam" id="input-lagnam" type="text"
                                                                    placeholder="{{ __('Lagnam') }}"
                                                                    value="{{ old('lagnam', $memberHoroscope->lagnam) }}" />
                                                                @if ($errors->has('lagnam'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-lagnam">{{ $errors->first('lagnam') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Star') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('star') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="star" >
                                                                    <option value="">Select Rasi</option>
                                                                    @foreach ($stars as $star )
                                                                        <option value="{{ $star->id }}" @if(old('star', $memberHoroscope->star_id) == $star->id) selected @endif>
                                                                            {{ $star->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('star'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-star">{{ $errors->first('star') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Horoscope Lock') }}</label>
                                                        <div class="col-sm-7">
                                                            <div
                                                                class="form-group{{ $errors->has('star') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="horoscope_lock" >
                                                                    <option value='{{ VISIBLE_TO_ALL }}' @if($member->horoscope_lock == VISIBLE_TO_ALL) selected @endif>Visible To All</option>
                                                                    <option value='{{ ONLY_ACCEPTED_PROFILES }}' @if($member->horoscope_lock == ONLY_ACCEPTED_PROFILES) selected @endif>Visible Only For Accepted Profiles</option>
                                                                </select>
                                                                @if ($errors->has('horoscope_lock'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-horoscope_lock">{{ $errors->first('horoscope_lock') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Horoscope Images') }}</label>
                                                        <div class="col-sm-7">
                                                            <div class="fileinput @if(!$memberHoroscope->horoscope_image) fileinput-new @else fileinput-exists @endif text-center" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                <img src="{{ asset('material') . "/img/image_placeholder.jpg" }}" style="width: 100px" alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                                        <img src="{{ asset('site/images/horoscope/' . $memberHoroscope->horoscope_image ) }}" />
                                                                </div>
                                                                <div>
                                                                <span class="btn btn-rose btn-file">
                                                                    <span class="fileinput-new">Select image</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="hidden" name="remove_image_horoscope_image" value="" />
                                                                    <input type="file" name="horoscope_image" accept="image/x-png,image/jpg,image/jpeg" >
                                                                </span>
                                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput" data-field-name="horoscope_image"><i class="fa fa-times"></i> Remove</a>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('horoscope_image'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-horoscope_image">{{ $errors->first('horoscope_image') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="ml-auto">
                                                    <button type="button" data-previous="family-location-details" data-current="horoscope-details" class="btn btn-info switch-previous-tab">{{ __('Previous') }}</button>
                                                    <button type="type" data-next="profile-photos" data-current="horoscope-details"
                                                    class="btn btn-primary switch-tab">{{ __('NexT') }}</button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-content @if($activeTab == 'profile-photos') active @else hide  @endif" id="profile-photos">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>Profile Photos</h3>
                                                    <div class="row">
                                                        <label class="col-sm-2 col-form-label">{{ __('Profile Photo Lock') }}</label>
                                                        <div class="col-sm-6">
                                                            <div
                                                                class="form-group{{ $errors->has('rasi') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="profile_photo_lock" id="input_profile_photo_lock" >
                                                                    <option value='{{ VISIBLE_TO_ALL }}' @if($member->profile_photo_lock == VISIBLE_TO_ALL) selected @endif>Visible To All</option>
                                                                    <option value='{{ ONLY_ACCEPTED_PROFILES }}' @if($member->profile_photo_lock == ONLY_ACCEPTED_PROFILES) selected @endif>Visible Only For Accepted Profiles</option>
                                                                </select>
                                                                @if ($errors->has('horscope_lock'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-horscope_lock">{{ $errors->first('horscope_lock') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                            <div class="table-responsive m-auto" style="width: auto">
                                                            <table id="profile_photo_add_section" class="table m-auto table-responsive" style="width:auto">
                                                                <thead>
                                                                        <tr>
                                                                            <th>Photo</th>
                                                                            <th>Is Profile Photo</th>
                                                                            <th>Remove Photo</th>
                                                                        </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($member->member_photos as $profilePhoto)
                                                            <tr class="member_profile_photo_field_section">
                                                                <td>
                                                                    <input type="hidden" name="rowno[{{ $profilePhoto->id }}]" value="1" />
                                                                    <div style="float:left">
                                                                    <img src="{{ $profilePhoto->secureProfilePhoto() }}" class="alignCenter img my-0 " alt="Avatar" style="width: 100px; display: inline-block; margin-right: 10px;" />
                                                                    </div>
                                                                    <div style="float: left">
                                                                        <input id="member_profile_photo" name="profile_photos[{{ $profilePhoto->id }}]" type="file" class="file"  data-show-upload="false" accept="image/x-png,image/jpg,image/jpeg" >
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="is_profile_photo" @if($profilePhoto->is_profile_photo == 1) checked @endif value="{{ $profilePhoto->id }}" />
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="remove_photos[{{ $profilePhoto->id }}]" value="{{ $profilePhoto->id }}" />
                                                                </td>
                                                        </tr>
                                                            @empty
                                                                        <tr class="member_profile_photo_field_section">
                                                                            <td>
                                                                                <input type="hidden" name="rowno[]" value="1" />
                                                                                <input id="member_profile_photo" name="profile_photos[]" type="file" class="file"  data-show-upload="false" accept="image/x-png,image/jpg,image/jpeg" >
                                                                            </td>
                                                                            <td>
                                                                                <input type="radio" name="is_profile_photo" value="1" />
                                                                            </td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                            <div style="clear: both">
                                                                <button type="button" class="btn btn-success" id="add_profile_photo_section" onclick="MemberProfilePhoto.addRow()" >
                                                                    Add More photo
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="bottommargin-sm"></div>
                                        <div class="row">
                                            <div class="ml-auto">
                                                <button type="button" data-previous="horoscope-details" data-current="profile-photos" class="btn btn-info switch-previous-tab">{{ __('Previous') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
            $(".tablist li a").on('click', function(e) {

                var tab = $(this).data('toggle');

                if ($(this).hasClass('btn-success')) {
                    return false;
                }

                $(".tablist li a.btn-success").addClass('btn-default');
                $(".tablist li a.btn-success").removeClass('btn-success');
                $(this).removeClass('btn-default');
                $(this).addClass('btn-success');

                $(".tab-container").find('div.active').addClass('hide');
                $(".tab-container").find('div.active').removeClass('active');

                $('#' + tab).removeClass('hide');
                $('#' + tab).addClass('active');

            });

            $(".switch-tab").on('click', function(e) {
                e.preventDefault();
                $(".tablist li").find('a[data-toggle="' + $(this).data('next') + '"]').trigger('click');
            });

            $(".switch-previous-tab").on('click', function(e) {
                e.preventDefault();
                $(".tablist li").find('a[data-toggle="' + $(this).data('previous') + '"]').trigger('click');
            });


            $("[data-dismiss='fileinput']").on('click', function() {
                $("[name='remove_image_" + $(this).data('field-name') + "']").val(1);
            });

            $(document).ready(function() {
                $('.datepicker').datetimepicker({
                    format: "DD-MM-YYYY",
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down",
                        previous: "fa fa-chevron-left",
                        next: "fa fa-chevron-right",
                        today: "fa fa-screenshot",
                        clear: "fa fa-trash",
                        close: "fa fa-remove"
                    }
                });
            });


            $("#reset_password").on('click', function() {
                if(!confirm("Are you sure want to reset the member password")) {
                    return false;
                }

                $.ajax({
                    "url" : "{{ route("admin.member.reset_password", $member->id) }}",
                    "type" : "post",
                    "dataType" : "json",
                    "success" : function() {
                        alert("Updated Successfully")
                    },
                    "error" : function(request, status, error) {
                        console.log(request);
                        alert(request.responseJSON.message);
                    }

                })
            })
        </script>
    @endsection
