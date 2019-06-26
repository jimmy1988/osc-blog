<?php

  $page_title="Reset Password";
?>

@extends('backend.templates.admin_template')

@section('section')
<div class="container content-wrapper-extended">
    <div class="row justify-content-center">
        <div class="col-sm-2">&nbsp;</div>
        <div class="col-sm-8">
            <div class="card">
              <div class="card-header bg-pink"><img alt="Open Study College Logo Large" src="/backend/images/svg_osc_logo.svg" width="100%" /></div>
                <div class="card-body">
                  <h2 id="register-title">{{ __('Reset Password') }}</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="user_email" type="email" class="form-control" name="user_email" value="{{ old('user_email') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                          <div class="col-sm-2">&nbsp;</div>
                            <div class="col-md-8 text-right">
                              <a href="/login" class="btn btn-link color-pink" id="backToLogin">Back to Login</a>
                              <button type="submit" class="btn btn-primary bg-pink">
                                  {{ __('Send Password Reset Link') }}
                              </button>
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2">&nbsp;</div>
    </div>
</div>
@endsection
