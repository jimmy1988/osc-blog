{{-- {{ Displays the nexct article }} --}}

<hr class="blogfeed-rule" />

<div id="belowheader">
    <section class="blogfeed feed-inner-prev-stories">

        {{-- {{ if we have the next article then we can display it }} --}}
        @if(isset($nextArticle) && !empty($nextArticle) && count($nextArticle) > 0)

          <h5>Next Article</h5>

          {{-- {{ loop through the next articles }} --}}
          <?php $count = 0; ?>
          @foreach ($nextArticle as $article)

            {{-- {{ Only display 1 article }} --}}
            @if ($count == 0)
              <!-- Article Intro -->
              <article>

                  {{-- {{ Echo the post slug }} --}}
                  <a class="thumbnail-intro" href="@if (isset($article->post_slug) && !empty($article->post_slug)) {{ "/post/" . $article->post_slug}} @endif"><img class="post-thumbnail" src="@if (isset($article->post_featured_image) && !empty($article->post_featured_image)) {{$article->post_featured_image}} @endif" /></a>

                  <div>

                      {{-- {{ echo out the post created date providing that it exists }} --}}
                      <div class="article-meta">
                          <span class="article-date">@if (isset($article->post_created) && !empty($article->post_created)) {{date("d/m/Y", strtotime($article->post_created))}} @endif</span>
                      </div>

                      <a href="@if (isset($article->post_slug) && !empty($article->post_slug)) {{ "/post/" . $article->post_slug}} @else {{ "#" }} @endif">
                          <h3>@if (isset($article->post_title) && !empty($article->post_title)) {{$article->post_title}} @endif</h3>
                          <p>@if (isset($article->post_meta_description) && !empty($article->post_meta_description)) {{$article->post_meta_description}} @endif</p>
                      </a>

                      <?php
                        //get the articles tags
                        if(isset($article->post_id) && !empty($article->post_id)){
                          $article_tags = App\PostTags::where("post", $article->post_id)->take(10)->get();
                        }
                      ?>

                    <ul class="article-tags recent-stories-tags">
                      {{-- {{ if we have the articles tehn we can start printing them to the screen }} --}}
                      @if (isset($article_tags) && !empty($article_tags) && $article_tags->count() > 0)
                          {{-- {{ start looping through the tags }} --}}
                          @foreach ($article_tags as $tag)
                            {{-- {{ if we have the tag name then we can dislay it to the screen }} --}}
                            @if (isset($tag->postTag->tag_name) && !empty($tag->postTag->tag_name))
                              <li><a href="/search/{{$tag->postTag->tag_name}}/false/tags">{{$tag->postTag->tag_name}}</a></li>
                            @endif
                          @endforeach
                      @else
                        {{-- {{ if no tags have been detected then we can mark it as an uncategorised post }} --}}
                        <li><a href="/search/Uncategorised/false/tags">Uncategorised</a></li>
                      @endif
                    </ul>
                    <div class="clearfix"></div>

                  </div>
              </article>
              <!-- /Article Intro -->
            @else
              @break
            @endif
            <?php $count++; ?>
          @endforeach

        @else

          {{-- {{ if we have no next article then we can display a message to indicate that we have no posts yet }} --}}

          <!-- Article Intro -->
          <article>

            <a class="thumbnail-intro" href="#"><img class="post-thumbnail" src="/frontend/images/no-post.png" /></a>

            <div>
              <div class="article-meta">
                <span class="article-date">&nbsp;</span>
              </div>

              <a href="#">
                <h3>No Posts Yet, please check back later</h3>
                <p>&nbsp;</p>
              </a>

            </div>
          </article>
          <!-- /Article Intro -->
        @endif

    </section>
</div>
