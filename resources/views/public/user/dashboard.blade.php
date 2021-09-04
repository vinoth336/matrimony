    @extends('public.app')

@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-2 clearfix">
                <div class="row clearfix">
                    @include('public.user.quick_filter')
                    <div class="col-md-6 profile_container scrollit" style="min-height:100vh">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <br>
                                    <h5 class="px-3" style="text-align: justify">Based on your profile details, following are matched profiles</h5>
                                </div>
                                <div class="row">

                                    @foreach($profiles as $profile)
                                        @include('public.user.components.member_profile_summary')
                                    @endforeach
                                    <div class="col-lg-12">
                                        {{ $profiles->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('public.user.sidebar')
                </div>
            </div>
        </div>
    </section>
@push('js')
<script type="text/javascript" src="{{ asset('site/js/matrimony_member.js') }}"></script>
<script>
    $(document).ready(function(){
        // Setting Pagination Bulma Class
        $('.pagination').addClass("pagination mt-5 pagination-circle justify-content-center");

    });
</script>
@endpush

@endsection
