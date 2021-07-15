@extends('site.app')

@section('content')

<section id="page-title">
<div class="container clearfix">
<h1>FAQs</h1>
<span>All your Questions answered in one place</span>
</div>
</section>

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">

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
                    <div class="toggle-content">{{ $faq->answer }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="sidebar col-lg-4">
            <div class="sidebar-widgets-wrap">
                <div class="container clearfix">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Our Success Stories</h4>
                            <div class="fslider testimonial" data-animation="slide" data-arrows="false">
                                <div class="flexslider">
                                    <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                        <div class="slider-wrap"
                                            style="width: 1000%; transition-duration: 0s; transform: translate3d(-247px, 0px, 0px);">

                                            @php
                                            $total_testmonials = $testmonials->count() ;
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
            </div>
        </div>
    </div>
</div>
</div>
</section>


@endsection
