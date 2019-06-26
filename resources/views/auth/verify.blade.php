<?php
  $page_title="Verify Email Address";
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
                  <h2 id="register-title">{{ __('Verify Your Email Address') }}</h2>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="/email/resend/{{Auth::id()}}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
