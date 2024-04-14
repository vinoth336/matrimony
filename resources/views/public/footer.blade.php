
@if(auth()->guard('member')->check() && auth()->user()->phone_number_verified_at)

@include('public.user.mobile_side_filter')
<div id="ofBar" class="d-md-none d-lg-none">
    <div class="ofBar-content" style="height: 40px">
        <button type="button" class="btn mobile_sidebar" data-toggle="modal" data-target="#filter_modal" style="width: 48%">
            Filter&nbsp;
            <i class="icon-filter1"></i>
        </button>
        <button type="button" class="btn mobile_sidebar" data-toggle="modal" data-target="#quickaction_modal" style="width: 48%">
            Quick Actions&nbsp;
            <i class="icon-line-menu"></i>
        </button>
    </div>
</div>
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePassword" >
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('member.update_password') }}">
            @csrf
            @method('PATCH')
        <div class="modal-content ">
            <div class="modal-header">
              <h2 class="modal-title">Change Password</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if(!(auth()->user()->show_change_password_popup ?? false ))
                    <div class="row form-group">
                        <label class="col-sm-12 col-form-label font-normal">{{ __('Old password') }}</label>
                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control" required min="6" maxlength="60" />
                                @if($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                    </div>
                @endif
                    <div class="row form-group">
                        <label class="col-sm-12 col-form-label font-normal">{{ __('New password') }}</label>
                            <div class="col-sm-12">
                                <input type="password" name="new_password" class="form-control" required min="6" maxlength="60" />
                                @if($errors->has('new_password'))
                                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                            @endif
                            </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-12 col-form-label font-normal">{{ __('Confirm password') }}</label>
                            <div class="col-sm-12">
                                <input type="password" name="password_confirm" class="form-control" required min="6" maxlength="60" />
                                @if($errors->has('password_confirm'))
                                    <span class="text-danger">{{ $errors->first('password_confirm') }}</span>
                                @endif
                            </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                <div class="col-lg-12 " style="text-align: right; margin-top:10px">
                    <a href="{{ route('member.dashboard') }}" class="btn btn-danger"  data-dismiss="modal" aria-label="Close">
                    Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                </div>
                </div>
            </div>
        </div><!-- modal-content -->
      </form>
    </div><!-- modal-dialog -->
</div>
@endif


<footer id="footer" class="dark">
    <div id="copyrights">
        <div class="container">
            <div class="row col-mb-30">
                <div class="col-md-6 text-center text-md-left">
                    Copyrights &copy; {{ date('Y') }} All Rights Reserved by {{ $siteInformation->site_name }}.<br>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        <a href="https://www.facebook.com/{{-- $siteInformation->facebook_id --}}" class="social-icon si-small si-borderless si-facebook" target="_blank">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/{{-- $siteInformation->instagram_id --}}/" class="social-icon si-small si-borderless si-instagram" target="_blank">
                            <i class="icon-instagram"></i>
                            <i class="icon-instagram"></i>
                        </a>
                        <a href="tel:{{-- $siteInformation->phone_no --}}" class="social-icon si-small si-borderless si-whatsapp">
                            <i class="icon-phone3"></i>
                            <i class="icon-phone3"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

<div id="gotoTop" class="icon-angle-up"></div>

<script src="{{  asset('site/js/plugins.min.js') }}?v={{ $version }}"></script>
<script src="{{  asset('site/js/functions.js') }}?v={{ $version }}"></script>
<script src="{{  asset('site/js/components/bs-filestyle.js') }}?v={{ $version }}"></script>
<script src="{{  asset('site/js/components/bs-select.js') }}?v={{ $version }}"></script>
<script src="{{  asset('site/js/components/selectsplitter.js') }}?v={{ $version }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="module">
    import BugsnagPerformance from '//d2wy8f7a9ursnm.cloudfront.net/v1/bugsnag-performance.min.js'
    BugsnagPerformance.start({ apiKey: '832a20695fd91da69643f9d760e33c40' })
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SV1FZ5L05C"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-SV1FZ5L05C');
</script>
@stack('js')

@if(auth()->guard('member')->check())
@if ($errors->has('password') || $errors->has('new_password') || $errors->has('confirm_password'))
    <script>
        $(document).ready(function(){
            $("#changePasswordModal").modal('show');
        });
    </script>
@elseif(auth()->guard('member')->check())
    @if((auth()->user()->show_change_password_popup ?? false ))
        <script>
            $(document).ready(function(){
                $("#changePasswordModal").modal('show');
            });
        </script>

<script type="text/javascript">
    // Immutable hash state identifiers.
    var closedModalHashStateId = "#modalClosed";
    var openModalHashStateId = "#modalOpen";

    /* Updating the hash state creates a new entry
     * in the web browser's history. The latest entry in the web browser's
     * history is "modal.html#modalClosed". */
    window.location.hash = closedModalHashStateId;

    /* The latest entry in the web browser's history is now "modal.html#modalOpen".
     * The entry before this is "modal.html#modalClosed". */
    $('.mobile_sidebar').on('show.bs.modal', function(e) {
      window.location.hash = openModalHashStateId;
    });

    /* When the user closes the modal using the Twitter Bootstrap UI,
     * we just return to the previous entry in the web
     * browser's history, which is "modal.html#modalClosed". This is the same thing
     * that happens when the user clicks the web browser's back button. */
    $('.mobile_sidebar').on('hide.bs.modal', function(e) {
      window.history.back();
    });
  </script>
    @endif
@endif

@if(session()->get("password_update_successfully") ?? false )
    <script>
        alert("Password Updated Successfully");
    </script>
@endif

@endif



<!--
<a class="hide" href="https://wa.me/91{{-- $siteInformation->phone_no --}}?text=Hi Marriedly," class="float" target="_blank">
<i class="fa icon-whatsapp my-float"></i>
</a>
-->
</body>
</html>
