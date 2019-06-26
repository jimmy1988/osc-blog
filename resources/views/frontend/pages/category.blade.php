{{-- {{ Categories page }} --}}

{{-- {{ Get the main template }} --}}
@extends('frontend.templates.index')

{{-- {{ Start of page content }} --}}
@section('section')

    {{-- {{ Mobile Menu Button }} --}}
    <a class="js-togglenav menubtn" href="#"><span></span><span></span><span></span><span></span></a>

    <section id="feed-header">

        {{-- {{ Start of Main Header }} --}}
        <div class="header-container">
            <div id="masthead">
                {{-- {{ Get the top navbar }} --}}
                @include("frontend.layouts.navbarTop")
                {{-- {{ Get the bottom navbar }} --}}
                @include("frontend.layouts.navbarBottom")
            </div><!-- /Masthead -->
            {{-- {{ End of Main Header }} --}}

            {{-- {{ Start of top article }} --}}
            <div id="article-carousel">


            @if (isset($active_posts) && !empty($active_posts) && $active_posts->count() > 0)
                {{-- {{ Posts have been found }} --}}
                <?php $count = 1; ?>
                {{-- {{ Loop through the posts only displaying the latest one }} --}}
                @foreach ($active_posts as $post)
                    @if ($count == 1)
                        {{-- {{ Produce the latest article }} --}}

                        <!-- Article Intro -->
                            <article class="course-otm">
                                <div class="article-meta">
                                    <span class="article-date">@if (isset($post->post_created) && !empty($post->post_created)) {{ date("d/m/Y", strtotime($post->post_created)) }} @endif</span>
                                    <span class="featured-post"><i class="ico-featured"></i><span>Featured Post</span></span>
                                    {{-- {{ echo out the category name }} --}}
                                    @if (isset($post->category->category) && !empty($post->category->category))
                                        <span class="article-category"><a title="Search for posts relating to this category" href="/search/{{$post->category->category}}/false/categories" class="article-category-link">{{$post->category->category}}</a></span></span>
                                    @endif
                                </div>

                                {{-- {{ ech out the post title }} --}}
                                @if (isset($post->post_title) && !empty($post->post_title))
                                    <h1>{{$post->post_title}}</h1>
                                @endif

                                <?php
                                //Get the articles tags
                                if(isset($post->post_id) && !empty($post->post_id)){
                                    $article_tags = App\PostTags::where("post", $post->post_id)->take(10)->get();
                                }

                                ?>

                                <ul class="article-tags">
                                    @if (isset($article_tags) && !empty($article_tags) && $article_tags->count() > 0)

                                        {{-- {{ Loop through the articles tags }} --}}
                                        @foreach ($article_tags as $tag)
                                            @if (isset($tag->postTag->tag_name) && !empty($tag->postTag->tag_name))
                                                <li><a href="/search/{{$tag->postTag->tag_name}}/false/tags">{{$tag->postTag->tag_name}}</a></li>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- {{ if there are no tags then it gets marked as uncategoried }} --}}
                                        <li><a href="/search/Uncategorised/false/tags">Uncategorised</a></li>
                                    @endif
                                </ul>
                                <div class="clearfix"></div>

                                {{-- {{ if we have the post slug }} --}}
                                @if (isset($post->post_slug) && !empty($post->post_slug))
                                    <a class="readmore-bttn" href="/post/{{$post->post_slug}}">Read this article</a>
                                @endif

                                <?php

                                //Dynaically produce the thumbnail path
                                $thumbnailPath = "";

                                if(isset($post->post_featured_image) && !empty($post->post_featured_image) && file_exists($post->post_featured_image)){
                                    $thumbnailPath = $post->post_featured_image;
                                }else{
                                    $thumbnailPath = "/all/images/temp.jpg";
                                }
                                ?>

                                <img class="post-thumbnail-large" src="{{$thumbnailPath}}" />

                            </article><!-- /Article Intro -->
                    @else
                        @break
                    @endif
                    <?php $count++; ?>
                @endforeach

            @else
                {{-- {{ No Posts Found }} --}}

                <!-- Article Intro -->
                    <article class="course-otm" style="height: 350px;">
                        <img class="post-thumbnail-large" src="/frontend/images/no-post.png" />
                    </article>
                @endif
            </div>
            {{-- {{ End of top article }} --}}
        </div>
    </section><!-- /Feed Header -->


    <div id="belowheader">
        {{-- {{ End of Recent Stories }} --}}

        {{-- {{ Start of previous posts }} --}}
        <section class="feed-prev-stories blogfeed" id="previous-posts"> <a href="#previous-posts"></a>

            <h4>{{$page_title}}</h4>

        @if (isset($active_posts) && !empty($active_posts) && $active_posts->count() > 0)
            @include("frontend.includes.postList", ['active_posts'=>$active_posts])
            {{-- {{ TODO: needs more development}} --}}
            {{--<a class="readmore-bttn" href="#">Load more posts</a>--}}

        @else
            {{-- {{ If we have no posts then we display the no posts message }} --}}

            <!-- Article Intro -->
                <article>

                    <a class="thumbnail-intro" href="#"><img class="post-thumbnail" src="/frontend/images/no-post.png" /></a>

                    <div>
                        <div class="article-meta">
                            <span class="article-date">&nbsp;</span>
                        </div>

                        <a href="#">
                            <h3>No Previous Posts Yet, please check back later</h3>
                            <p>&nbsp;</p>
                        </a>

                    </div>
                </article>
                <!-- /Article Intro -->
            @endif

        </section>
        {{-- {{ End of previous posts }} --}}

    </div>
@endsection
{{-- {{ End of page content }} --}}
