@extends('public.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Material Dashboard')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <div class="card card-login card-hidden mb-3">
            <div class="card-header card-header-primary text-center">
              <p class="card-title"><strong>{{ __('Email Already Verified') }}</strong></p>
            </div>
            <div class="card-body">
              <p class="card-description text-center"></p>
              <p>
                   Please Use This Link To
                   <a href="{{ route('public.login') }}">Login</a>
              </p>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection
