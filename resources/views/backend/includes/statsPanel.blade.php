{{-- {{ Display all stats relating to posts }} --}}

<div class="content-wrapper content-padding" id="control-panel-container">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#statsPanel"><strong>View/Hide Stats</strong></a>
          <i class="fas fa-chevron-down pull-right"></i>
        </h4>
      </div>
      <div id="statsPanel" class="panel-collapse collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12">
              <h3 class="stats-title">Stats</h3>
            </div>
          </div>
          <div class="row">
            {{-- {{ Display the total number of posts }} --}}
            @if (isset($all_posts) && !empty($all_posts))
              <div class="col-lg-3 col-xs-6">
                 <!-- small box -->
                 <div class="small-box bg-aqua">
                   <div class="inner">
                     <h3>
                       @if (isset($all_posts) && !empty($all_posts))
                         {{count($all_posts)}}
                       @endif
                     </h3>
                     <p>Total Posts</p>
                   </div>
                   <div class="icon"><i class="fas fa-clipboard-list"></i>
                   </div>
                 </div>
               </div>
               <!-- ./col -->
            @endif

            {{-- {{ Display the users total posts }} --}}
            @if (isset($my_posts) && !empty($my_posts))
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>
                      @if (isset($my_posts) && !empty($my_posts))
                        {{count($my_posts)}}
                      @endif
                    </h3>
                    <p>My Posts</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
            @endif

            {{-- {{ Display the total views of all posts that the user has created }} --}}
            @if (isset($total_views) && !empty($total_views))
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>
                      @if (isset($total_views) && !empty($total_views))
                        {{$total_views}}
                      @endif
                    </h3>
                    <p>Total Views</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-tag"></i>
                  </div>
                </div>
              </div>
            @endif

          </div>

          {{-- {{ Display the most viewed post }} --}}
          @if (isset($most_viewed) && !empty($most_viewed) && $most_viewed->count() > 0)
            <div class="row">
              <div class="col-xs-12">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>Most Viewed Post</h3>
                    <h4>
                      @if (isset($most_viewed->post_title) && !empty($most_viewed->post_title))
                        {{$most_viewed->post_title}}
                      @endif
                    </h4>
                    <h5>By
                      @if (isset($most_viewed->user->user_first_name) && !empty($most_viewed->user->user_first_name) && isset($most_viewed->user->user_surname) && !empty($most_viewed->user->user_surname))
                        {{$most_viewed->user->user_first_name . " " . $most_viewed->user->user_surname}}
                      @endif
                    </h5>
                    <p>With
                      @if (isset($most_viewed->views) && !empty($most_viewed->views))
                        {{$most_viewed->views}}
                      @else
                        {{ "0" }}
                      @endif
                       Views</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
