@if(!empty($profile))
@php
    $showProfilePhoto = false;
    $profileInterestReceived = $profile->current_user_interest_received()->first();
    $responseStatus = $profileInterestReceived->request_status ?? null;
    $profileInterestRequest = $profile->current_user_interested_profiles()
    ->where('profile_status', PROFILE_INTEREST)->first();
    $requestStatus = $profileInterestRequest->request_status ?? null;
    $isHavingProfilePhoto = $profile->isHavingProfilePhoto();
    $profilePhotoRequestStatus = $profile->profile_photo_request_status()->count() ? $profile->profile_photo_request_status->request_status : null;

    if($responseStatus == PROFILE_REQUEST_APPROVED ||
        $requestStatus == PROFILE_REQUEST_APPROVED || $profile->profilePhotoIsPubliclyVisible() || $profilePhotoRequestStatus == PROFILE_PHONE_NUMBER_APPROVED) {
        $showProfilePhoto = true;
    }
    if($member->isAdminUser()) {
        $showProfilePhoto = true;
        $profileHoroscope = $profile->horoscope ?? optional();
    }
@endphp

<div class="entry event col-12 member_profile ">
    <input type="hidden" name="member_code" value="{{ $profile->member_code }}" />
    <div class="grid-inner row align-items-center no-gutters p-4">
        <div class="col-md-4 mb-md-0 d-none d-lg-block d-md-block">
            <a href="#">
                @if($showProfilePhoto)
                    <img src="{{ $profile->secureProfilePhoto() }}" alt="{{ $profile->fullName }}">
                @else
                    <img src="{{ $profile->getDefaultProfilePhoto() }}" alt="{{ $profile->fullName }}">

                    @if($isHavingProfilePhoto)
                        @if($profilePhotoRequestStatus == PROFILE_PHONE_NUMBER_REQUEST)
                            <button type="button" class="btn btn-success" disabled>
                                Request Rejected
                            </button>
                        @elseif($profilePhotoRequestStatus == PROFILE_PHONE_NUMBER_REJECT)
                            <button type="button" class="btn btn-default" disabled>
                                Request Rejected
                            </button>
                        @elseif($profilePhotoRequestStatus == null)
                            <button type="btn" class="btn btn-success profile_photo_request photo_request_send" >
                                Send Photo Request
                            </button>
                        @endif
                    @endif
                @endif
            </a>
        </div>
        <div class="col-md-8 pl-md-4">
            <div class="entry-title title-xs">
                <h2 style="text-decoration: underline">
                    <a href="{{ route('member.view_profile', $profile->member_code) }}">{{ $profile->fullName }}</a></h2>
                RG{{ $profile->member_code }}
            </div>
            <div class="entry-meta">
                <ul>
                    @php
                        $profileDegrees = $degrees->whereIn('id', $profile->educations->where('degree_id', '!=', DEGREE_OTHERS)->pluck('degree_id'))->pluck('name');
                        $profileDegrees = $profileDegrees->toArray();
                        $otherDegrees = $profile->educations->whereNotNull('remarks')->pluck('remarks')->toArray();
                        $profileDegrees = implode(" , ", array_merge($profileDegrees, $otherDegrees));

                        $profileLocation = $profile->location ?? optional();
                        $profileLocationCity = $profileLocation->city ? $profileLocation->city->name : null;
                        $profileLocationState = $profileLocation->state ? $profileLocation->state->name : null;
                        $profileOccupation = $profile->occupation ?? optional();
                        $memberHoroscope = $profile->horoscope ?? optional();
                        $memberDosham = $profile->doshams()->count() ? $member->doshams()->pluck('dhosams.name')->implode(", ") : null ;

                        $memberAnnualIncome = array_search($profileOccupation->annual_income, ANNUAL_INCOME_RANGE_KEY_VALUE);
                        $annualIncome = ANNUAL_INCOME_RANGE[$memberAnnualIncome] ?? null;
                    @endphp
                    @if($member->isAdminUser())
                        <li>Gender : {{ $profile->genderName }}</li>
                    @endif
                    <li>Age : {{ $profile->age }}</li>
                    <li>Mother Tongue : {{ $profile->mother_tongue->name }}</li>
                    <li>Education : {{ $profileDegrees }}</li>
                    <li>Annual Income : {{ $annualIncome }}</li>
                    <li>Occupation : {{ optional($profile->occupation)->role }}</li>
                    <li>Phone Number :
                        <span class="p-1 share_my_phone_number_container ">
                            {!! showPhoneNumberRequestStatus($profile) !!}
                        </span>
                    </li>
                    <li>
                        <div>
                            <div class="ml-4">
                                <b>Rasi</b>&nbsp;{{ optional($memberHoroscope->star)->name }} |

                                <b>Star</b>&nbsp;{{ optional($memberHoroscope->rasi)->name }} |

                                <b>Doshams</b>&nbsp;{{ $memberDosham }} |

                            </div>

                        </div>

                    </li>
                    @if($profileLocation->city_id)
                        <li><br><i class="icon-map-marker1"></i>
                          {{ $profileLocationCity }}, {{ $profileLocationState }}</li>
                    @endif
                    @if($member->isAdminUser())
                        @if($profileHoroscope->horoscope_image)
                        <li>
                            <a class="text-primary" href="{{ asset('site/images/horoscope/' . $profileHoroscope->horoscope_image ) }}" target="_blank">
                                View Horoscope
                            </a>
                        </li>
                        @endif
                    @endif
                </ul>
            </div>
            <div class="entry-meta">
                @if($checkProfileStatus ?? false)
                    @if($profile->current_user_interest_received()->count() ?? false)
                        @php
                            $profileInterestReceived = $profile->current_user_interest_received()->first();
                            $requestStatus = $profileInterestReceived->request_status ?? null;
                        @endphp
                        @if($requestStatus == PROFILE_REQUEST_PENDING)
                            Waiting For Your Response
                            @php
                                $showInterestAcceptButton = true;
                                $showInterestRejectButton = true;
                                $showBlockButton = false;
                            @endphp
                        @elseif($requestStatus == PROFILE_REQUEST_APPROVED)
                            <b>Interest Accepted</b>
                            @php
                                $showInterestAcceptButton = false;
                                $showInterestRejectButton = false;
                                $showBlockButton = false;
                            @endphp
                        @endif
                    @elseif($profile->current_user_interested_profiles()->count() ?? false)
                            @php
                                $profileInterestRequest = $profile->current_user_interested_profiles()->first();
                                $requestStatus = $profileInterestRequest->request_status ?? null;
                                $profileStatus = $profileInterestRequest->profile_status ?? null;
                            @endphp
                            @if($requestStatus == PROFILE_REQUEST_APPROVED && $profileStatus == PROFILE_INTEREST)
                                Your Request Accepted
                                @php
                                    $showInterestRejectButton = false;
                                @endphp
                            @elseif($requestStatus == PROFILE_REQUEST_PENDING && $profileStatus == PROFILE_INTEREST)
                                Waiting for <b>{{ $profile->fullName }}</b> To Accept
                                @php
                                    $showSendInterestButton = false;
                                    $showIgnoreButton = false;
                                    $showDeleteRequest = true;
                                @endphp
                            @elseif($profileStatus == PROFILE_SHORTLIST)
                                @php
                                    $showSendInterestButton = true;
                                    $showIgnoreButton = true;
                                    $showDeleteFromShortList = true;
                                @endphp
                            @elseif($profileStatus == PROFILE_IGNORED)
                                @php
                                    $showShortListButton = true;
                                    $showSendInterestButton = true;
                                    $showDeleteFromIgnoreList = true;
                                @endphp
                            @endif
                    @else
                            @php
                                $showShortListButton = true;
                                $showSendInterestButton = true;
                                $showIgnoreButton = true;
                            @endphp
                    @endif
                @endif
                {{-- This Section For Phone Request Section --}}
                @if($requestFrom ?? false)
                  @if($requestFrom == 'phone_request_section')
                    @if($profile->phone_number_request_status && $profile->phone_number_request_status->request_status == PROFILE_PHONE_NUMBER_REQUEST)
                        @php
                            $showPhoneNumberRequestAcceptButton = true;
                        @endphp
                    @endif
                    @if($profile->phone_number_request_status && $profile->phone_number_request_status->request_status != PROFILE_PHONE_NUMBER_REJECT)
                        @php
                            $showPhoneNumberRequestRejectButton = true;
                        @endphp
                    @endif
                    @if($profile->phone_number_request_status && $profile->phone_number_request_status->request_status == PROFILE_PHONE_NUMBER_REJECT)
                        @php
                            $showPhoneNumberRequestAcceptButton = true;
                        @endphp
                    @endif
                  @endif
                @endif
                {{-- This Section For Phone Request Section Ended --}}
            </div>
            <div class="entry-content">
                @if($showCreatedOn ?? false)
                <h6 class="text font-italic font-normal float-right text-dark" style="margin-bottom:  0px">
                    <i class="icon-time text-success"></i> {{ $profileViewInfo->created_at }}
                </h6>
                <br>
            @endif
                    @if($member->isAdminUser())
                        <a class="btn btn-success" href="whatsapp://send?text={{ whatsappShareContent($profile) }}"
                           data-action="share/whatsapp/share"
                           target="_blank">
                            <i class="icon-whatsapp"></i>
                            Share to whatsapp
                        </a>
            @elseif($requestFrom ?? false)
                @if($showPhoneNumberRequestAcceptButton ?? false)
                    <button type="button" class="btn btn-success accept_phone_number_request">
                        Accept Request
                    </button>
                @endif

                @if($showPhoneNumberRequestRejectButton ?? false)
                    <button type="button" class="btn btn-danger reject_phone_number_request">
                        Reject Request
                    </button>
                @endif
            @else
                @if($showInterestAcceptButton ?? false)
                    <button type="button" class="btn btn-success btn-sm mb-1 accept_profile_interest">
                        <i class="icon-line-check"></i>&nbsp;Accept
                    </button>
                @endif
                @if($showInterestRejectButton ?? false)
                    <button type="button" class="btn btn-danger btn-sm mb-1 not_interest">
                        <i class="icon-line-cross"></i>&nbsp;Not Interest
                    </button>
                @endif
                @if($showDeleteRequest ?? false)
                    <button type="button" class="btn btn-danger btn-sm mb-1 delete_my_request">
                        <i class="icon-line-cross"></i>&nbsp;Delete My Request
                    </button>
                @endif
                @if($showShortListButton ?? false)
                    <button type="button" class="btn btn-info btn-sm mb-1 add_profile_to_shortlist">
                        <i class="icon-star3"></i>&nbsp;Add To Shortlist
                    </button>
                @endif
                @if($showSendInterestButton ?? false)
                    <button type="button" class="btn btn-success btn-sm mb-1 send_interest">
                        <i class="icon-hand-holding-heart"></i>&nbsp;Send Interest
                    </button>
                @endif
                @if($showIgnoreButton ?? false)
                    <button type="button" class="btn btn-danger btn-sm mb-1 add_profile_to_ignore_list">
                        <i class="icon-forbidden"></i>&nbsp;Ignore
                    </button>
                @endif
                @if($showDeleteFromIgnoreList ?? false)
                    <button type="button" class="btn btn-danger btn-sm mb-1 remove_from_ignore_list">
                        <i class="icon-line-cross"></i>&nbsp;Remove From Ignore List
                    </button>
                @endif
                @if($showDeleteFromShortList ?? false)
                    <button type="button" class="btn btn-danger btn-sm mb-1 remove_from_short_list">
                        <i class="icon-line-cross"></i>&nbsp;Remove From Short List
                    </button>
                @endif
                @if($showBlockButton ?? false)
                    <button type="button" class="btn btn-warning btn-sm mb-1 block_profile text-white">
                        <i class="icon-line-ban"></i>&nbsp;Block Profile
                    </button>
                @endif
            @endif
            </div>
        </div>
    </div>
</div>
@endif
