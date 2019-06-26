{{-- {{ Frontend Single post template }} --}}

{{-- {{ get the frontend head tags }} --}}
@include('frontend.layouts.top')

{{-- {{ if we have the admin panel then import al the admin components }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")

  {{-- {{ import the admin header if we have a user id }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    @include('backend.layouts.header')
  @endif

  {{-- {{ if we have a user id then import the admin sidebar }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    @include('backend.layouts.sidebar')
  @endif
@endif

{{-- {{ if we have the admin panel flag then we can start opening the tags }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ if we have the user id then we can open the tags }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    <div class="content-wrapper content-padding content-wrapper-extended" style="background-color: unset !important; margin-top:65px;">
      <div class="row">
        <div class="col-xs-12">
  @endif
@endif

{{-- {{ Get the header }} --}}
@include('frontend.layouts.header')

{{-- {{ if we have the admin panel flag then we can start closing the tags }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ if we have a user id close the tags }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
        </div>
      </div>
    </div>
  @endif
@endif

{{-- {{ if we have the admin panel then start to display it }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ if we have user details then we can roduce tags for the admin section }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    <div class="content-wrapper content-padding content-wrapper-extended">
      <div class="row">
        <div class="col-xs-12">
  @endif
@endif

{{-- {{ Get the main section of the page }} --}}
@yield('section')

{{-- {{ close the tags if we have the admin panel }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ close the tags if we have the user details }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
        </div>
      </div>
    </div>
  @endif
@endif

{{-- {{ if the admin panel is not set then we can get the next article section }} --}}
@if (!isset($adminPanel) || empty($adminPanel) || $adminPanel != "true")
  @include('frontend.layouts.nextArticle')
@endif

{{-- {{ if the admin panel is needed we can start producing the tags }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ if we have user details the we can produce the tags }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    <div class="content-wrapper content-padding content-wrapper-extended">
      <div class="row">
        <div class="col-xs-12">
  @endif
@endif

{{-- {{Get the search modal}} --}}
@include('frontend.includes.searchModal')

{{-- {{ if we have the admin panel then produce the admin tags }} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{ Close the admin tags }} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
        </div>
      </div>
    </div>
  @endif
@endif

{{-- {{if we have the admin panel then produce the containing tags}} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{if we have user details then produce the containing tags}} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
    <div class="content-wrapper content-padding content-wrapper-extended">
      <div class="row">
        <div class="col-xs-12">
  @endif
@endif

{{-- {{Get the footer}} --}}
@include('frontend.layouts.footer')

{{-- {{if we have the admin panel then  start closing the tags}} --}}
@if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
  {{-- {{if the user is signed in then fully close the tags}} --}}
  @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
        </div>
      </div>
    </div>
  @endif
@endif

{{-- {{Get all the essential scripts}} --}}
@include('frontend.layouts.scripts')

{{-- {{Close the document}} --}}
@include('frontend.layouts.bottom')
