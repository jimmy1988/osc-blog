{{-- {{ View All posts page as a table }} --}}

{{-- {{ Get the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')
  {{-- {{ Get the control panel }} --}}
  @include('backend.includes.postControlPanel')
  <div class="content-wrapper content-padding content-wrapper-extended">
    <div class="row">
      <div class="col-sm-12">
        <div class="table-responsive" id="all-posts-table-container">
          <table class="table table-bordered table-striped table-hover" id="all-posts-table">
            <thead>
              <tr>
                <th>Status</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Date Created</th>
                <th>Date Last Updated</th>
                <th>Views</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {{-- {{ if we have all f the osts then we can display }} --}}
              @if(isset($all_posts) && !empty($all_posts) && count($all_posts) > 0)
                @foreach ($all_posts as $post)
                  {{-- {{ Display the post status based on the index we have }} --}}
                  @if ($post->post_status == "1")
                    <!--Draft-->
                    <tr class="draft-record">
                      <td>Draft</td>
                      {{-- <td><i class="iconStatus fas fa-scroll"></i></td> --}}
                  @elseif($post->post_status == "2")
                    <!--Public-->
                    <tr class="public-record">
                      <td>Public</td>
                      {{-- <td><i class="iconStatus fas fa-check"></i></td> --}}
                  @elseif($post->post_status == "3")
                    <!--Removed-->
                    <tr class="removed-record">
                      <td>Removed</td>
                      {{-- <td><i class="iconStatus fas fa-eraser"></i></td> --}}
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
                        {{-- {{ Author first name and surname }} --}}
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
                        {{-- {{ Post Created Date }} --}}
                        @if (isset($post->post_created) && !empty($post->post_created) && $post->post_created != "0000-00-00 00:00:00")
                          {{date("d/m/Y H:i",strtotime($post->post_created))}}
                        @else
                          {{ date("d/m/Y H:i") }}
                        @endif
                      </td>
                      <td>
                        {{-- {{ Post Last Update }} --}}
                        @if (isset($post->post_last_updated) && !empty($post->post_last_updated) && $post->post_last_updated != "0000-00-00 00:00:00")
                          {{date("d/m/Y H:i",strtotime($post->post_last_updated))}}
                        @else
                          {{ "Not Updated" }}
                        @endif

                      </td>
                      <td>
                        {{-- {{ Post Total Views }} --}}
                        @if (isset($post->views) && !empty($post->views))
                          {{$post->views}}
                        @else
                          {{ "&nbsp;" }}
                        @endif
                      </td>
                      <td class="blank-cell">
                        {{-- {{ Buttons }} --}}
                        @if (isset($post->post_slug) && !empty($post->post_slug))
                          <a href="/admin/post/{{$post->post_slug}}" class="btn btn-success" role="button"><i class="fas fa-eye"></i></a>
                        @endif
                        @if (isset($post->post_id) && !empty($post->post_id))
                          <a href="/admin/post/{{$post->post_id}}/edit" class="btn btn-info" role="button"><i class="fas fa-edit"></i></a>
                        @endif
                        {{-- @if ($post->post_author == Auth::id()) --}}
                          {{-- {!!Form::open(['action' => ['PostsController@destroy', $post->post_id], 'method' => 'POST', 'class' =>'visible-sm-inline-block visible-md-inline-block visible-xs-inline-block visible-lg-inline-block visible-xl-inline-block deletePostForm'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::hidden('redirect', $_SERVER['REQUEST_URI'])}}
                            <button type="submit" name="delete" value="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                          {!!Form::close()!!} --}}
                        {{-- @endif --}}
                      </td>
                    </tr>
                @endforeach
              @else
                {{-- {{ No posts message }} --}}
                <tr class="text-center bg-pink" style="color:#FFF;">
                  <td colspan="8">No Posts Found</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript">
    $(document).ready( function(){
      $.noConflict()
      //activate the datatables
      @if (isset($all_posts) && !empty($all_posts))
        @if (count($all_posts) > 0)
          $("#all-posts-table").DataTable({
            autoWidth:  false,
          }
          ).columns.adjust();
        @endif
      @endif
    });
  </script>
@endsection
