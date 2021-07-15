@extends('layouts.app', ['activePage' => 'site_information', 'titlePage' => __('Create siteInformations')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('site_information.store') }}" autocomplete="off"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create siteInformations') }}</h4>

                            </div>
                            <div class="card-body ">
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
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Site Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('site_name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}"
                                                name="site_name" id="input-contact_person" type="text"
                                                placeholder="{{ __('Site Name') }}"
                                                value="{{ old('site_name', $siteInformation->site_name) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('site_name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('site_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Logo') }}</label>
                                    <div class="col-sm-7">

                                        <div class="fileinput @if(!$siteInformation->logo) fileinput-new @else fileinput-exists @endif text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') . "/img/image_placeholder.jpg" }}" style="width: 100px" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <img src="{{ asset('site/images/logo/' . $siteInformation->logo ) }}" />
                                            </div>
                                            <div>
                                              <span class="btn btn-rose btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="hidden" name="remove_image" value="" />
                                                <input type="file" name="logo" accept="image/x-png,image/jpg,image/jpeg" >
                                              </span>
                                              <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                          </div>
                                          @if ($errors->has('logo'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('logo') }}</span>
                                          @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Meta Descrition') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('meta_description') ? ' has-danger' : '' }}">
                                            <textarea
                                                class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                name="meta_description" id="description"
                                                placeholder="{{ __('Meta Description') }}"
                                                required>{{ old('meta_description', $siteInformation->meta_description) }}</textarea>
                                            @if ($errors->has('meta_description'))
                                                <span id="phone_no-error" class="error text-danger"
                                                    for="input-phone_no">{{ $errors->first('meta_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Facebook Id') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('facebook_id') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('facebook_id') ? ' is-invalid' : '' }}"
                                                name="facebook_id" id="input-contact_person" type="text"
                                                placeholder="{{ __('FaceBook Id') }}"
                                                value="{{ old('facebook_id', $siteInformation->facebook_id) }}"
                                                 />
                                            @if ($errors->has('facebook_id'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('facebook_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Instagram Id') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('instagram_id') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('instagram_id') ? ' is-invalid' : '' }}"
                                                name="instagram_id" id="input-contact_person" type="text"
                                                placeholder="{{ __('Instagram Id') }}"
                                                value="{{ old('instagram_id', $siteInformation->instagram_id) }}"
                                                 />
                                            @if ($errors->has('instagram_id'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('instagram_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Phone No') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                                            <input
                                                number="true" minlength="10" maxlength="10"
                                                class="form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}"
                                                name="phone_no" id="input-contact_person" type="number"
                                                placeholder="{{ __('Phone No') }}"
                                                value="{{ old('phone_no', $siteInformation->phone_no) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('phone_no'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('phone_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('email_id') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email_id') ? ' is-invalid' : '' }}"
                                                name="email_id" id="input-contact_person" type="text"
                                                placeholder="{{ __('Email') }}"
                                                value="{{ old('email_id', $siteInformation->email_id) }}" required="false"
                                                aria-required="false" />
                                            @if ($errors->has('email_id'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('email_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Latitude') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('lat') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}"
                                                name="lat" id="input-contact_person" type="text"
                                                placeholder="{{ __('Latitude') }}"
                                                value="{{ old('lat', $siteInformation->lat) }}" required="false"
                                                aria-required="false" />
                                            @if ($errors->has('lat'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('lat') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Longitude') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('long') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('long') ? ' is-invalid' : '' }}"
                                                name="long" id="input-contact_person" type="text"
                                                placeholder="{{ __('Longitude') }}"
                                                value="{{ old('long', $siteInformation->long) }}" required="false"
                                                aria-required="false" />
                                            @if ($errors->has('long'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('long') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Working Hours') }}</label>
                                    <div class="col-sm-7">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('working_hours_mon_fri') ? ' has-danger' : '' }}">
                                                    <input
                                                        class="form-control{{ $errors->has('working_hours_mon_fri') ? ' is-invalid' : '' }}"
                                                        name="working_hours_mon_fri" id="input-contact_person" type="text"
                                                        placeholder="{{ __('Monday - Friday') }}"
                                                        value="{{ old('working_hours_mon_fri', $siteInformation->working_hours_mon_fri) }}" required="false"
                                                        aria-required="false" />
                                                    @if ($errors->has('working_hours_mon_fri'))
                                                        <span id="name-error" class="error text-danger"
                                                            for="input-contact_person">{{ $errors->first('working_hours_mon_fri') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('working_hours_sat') ? ' has-danger' : '' }}">
                                                    <input
                                                        class="form-control{{ $errors->has('working_hours_sat') ? ' is-invalid' : '' }}"
                                                        name="working_hours_sat" id="input-contact_person" type="text"
                                                        placeholder="{{ __('Saturday') }}"
                                                        value="{{ old('working_hours_sat', $siteInformation->working_hours_sat) }}" required="false"
                                                        aria-required="false" />
                                                    @if ($errors->has('working_hours_sat'))
                                                        <span id="name-error" class="error text-danger"
                                                            for="input-contact_person">{{ $errors->first('working_hours_sat') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group{{ $errors->has('working_hours_sun') ? ' has-danger' : '' }}">
                                                    <input
                                                        class="form-control{{ $errors->has('working_hours_sun') ? ' is-invalid' : '' }}"
                                                        name="working_hours_sun" id="input-contact_person" type="text"
                                                        placeholder="{{ __('Sunday') }}"
                                                        value="{{ old('working_hours_sun', $siteInformation->working_hours_sun) }}" required="false"
                                                        aria-required="false" />
                                                    @if ($errors->has('working_hours_sun'))
                                                        <span id="name-error" class="error text-danger"
                                                            for="input-contact_person">{{ $errors->first('working_hours_sun') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
