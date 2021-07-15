@extends('public.app')
@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-2 clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-6 profile_container scrollit" style="min-height:100vh;">
                        <div class="row">
                            <h4 class="text-center px-3"><br>Shortlisted Profiles By You</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach($profiles as $profile)
                                        @php
                                            $profileViewInfo = $profile;
                                            $profile = $profile->member_profile;
                                        @endphp
                                        @include('public.user.components.member_profile_summary')
                                    @endforeach
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
