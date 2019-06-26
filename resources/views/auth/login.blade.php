<?php
  $page_title="Login";
?>

@extends('backend.templates.admin_template')

@section('section')

  <div class="container content-wrapper-extended">
      <div class="row">
        <div class="col-md-2">&nbsp;</div>
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header bg-pink"><img alt="Open Study College Logo Large" src="/backend/images/svg_osc_logo.svg" width="100%" /></div>
                  <div class="card-body">
                    <h2 id="register-title">{{ __('Login') }}</h2>
                      <form method="POST" action="{{ route('login') }}">
                          {{ csrf_field() }}

                          <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                              <div class="col-md-6">
                                  <input id="user_email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="user_email" value="" autocomplete="false" required autofocus>

                                  @if ($errors->has('user_email'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('user_email') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                              <div class="col-md-6">
                                  <input id="user_password" type="password" value="" autocomplete="false" class=" form-control{{ $errors->has('user_password') ? ' is-invalid' : '' }}" name="user_password" required>
                                  <span toggle="#user_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                  @if ($errors->has('user_password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('user_password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-sm-2">
                              &nbsp;
                            </div>
                              <div class="col-sm-8 text-right">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                      <label class="form-check-label" for="remember">
                                          {{ __('Remember Me') }}
                                      </label>
                                  </div>
                              </div>
                              <div class="col-sm-2">
                                &nbsp;
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                            <div class="col-sm-2">
                              &nbsp;
                            </div>
                              <div class="col-sm-8 text-right">

                                  @if (Route::has('password.request'))
                                      <a class="btn btn-link color-pink" id="forgotPasswordLink" href="{{ route('password.request') }}">
                                          {{ __('Forgot Your Password?') }}
                                      </a>
                                  @endif

                                  <button type="submit" class="btn btn-primary bg-pink">
                                      {{ __('Login') }}
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
