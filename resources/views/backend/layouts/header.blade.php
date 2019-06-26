{{-- {{ Admin Header }} --}}

<div class="container-fluid main-header bg-pink">
  <header class="">
    <!-- Logo -->
    <a href="/admin" class="logo bg-pink">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img alt="Open Study College Logo Large" src="/backend/images/svg_osc_logo_small.png" width="100%" /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img alt="Open Study College Logo Large" src="/backend/images/svg_osc_logo.svg" width="100%" /></span>
    </a>
    <?php
      //get the email verified at date
      if(isset($user_details->email_verified_at) && !empty($user_details->email_verified_at)){
        $email_verified_at = $user_details->email_verified_at;
      }
    ?>

    {{-- {{ If we have a user logged in displayb the admin navbar }} --}}
    @if (Auth::id() > 0 && isset($email_verified_at) && !empty($email_verified_at) && strtotime($email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
      @include('backend.layouts.navbar')
    @endif
  </header>
</div>
