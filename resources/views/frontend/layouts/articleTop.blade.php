{{-- {{ Display the top of the article }} --}}

<!-- Article Intro -->
<article class="course-otm">
    <div class="article-meta">

        {{-- {{ Post Date}} --}}
        <span class="article-date">
          @if (isset($postPreview['post_created']) && !empty($postPreview['post_created']))
            {{ date("d/m/Y", strtotime($postPreview['post_created'])) }}
          @elseif(isset($post['post_created']) & !empty($post['post_created']))
            {{ date("d/m/Y", strtotime($post['post_created'])) }}
          @else
            {{ date("d/m/Y") }}
          @endif
        </span>

        {{-- {{ Featured Post }} --}}
        @if ((isset($postPreview['featured']) && !empty($postPreview['featured'])) || (isset($post['featured']) && !empty($post['featured'])))
          <span class="article-date  featured-post"><i class="ico-featured"></i>&nbsp;Featured Post</span>
        @endif

        {{-- {{ Display the post categories }} --}}

          @if (isset($postPreview['post_category']) && !empty($postPreview['post_category']) && isset($post_categories) && !empty($post_categories))
            <span class="author-name article-date">{{$post_categories[$postPreview['post_category']-1]['category']}}</span>
          @elseif (isset($post['post_category']) && !empty($post['post_category']) && isset($post_categories) && !empty($post_categories))
            <span class="author-name article-date">{{$post_categories[$post['post_category']-1]['category']}}</span>
          @endif


        {{-- {{ Display the post author }} --}}
        <span class="article-date author-name">Author:
          @if(isset($postPreview) && !empty($postPreview))
            {{ $postPreview['user_first_name'] . " " . $postPreview['user_surname']}}
          @elseif(isset($post) && !empty($post))
            {{ $post->user->user_first_name . " " . $post->user->user_surname }}
          @endif
        </span>
    </div>

    {{-- {{ Display the post title }} --}}
    @if (isset($post['post_title']) && !empty($post['post_title']))
      <h1>{{ $post['post_title'] }}</h1>
    @elseif (isset($postPreview['post_title']) && !empty($postPreview['post_title']))
      <h1>{{ $postPreview['post_title'] }}</h1>
    @endif


    {{-- {{ Dislay the articles tags }} --}}
    @if (isset($post['post_id']) && !empty($post['post_id']))

      <?php
        $article_tags = App\PostTags::where("post", $post['post_id'])->get();
      ?>

      @if (isset($article_tags) && !empty($article_tags) && $article_tags->count() > 0)
        <ul class="article-tags">
          @foreach ($article_tags as $tag)
            <li><a href="/search/{{$tag->postTag->tag_name}}/false/tags">{{$tag->postTag->tag_name}}</a></li>
          @endforeach
        </ul>
      @endif


    @elseif (isset($postPreview) && !empty($postPreview))
        <ul class="article-tags">
          @if (isset($postPreview['current_tags_name']) && !empty($postPreview['current_tags_name']) && count($postPreview['current_tags_name']) > 0)
            @foreach ($postPreview['current_tags_name'] as $currentTag => $currentTagName)
              <li><a href="/search/{{$currentTagName}}/false/tags">{{$currentTagName}}</a></li>
            @endforeach
          @endif
          @if (isset($postPreview['tags_name']) && !empty($postPreview['tags_name']) && count($postPreview['tags_name']) > 0)
            @for ($i=0; $i < count($postPreview['tags_name']); $i++)
              <li><a href="/search/{{$postPreview['tags_name'][$i]}}/false/tags">{{$postPreview['tags_name'][$i]}}</a></li>
            @endfor
          @endif
        </ul>
    @endif

</article><!-- /Article Intro -->
