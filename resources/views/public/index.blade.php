@extends('public.app')
@section('content')
    <?php
    $enquiry_form_class = 'form-group row';
    //$services = $servicesForEnquiries;
    ?>

    <style>
        .btn-light {
            background: #fff !important;
        }
        .bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover
        {
            color: #495057 !important;
        }
    </style>

    <section id="slider" class=""
        style="background-image: url('{{ $siteInformation->site_background_image ? asset("/site/images/site_background/" . $siteInformation->site_background_image) : asset('/site/images/site_images/bg.jpg') }}');background-repeat: no-repeat;background-size: cover;">
        <div class="container clearfix">
            <div class="row">
                <div class="col-lg-6 ">

                </div>
                <div class="col-lg-6">
                    <div class="">
                        <div class="">
                            @if (session('status'))

                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>

                        @endif
                            <form style="margin-top: 50px;background: #f5f8f9; padding:20px;border: 1px solid #ddd"
                                action="{{ route('public.register') }}" id="myform" method="post">
                                @csrf
                                @method('post')


                                <div class="form-group ">
                                    <div class=" text-white  bg-danger p-3 text-center ">
                                        Registration Form
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4 col-sm-4" for="first_name">
                                        First name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" class="form-control"  required name="first_name" placeholder="First name"
                                            value="{{ old('first_name') }}">
                                        <span id="first_nameMsg" class="error">
                                            @error('first_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="last_name">
                                        Last name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" class="form-control"  required name="last_name" placeholder="Last name"
                                            value="{{ old('last_name') }}">
                                        <span id="last_nameMsg" class="error">
                                            @error('last_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="dob">
                                        Date of birth
                                        <span class="text-danger">*</span><br>
                                        (DD-MM-YYYY)
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" class="form-control datepicker" autocomplete="off" data-provide="datepicker" name="dob" id="dob"
                                            value="{{ old('dob') }}" placeholder="DD-MM-YYYY">
                                        <span id="dobMsg" class="error">
                                            @error('dob')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="rasi">
                                        Rasi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control" name="rasi" id="rasi" required>
                                            <option value="">Select Rasi</option>
                                            @foreach ($rasies as $rasi )
                                                <option value="{{ $rasi->id }}" @if(old('rasi') == $rasi->id) selected @endif>
                                                    {{ $rasi->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('rasi')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="dob">
                                        Star
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control" name="star" id="star" required>
                                            <option value="">Select Star</option>
                                            @foreach ($stars as $star )
                                                <option value="{{ $star->id }}" @if(old('star') == $star->id) selected @endif>
                                                    {{ $star->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="dobMsg" class="error">
                                            @error('star')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="dhosam">
                                        Doshams
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control" name="dhosam[]" id="dhosam" multiple >
                                            @foreach($dhosams as $dhosam)
                                                <option value="{{ $dhosam->id }}" @if(in_array($dhosam->id, old('dhosam', [])))
                                                    selected @endif >{{ $dhosam->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dosham')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="gender">
                                        Gender
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="2" @if(old('gender') == 2) checked @endif>&nbsp; &nbsp; Female
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="1" @if(old('gender') == 1) checked @endif>&nbsp; &nbsp; Male
                                    </label>
                                    <br>
                                    <span id="genderMsg" class="error">
                                        @error('gender')
                                                {{ $message }}
                                            @enderror
                                    </span>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="religion">
                                        Religion
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control"  required name="religion" id="religion">
                                            <option value="1" selected>Hindu</option>
                                        </select>
                                        <span id="religionMsg" class="error">
                                            @error('religion')
                                                    {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="mother_tongue">
                                        Mother Tongue
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control"  required name="mother_tongue" id="mother_tongue">
                                            <option value="1" @if(old('mother_tongue') == 1) selected @endif>Tamil</option>
                                            <option value="2" @if(old('mother_tongue') == 2) selected @endif>Telugu</option>
                                        </select>
                                        <span id="mother_tongueMsg" class="error">
                                            @error('mother_tongue')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="email">
                                        Email
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            value="{{ old('email') }}">
                                        <span id="emailMsg" class="error">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="phone_no">
                                        State
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control" name="state" id="state" required>
                                            <option value="" selected>Select State</option>
                                            @foreach ($states as $state )
                                                <option value="{{ $state->id }}" @if(old('state') == $state->id) selected @endif>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="name-error" class="error text-danger"
                                              for="input-state">
                                            @error('state')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="city">
                                        City
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class="selectpicker select form-control" name="city" id="city" required>
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city )
                                                <option value="{{ $city->id }}" @if(old('city') == $city->id) selected @endif>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="name-error" class="error text-danger"
                                              for="input-city">
                                            @error('city')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="pincode">
                                        Pincode
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input
                                            class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}"
                                            name="pincode" id="pincode" type="number"
                                            placeholder="{{ __('Pin Code') }}"
                                            value="{{ old('pincode') }}" data-required="true"
                                            aria-data-required="true" />
                                            <span id="name-error" class="error text-danger"
                                                  for="input-pincode">
                                                @error('pincode')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="phone_no">
                                        Mobile No
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="number" class="form-control"  required placeholder="Mobile No" name="phone_no"
                                               value="{{ old('phone_no') }}">
                                        <span id="phone_no_msg" class="error">
                                            @error('phone_no')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="passwords">
                                        Password
                                        <span class="text-danger">*</span>
                                        <br>
                                        <i style="font-size: 9px">(Min 6)</i>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="password" class="form-control"  required placeholder="Password" name="password" min="6">
                                        <span id="passwordsMsg" class="error">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 col-md-4" for="cPassword">
                                        Confirm Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="password" class="form-control"  required placeholder="Confirm Password"
                                            name="confirm_password" min="6">
                                        <span id="confirm_password_msg" class="error">
                                            @error('confirm_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <p>
                                    By Clicking "Sign Up" You agree to {{ $siteInformation->site_name }}
                                    <a href="{{ route('public.terms_and_condition') }}">Terms and Condition</a>
                                </p>
                                <input type="submit" class="btn btn-success btn-block" value="Signup">
                                <input type="hidden" name="prefix" value="template-phone_noform-">
                                <br>
                                <div class="text-center">
                                    Already Existing Customer, Click here for
                                    <a href="{{ route('public.login') }}">Login</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap" style="padding-bottom: 0px;">
            <div class="container clearfix">
                <div class="section header-stick"
                    style="padding-bottom: 0px;margin-bottom:10px;margin-top: 0.3rem !important;">
                    <div class="container clearfix">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="heading-block bottommargin-sm">
                                    <h3>Who We Are</h3>
                                </div>
                                <p class="mb-0 justify-content-center">{{ config('app.name') }}
                                    – Matrimonial Website for Vannar Brides & Grooms.
                                    Our purpose is to build a platform for our community to take advantage of
                                    matrimonial services and lead happy marriage life which has been missing for years.We
                                    are one of the dedicated Matrimony offering online matrimonial services for our
                                    community. Get the support of our user-friendly search features to find a better bride
                                    or groom who matches your preferences.Go ahead! Join with us and begin your happy
                                    journey today.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line" style="margin: 2rem 0;"></div>
            </div>
        </div>
    </section>

    {{--<section id="section-team" class="page-section topmargin">
        <div class="heading-block center">
            <h2>For Registration</h2>
            <span>People who have contributed enormously to our Site.</span>
        </div>
        <div class="container clearfix">
            <div class="row col-mb-50 mb-0">
                <div class="col-lg-6">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Murugesan.jpeg') }}" alt="Murugesan">
                        </div>
                        <div class="team-desc col-sm-6 text-center">
                            <div class="team-title mt-1">
                                <h4>R. Murugesan Yadav</h4>
                                <span>
                                    B.A (Astro) MA.M.PHIL SM.P
                                </span>
                            </div>
                            <div class="team-content">
                                தலைவர் மதுரை மாவட்ட யாதவ முன்னேற்ற நலச் சங்கம்
                            </div>
                            <div class="mt-1">
                                <i class="icon-phone3"></i>
                                <a href="tel:918870346377" class="mx-1">
                                    +918870346377
                                </a>
                            </div>
                            <div class="mt-1">
                                <i class="icon-whatsapp"></i>
                                <a href="https://wa.me/918870346377?text=Hi Sir," class="mx-1">
                                    +918870346377
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Panneerselvam.jpeg') }}" alt="Panneerselvam">
                        </div>
                        <div class="team-desc col-sm-6 text-center">
                            <div class="team-title mt-1">
                                <h4>K. Panneerselvam, M.com</h4>
                                <span>
                                    TNSTC (KUM) Retd
                                </span>
                            </div>
                            <div class="team-content">
                            </div>
                            <div class="mt-1">
                                <i class="icon-phone3"></i>
                                <a href="tel:919442986826" class="mx-1">
                                    +919442986826
                                </a>
                            </div>
                            <div class="mt-1">
                                <i class="icon-whatsapp"></i>
                                <a href="https://wa.me/919442986826?text=Hi Sir," class="mx-1">
                                    +919442986826
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Kannan.jpeg') }}" alt="Kannan">
                        </div>
                        <div class="team-desc col-sm-6 text-center mt-1">
                            <div class="team-title">
                                <h4>J. Kannan, </h4>
                                <span>
                                    B.sc
                                </span>
                            </div>
                            <div class="team-content">
                            </div>
                            <div class="mt-1">
                                <i class="icon-phone3"></i>
                                <a href="tel:918220012717" class="mx-1">
                                    +918220012717
                                </a>
                            </div>
                            <div class="mt-1">
                                <i class="icon-whatsapp"></i>
                                <a href="https://wa.me/918220012717?text=Hi Sir," class="mx-1">
                                    +918220012717
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
        </div>
    </section>--}}

    <section id="content" style="margin-bottom: 30px;display: none">
        <div class="container clearfix" id="success_stories" style="padding-bottom: 0px;">
            <div class="row col-mb-50">
                <div class="col-lg-12">
                    <h4>Our Success Stories</h4>
                    <div class="fslider testimonial" data-animation="slide" data-arrows="false">
                        <div class="flexslider">
                            <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                <div class="slider-wrap"
                                    style="width: 1000%; transition-duration: 0s; transform: translate3d(-247px, 0px, 0px);">

                                    @php
                                        $total_testmonials = $testmonials->count();
                                    @endphp
                                    @foreach ($testmonials as $client)
                                        <div class="slide" data-thumb-alt=""
                                            style="width: 247.984px; margin-right: 0px; float: left; display: block;">
                                            <div class="testi-image">
                                                <a href="#">
                                                    <img src="{{ asset('site/images/avatar/thumbnails/' . $client->client_image) }}"
                                                        alt="{{ $client->client_name }}" draggable="false">
                                                </a>
                                            </div>
                                            <div class="testi-content">
                                                <p>{{ substr($client->comment, 0, 100) }}...</p>
                                                <div class="testi-meta">
                                                    <b>{{ $client->client_name }}</b>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="content" class="d-none" >
        <div class="heading-block center">
            <h2>Faq's</h2>
        </div>
        <div id="contact_us" class="content-wrap page-section pt-0" style="padding-top: 0px" data-onepage-settings="{\"
            offset\":65,\"speed\":\"1250\",\"easing\":\"easeInOutExpo\"}">
            <div class="container clearfix">
                <div class="row col-mb-50 mb-0">
                    <div class="col-lg-12 min-vh-50">
                        <div class="postcontent col-lg-8">
                            <div class="clear"></div>
                            <div id="faqs" class="faqs">
                                @foreach($faqs as $faq)
                                <div class="toggle faq faq-marketplace faq-authors">
                                    <div class="toggle-header">
                                        <div class="toggle-icon">
                                            <i class="toggle-closed icon-question-sign"></i>
                                            <i class="toggle-open icon-question-sign"></i>
                                        </div>
                                        <div class="toggle-title">
                                           {{ $faq->question }}
                                        </div>
                                    </div>
                                    <div class="toggle-content">
                                        <p style="text-align: justify">
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            // bind 'myForm' and provide a simple callback function
            $('#myForm').ajaxForm(function() {
                alert("Thank you for your comment!");
            });

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('site/js/city_state.js') }}"></script>
@endsection
