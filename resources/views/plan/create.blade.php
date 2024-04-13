@extends('layouts.app', ['activePage' => 'plan', 'titlePage' => __('Create Plan')])

@section('content')
    <style>
        .hide {
            display: none;
        }

        .access_limit_input {
            width: 80px;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('admin.plan.store') }}" autocomplete="off"
                          class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create Plan') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Plan Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('plan_code') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('plan_code') ? ' is-invalid' : '' }}"
                                                   name="plan_name" id="input-contact_person" type="text"
                                                   placeholder="{{ __('Plan Name') }}"
                                                   value="{{ old('plan_code') }}" required="true"
                                                   aria-required="true" />
                                            @if ($errors->has('plan_code'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-contact_person">{{ $errors->first('plan_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Plan Code') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('plan_code') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('plan_code') ? ' is-invalid' : '' }}"
                                                   name="plan_code" id="input-contact_person" type="text"
                                                   placeholder="{{ __('Plan Code') }}"
                                                   value="{{ old('plan_code') }}" required="true"
                                                   aria-required="true" />
                                            @if ($errors->has('plan_code'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-contact_person">{{ $errors->first('plan_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                   name="price" id="input-contact_person" type="number"
                                                   placeholder="{{ __('Price') }}"
                                                   value="{{ old('price') }}"
                                                   aria-required="true" />
                                            @if ($errors->has('price'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-contact_person">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Offer Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('offer_price') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('offer_price') ? ' is-invalid' : '' }}"
                                                   name="offer_price" id="input-contact_person" type="text"
                                                   placeholder="{{ __('Plan Code') }}"
                                                   value="{{ old('offer_price') }}"
                                                   aria-required="true" />
                                            @if ($errors->has('offer_price'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-contact_person">{{ $errors->first('offer_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Offer End At') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('offer_end_at') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('offer_end_at') ? ' is-invalid' : '' }}"
                                                       name="offer_end_at" id="input-contact_person" type="text"
                                                       placeholder="{{ __('Offer End At') }}"
                                                       value="{{ old('offer_end_at') }}"
                                                       aria-required="true" />
                                                @if ($errors->has('offer_end_at'))
                                                    <span id="name-error" class="error text-danger"
                                                          for="input-contact_person">{{ $errors->first('offer_end_at') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Is Active') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('is_active') ? ' has-danger' : '' }}">
                                                <select name="is_active">
                                                    <option value="0">In-Active</option>
                                                    <option value="1" @selected(1 == old('is_active', 1))>In-Active</option>
                                                </select>
                                                @if ($errors->has('is_active'))
                                                    <span id="name-error" class="error text-danger"
                                                          for="input-contact_person">{{ $errors->first('is_active') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Duration') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('duration') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                                       name="duration" id="input-contact_person" type="number"
                                                       placeholder="{{ __('Duration') }}"
                                                       value="{{ old('duration') }}"
                                                       aria-required="true" />
                                                @if ($errors->has('duration'))
                                                    <span id="name-error" class="error text-danger"
                                                          for="input-contact_person">{{ $errors->first('duration') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Permission / Access') }}</label>
                                        <div class="col-sm-10">
                                            <div class="row form-group{{ $errors->has('is_active') ? ' has-danger' : '' }}">
                                                @foreach(config('plan_access') as $access => $accessDetail)

                                                <div class="col-sm-4">
                                                    <label >{{ $accessDetail['name'] }}</label><br>
                                                    <div class="access_limit_container" style="height: 80px">
                                                    @if($accessDetail['field_type'] == 'boolean')
                                                        <input type="checkbox" name="access_detail[{{ $access }}]['status']" value="active">
                                                    @endif
                                                    @if($accessDetail['field_type'] == 'boolean_with_limit')
                                                            <input type="checkbox" class="boolean_with_limit" name="access_detail[{{ $access }}]['status']" value="active" />
                                                            <span class="hide access_limit_type" id="access_limit_type_{{ $access }}" style="margin-left: 10px">
                                                                <input type="radio" class="access_limit_type" name="access_detail[{{ $access }}]['limit_type']" value="limit" />&nbsp;Limit
                                                                <input type="radio" class="access_limit_type" name="access_detail[{{ $access }}]['limit_type']" value="unlimit" style="margin-left: 10px" />&nbsp;UnLimit
                                                            </span>
                                                            <div class="hide access_limit" id="access_limit_{{ $access }}">
                                                                <input type="number" class="access_limit_input" name="access_detail[{{ $access }}]['limit']" value="" />
                                                            </div>
                                                    @endif
                                                    </div>
                                                </div>

                                                @endforeach
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
    <script>

        $(document).on('click', ".boolean_with_limit", function() {
            var accessLimitContainer = $(this).parent('.access_limit_container');
            if($(this).is(":checked")) {
                accessLimitContainer.find('.access_limit_type').removeClass('hide');
            } else {
                accessLimitContainer.find('.access_limit_type').addClass('hide');
            }
        })

        $(".access_limit_type").change(function() {
            var accessLimitContainer = $(this).closest('.access_limit_container');
            var accessType = $(this).val();
            if(accessType) {
                console.log(accessType);
                if (accessType == 'limit') {
                    console.log(accessLimitContainer.html());
                    accessLimitContainer.find('.access_limit').removeClass('hide');
                } else {
                    accessLimitContainer.find('.access_limit').addClass('hide');
                }
            }
        })
    </script>
@endsection
