<!-- Modal -->

<div class="modal modal_outer right_modal fade" id="filter_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <form method="get" action="{{ route('member.dashboard') }}">
            @csrf
            <div class="modal-content ">
                <!-- <input type="hidden" name="email_e" value="admin@filmscafe.in"> -->
                <div class="modal-header">
                    <h2 class="modal-title">Filter</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body get_quote_view_modal_body">
                    <div class="" style="overflow: auto">
                        @if($member->isAdminUser())
                            <div class="row form-group">
                                <label class="col-sm-12 col-form-label font-normal">{{ __('Gender') }}</label>
                                <div class="col-sm-12">
                                    <select class="selectpicker form-control" name="gender">
                                        <option value="male" @if(old('gender', request()->input('gender')) == 'male') selected @endif>
                                            Male
                                        </option>
                                        <option value="female" @if(old('gender', request()->input('gender')) == 'female') selected @endif >
                                            Female
                                        </option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Age') }}</label>
                            <div class="col-sm-12">
                                <div style="width: 40%; display: inline-block">
                                    <select class="selectpicker form-control" name="from_age" style="width: 50px">
                                        @for ($i = 20; $i <= 60; $i++)
                                            <option value="{{ $i }}"
                                                    @if($i == old('from_age', request()->input('from_age') ?? 20)) selected @endif)>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="display: inline-block">
                                    To
                                </div>
                                <div style="width: 40%; display: inline-block">

                                    <select class="selectpicker form-control" name="to_age">
                                        @for ($i = 20; $i <= 60; $i++)
                                            <option value="{{ $i }}"
                                                    @if($i == old('to_age', request()->input('to_age') ?? 60)) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6" style="width: 48%">
                                <label class="col-sm-12 col-form-label font-normal">{{ __('Rasi') }}</label>
                                <div class="col-sm-12">
                                    <select class="selectpicker form-control" name="rasies[]" multiple>
                                        @php
                                            $selectedRasies = request()->has('rasies') ? request()->input('rasies') : [];
                                        @endphp
                                        @foreach ($rasies as $rasi )
                                            <option value="{{ $rasi->id }}"
                                                    @if(in_array($rasi->id, old('rasies', $selectedRasies))) selected @endif>
                                                {{ $rasi->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6" style="width: 48%">
                                <label class="col-sm-12 col-form-label font-normal">{{ __('Star') }}</label>
                                <div class="col-sm-12">
                                    <select class="selectpicker form-control" name="stars[]" multiple>
                                        @php
                                            $selectedStars = request()->has('stars') ? request()->input('stars') : [];
                                        @endphp
                                        @foreach ($stars as $star )
                                            <option value="{{ $star->id }}"
                                                    @if(in_array($star->id, old('stars', $selectedStars))) selected @endif>
                                                {{ $star->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Dhosam') }}</label>
                            <div class="col-sm-12">
                                <select class="selectpicker form-control" name="dhosams[]" multiple>
                                    @php
                                        $selectedDhosam = request()->has('dhosams') ? request()->input('dhosams') : [1, 7];
                                    @endphp
                                    @foreach ($dhosams as $dhosam )
                                        <option value="{{ $dhosam->id }}"
                                                @if(in_array($dhosam->id, old('dhosams', $selectedDhosam))) selected @endif>
                                            {{ $dhosam->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Mother Tuge') }}</label>
                            <div class="col-sm-12">
                                <select class="selectpicker form-control" name="mother_tongues[]" multiple>
                                    @php
                                        $selectedMotherTongues = request()->has('mother_tongues') ? request()->input('mother_tongues') : [1];
                                    @endphp
                                    <option value="1" @if(in_array(1, $selectedMotherTongues)) selected @endif>
                                        Tamil
                                    </option>
                                    <option value="2" @if(in_array(2, $selectedMotherTongues)) selected @endif>
                                        Telugu
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Marriedl Status') }}</label>
                            <div class="col-sm-7">
                                <select class="selectpicker form-control" name="marital_status[]" multiple>
                                    @php
                                        $selectedMaritalStatus = request()->has('marital_status') ? request()->input('marital_status') : [1];
                                    @endphp
                                    @foreach ($maritalStatus as $status )
                                        <option value="{{ $status->id }}"
                                                @if(in_array($status->id, $selectedMaritalStatus)) selected @endif>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Profile ID') }}</label>
                            <div class="col-sm-7">
                                <input type="text" name="profile_id" class="form-control"
                                       value="{{ old('profile_id', request()->input('profile_id')) }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 " style="text-align: right; margin-top:10px">
                                <a href="{{ route('member.dashboard') }}" class="btn btn-danger"  id="reset" onclick="Filter.resetFilter()">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div><!-- modal-content -->
        </form>
    </div><!-- modal-dialog -->
</div>


<div class="modal modal_outer right_modal fade" id="quickaction_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <form method="post" id="get_quote_frm">
            <div class="modal-content ">
                <!-- <input type="hidden" name="email_e" value="admin@filmscafe.in"> -->
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px !important">Quick Action</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body get_quote_view_modal_body">
                    <div class="row">
                        <div class="col-md-3 " id="">
                            <div class="title title-border" style="">
                                <div class="row">
                                    <div class="col-md-5 bg-info text-white" style="width: 50%;height: 100px">
                                        <a class="text-white" href="{{ route('member.interest_received') }}">
                                            <h2 style="line-height: 0.5;margin-top: 17px;margin-bottom: 10px;"
                                                class="text-white">
                                                {{ $member->interest_received()->where('request_status', PROFILE_REQUEST_PENDING)->count() }}</h2>
                                            Response Received
                                        </a>
                                    </div>
                                    <div class="col-md-5 bg-warning text-white " style="width: 50%;height: 100px;">
                                        <a class="text-white" href="{{ route('member.who_viewed_you') }}">
                                            <h2 style="line-height: 0.5;margin-top: 17px;margin-bottom: 10px;"
                                                class="text-white">
                                                {{ $member->member_profile_viewed()->count() }}
                                            </h2>
                                            Viewed Your Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <ul class="sidenav ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header topmargin-sm"
                                style="margin-top: 1rem !important">
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.viewed_profile') }}">
                                        <i class="icon-eye"></i>Profile Viewed
                                        <label class="text-info float-right" style="font-size: 18px">
                                            {{ $member->member_viewed_profiles()->count() }}
                                        </label>
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.shortlisted_profiles') }}">
                                        <i class="icon-star3"></i>My ShortList
                                        <label class="text-info float-right" style="font-size: 18px">
                                            {{ $member->shortlisted_profiles()->count() }}
                                        </label>
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.interested_profiles') }}">
                                        <i class="icon-hand-holding-heart"></i>My Interest Request
                                        <label class="text-info float-right" style="font-size: 18px">
                                            {{ $member->interested_profiles()->count() }}

                                        </label>
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.ignored_profiles') }}">
                                        <i class="icon-forbidden"></i>My Ignored List
                                        <label class="text-info float-right" style="font-size: 18px">
                                            {{ $member->ignored_profiles()->count() }}
                                        </label>
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.profile_photo_request_received') }}">
                                        <i class="icon-camera"></i>Profile Photo Request
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.phone_number_request_received') }}">
                                        <i class="icon-phone1"></i>Phone Number Request
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a>
                                        <i class="icon-facebook-messenger"></i>Send Message To Admin
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="{{ route('member.profile') }}">
                                        <i class="icon-user-cog"></i>My Profile
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                                    <a href="Javascript:void(0);"
                                       onclick="Javascript:$('#quickaction_modal').modal('hide');$('#changePasswordModal').modal('show');">
                                        <i class="icon-key1"></i>Change Password
                                    </a>
                                </li>
                                <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab">

                                    <a href=""
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                            class="icon-line2-logout"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- modal-content -->
        </form>
    </div><!-- modal-dialog -->
</div>
@push('js')
    <script>
        $('.modal').on('shown.bs.modal', function (e) {
            window.location.href = '#' + $(this).attr('id');
        });
        $('.modal').on('hidden.bs.modal', function (e) {
            history.pushState('', document.title, window.location.pathname);
        });
        $(window).bind('hashchange', function () {
            if (window.location.hash == '') {
                $('.modal').modal('hide');
            }
        });
    </script>
@endpush
