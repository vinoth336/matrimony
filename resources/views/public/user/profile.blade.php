@extends('public.app')
@section('content')
@php
$memberEducations = $member->educations;
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
<section id="page-title" class="page-title-pattern page-title-dark skrollable skrollable-between" style="background: rgb(34,195,90);
background: linear-gradient(0deg, rgba(34,195,90,0.9752275910364145) 27%, rgba(54,127,173,1) 100%);padding:1rem 0;">

    <div class="container clearfix">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div style="display: inline-block; padding-right:10px;">
                            <img src="{{ $member->secureProfilePhoto() }}" class="alignCenter img my-0 " alt="Avatar"
                                        style="max-width: 120px;">
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-top:1.5rem">
                        <div class="heading-block border-0 mb-0" style="display:inline-block;padding-left:1.5rem">
                            <h4 class="alignLeft">{{ $member->fullName }}</h4>
                            <b >RG{{ $member->member_code }}</b><br>
                            <a href="#" class="text-dark" data-toggle="modal" data-target=".upload_profile_photo">
                                <i class="icon-edit2"></i>
                                Edit Profile Photo
                            </a>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade upload_profile_photo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form action="{{ route('member.upload_profile_photo') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="modal-dialog modal-lg">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uploadProfilePhoto">Upload Profile Photo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-5 col-form-label">{{ __('File') }}</label>
                            <div class="col-sm-12">
                                <div class="form-group{{ $errors->has('profile_photo') ? ' has-danger' : '' }}">
                                    <input type="file" name="profile_photo" accept="image/x-png,image/jpg,image/jpeg" required >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

