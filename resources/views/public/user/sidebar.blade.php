<div class="w-100 line d-block d-md-none d-none d-sm-block"></div>
<div class="col-md-3 right_side_bar_fixed" id="">
    <div class="title title-border" style="margin-top:2rem !important">
        <div class="row">
            <div class="col-md-5 bg-info text-white" style="margin-left:7%;height: 100px">
                <a class="text-white" href="{{ route('member.interest_received') }}" >
                <h2 style="line-height: 0.5;margin-top: 17px;margin-bottom: 10px;" class="text-white">
                    {{ $member->interest_received()->where('request_status', PROFILE_REQUEST_PENDING)->count() }}</h2>
                    Response Received
                </a>
            </div>
            <div class="col-md-5 bg-warning text-white " style="height: 100px;margin-left:5px">
                <a class="text-white" href="{{ route('member.who_viewed_you') }}" >
                    <h2 style="line-height: 0.5;margin-top: 17px;margin-bottom: 10px;" class="text-white">
                        {{ $member->member_profile_viewed()->count() }}
                    </h2>
                    Viewed Your Profile
                </a>
            </div>
        </div>
    </div>
    <div class="fancy-title title-border" style="margin-top:2rem !important">
        <h4>Quick Action</h4>
    </div>
    <ul class="sidenav ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
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
            <a>
                <i class="icon-facebook-messenger"></i>Send Message To Admin
            </a>
        </li>
    </ul>
</div>
