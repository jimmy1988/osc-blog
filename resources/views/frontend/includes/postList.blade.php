{{-- {{ List all current posts }} --}}

@foreach ($active_posts as $post)
    <!-- Article Intro -->
    <article>

        {{-- {{ create the link for the thumbnail and display the featured image }} --}}
        <a class="thumbnail-intro" href="@if (isset($post->post_slug) && !empty($post->post_slug)) {{ "/post/" . $post->post_slug}} @else "#" @endif">
          <img class="post-thumbnail" src="@if(isset($post->post_featured_image) && !empty($post->post_featured_image)) {{ $post->post_featured_image }} @else {{ STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER . "/" . POST_IMAGES_NO_IMAGE_FILE }} @endif" />
        </a>

        <div>

            {{-- {{ echo out the date created }} --}}
            <div class="article-meta">
                <span class="article-date">@if(isset($post->post_created) && !empty($post->post_created)) {{date("d/m/Y", strtotime($post->post_created))}} @endif</span>
            </div>

            {{-- {{ create a link to the post and echo out the title and dscription }} --}}
            <a href="@if(isset($post->post_slug) && !empty($post->post_slug)) {{ "/post/" . $post->post_slug}} @endif">
                <h3>@if(isset($post->post_title) && !empty($post->post_title)) {{$post->post_title}} @endif</h3>
                <p>@if(isset($post->post_description) && !empty($post->post_description)) {{$post->post_description}} @endif</p>
            </a>

            <?php
            //if we have a post id - find the posts tags
            if(isset($post->post_id) && !empty($post->post_id)){
                $article_tags = App\PostTags::where("post", $post->post_id)->take(10)->get();
            }
            ?>

            <ul class="article-tags recent-stories-tags">
                @if (isset($article_tags) && !empty($article_tags) && $article_tags->count() > 0)
                    {{-- {{ if we have tagts for the article then we display them }} --}}
                    @foreach ($article_tags as $tag)
                        @if (isset($tag->postTag->tag_name) && !empty($tag->postTag->tag_name))
                            <li><a href="/search/{{$tag->postTag->tag_name}}/false/tags">{{$tag->postTag->tag_name}}</a></li>
                        @endif
                    @endforeach
                @else
                    {{-- {{ display an uncateregorised tag }} --}}
                    <li><a href="/search/Uncategorised/false/tags">Uncategorised</a></li>
                @endif
            </ul>
            <div class="clearfix"></div>

        </div>
    </article>
    <!-- /Article Intro -->
@endforeach
<div>{{ $active_posts->fragment('previous-posts')->links() }}</div>
