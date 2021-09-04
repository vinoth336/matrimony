@extends('layouts.app', ['activePage' => 'Product Images', 'titlePage' => __('Create Product')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('member.import_member') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Import Member List') }}</h4>
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
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <label class="col-form-label">{{ __('Import') }}</label>
                                            <input name="member_list"  type="file" />
                                            @if ($errors->has('member_list'))
                                                <span id="member_list-error" class="error text-danger"
                                                    for="input-member_list">{{ $errors->first('member_list') }}</span>
                                            @endif
                                        </div>
                                        <div class="text-center" style="margin-top: 10px">
                                            <a href="{{ asset('admin/sample_profile_import.xlsx') }}" target="_blank">
                                                Sample File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('admin.member.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
