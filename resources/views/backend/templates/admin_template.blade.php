{{-- {{ Basic admin template }} --}}

<?php
  //get the date in which the user was verified
  if(isset($user_details->email_verified_at) && !empty($user_details->email_verified_at)){
    $email_verified_at = $user_details->email_verified_at;
  }
?>

{{-- {{ get the top of the document }} --}}
@include('backend.layouts.top')
{{-- {{ Get the header }} --}}
@include('backend.layouts.header')
{{-- {{ If we have a user set and the user is verified then we can get the sidebar }} --}}
@if (Auth::id() > 0 && isset($email_verified_at) && !empty($email_verified_at) && strtotime($email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
  @include('backend.layouts.sidebar')
@endif
{{-- {{ If we have a user set and the user is verified then we can get the title bar }} --}}
@if (Auth::id() > 0 && isset($email_verified_at) && !empty($email_verified_at) && strtotime($email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
  @include('backend.layouts.titlebar')
@endif

{{-- {{ Get the messages template }} --}}
@include('backend.includes.messages')

{{-- {{ If Javascript is not enabled or is undetectable then display this message }} --}}
<noscript>
  <div class="content-wrapper content-padding content-wrapper-extended">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-danger">
          You do not have Javascript enabled in your browser, please go to your browser settings and enable javscript
        </div>
      </div>
    </div>
  </div>
</noscript>

{{-- {{ Get page content }} --}}
@yield('section')

{{-- {{ Get the bottom credits section }} --}}
@include('backend.layouts.credits')
{{-- {{ Get all thescripts that are needed for the page }} --}}
@include('backend.layouts.scripts')
{{-- {{   Get the bottom of the document }} --}}
@include('backend.layouts.bottom')
