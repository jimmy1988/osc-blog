{{-- {{ Blog frontend header --}}

{{-- {{ mobile navbar button }} --}}
<a class="js-togglenav menubtn" href="#"><span></span><span></span><span></span><span></span></a>

<section id="feed-header">

<div class="header-container">
    <div id="masthead">

      {{-- {{ if we have the admin flag then get the menu space}} --}}
      @if (isset($adminPanel) && !empty($adminPanel) && $adminPanel == "true")
        @if (Auth::id() > 0 && isset($user_details) && !empty($user_details) && strtotime($user_details->email_verified_at) <= strtotime(date("Y-m-d H:i:s")))
          <div id="menuSpacer">&nbsp;</div>
        @endif
      @else
        {{-- {{ Get the nav bar top }} --}}
        @include('frontend.layouts.navbarTop')
      @endif

      {{-- {{ Get the bottom nav bar }} --}}
      @include('frontend.layouts.navbarBottom')
    </div><!-- /Masthead -->

    @if ((isset($post) && !empty($post)) || (isset($postPreview) && !empty($postPreview)))
      @include('frontend.layouts.articleTop')
    @endif

</div>

  {{-- {{ Get the image }} --}}
  @if (isset($imageTempPath) && !empty($imageTempPath))
    <img class="post-thumbnail-large" src="{{ $imageTempPath }}" />
  @elseif(isset($post['post_banner_image']) && !empty($post['post_banner_image']))
    <img class="post-thumbnail-large" src="{{ $post['post_banner_image'] }}" />
  @else
    {{-- <img class="post-thumbnail-large" src="/all/images/temp.jpg" /> --}}
    <img class="post-thumbnail-large" src="{{STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER . "/" . POST_IMAGES_NO_IMAGE_FILE}}" />
  @endif

</section><!-- /Feed Header -->
