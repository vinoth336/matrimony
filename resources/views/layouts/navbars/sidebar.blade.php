@php
 $subPage = $subPage ?? null;
@endphp

<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      {{ __('Rajus Group') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ $activePage == 'member' ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true" href="#">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Member') }}</p>
        </a>
        <div class="collapse show" id="laravelExample">
            <ul class="nav">
                <li class="nav-item {{ $activePage == 'profile' && $titlePage == 'Members' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.member.index') }}">
                        <span class="sidebar-mini"> UP </span>
                        <span class="sidebar-normal">{{ __('View Members List') }} </span>
                    </a>
                </li>
              <li class="nav-item {{ $activePage == 'profile' && $titlePage == 'Create Member' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.member.add') }}">
                  <span class="sidebar-mini"> UP </span>
                  <span class="sidebar-normal">{{ __('Add Profile') }} </span>
                </a>
              </li>
            </ul>
          </div>
      </li>
      <li class="nav-item{{ $activePage == 'site_information' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('site_information.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Site Information') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'testimonials' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('testimonials.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Success Stories') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'enquiries' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('enquiries.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Enquiries') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'faqs' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('faqs.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Faq\'s') }}</p>
        </a>
      </li>

    </ul>
  </div>
</div>
