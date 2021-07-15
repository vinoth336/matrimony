@extends('layouts.app', ['activePage' => 'testimonials', 'titlePage' => __('Create testimonials')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('testimonials.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create testimonials') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Member Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('client_name') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}"
                                                name="client_name" id="input-client_name" type="text"
                                                placeholder="{{ __('Members Name') }}" value="{{ old('client_name') }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('client_name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-client_name">{{ $errors->first('client_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Members Image') }}</label>
                                    <div class="col-sm-7">

                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="client_image" accept="image/x-png,image/jpg,image/jpeg" >
                                              </span>
                                              <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                          </div>
                                          @if ($errors->has('client_image'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('client_image') }}</span>
                                          @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Members Comments') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('comment') ? ' has-danger' : '' }}">
                                            <textarea
                                                class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"
                                                name="comment" id="comment" placeholder="{{ __('Members Comments') }}"
                                                required>{{ old('comment') }}</textarea>
                                            @if ($errors->has('comment'))
                                                <span id="comment-error" class="error text-danger"
                                                    for="input-comment">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('testimonials.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
