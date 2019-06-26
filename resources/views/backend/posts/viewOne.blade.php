{{-- {{ View one single post in a simulated frontend environment with all the backend menus }} --}}

{{-- {{ Import the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')

  {{-- {{ Import the control panel }} --}}
  @include('backend.includes.postControlPanel')

      <div class="content-wrapper content-wrapper-extended previewPostPage">
        <a class="js-togglenav menubtn" href="#"><span></span><span></span><span></span><span></span></a>

        <section id="feed-header">

            <div class="header-container">
                <div id="masthead">

                <!-- Article Intro -->
                <article class="course-otm">
                    <div class="article-meta">
                        <span class="article-date">
                          {{-- {{ Post created date }} --}}
                          @if(isset($postArray->post_created) && !empty($postArray->post_created) && $postArray->post_created != "0000-00-00 00:00:00")
                            {{date("d/m/Y", strtotime($postArray->post_created))}}
                          @else
                            {{date("d/m/Y")}}
                          @endif
                        </span>
                        {{-- {{ Featured Post }} --}}
                        @if (isset($postArray->featured) && !empty($postArray->featured) && $postArray->featured == "1")
                          <span class="featured-post"><i class="ico-featured"></i>&nbsp;Featured Post</span>
                        @endif
                        {{-- {{ Post Category }} --}}
                        <span class="author-name">
                          <span>
                            @if (isset($postArray->category->category) && !empty($postArray->category->category))
                              {{$postArray->category->category}}
                            @endif
                          </span>
                        </span>
                        {{-- {{ Post Author }} --}}
                        <span class="author-name">Author:
                          @if (isset($postArray->user->user_first_name) && !empty($postArray->user->user_first_name) && isset($postArray->user->user_surname) && !empty($postArray->user->user_surname))
                            {{$postArray->user->user_first_name . " " . $postArray->user->user_surname}}
                          @endif
                        </span>
                    </div>

                    {{-- {{ Post Title }} --}}
                    <h1>@if (isset($postArray->post_title) && !empty($postArray->post_title)) {{$postArray->post_title}} @endif</h1>

                    {{-- {{ Get all tags realting to the post }} --}}
                    @if (isset($allTags) && !empty($allTags) && $allTags->count() > 0)
                      <ul class="article-tags">
                        @foreach ($allTags as $tagNames)
                          @if (isset($tagNames->postTag->tag_name) && !empty($tagNames->postTag->tag_name))
                            <li><a href="#">{{$tagNames->postTag->tag_name}}</a></li>
                          @endif
                        @endforeach
                      </ul>
                    @endif
                </article><!-- /Article Intro -->
            </div>

            {{-- {{ Display the image }} --}}
            @if (isset($imageTempPath) && !empty($imageTempPath))
              <img class="post-thumbnail-large" src="{{ $imageTempPath }}" />
            @elseif(isset($postArray->post_featured_image) && !empty($postArray->post_featured_image))
              <img class="post-thumbnail-large" src="{{ $postArray->post_featured_image }}" />
            @else
              <img class="post-thumbnail-large" src="/all/images/temp.jpg" />
            @endif
        </section><!-- /Feed Header -->

        {{-- {{ Display the post content }} --}}
        <div id="belowheader">
          <section id="blogcontent" class="">
            @if (isset($postArray->post_content) && !empty($postArray->post_content))
              <article class="content-padding">
                {!! $postArray->post_content !!}
              </article>
              <!-- /Article -->
            @endif
          </section>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