</section>
<section id="content" class="mb-10">
    <div class="content-wrap">
        <div class="container clearfix">
            @if ($errors->has('profile_photo'))
                <div id="name-error" class="error text-danger mt-2" for="input-profile_photo">
                    {{ $errors->first('profile_photo') }}
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success  mt-2">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row clearfix">
                <div class="col-md-12 mt-4">
                    <div class="tabs tabs-bb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-9">

                        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header" role="tablist">
                            <li role="tab" tabindex="0" class="ui-tabs-tab ui-corner-top ui-tabs-active" aria-controls="tabs-33" aria-labelledby="ui-id-17">
                                <a href="#basic-details" class="ui-tabs-anchor" id="ui-id-17">
                                    <i class="icon-home2 mr-0"></i>
                                    Basic Information
                                </a>
                            </li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                <a href="#education-and-occupation-details" class="ui-tabs-anchor" id="ui-id-18">
                                    Education And Occupation
                                </a>
                            </li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" >
                                <a href="#family-location-details" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-19">
                                    Family Details And Location
                                </a>
                            </li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" >
                                <a href="#horoscope-details" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-19">
                                    Horoscope
                                </a>
                            </li>
                        </ul>

                        <div class="tab-container">
                            <form method="post" action="{{ route('member.profile') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                    <div class="tab-content" id="basic-details">
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('First Name') }}</label>
                                                    <div class="col-sm-12">
                                                        <div
                                                            class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                                            <input
                                                                class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                                                name="first_name" id="input-first_name" type="text"
                                                                placeholder="{{ __('First Name') }}" value="{{ old('first_name', $member->first_name) }}"
                                                                data-required="true" aria-data-required="true" />
                                                            @if ($errors->has('first_name'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-first_name">{{ $errors->first('first_name') }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Last Name') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                                            <input
                                                                class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                                                name="last_name" id="input-contact_person" type="text"
                                                                placeholder="{{ __('Last Name') }}" value="{{ old('last_name', $member->last_name) }}"
                                                                data-required="true" aria-data-required="true" />
                                                            @if ($errors->has('last_name'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-last_name">{{ $errors->first('last_name') }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Date Of Birth') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
                                                            <input
                                                                class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}"
                                                                name="dob" id="input-contact_person" type="text"
                                                                placeholder="{{ __('Date Of Birth') }}" value="{{ old('dob', $member->dob) }}"
                                                                data-required="true" aria-data-required="true" />
                                                            @if ($errors->has('dob'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-dob">{{ $errors->first('dob') }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Blood Group') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('blood') ? ' has-danger' : '' }}">
                                                            <select class="selectpicker form-control {{ $errors->has('blood') ? ' is-invalid' : '' }}" name="blood" required>
                                                                @foreach ($bloodGroup as $blood)
                                                                    <option value="{{ $blood->id }}"
                                                                        @if($blood->id == old('blood', $member->blood->id)) selected @endif>
                                                                        {{ $blood->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('blood'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-last_name">{{ $errors->first('blood') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Gender') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                                                            <select disabled class="selectpicker select form-control  {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" required>
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
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Religion') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('religion') ? ' has-danger' : '' }}">
                                                            <select class="selectpicker select form-control  {{ $errors->has('religion') ? ' is-invalid' : '' }}" name="religion" required>
                                                                <option value="1" @if(old('religion') == 1) selected @endif>Hindu</option>
                                                            </select>
                                                            @if ($errors->has('religion'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-religion">{{ $errors->first('religion') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Mother Tongue') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('mother_tongue') ? ' has-danger' : '' }}">
                                                            <select class="selectpicker select form-control {{ $errors->has('mother_tongue') ? ' is-invalid' : '' }}" name="mother_tongue" required>
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
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Email') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                            <input
                                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                                name="email" id="input-email" type="text"
                                                                placeholder="{{ __('Email Id') }}" value="{{ old('email', $member->email) }}"
                                                                data-required="true" aria-data-required="true" />
                                                            @if ($errors->has('email'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-email">{{ $errors->first('email') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Mobile No') }}</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                                                            <input disabled
                                                                class="form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}"
                                                                id="input-contact_person" type="text"
                                                                placeholder="{{ __('Mobile No') }}" value="{{ old('phone_no', $member->phone_no) }}"
                                                                data-required="true" aria-data-required="true" />
                                                            @if ($errors->has('phone_no'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="col-sm-5 col-form-label">{{ __('Marital Status') }}</label>
                                                    <div class="col-sm-12">
                                                            <select class="selectpicker select form-control" name="marital_status" id="input-service" type="text">
                                                                <option value=''>Select Marital Status</option>
                                                                @foreach($maritalStatus as $status)
                                                                    <option value="{{ $status->slug }}" @if(old('marital_status', optional($member->marital_status)->slug) == $status->slug))
                                                                    selected @endif >{{ $status->name }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-content" id="education-and-occupation-details">
                                        <div class="form-row">
                                            <div class="col-md-12 form-group">
                                                <input type="hidden" id="others_degree_value" value="{{ DEGREE_OTHERS }}" />
                                                <label class="col-sm-5 col-form-label">{{ __('Qualifications') }}</label>
                                                <div class="col-sm-12">
                                                        @php
                                                            $memberDegrees = $memberEducations->pluck('degree_id')->toArray();
                                                            $degreeRemarks = implode(" ", $memberEducations->whereNotNull('remarks')->pluck('remarks')->toArray());
                                                        @endphp

                                                        <select class="selectpicker select form-control" name="degree[]" id="input_degree" type="text" multiple >
                                                            <option value=''>Select Degree</option>
                                                            @foreach($degrees as $degree)
                                                                <option value="{{ $degree->id }}" @if(old('degree.0') == $degree->id
                                                                || in_array($degree->id, $memberDegrees)))
                                                                selected @endif >{{ $degree->name }}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 form-group @if($degreeRemarks == null)  hide @endif" id="degree_remark_container">
                                                <label class="col-sm-5 col-form-label">Other Degree Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control col-sm-6" name="degree_remarks" value="{{ $degreeRemarks }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Employee In') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                        <select name="employee_in" class="selectpicker select form-control">
                                                                <option value="">Select Employee In </option>
                                                                @foreach ($employeeIns as $employeeIn )
                                                                    <option value="{{ $employeeIn->id }}"
                                                                        @if($employeeIn->id == old('employee_in', $memberOccupation->employee_in_id)) selected @endif >
                                                                        {{ $employeeIn->name }}
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                        @if ($errors->has('employee_in'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-role">{{ $errors->first('employee_in') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Role Name') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}"
                                                            name="role" id="input-contact_person" type="text"
                                                            placeholder="{{ __('Role Name') }}"
                                                            value="{{ old('role', $memberOccupation->role) }}" data-required="true"
                                                            aria-data-required="true" />
                                                        @if ($errors->has('role'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-role">{{ $errors->first('role') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 form-group">
                                                <label
                                                    class="col-sm-5 col-form-label">{{ __('Organisation Detail') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('organisation_details') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('organisation_details') ? ' is-invalid' : '' }}"
                                                            name="organisation_details" id="input-organisation_details" type="text"
                                                            placeholder="{{ __('Organisation Detail') }}"
                                                            value="{{ old('organisation_details', $memberOccupation->organisation_details) }}" data-required="true"
                                                            aria-data-required="true" />
                                                        @if ($errors->has('organisation_details'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-organisation_details">{{ $errors->first('organisation_details') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Job Location') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('job_location') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('job_location') ? ' is-invalid' : '' }}"
                                                            name="job_location" id="input-job_location" type="text"
                                                            placeholder="{{ __('Job Location') }}"
                                                            value="{{ old('job_location', $memberOccupation->job_location) }}" data-required="true"
                                                            aria-data-required="true" />
                                                        @if ($errors->has('job_location'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-job_location">{{ $errors->first('job_location') }}</span>
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 form-group">
                                                <label class="col-sm-5 col-form-label">{{ __('Annual Income') }}</label>
                                                <div class="col-sm-12">
                                                    <div
                                                        class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                        @php
                                                        $memberAnnualIncome = array_search($memberOccupation->annual_income, ANNUAL_INCOME_RANGE_KEY_VALUE);
                                                        @endphp
                                                        <select name="annual_income" class="selectpicker select form-control">
                                                                <option value="">Select Annual Income</option>
                                                                @foreach (ANNUAL_INCOME_RANGE as $range => $value )
                                                                    <option value="{{ $range }}"
                                                                        @if($range == old('annual_income', $memberAnnualIncome)) selected @endif >
                                                                        {{ $value}}
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                        @if ($errors->has('employee_in'))
                                                            <span id="name-error" class="error text-danger"
                                                                for="input-role">{{ $errors->first('employee_in') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-content" id="family-location-details">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('Family Type') }}</label>
                                                            <div class="col-sm-12">
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
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('Father Name') }}</label>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="form-group{{ $errors->has('father_name') ? ' has-danger' : '' }}">
                                                                    <input
                                                                        class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}"
                                                                        name="father_name" id="input-father_name" type="text"
                                                                        placeholder="{{ __('Father Name') }}"
                                                                        value="{{ old('father_name', $memberFamily->father_name) }}" data-required="true"
                                                                        aria-data-required="true" />
                                                                    @if ($errors->has('father_name'))
                                                                        <span id="name-error" class="error text-danger"
                                                                            for="input-father_name">{{ $errors->first('father_name') }}</span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('Mother Name') }}</label>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="form-group{{ $errors->has('mother_name') ? ' has-danger' : '' }}">
                                                                    <input
                                                                        class="form-control{{ $errors->has('mother_name') ? ' is-invalid' : '' }}"
                                                                        name="mother_name" id="input-mother_name" type="text"
                                                                        placeholder="{{ __('Mother Name') }}"
                                                                        value="{{ old('mother_name', $memberFamily->mother_name) }}" data-required="true"
                                                                        aria-data-required="true" />
                                                                    @if ($errors->has('mother_name'))
                                                                        <span id="name-error" class="error text-danger"
                                                                            for="input-mother_name">{{ $errors->first('mother_name') }}</span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('No Of Brothers') }}</label>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="form-group{{ $errors->has('brothers') ? ' has-danger' : '' }}">
                                                                    <input
                                                                        class="form-control{{ $errors->has('brothers') ? ' is-invalid' : '' }}"
                                                                        name="brothers" id="input-contact_person" type="text"
                                                                        placeholder="{{ __('Brothers') }}"
                                                                        value="{{ old('brothers', $memberFamily->brothers) }}" data-required="true"
                                                                        aria-data-required="true" />
                                                                    @if ($errors->has('brothers'))
                                                                        <span id="name-error" class="error text-danger"
                                                                            for="input-brothers">{{ $errors->first('brothers') }}</span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('No Of Sisters') }}</label>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="form-group{{ $errors->has('sisters') ? ' has-danger' : '' }}">
                                                                    <input
                                                                        class="form-control{{ $errors->has('sisters') ? ' is-invalid' : '' }}"
                                                                        name="sisters" id="input-sisters" type="text"
                                                                        placeholder="{{ __('Sisters') }}"
                                                                        value="{{ old('sisters', $memberFamily->sisters) }}" data-required="true"
                                                                        aria-data-required="true" />
                                                                    @if ($errors->has('sisters'))
                                                                        <span id="name-error" class="error text-danger"
                                                                            for="input-sisters">{{ $errors->first('sisters') }}</span>
                                                                    @endif

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="col-sm-5 col-form-label">{{ __('Family Remarks') }}</label>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="form-group{{ $errors->has('family_remarks') ? ' has-danger' : '' }}">
                                                                    <textarea
                                                                        class="form-control{{ $errors->has('family_remarks') ? ' is-invalid' : '' }}"
                                                                        name="family_remarks" id="input-parents" type="text"
                                                                        placeholder="{{ __('Remarks') }}"
                                                                        >{{ old('parents', $memberFamily->remarks) }}</textarea>
                                                                    @if ($errors->has('family_remarks'))
                                                                        <span id="name-error" class="error text-danger"
                                                                            for="input-family_remarks">{{ $errors->first('family_remarks') }}</span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 form-group">
                                                    <h4>Location Details</h4>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Address') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                                    name="address" id="input-address" type="text"
                                                                    placeholder="{{ __('Address') }}"
                                                                    value="{{ old('address', $memberLocation->address) }}" data-required="true"
                                                                    aria-data-required="true" />
                                                                @if ($errors->has('address'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-address">{{ $errors->first('address') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('State') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('State') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="state" >
                                                                    <option value="">Select State</option>
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
                                            </div>
                                            <div class="form-row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('City') }}</label>
                                                        <div class="col-sm-12">
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
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Pin Code') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('pincode') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}"
                                                                    name="pincode" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('Pin Code') }}"
                                                                    value="{{ old('pincode', $memberLocation->pincode) }}" data-required="true"
                                                                    aria-data-required="true" />
                                                                @if ($errors->has('pincode'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-pincode">{{ $errors->first('pincode') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                            </div>
                                            <div class="form-row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('LandMark') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('landmark') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('landmark') ? ' is-invalid' : '' }}"
                                                                    name="landmark" id="input-contact_person" type="text"
                                                                    placeholder="{{ __('LandMark') }}"
                                                                    value="{{ old('landmark', $memberLocation->landmark) }}" data-required="true"
                                                                    aria-data-required="true" />
                                                                @if ($errors->has('landmark'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-landmark">{{ $errors->first('landmark') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                            </div>
                                    </div>
                                    <div class="tab-content" id="horoscope-details">
                                            <input type="hidden" id="others_dhosam_value" value="{{ DHOSHAM_OTHERS }}" />
                                            <div class="form-row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Rasi') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('rasi') ? ' has-danger' : '' }}">

                                                                <select class="selectpicker select form-control" name="rasi" >
                                                                    <option value="">Select Rasi</option>
                                                                    @foreach ($rasies as $rasi )
                                                                        <option value="{{ $rasi->id }}" @if(old('rasi', optional($memberHoroscope->rasi)->id) == $rasi->id) selected @endif>
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
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Lagnam') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('lagnam') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="lagnam" >
                                                                    <option value="">Select Lagnam</option>
                                                                    @foreach ($rasies as $rasi )
                                                                        <option value="{{ $rasi->id }}" @if(old('lagnam', optional($memberHoroscope->lagnam_rasi)->id) == $rasi->id) selected @endif>
                                                                            {{ $rasi->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('lagnam'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-lagnam">{{ $errors->first('lagnam') }}</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Star') }}</label>
                                                        <div class="col-sm-12">
                                                            <div
                                                                class="form-group{{ $errors->has('star') ? ' has-danger' : '' }}">
                                                                <select class="selectpicker select form-control" name="star" >
                                                                    <option value="">Select Rasi</option>
                                                                    @foreach ($stars as $star )
                                                                        <option value="{{ $star->id }}" @if(old('star', optional($memberHoroscope->star)->id) == $star->id) selected @endif>
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
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-sm-5 col-form-label">{{ __('Horoscope Images') }}</label>
                                                        <div class="col-sm-12">
                                                            <div class="col-lg-12">
                                                                <input id="horoscope_image" name="horoscope_image" type="file" class="file" data-initial-preview-type="image" data-initial-preview="<img src='{{ asset('site/images/horoscope/' . $memberHoroscope->horoscope_image ) }}' >'" data-show-upload="false" accept="image/x-png,image/jpg,image/jpeg" data-show-preview="true">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                                    @if (!$memberHoroscope->horoscope_image)
                                                                        <p class="text-center"> Horoscope Not Uploaded</p>
                                                                    @else
                                                                        <a href="{{ asset('site/images/horoscope/' . $memberHoroscope->horoscope_image ) }}" target="_blank">
                                                                            View Horoscope
                                                                        </a>
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
                                                            class="form-group{{ $errors->has('rasi') ? ' has-danger' : '' }}">

                                                            <select class="selectpicker select form-control" name="dhosam" id="input_dhosam" >
                                                                <option value=''>Select Dhosam Status</option>
                                                                @foreach($dhosams as $dhosam)
                                                                    <option value="{{ $dhosam->slug }}" @if(old('dhosam', optional($member->dhosam)->slug) == $dhosam->slug))
                                                                    selected @endif >{{ $dhosam->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('dhosam'))
                                                                <span id="name-error" class="error text-danger"
                                                                    for="input-dhosam">{{ $errors->first('dhosam') }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 form-group @if($member->dhosam_remarks == null)  hide @endif" id="dhosam_remark_container">
                                                    <label class="col-sm-5 col-form-label">Other Dhosam</label>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control col-sm-6" name="dhosam_remarks">{{ old('dhosam_remarks', $member->dhosam_remarks) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row form-group " >
                                        <div class="ml-auto">
                                            <a href="{{ route('member.dashboard') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('js')
<script>
    $(document).ready(function() {
        $('.selectsplitter').selectsplitter();
    });
    $("#input_degree").on('change', function() {
       var vals = $(this).val();
       if(vals.indexOf($("#others_degree_value").val()) >= 0 ) {
            $("#degree_remark_container").removeClass('hide');
       } else {
           if(!$("#degree_remark_container").hasClass('hide')) {
                $("#degree_remark_container").addClass('hide');
           }
       }
    });
    $("#input_dhosam").on('change', function() {
       var vals = $(this).val();
       if(vals  == $("#others_dhosam_value").val() ) {
            $("#dhosam_remark_container").removeClass('hide');
       } else {
           if(!$("#dhosam_remark_container").hasClass('hide')) {
                $("#dhosam_remark_container").addClass('hide');
           }
       }
    });
</script>
@endpush
@endsection
