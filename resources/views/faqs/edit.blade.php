@extends('layouts.app', ['activePage' => 'Faqs', 'titlePage' => __('Create Faqs')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('faqs.update', $faq->id) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Faqs') }}</h4>

              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Question') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="question" id="input-contact_person" type="text" placeholder="{{ __('Question') }}" value="{{ old('question', $faq->question) }}" required="true" aria-required="true"/>
                      @if ($errors->has('question'))
                        <span id="name-error" class="error text-danger" for="input-contact_person">{{ $errors->first('question') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Answer') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('answer') ? ' has-danger' : '' }}">
                      <textarea class="form-control{{ $errors->has('answer') ? ' is-invalid' : '' }}" name="answer" id="answer" type="email" placeholder="{{ __('Answer') }}" required >{{ old('answer', $faq->answer) }}</textarea>
                      @if ($errors->has('answer'))
                        <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('answer') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <a href="{{ route('faqs.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
@endsection
