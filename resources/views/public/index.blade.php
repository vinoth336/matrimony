@extends('public.app')
@section('content')
    <?php
    $enquiry_form_class = 'form-group row';
    //$services = $servicesForEnquiries;
    ?>
    <section id="slider" class=""
        style="background-image: url('{{ asset('/site/images/site_images/bg2.jpg') }}');background-repeat: no-repeat;background-size: cover;height: 80vh">

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
                                    – Matrimonial Website for Yadava Brides & Grooms.
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

    <section id="section-team" class="page-section topmargin">
        <div class="heading-block center">
            <h2>For Registration</h2>
            <span>People who have contributed enormously to our Site.</span>
        </div>
        <div class="container clearfix">
            <div class="row col-mb-50 mb-0">
                <div class="col-lg-4">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Panneerselvam.jpeg') }}" alt="Panneerselvam">
                        </div>
                        <div class="team-desc col-sm-6">
                            <div class="team-title">
                                <h4>Panneerselvam</h4>
                            </div>
                            <div class="team-content">
                            </div>
                            <a href="#" class="social-icon si-rounded si-small si-facebook">
                                <i class="icon-phone3"></i>
                                <i class="icon-phone3"></i>
                            </a>
                            <a href="#" class="social-icon si-rounded si-small si-twitter">
                                <i class="icon-whatsapp"></i>
                                <i class="icon-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Kannan.jpeg') }}" alt="Kannan">
                        </div>
                        <div class="team-desc col-sm-6">
                            <div class="team-title">
                                <h4>Kannan</h4>
                            </div>
                            <div class="team-content">
                            </div>
                            <a href="#" class="social-icon si-rounded si-small si-facebook">
                                <i class="icon-phone3"></i>
                                <i class="icon-phone3"></i>
                            </a>
                            <a href="#" class="social-icon si-rounded si-small si-twitter">
                                <i class="icon-whatsapp"></i>
                                <i class="icon-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team team-list row align-items-center">
                        <div class="team-image col-sm-6">
                            <img src="{{ asset('site/images/site_images/Murugesan.jpeg') }}" alt="Murugesan">
                        </div>
                        <div class="team-desc col-sm-6">
                            <div class="team-title">
                                <h4>Murugesan</h4>
                            </div>
                            <div class="team-content">
                            </div>
                            <a href="#" class="social-icon si-rounded si-small si-facebook">
                                <i class="icon-phone3"></i>
                                <i class="icon-phone3"></i>
                            </a>
                            <a href="#" class="social-icon si-rounded si-small si-twitter">
                                <i class="icon-whatsapp"></i>
                                <i class="icon-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>

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

    <section id="content">
        <div class="heading-block center">
            <h2>Contact Us</h2>
            <span>We Welcome Online Enquiry</span>
        </div>
        <div id="contact_us" class="content-wrap page-section pt-0" style="padding-top: 0px" data-onepage-settings="{\"
            offset\":65,\"speed\":\"1250\",\"easing\":\"easeInOutExpo\"}">
            <div class="container clearfix">
                <div class="row align-items-stretch col-mb-50 mb-0">
                    <div class="col-lg-6">
                        <!-- Enquiry Form Start Here -->
                        <?php $enquiry_form_class = 'col-md-4';
                        ?>
                        @include('public.enquiry_form')
                        <!-- Enquiry Form Ended Here -->
                    </div>
                    <!-- Enquiry Form Ended Here -->
                    <div class="col-lg-6 min-vh-50">
                        <div class="card overflow-hidden" style="border:none">
                            <div class="card-body">
                                <h4>Address</h4>
                                <p>
                                    396/4, Ramasamy House,<br>
                                    Andankovil Puthur Keelpagam,<br>
                                    Karur - 639002
                                </p>
                            </div>

                            <div class="card-body">
                                <h4>Opening Hours</h4>
                                <p></p>
                                <ul class="iconlist mb-0">
                                    <li><i class="icon-time color"></i> <strong>Mondays-Fridays:</strong>
                                        {{ $siteInformation->working_hours_mon_fri }}</li>
                                    <li><i class="icon-time color"></i> <strong>Saturdays:</strong>
                                        {{ $siteInformation->working_hours_sat }}</li>
                                    <li><i class="icon-time text-danger"></i> <strong>Sundays:</strong>
                                        {{ $siteInformation->working_hours_sun }}</li>
                                </ul>
                                <i class="icon-time bgicon"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row col-mb-50" id="faqs">
                    <h4>Faq's</h4>
                    <div class="col-lg-12 min-vh-50">
                        <div class="postcontent col-lg-8">
                            <div class="clear"></div>
                            <div id="faqs" class="faqs">
                                @foreach ($faqs as $faq)
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
                <hr>
                <div class="row col-mb-50">
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href="#"><i class="icon-map-marker2"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Get Direction<span class="subtitle">Check In<br>Google Map</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('tel:+91{{ $siteInformation->phone_no }}', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href=""><i class="icon-phone3"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Speak to<br> Us<span class="subtitle"><a style="text-decoration: none;color:#000"
                                            href="tel:+91{{ $siteInformation->phone_no }}"> (+91)
                                            {{ $siteInformation->phone_no }}</a></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('https://www.instagram.com/{{ $siteInformation->instagram_id }}/', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href="#"><i class="icon-instagram"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Follow<br>Us<span class="subtitle">2.3M Followers</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('https://www.facebook.com/{{ $siteInformation->facebook_id }}', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href="#"><i class="icon-facebook2"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Follow<br>Us<span class="subtitle">2.3M Followers</span></h3>
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
@endsection
