<?php
  //password reset form

  $page_title="Reset Password";
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
                    <h2 id="register-title">{{ __('Reset Password') }}</h2>
                    <form method="POST" action="/password/reset">
                        {{ csrf_field() }}

                        <input type="hidden" name="reset_token" value="{{ $token }}">
                        <input type="hidden" name="user_id" value="{{$user->user_id}}">

                        <div class="form-group row">
                            <label for="user_password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="user_password" type="password" class="form-control{{ $errors->has('user_password') ? ' is-invalid' : '' }}" name="user_password">
                                <span toggle="#user_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
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
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-md-8 text-right">
                              <button type="submit" class="btn btn-primary bg-pink">
                                  {{ __('Reset Password') }}
                              </button>
                          </div>
                          <div class="col-sm-2">&nbsp;</div>
                        </div>
                    </form>
                </div>
            </div>
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
