{{-- {{ Edit Post Page }} --}}

{{-- {{ Get the admin template}} --}}
@extends('backend.templates.admin_template')
@section('section')

  <?php
    //HTML to create new tags
    $tagContainer = "<div class=\"row add-tag-row\">";
    $tagContainer .= "  <div class=\"form-group\">";
    $tagContainer .= "    <div class=\"col-sm-9 pull-left px-0\">";
    $tagContainer .=        "<input class=\"form-control tag-name\" name=\"tags_name[]\" type=\"text\" value=\"\" onkeyup=\"request_results(this);\">";
    $tagContainer .=        "<div class=\"livesearch\"></div>";
    $tagContainer .=      "</div>";
    $tagContainer .=      "<div class=\"col-sm-3 pull-right\">";
    $tagContainer .=      " <button onclick=\"deleteTag(this);\" class=\"btn btn-danger delete-tag-button\" type=\"button\"><i class=\"fas fa-trash-alt\"></i></button>";
    $tagContainer .=      "</div>";
    $tagContainer .=  "</div>";
    $tagContainer .="</div>";
  ?>

  {{-- {{ Get the control panel }} --}}
  @include('backend.includes.postControlPanel')
  <div class="content-wrapper content-padding content-wrapper-extended">
    <div class="row">
      {{-- {{ Open the form }} --}}
      {!! Form::open(['action' => ['PostsController@update', $currentPost->post_id], 'method' => 'POST', 'enctype' => 'multipart/form-data', "id" => "createPostForm"]) !!}
        <div class="col-xs-12 col-md-8">
          <div class="container-fluid">
            {{-- {{ Hidden fields }} --}}
            <div class="row">
              <div class="col-12" id="hiddenFields">
                {{-- {{ Old post featured image }} --}}
                {{Form::hidden('post_old_featured_image', $currentPost->post_featured_image, ['class' => 'form-control'])}}
                {{-- {{ Alternative method }} --}}
                {{Form::hidden("_method", "PUT", ['id' => 'methodHiddenField'])}}
              </div>
            </div>
            {{-- {{ Post Title }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_title', 'Title')}}
                    {{Form::text('post_title', $currentPost->post_title, ['class' => 'form-control', 'placeholder' => 'Post Title'])}}
                  </div>
              </div>
            </div>
            {{-- {{ Post Slug }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_slug', 'Slug')}}
                    {{Form::text('post_slug', $currentPost->post_slug, ["readonly" => "readonly", 'class' => 'form-control', 'placeholder' => 'Slug (will automatically populate)'])}}
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#uploadTab">Post Featured Image - Upload Image</a>
                      {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                    </h4>
                  </div>
                  {{-- {{ Get the post featured image }} --}}
                  <div id="uploadTab" class="panel-collapse collapse in show">
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-sm-8">
                            <div class="form-group">
                              <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm_feature" data-input="post_featured_image" data-preview="post_featured_image_holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose
                                 </a>
                               </span>

                              @if (isset($currentPost->post_featured_image) && !empty($currentPost->post_featured_image))
                                    <input id="post_featured_image" class="form-control" type="text" name="post_featured_image" value="{{$currentPost->post_featured_image}}">
                                </div>
                                <img id="post_featured_image_holder" src="{{$currentPost->post_featured_image}}" alt="your image" class="view-image"/>
                              @else
                                  <input id="post_featured_image" class="form-control" type="text" name="post_featured_image">
                              </div>
                                <img id="post_featured_image_holder" src="{{STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER . "/" . POST_IMAGES_NO_IMAGE_FILE}}" alt="your image" class="view-image"/>
                              @endif

{{--                              {{Form::file('post_featured_image',['onchange'=>"readURL(this, 'view-image-feature', false);", "id" => "image_choose"])}}--}}
                            </div>
                          </div>
                          <div class="col-sm-2">&nbsp;</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- {{ Get the banner image }} --}}
            <div class="row">
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#uploadTab">Post Banner Image - Upload Image</a>
                      {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                    </h4>
                  </div>
                  <div id="uploadTab" class="panel-collapse collapse in show">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8">
                          <div class="form-group">
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm_banner" data-input="post_banner_image" data-preview="post_banner_image_holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose
                                 </a>
                               </span>

                            @if (isset($currentPost->post_banner_image) && !empty($currentPost->post_banner_image))
                                  <input id="post_banner_image" class="form-control" type="text" name="post_banner_image" value="{{$currentPost->post_banner_image}}">
                              </div>
                              <img id="post_banner_image_holder" src="{{$currentPost->post_banner_image}}" alt="your image" class="view-image"/>
                            @else
                                <input id="post_banner_image" class="form-control" type="text" name="post_banner_image">
                              </div>
                              <img id="post_banner_image_holder" src="{{STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER . "/" . POST_IMAGES_NO_IMAGE_FILE}}" alt="your image" class="view-image"/>
                            @endif
{{--                            {{Form::file('post_banner_image',['onchange'=>"readURL(this, 'view-image-banner', false);", "id" => "image_choose"])}}--}}
                          </div>
                        </div>
                        <div class="col-sm-2">&nbsp;</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- {{ Get the feature description }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_description', 'Feature Description (character limit 500)')}}
                    {{Form::textarea('post_description', $currentPost->post_description, ['class' => 'form-control', 'placeholder' => 'Feature Discription'])}}
                </div>
              </div>
            </div>
            {{-- {{ Get the post body }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  {{Form::label('post_content', 'Body')}}
                  {{Form::textarea('post_content', $currentPost->post_content, ['id' => 'ckeditor', 'class' => 'form-control', 'placeholder' => 'Blog Content'])}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#seoTab">SEO &amp; Marketing</a>
                      {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                    </h4>
                  </div>
                  <div id="seoTab" class="panel-collapse collapse in show">
                    <div class="panel-body" id="seo-marketing-container">
                      <div class="row">
                        <div class="col-sm-12">
                          {{-- {{ Meta Description }} --}}
                          <div class="form-group">
                            {{Form::label('meta_description', 'Meta Description (character limit 150)')}}
                            {{Form::textarea('meta_description', $currentPost->post_meta_description, ['class' => 'form-control'])}}
                          </div>
                          {{-- {{ Focus Keyword }} --}}
                          <div class="form-group">
                            {{Form::label('focus_keyword', 'Focus Keyword')}}
                            {{Form::text('focus_keyword', $currentPost->post_focus_keyword, ['class' => 'form-control'])}}
                          </div>
                          {{-- {{ index the page on serach engines }} --}}
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-6">
                                <label>Index on Search Engines</label>
                              </div>
                              <div class="col-sm-6">
                                <label class="switch">
                                  <input type="checkbox" name="indexOnSearchEngines" class="sliderCheckbox" @if(isset($currentPost->index_on_search_engines) && !empty($currentPost->index_on_search_engines) && $currentPost->index_on_search_engines == "1") {{"checked"}} @endif>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                            </div>
                          </div>
                          {{-- {{ Allow serach engines to follow the links }} --}}
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-6">
                                <label>Allow search engines to follow links</label>
                              </div>
                              <div class="col-sm-6">
                                <label class="switch">
                                  <input type="checkbox" class="sliderCheckbox" name="followLinks" @if(isset($currentPost->follow_links) && !empty($currentPost->follow_links) && $currentPost->follow_links == "1") {{"checked"}} @endif>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--Right Control Panel-->
        <div class="col-xs-12 col-md-4">
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#publishTab">Saving &amp; Publishing</a>
                  {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                </h4>
              </div>
              <div id="publishTab" class="panel-collapse collapse in">
                <div class="panel-body">
                  {{-- {{ List all post statuses and select the current post status }} --}}
                  @if(isset($post_statuses) && !empty($post_statuses))
                    <div class="row no-margin">
                      <div class="form-group">
                        <div class="col-12">
                          {{Form::label('post_status', 'Status')}}
                          <select name="post_status" id="post_status" class="form-control">
                            @foreach ($post_statuses as $status)
                              @if (isset($status->post_status_id) && !empty($status->post_status_id) && isset($currentPost->post_status) && !empty($currentPost->post_status) && isset($status->post_status) && !empty($status->post_status))
                                <option value="{{$status->post_status_id}}"
                                  @if ($status->post_status_id == $currentPost->post_status)
                                    {{"selected"}}
                                  @endif
                                >{{$status->post_status}}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
                <div class="panel-footer text-right">
                  <div class="row no-margin">
                    {{-- {{ Preview and save buttons }} --}}
                    <div class="form-group">
                      <div class="col-xs-6 text-left">
                        {{Form::button('<i class="fas fa-eye"></i>&nbsp;Preview', ["type" => "submit", 'class'=>'btn btn-primary bg-green', "id" => "previewPostButton", "formtarget" => "_blank"])}}
                      </div>
                      <div class="col-xs-6 text-right">
                        {{Form::button('<i class="far fa-save"></i>&nbsp;Update', ["type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "updatePostButton"])}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#categoriesTab">Categories</a>
                  {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                </h4>
              </div>
              <div id="categoriesTab" class="panel-collapse collapse in show">
                <div class="panel-body">
                  {{-- {{ List all the post categories and select the current one }} --}}
                  @if(isset($post_categories) && !empty($post_categories))
                    <div class="row no-margin">
                      <div class="form-group">
                        <div class="col-12">
                          {{Form::label('post_category', 'Category')}}
                          <select name="post_category" id="post_category" class="form-control">
                            @foreach ($post_categories as $category)
                              @if (
                                isset($category->category_id) && !empty($category->category_id) &&
                                isset($currentPost->post_category) && !empty($currentPost->post_category) &&
                                isset($category->category) && !empty($category->category)
                                )
                                <option value="{{$category->category_id}}"
                                  @if ($category->category_id == $currentPost->post_category)
                                    {{"selected"}}
                                  @endif
                                >{{$category->category}}</option>
                              @endif

                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#tagsTab">Tags</a>
                  {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                </h4>
              </div>
              <div id="tagsTab" class="panel-collapse collapse in show">
                <div class="panel-body" id="tags-panel-body">

                  @if (isset($postTags) && !empty($postTags) && $postTags->count() > 0)
                    @foreach ($postTags as $postTag)
                      <div class="row add-tag-row">
                        <div class="form-group">
                          <div class="col-sm-9 pull-left px-0">
                            <input class="form-control tag-name" readonly name="current_tags_name[{{$postTag->tag}}]" type="text" value="{{$postTag->postTag->tag_name}}" onkeyup="request_results(this);">
                            <div class="livesearch"></div>
                          </div>
                          <div class="col-sm-3 pull-right">
                            <button onclick="deleteTag(this);" class="btn btn-danger delete-tag-button" type="button"><i class="fas fa-trash-alt"></i></button>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
                <div class="panel-footer text-right">
                  {{Form::button('<i class="fas fa-plus"></i>', ['class'=>'btn btn-primary bg-green', "id" => "add-tag"])}}
                </div>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#tagsFeatured">Featured</a>
                  {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                </h4>
              </div>
              <div id="FeaturedTab" class="panel-collapse collapse in show">
                <div class="panel-body" id="featured-panel-body">
                  <div class="col-sm-6">
                    <label>Show on featured list</label>
                  </div>
                  <div class="col-sm-6">
                    <label class="switch">
                      <input type="checkbox" name="featured" value='1' class="sliderCheckbox" @if(isset($currentPost->featured) && !empty($currentPost->featured) && $currentPost->featured == "1") {{"checked"}} @endif>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- {{ Close the forn }} --}}
      {!! Form::close() !!}
    </div>

  </div>

  <script type="text/javascript">
    //Get the HTML to create new tags on the fly
    var tagsHtml = '<?php echo $tagContainer; ?>';
  </script>

  <!--Show an image in the image tag when a user selectes it from the file selection box-->
  <script type="text/javascript" src="{{ asset('/backend/js/showImageFromSelection.js') }}"></script>
  {{-- {{ Live search to show tags based on a users search criterion }} --}}
  <script type="text/javascript" src="{{ asset('/backend/js/tagTextSelection.js') }}"></script>

  {{-- {{ When the title is filled in, the slug is filled in  }} --}}
{{--  <script type="text/javascript" src="{{asset('/backend/js/fillInSlugFromTitle.js')}}"></script>--}}

  {{-- {{ Switch the checkbox based on the slider }} --}}
  <script type="text/javascript" src="{{asset('/backend/js/controlSwitchCheckbox.js')}}"></script>

  {{-- {{ validate the current page }} --}}
  <script type="text/javascript" src="{{asset('/backend/js/validation/validateCreatePost.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      //switch the form to preview the post
      $("#previewPostButton").on("click", function(){
        var url = $("#createPostForm").attr("action");
        url = "{{ route("post.preview") }}";
        $("#createPostForm").attr("action", url);
        $("#methodHiddenField").remove();
        return true;
      });

      //switch the form to update the post
      $("#updatePostButton").on("click", function(){
        var url = "/admin/posts/{{$currentPost->post_id}}";
        var hiddenFields = '{{Form::hidden("_method", "PUT", ["id" => "methodHiddenField"])}}';
        $("#hiddenFields").append(hiddenFields);
        $("#createPostForm").attr("action", url);
        return true;
      });
    });
  </script>

  {{-- <script type="module" src="/yoastseo/index.js"></script>
  <script type="module" src="/backend/js/yoastseo/useyoast.js"></script>
  <script type="module">
    import { AnalysisWebWorker } from "/yoastseo";

    const worker = new AnalysisWebWorker( self );
    worker.register();
  </script> --}}


@endsection
