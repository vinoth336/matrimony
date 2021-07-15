@extends('layouts.app', ['activePage' => 'testimonials', 'titlePage' => __('Create testimonials')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('testimonials.update', $testimonial->id) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create Testimonials') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Client Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}"
                                                name="client_name" id="input-client_name" type="text"
                                                placeholder="{{ __('client_name') }}" value="{{ old('client_name', $testimonial->client_name) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('client_name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-client_name">{{ $errors->first('client_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Client Image') }}</label>
                                    <div class="col-sm-7">

                                        <div class="fileinput @if(!$testimonial->client_image) fileinput-new @else fileinput-exists @endif text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') . "/img/image_placeholder.jpg" }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <img src="{{ asset('site/images/avatar/' . $testimonial->client_image ) }}" />
                                            </div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="hidden" name="remove_client_logo" value="" />
                                                <input type="file" name="client_image" accept="image/x-png,image/jpg,image/jpeg" >
                                              </span>
                                              <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                          </div>
                                          @if ($errors->has('client_image'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-client_name">{{ $errors->first('client_image') }}</span>
                                          @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Client Comments') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('comment') ? ' has-danger' : '' }}">
                                            <textarea
                                                class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"
                                                name="comment" id="comment" placeholder="{{ __('Client Comments') }}"
                                                required>{{ old('comment', $testimonial->comment) }}</textarea>
                                            @if ($errors->has('comment'))
                                                <span id="phone_no-error" class="error text-danger"
                                                    for="input-phone_no">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('testimonials.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("[data-dismiss='fileinput']").on('click', function() {
          $("[name='remove_client_logo']").val(1);
        });
        </script>
@endsection
