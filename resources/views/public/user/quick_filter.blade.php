<div class="col-md-3 d-none d-sm-block fixed">
    <div class="row" style="overflow: auto">
        <div class="col-md-12">
            <div class="tabs tabs-bb clearfix" id="tab-9">
            <ul class="tab-nav clearfix">
                <li>
                    <a href="#basic_search" >
                      <i class="icon-filter1"></i>
                       Basic Search
                    </a>
                </li>
                <li>
                    <a href="#profile_id_search"  >
                        Profile Id
                    </a>
                </li>
            </ul>
            @if(auth()->user()->isAdminUser())
                <style>
                #basic_search div.row {
                    margin-bottom: 0.3rem;
                }
                </style>
            @endif
                <div class="tab-container">
                    <div class="tab-content " id="basic_search">
                        <form method="get" action="{{ route('member.dashboard') }}">
                            @csrf
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
                                <div class="col-sm-5">
                                <select class="selectpicker form-control" name="from_age">
                                    @for ($i = 20; $i <= 60; $i++)
                                            <option value="{{ $i }}" @if($i == old('from_age', request()->input('from_age') ?? 22)) selected @endif)>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                                <div class="col-sm-2">
                                    To
                                </div>
                                <div class="col-sm-5">
                                    <select class="selectpicker form-control" name="to_age">
                                        @for ($i = 22; $i <= 40; $i++)
                                            <option value="{{ $i }}" @if($i == old('to_age', request()->input('to_age') ?? 40)) selected @endif>{{ $i }}</option>
                                    @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12" style="padding-left: 0px">
                                    <label class="col-sm-12 col-form-label font-normal">{{ __('Rasi') }}</label>
                                    <div class="col-sm-12">
                                        <select class="selectpicker form-control" name="rasies[]" multiple>
                                            @php
                                                $selectedRasies = request()->has('rasies') ? request()->input('rasies') : [];
                                            @endphp
                                        @foreach ($rasies as $rasi )
                                            <option value="{{ $rasi->id }}" @if(in_array($rasi->id, old('rasies', $selectedRasies))) selected @endif>
                                            {{ $rasi->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12" >
                                    <label class="col-sm-12 col-form-label font-normal">{{ __('Star') }}</label>
                                <div class="col-sm-12">
                                    <select class="selectpicker form-control" name="stars[]" multiple>
                                        @php
                                            $selectedStars = request()->has('stars') ? request()->input('stars') : [];
                                        @endphp
                                        @foreach ($stars as $star )
                                            <option value="{{ $star->id }}" @if(in_array($star->id, old('stars', $selectedStars))) selected @endif>
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
                                            <option value="{{ $dhosam->id }}" @if(in_array($dhosam->id, old('dhosams', $selectedDhosam))) selected @endif>
                                                {{ $dhosam->name }}
                                            </option>
                                        @endforeach
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
                                            <option value="{{ $status->id }}" @if(in_array($status->id, $selectedMaritalStatus)) selected @endif>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <a href="{{ route('member.dashboard') }}" class="btn btn-danger">
                                        <i class="icon-refresh"></i>
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-content" id="profile_id_search">
                        <form method="get" action="{{ route('member.search_profile_id') }}">
                            @csrf
                        <div class="row form-group">
                            <label class="col-sm-12 col-form-label font-normal">{{ __('Profile ID') }}</label>
                            <div class="col-sm-12">
                            <input type="text" name="profile_id" class="form-control" value="{{ old('profile_id', request()->input('profile_id')) }}" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-5 ml-auto">
                                <a href="{{ route('member.dashboard') }}" class="btn btn-danger">
                                    <i class="icon-refresh"></i>
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
