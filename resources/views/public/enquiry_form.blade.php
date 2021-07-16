@if($errors->count() || session('status'))
<script>
    $(document).ready(function() {
        $([document.documentElement, document.body]).animate({
        scrollTop: $("#enquiry_form_section").offset().top - 300
        }, 200);
    });

</script>
@endif

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

<div class="form-widget1" id="enquiry_form_section">
    <div class="form-result"></div>
<form class="mb-0" action="{{ route('enquiry.store') }}" id="myform" method="post">
    @csrf
    @method('post')
    <div class="form-process">
        <div class="css3-spinner">
            <div class="css3-spinner-scaler"></div>
        </div>
    </div>
    <div class="row">
        <div class="{{ $enquiry_form_class }}  form-group">
            <label for="template-contactform-name">Name <small>*</small></label>
            <input type="text" id="template-contactform-name" name="name" value="{{ old('name') }}"
                class="sm-form-control required" required />
            @if ($errors->has('name'))
                <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="{{ $enquiry_form_class }}  form-group">
            <label for="template-contactform-email">Email <small>*</small></label>
            <input type="email" id="template-contactform-email" name="email" value="{{ old('email') }}"
                class="required email sm-form-control" />
                @if ($errors->has('email'))
                <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="{{ $enquiry_form_class }}  form-group">
            <label for="template-contactform-phone">Phone</label>
            <input type="number" id="template-contactform-phone" name="phone_no" value="{{ old('phone_no') }}"
                class="sm-form-control" required />
                @if ($errors->has('phone_no'))
                <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
            @endif
        </div>
        <div class="w-100"></div>
        <div class="col-md-8 form-group">
            <label for="template-contactform-subject">Subject <small>*</small></label>
            <input type="text" id="template-contactform-subject" name="subject" value="{{ old('subject') }}"
                class="required sm-form-control" required />
                @if ($errors->has('subject'))
                <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('subject') }}</span>
            @endif
        </div>
        <div class="w-100"></div>
        <div class="col-12 form-group">
            <label for="template-contactform-message">Message <small>*</small></label>
            <textarea class="required sm-form-control" id="template-contactform-message" name="message" rows="6"
                cols="30" required>{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('message') }}</span>
            @endif
        </div>
        <div class="col-12 form-group">
            <button name="submit" type="submit" tabindex="5" value="Submit" class="button button-3d m-0">Submit
                Comment</button>
        </div>
    </div>
    <input type="hidden" name="prefix" value="template-contactform-">
</form>
</div>
