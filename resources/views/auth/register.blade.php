<?php
  $page_title="Register";
?>

@extends('backend.templates.admin_template')

@section('section')
<div class="container content-wrapper-extended">
    <div class="row">
      <div class="col-md-2">&nbsp;</div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-pink">
                  <img alt="Open Study College Logo Large" src="/backend/images/svg_osc_logo.svg" width="100%" />
                </div>
                <div class="card-body">
                  <h2 id="register-title">{{ __('Register') }}</h2>
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="user_first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                            <div class="col-md-6">
                                <input id="user_first_name" type="text" class="form-control{{ $errors->has('user_first_name') ? ' is-invalid' : '' }}" name="user_first_name" value="{{ old('user_first_name') }}" autofocus>

                                @if ($errors->has('user_first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>
                            <div class="col-md-6">
                                <input id="user_surname" type="text" class="form-control{{ $errors->has('user_surname') ? ' is-invalid' : '' }}" name="user_surname" value="{{ old('user_surname') }}">

                                @if ($errors->has('user_surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="user_email" type="email" class="form-control{{ $errors->has('user_email') ? ' is-invalid' : '' }}" name="user_email" value="{{ old('user_email') }}">

                                @if ($errors->has('user_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="user_password" type="password" class="form-control{{ $errors->has('user_password') ? ' is-invalid' : '' }}" name="user_password">
                                <span toggle="#user_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                @if ($errors->has('user_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                          <div class="col-sm-2">
                            &nbsp;
                          </div>
                            <div class="col-md-8 text-right">
                                <button type="submit" class="btn btn-primary bg-pink">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="col-sm-2">
                              &nbsp;
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript" async defer>
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>
@endsection
