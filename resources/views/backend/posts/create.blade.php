{{-- {{ Create a new post }} --}}

{{-- {{ Get the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')

  <?php
    //Tag container - for new tags
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
      {{-- {{ Open form }} --}}
      {!! Form::open(['action' => ['PostsController@store', "false"], 'method' => 'POST', 'enctype' => 'multipart/form-data', "id" => "createPostForm"]) !!}
        <div class="col-xs-12 col-md-8">
          <div class="container-fluid">
            {{-- Post Title --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_title', 'Title')}}
                    {{Form::text('post_title', '', ['class' => 'form-control', 'placeholder' => 'Post Title'])}}
                  </div>
              </div>
            </div>
            {{-- {{ Post Slug }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_slug', 'Slug')}}
                    {{Form::text('post_slug', '', ['class' => 'form-control', 'placeholder' => 'Slug'])}}
                  </div>
              </div>
            </div>

            {{-- {{ Post Featured Image }} --}}
            <div class="row">
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#uploadTab">Post Featured Image - Upload Image</a>
                      {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                    </h4>
                  </div>
                  <div id="uploadTab" class="panel-collapse collapse in show">
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-sm-8">
                            <div class="form-group">
                              {{-- View the image --}}
                              {{--<img id="view-image-feature" src="{{ STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER}}/{{POST_IMAGES_NO_IMAGE_FILE}}" alt="your image" class="view-image"/>--}}
                              {{-- {{ Upload Button to upload the featured image }} --}}
{{--                              {{Form::file('post_featured_image',['onchange'=>"readURL(this, 'view-image-feature', false);", "id" => "image_choose"])}}--}}
                              <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm_feature" data-input="post_featured_image" data-preview="post_featured_image_holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose
                                 </a>
                               </span>
                                <input id="post_featured_image" class="form-control" type="text" name="post_featured_image">
                              </div>
                              <img id="post_featured_image_holder" src="{{ STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER}}/{{POST_IMAGES_NO_IMAGE_FILE}}" alt="your image"  class="view-image">
                            </div>
                          </div>
                          <div class="col-sm-2">&nbsp;</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- {{ Post Banner Image }} --}}
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
                            {{-- View the iamge --}}
                            {{--<img id="view-image-banner" src="{{ STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER}}/{{POST_IMAGES_NO_IMAGE_FILE}}" alt="your image" class="view-image"/>--}}
                            {{-- Upload the file --}}
{{--                            {{Form::file('post_banner_image',['onchange'=>"readURL(this, 'view-image-banner', false);", "id" => "image_choose"])}}--}}
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm_banner" data-input="post_banner_image" data-preview="post_banner_image_holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Choose
                                 </a>
                               </span>
                              <input id="post_banner_image" class="form-control" type="text" name="post_banner_image">
                            </div>
                            <img id="post_banner_image_holder" src="{{ STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER}}/{{POST_IMAGES_NO_IMAGE_FILE}}" alt="your image"  class="view-image">
                          </div>

                        </div>
                        <div class="col-sm-2">&nbsp;</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Post Feature Description --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  {{Form::label('post_description', 'Feature Description (character limit 500)')}}
                  {{Form::textarea('post_description', '', ['class' => 'form-control', 'placeholder' => 'Feature Discription'])}}
                </div>
              </div>
            </div>
            {{-- {{ Post Body }} --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    {{Form::label('post_content', 'Body')}}
                    {{Form::textarea('post_content', '', ['id' => 'ckeditor', 'class' => 'form-control', 'placeholder' => 'Blog Content'])}}
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
                          {{-- {{ Post Meta Description }} --}}
                          <div class="form-group">
                            {{Form::label('meta_description', 'Meta Description (character limit 150)')}}
                            {{Form::textarea('meta_description', '', ['class' => 'form-control'])}}
                          </div>
                          {{-- {{ Post Focus Keyword }} --}}
                          <div class="form-group">
                            {{Form::label('focus_keyword', 'Focus Keyword')}}
                            {{Form::text('focus_keyword', '', ['class' => 'form-control'])}}
                          </div>
                          <div class="form-group">
                            <div class="row">
                              {{-- {{ Index this post on search engines }} --}}
                              <div class="col-sm-6">
                                <label>Index on Search Engines</label>
                              </div>
                              <div class="col-sm-6">
                                <label class="switch">
                                  <input type="checkbox" name="indexOnSearchEngines" class="sliderCheckbox" checked>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              {{-- {{ Follow all links }} --}}
                              <div class="col-sm-6">
                                <label>Allow search engines to follow links</label>
                              </div>
                              <div class="col-sm-6">
                                <label class="switch">
                                  <input type="checkbox" class="sliderCheckbox" name="followLinks" checked>
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
              <div id="publishTab" class="panel-collapse collapse in show">
                <div class="panel-body">
                  @if(isset($post_statuses) && !empty($post_statuses))
                    <div class="row no-margin">
                      <div class="form-group">
                        {{-- {{ Post Status }} --}}
                        <div class="col-12">
                          {{Form::label('post_status', 'Status')}}
                          <select name="post_status" id="post_status" class="form-control">
                            @foreach ($post_statuses as $status)
                              @if (isset($status->post_status_id) && !empty($status->post_status_id) && isset($status->post_status) && !empty($status->post_status))
                                <option value="{{$status->post_status_id}}">{{$status->post_status}}</option>
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
                    {{-- {{ Preview and Save Buttons }} --}}
                    <div class="form-group">

                      <div class="col-xs-6 text-left">
                        {{Form::button('<i class="fas fa-eye"></i>&nbsp;Preview', ["type" => "submit", 'class'=>'btn btn-primary bg-green', "id" => "previewPostButton", "formtarget" => "_blank"])}}
                      </div>
                      <div class="col-xs-6 text-right">
                        {{Form::button('<i class="far fa-save"></i>&nbsp;Save', ["type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "createPostButton"])}}
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
                  @if(isset($post_categories) && !empty($post_categories))
                    <div class="row no-margin">
                      <div class="form-group">
                        {{-- {{ Post Category }} --}}
                        <div class="col-12">
                          {{Form::label('post_category', 'Category')}}
                          <select name="post_category" id="post_category" class="form-control">
                            @foreach ($post_categories as $category)
                              @if (isset($category->category_id) && !empty($category->category_id) && isset($category->category) && !empty($category->category))
                                <option value="{{$category->category_id}}">{{$category->category}}</option>
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
              {{-- {{ Post Tags }} --}}
              <div id="tagsTab" class="panel-collapse collapse in show">
                <div class="panel-body" id="tags-panel-body">

                </div>
                {{-- {{ Add Tags Button }} --}}
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
                {{-- {{ Post Featured }} --}}
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
      {!! Form::close() !!}
      {{-- {{ Close the form }} --}}
    </div>

  </div>

  <script type="text/javascript">
    //Get HTML of any new tags
    var tagsHtml = '<?php echo $tagContainer; ?>';
  </script>

  <!--Show the image from the selection in the file window-->
  <script type="text/javascript" src="{{ asset('/backend/js/showImageFromSelection.js') }}"></script>
  <!--Get the tag name based upon what is putt in the tag search box-->
  <script type="text/javascript" src="{{ asset('/backend/js/tagTextSelection.js') }}"></script>

  <!--Fills the slug in automatically based on what the title is-->
  {{--<script type="text/javascript" src="{{asset('/backend/js/fillInSlugFromTitle.js')}}"></script>--}}
  <!--Select the check box based on what is activated or not-->
  <script type="text/javascript" src="{{asset('/backend/js/controlSwitchCheckbox.js')}}"></script>

  <!--Validate the new post-->
  <script type="text/javascript" src="{{asset('/backend/js/validation/validateCreatePost.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      //change the url of the form to preview when submitting
      $("#previewPostButton").on("click", function(){
        var url = "{{ route("post.preview") }}";
        $("#createPostForm").attr("action", url);
        return true;
      });

      //change the url of the form to create when submitting
      $("#createPostButton").on("click", function(){
        var url = "/admin/posts?false";
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
