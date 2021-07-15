@extends('public.app')
@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-2 clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-6 profile_container scrollit" style="min-height:100vh;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <h2 align="center" style="margin-top:20vh">
                                        Please Contact Admin To Activate Your Account
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('public.user.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
