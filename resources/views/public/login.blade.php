@extends('public.app')
@section('content')

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                @if (session('status'))
                    <br>
                    <h4 class=" text-success text-center">
                        {{ session('status') }}
                    </h4>
                @endif
                <div class="row">

                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="well well-lg mb-0">

                            <form id="login-form" name="login-form" class="row" action="{{ route('public.login') }}"
                                method="post">
                                @csrf
                                <div class="col-12">
                                    <h3>Login to your Account</h3>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="login-form-username">Username:</label>
                                    <input type="text" id="login-form-username" name="username" value=""
                                        class="form-control" />
                                    <span class="text-danger">
                                        @error('username')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="login-form-password">Password:</label>
                                    <input type="password" id="login-form-password" name="password" value=""
                                        class="form-control" />
                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-12 form-group">
                                    <button type="submit" class="btn btn-secondary m-0" id="login-form-submit" name="submit"
                                        value="login">Login</button>
                                    <a href="#" class="float-right">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
