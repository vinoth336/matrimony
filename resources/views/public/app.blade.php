<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="{{ $siteInformation->site_name }}" />
<meta name="description" content="{{ $siteInformation->meta_description }}" />
<link rel="canonical" href="{{ config('app.url') }}" />
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $siteInformation->site_name }}">
<meta property="og:description" content="{{ $siteInformation->meta_description }}">
<meta property="og:url" content="h{{ config('app.url') }}">
<meta property="og:site_name" content="{{ $siteInformation->site_name }}">
<meta property="article:publisher" content="{{ config('app.url') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:creator" content="{{ __("@") }}{{ str_replace(" ", "",$siteInformation->site_name) }}">
<meta name="twitter:site" content="{{ __("@") }}{{ str_replace(" ", "",$siteInformation->site_name) }}">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&amp;display=swap" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('site/style.css') }}?v={{ $version }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/dark.css') }}?v={{ $version }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('site/css/bootstrap.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('site/css/font-icons.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('site/css/animate.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('site/css/magnific-popup.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('site/css/custom.css') }}?v={{ $version }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/swiper.css') }}?v={{ $version }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/components/bs-filestyle.css') }}?v={{ $version }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('site/css/components/bs-select.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('site/include/rs-plugin/css/settings.css') }}?v={{ $version }}" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{ asset('site/include/rs-plugin/css/layers.css') }}?v={{ $version }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/include/rs-plugin/css/navigation.css') }}?v={{ $version }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{ asset('site/css/left_right_modal_box.css') }}?v={{ $version }}" type="text/css" />
    @stack('css')
    <title>{{ $siteInformation->site_name }}</title>
    <script src="{{  asset('site/js/jquery.js') }}?v={{ $version }}"></script>
    <style>
        .list-groupt {
            border-radius : none;
        }
        .content-wrap {
            padding-top:0px;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body class="stretched">
    <style>
        .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:89px;
	right:22px;
	background-color:#25d366;
	color:#FFF;
	border-radius:50px;
	text-align:center;
    font-size:30px;
	box-shadow: 2px 2px 3px #999;
  z-index:100;
}

.my-float{
	margin-top: 9px;
}
        </style>

	<div id="wrapper" class="clearfix">
        <div id="top-bar">
            <div class="container">
                    <div class="row justify-content-between align-items-center">
                            <div class="col-12">
                                    <p class="mb-0 py-2 text-right text-md-right">
                                         <strong>Call:</strong>
                                            <a href="tel:{{ $siteInformation->phone_no }}">
                                                {{ $siteInformation->phone_no }}
                                            </a>|
                                            <strong>Email:</strong>
                                            <a href="mailto:{{ $siteInformation->email_id }}" class="__cf_email__">
                                                {{ $siteInformation->email_id }}
                                            </a>
                                    </p>
                            </div>
                    </div>
            </div>
        </div>
		<header id="header" class="full-header transparent-header white"  data-sticky-logo-height="70" data-menu-padding="25">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row">

						<div id="logo">
							<a @if(auth()->guard('member')->check()) href="{{ route('member.dashboard') }}" @else href="{{ route('public.index') }}" @endif class="standard-logo"
                                data-dark-logo="{{ asset('site/images/logo/'.$siteInformation->logo) }}">
                                <img src="{{ asset('site/images/logo/'.$siteInformation->logo) }}" style="height: 50px" />
                            </a>
							<a  @if(auth()->guard('member')->check()) href="{{ route('member.dashboard') }}" @else href="{{ route('public.index') }}" @endif class="retina-logo" data-dark-logo="">
                                <p style="width: 100%;">
                                    <img data-sticky="testing" src="{{ asset('site/images/logo/'.$siteInformation->logo) }}" />
                                </p>
                            </a>
						</div>
						<div class="header-misc">
                            @if(auth()->guard('member')->check() && auth()->user()->phone_number_verified_at)
                                <a href="{{ route('member.dashboard') }}">
                                    <i class="icon-home2"></i>
                                </a>
                            @endif
						</div>
						<div id="primary-menu-trigger" class="@if(auth()->guard('member')->check()) d-none d-sm-block @endif">
							<svg class="svg-trigger " viewBox="0 0 100 100">
								<path
									d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
								</path>
								<path d="m 30,50 h 40"></path>
								<path
									d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
								</path>
							</svg>
						</div>

						@include('public.navbar')
					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
        </header>



        @yield('content')

        @include('public.footer')
