{{-- {{ Main Dashboard }} --}}

{{-- {{ Get the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')

  {{-- {{ Get the stats panel }} --}}
  @include('backend.includes.statsPanel')

  {{-- {{ Get the control anel }} --}}
  @include('backend.includes.postControlPanel')

  <div class="content-wrapper content-padding content-wrapper-extended">

    {{-- Display all posts --}}
    <div class="panel-group">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#postsPanel">
              <strong>View/Hide All Posts</strong>
              <i class="fas fa-chevron-down pull-right"></i>
            </a>
          </h4>
        </div>
        <div id="postsPanel" class="panel-collapse collapse in show">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12">
                <h3 class="stats-title">All Posts</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive" id="all-posts-table-container">
                  <table class="table table-bordered table-striped table-hover" id="all-posts-table">
                    <thead>
                      <tr>
                        <th class="col-xs-1">Status</th>
                        <th class="col-xs-1">Title</th>
                        <th class="col-xs-1">Author</th>
                        <th class="col-xs-1">Category</th>
                        <th class="col-xs-1">Featured</th>
                        <th class="col-xs-1">Date Created</th>
                        <th class="col-xs-1">Date Last Updated</th>
                        <th class="col-xs-1">Views</th>
                        <th class="col-xs-1">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{-- Display all posts --}}
                      @if(isset($all_posts) && !empty($all_posts) && count($all_posts) > 0)
                        @foreach ($all_posts as $post)
                          {{-- Output the post post_status --}}
                          @if ($post->post_status == "1")
                            <!--Draft-->
                            <tr class="draft-record">
                              {{-- <td><i class="iconStatus fas fa-scroll"></i></td> --}}
                              <td>Draft</td>
                          @elseif($post->post_status == "2")
                            <!--Public-->
                            <tr class="public-record">
                              <td>Public</td>
                              {{-- <td><i class="iconStatus fas fa-check"></i></td> --}}
                          @else
                            <tr>
                              <td>&nbsp;</td>
                          @endif
                              <td>
                                {{-- {{ Post Title }} --}}
                                @if (isset($post->post_title) && !empty($post->post_title))
                                  {{$post->post_title}}
                                @else
                                  {{ "&nbsp;" }}
                                @endif
                              </td>
                              <td>
                                {{-- Author first name and surname --}}
                                @if (isset($post->user->user_first_name) && !empty($post->user->user_first_name) && isset($post->user->user_surname) && !empty($post->user->user_surname))
                                  {{$post->user->user_first_name . " " . $post->user->user_surname}}
                                @else
                                  {{ "&nbsp;" }}
                                @endif
                              </td>
                              <td>
                                {{-- {{ Post Category }} --}}
                                @if (isset($post->category->category) && !empty($post->category->category))
                                  {{$post->category->category}}
                                @else
                                  {{ "&nbsp;" }}
                                @endif
                              </td>
                              <td>
                                {{-- {{ is it a featured post or not }} --}}
                                @if (isset($post->featured) && !empty($post->featured))
                                  {{($post->featured==1?'Yes':'No')}}
                                @else
                                  {{ "No" }}
                                @endif
                              </td>
                              <td>
                                {{-- {{ Post Created Date }} --}}
                                @if (isset($post->post_created) && !empty($post->post_created))
                                  {{date("d/m/Y H:i",strtotime($post->post_created))}}
                                @else
                                  {{ "&nbsp;" }}
                                @endif
                              </td>
                              <td>
                                {{-- {{ Post last updated }} --}}
                                @if (isset($post->post_last_updated) && !empty($post->post_last_updated))
                                  {{date("d/m/Y H:i", strtotime($post->post_last_updated))}}
                                @else
                                  {{ "&nbsp;" }}
                                @endif
                              </td>
                              <td>
                                {{-- Post Tota Views --}}
                                @if (isset($post->views) && !empty($post->views))
                                  {{$post->views}}
                                @else
                                  {{ "0" }}
                                @endif

                              </td>
                              <td class="blank-cell">
                                @if (isset($post->post_slug) && !empty($post->post_slug))
                                  <a href="/admin/post/{{$post->post_slug}}" class="btn btn-success" role="button"><i class="fas fa-eye"></i></a>
                                @endif
                                @if (isset($post->post_id) && !empty($post->post_id))
                                  <a href="/admin/post/{{$post->post_id}}/edit" class="btn btn-info" role="button"><i class="fas fa-edit"></i></a>
                                @endif
                                {{-- @if ($post->post_author == Auth::id())
                                  {!!Form::open(['action' => ['PostsController@destroy', $post->post_id], 'method' => 'POST', 'class' =>'visible-sm-inline-block visible-md-inline-block visible-xs-inline-block visible-lg-inline-block visible-xl-inline-block deletePostForm'])!!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::hidden('redirect', $_SERVER['REQUEST_URI'])}}
                                    <button type="submit" name="delete" value="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                  {!!Form::close()!!}
                                @endif --}}
                              </td>
                            </tr>
                        @endforeach
                      @else
                        {{-- {{ No Posts Found Message }} --}}
                        <tr class="text-center bg-pink" style="color:#FFF;">
                          <td colspan="8">No Posts Found</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                <div>
                  {{-- {{ Pagination }} --}}
                  {{ $all_posts->fragment('previous-posts')->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready( function(){
      $.noConflict();
      //Confirm that the post should be deleted
      $(".deletePostForm").on("submit", function(){

        var confirmDelete = confirm("Are you sure you want to delete this post?");

        if(confirmDelete){
          return true;
        }else{
          return false;
        }
      });
    });
  </script>
@endsection
