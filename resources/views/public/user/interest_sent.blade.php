@extends('public.app')
@section('content')

    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-2 clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-6 profile_container scrollit" style="min-height:100vh;">
                        <div class="row">
                            <h4 class="text-center px-3"><br>Interest Sent By You</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="grid-filter style-3 mb-0">
                                    <li class="@if($activeTab == 'waiting_for_response' || $activeTab == null) activeFilter @endif">
                                        <a href="?search=waiting_for_response" >Waiting For Response</a>
                                    </li>
                                    <li class="@if($activeTab == 'accepted_profiles') activeFilter @endif">
                                        <a href="?search=accepted_profiles">Request Accepted</a>
                                    </li>
                                    <li class="@if($activeTab == 'not_interested_profiles') activeFilter @endif">
                                        <a href="?search=not_interested_profiles">Request Rejected</a>
                                    </li>
                                  </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @forelse($profiles as $profile)
                                        @php
                                            $profileViewInfo = $profile;
                                            $profile = $profile->member_profile;
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
