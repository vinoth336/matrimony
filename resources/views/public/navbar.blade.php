<nav class="primary-menu sub-title">
    <ul class="menu-container">


        @if(auth()->guard('member')->check())
            <li class="menu-item">
                <a class="menu-link" href="{{ route('public.index') }}">
                    <div>Home</div>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="{{ route('member.shortlisted_profiles') }}">
                    <div>My ShortList</div>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="{{ route('member.interest_received') }}">
                    <div>Response Received</div>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="{{ route('member.interested_profiles') }}">
                    <div>Interest Request</div>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="{{ route('member.viewed_profile') }}">
                    <div>Profile Viewed</div>
                </a>
            </li>
            <li class="menu-item sub-menu">
                <a class="menu-link">
                    <div>Account</div>
                </a>
                <form id="logout-form" action="{{ route('public.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <ul class="sub-menu-container">
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.profile') }}">
                            <div>My Profile</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href=""
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
            </li>
        @else
            <li class="menu-item">
            <a class="menu-link" href="{{ route('public.index') }}">
                    <div>Home</div>
                </a>
            </li>

            <li class="menu-item mega-menu">
                <a class="menu-link" href="/#success_stories">
                    <div>Our Success Stories</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="/#faqs">
                    <div>Faqs</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="/#contact_us">
                    <div>Contact Us</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="{{ route('public.login') }}">
                        <div>Login</div>
                    </a>
                </li>
        @endif
    </ul>
</nav>
