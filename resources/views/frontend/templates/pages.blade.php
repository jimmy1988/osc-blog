{{-- {{ Basic template for all basic pages on the frontend }} --}}

{{-- {{ Get the frontend top section for the head tags }} --}}
@include('frontend.layouts.top')

{{-- {{ Mobile menu button }} --}}
<a class="js-togglenav menubtn" href="#"><span></span><span></span><span></span><span></span></a>

{{-- {{ Open the header }} --}}
<section id="feed-header" style="min-height: 480px;">
  <div class="header-container">
      <div id="masthead">
          {{-- {{ Get the top navbar }} --}}
          @include("frontend.layouts.navbarTop")
          {{-- {{ Get the bottom navbar }} --}}
          @include("frontend.layouts.navbarBottom")
      </div><!-- /Masthead -->

      {{-- {{ Dynamicaly generate the thumbnail path }} --}}
      <?php
        $thumbnailPath = "";

        // $pageImage = "searchTop.jpg";

        if(isset($pageImage) && !empty($pageImage)){
          $thumbnailPath = FRONTEND_IMAGES_FOLDER . "/" . $pageImage;
        }else{
          $thumbnailPath = FRONTEND_IMAGES_FOLDER . "/" . "temp.jpg";
        }
      ?>
      <img class="post-thumbnail-large" src="{{$thumbnailPath}}" />
  </div>
</section><!-- /Feed Header -->

{{-- {{ Get the main content of the page }} --}}
@yield('section')

{{-- {{ Get the search model - this is for the ajax search }} --}}
@include('frontend.includes.searchModal')

{{-- {{ Get the footer }} --}}
@include('frontend.layouts.footer')

{{-- {{ Get the scripts }} --}}
@include('frontend.layouts.scripts')

{{-- {{ Get the bottom of the document }} --}}
@include('frontend.layouts.bottom')
