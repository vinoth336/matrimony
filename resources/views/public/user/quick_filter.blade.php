<div class="col-md-3 d-none d-sm-block fixed">
    <div class="row" style="overflow: auto">
        <div class="col-md-12">
            <div class="fancy-title title-border" style="margin-bottom: 5px;margin-top:0.1rem !important">
                <h3>Filter</h3>
            </div>
            <form method="post" action="{{ route('member.dashboard') }}">
                @csrf
                <div class="row form-group">
                    <label class="col-sm-12 col-form-label font-normal">{{ __('Age') }}</label>
                    <div class="col-sm-5">
                       <select class="selectpicker form-control" name="from_age">
                           @for ($i = 22; $i <= 40; $i++)
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
                                <option value="{{ $i }}" @if($i == old('to_age', request()->input('to_age') ?? 25)) selected @endif)>{{ $i }}</option>
                           @endfor
                        </select>
                     </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6" style="padding-left: 0px">
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
                    <div class="col-sm-6"  style="padding-right: 0px">
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
                                $selectedDhosam = request()->has('dhosams') ? request()->input('dhosams') : [1];
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
    </div>
</div>
