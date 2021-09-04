@extends('public.app')
@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-2 clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-6 profile_container scrollit" style="min-height:100vh;">
                        <div class="row" style="margin-top: 2rem">
                            <div class="col-12">
                                <a class="btn float-left @if($selected_tab == 'phone_number_request_received') btn-success @endif" href="{{ route('member.phone_number_request_received') }}">
                                    <i class="icon-phone-volume"></i>&nbsp;Request
                                </a>
                                <a class="btn float-right @if($selected_tab == 'phone_number_request_sent') btn-success @endif" href="{{ route('member.phone_number_request_sent') }}">
                                    <i class="icon-phone3"></i>&nbsp;Sent
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            @if($selected_tab == 'phone_number_request_received')
                            <h4 class="w-100 text-center"><br>Phone Number Request Sent By Others</h4>
                            @else
                            <h4 class="w-100 text-center"><br>Phone Number Request Sent By You</h4>
                            @endif
                        </div>
                        <div class="row topmargin-sm">
                            <div class="col-md-12">
                                <ul class="grid-filter style-3 mb-0">
                                    <li class="@if($activeTab == 'waiting_for_response' || $activeTab == null) activeFilter @endif">
                                        <a href="?search=waiting_for_response" >Waiting For Your Response</a>
                                    </li>
                                    <li class="@if($activeTab == 'accepted_profiles') activeFilter @endif">
                                        <a href="?search=accepted_profiles">Accepted Profiles</a>
                                    </li>
                                    <li class="@if($activeTab == 'not_interested_profiles') activeFilter @endif">
                                        <a href="?search=not_interested_profiles">Not Interest</a>
                                    </li>
                                  </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @forelse ($profiles as $profile)
                                        @php
                                            $profileViewInfo = $profile;
                                            $profile = $profile->member;
                                            $requestFrom = 'phone_request_section';
                                            $checkProfileStatus = false;
                                        @endphp
                                    @include('public.user.components.member_profile_summary')
                                    @empty
                                        <h4 class="text-center ml-auto mr-auto mt-5">NO RECORD FOUND</h4>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('public.user.sidebar')
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="{{ asset('site/js/matrimony_member.js') }}"></script>

@endsection
