{{-- {{ Display all the tags, add new ones and delete old or unused ones}} --}}

{{-- {{ Get the main template }} --}}
@extends('backend.templates.admin_template')
@section('section')
  {{-- {{ Get the control panel }} --}}
  @include('backend.includes.postControlPanel')

  <?php
    //The html that will create a new tag
    $tagContainer = "<div class=\"row add-tag-row\">";
    $tagContainer .= "  <div class=\"form-group\">";
    $tagContainer .= "    <div class=\"col-sm-9 pull-left px-0\">";
    $tagContainer .=        "<input class=\"form-control tag-name\" name=\"tags_name[]\" type=\"text\" value=\"\">";
    $tagContainer .=      "</div>";
    $tagContainer .=      "<div class=\"col-sm-3 pull-right\">";
    $tagContainer .=      " <button onclick=\"deleteTag(this);\" class=\"btn btn-danger delete-tag-button\" type=\"button\"><i class=\"fas fa-trash-alt\"></i></button>";
    $tagContainer .=      "</div>";
    $tagContainer .=  "</div>";
    $tagContainer .="</div>";
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-extended">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        {{-- {{ Open the form to save all tags in one go }} --}}
        {!! Form::open(['action' => ['TagsController@update', "0"], 'method' => 'POST', "id" => "updateTagsForm"]) !!}
          <div class="col-md-6">
            {{-- {{ Update all button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update All Tags', ["style" => "margin-bottom:25px", "type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "UpdateTagsButton"])}}
              <div class="table-responsive" id="all-tags-table-container">
                <table class="table table-bordered table-striped table-hover" id="all-tags-table">
                  <thead>
                    <tr>
                      <th>Tag</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- {{ if we have the tags then we can start displaying them }} --}}
                    @if (isset($tags) && !empty($tags) && $tags->count() > 0)
                      @foreach ($tags as $tag)
                        @if (isset($tag->tag_id) && !empty($tag->tag_id) && isset($tag->tag_name) && !empty($tag->tag_name))
                          <tr>
                            <td>
                              {{-- {{ Tag Name }} --}}
                              {{Form::text("tags[][" . $tag->tag_id . "]", $tag->tag_name, ['style' => 'text-align:center;', 'class' => 'form-control', 'placeholder' => 'Post Title'])}}
                              <span style="display:none">{{$tag->tag_name}}</span>
                            </td>
                            <td>
                              {{-- {{ Delete Button }} --}}
                              {{Form::hidden('tag_name', $tag->tag_name, ["id" => "tag_name_hidden_delete"])}}
                              <a href="/admin/tags/{{$tag->tag_id}}/delete" class="btn btn-danger deleteTagButton"><i class="fas fa-trash-alt"></i></button>
                            </td>
                          </tr>
                        @endif
                      @endforeach
                    @else
                      {{-- {{ No tags found message }} --}}
                      <tr>
                        <td colspan="6">
                          No Tags Found
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              {{-- {{ Hidden alternative method iput }} --}}
              {{Form::hidden("_method", "PUT")}}
              {{-- {{ Update all button at the bottom }} --}}
              {{Form::button('<i class="far fa-save"></i>&nbsp;Update All Tags', ["style" => "margin-top:25px","type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "UpdateTagsButton"])}}
            </div>
            {{-- {{ Close the form }} --}}
          {!! Form::close() !!}

        {{-- {{ Column Spacer }} --}}
        <div class="col-md-2">&nbsp;</div>

        {{-- {{ Add tags on the right hand side }} --}}
        <div class="col-md-4">
          {!! Form::open(['action' => 'TagsController@store', 'method' => 'POST', "id" => "createTagsForm"]) !!}
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#publishTab">Add Tags</a>
                    {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                  </h4>
                </div>
                <div id="publishTab" class="panel-collapse collapse in show">
                  {{-- {{ New tags container }} --}}
                  <div class="panel-body" id="tags-panel-body">

                  </div>
                  {{-- {{ Add tag button in the footer }} --}}
                  <div class="panel-footer text-right">
                    {{Form::button('<i class="fas fa-plus"></i>', ['class'=>'btn btn-primary bg-green', "id" => "add-tag"])}}
                  </div>
                  <div class="panel-footer text-right">
                    <div class="row no-margin text-right">
                      <div class="form-group">
                        {{-- {{ Save tags button }} --}}
                        <div class="col-12">
                          {{Form::button('<i class="far fa-save"></i>&nbsp;Save Tags', ["type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "createTagsButton"])}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- {{ close the form }} --}}
          {!! Form::close() !!}
        </div>
      </div>
    </section>
  </div>

  <script type="text/javascript">
    //dynamic html to add the tags in
    var tagsHtml = '<?php echo $tagContainer; ?>';
  </script>

  <script type="text/javascript">

    //delete tags one line at a time
    function deleteTag(elem){
      $(elem).parent().parent().parent().slideUp(200, function(){
        $(elem).parent().parent().parent().remove();
      });
    }

    $(document).ready( function(){
      $.noConflict();
      //activate datatables
      @if (isset($tags) && !empty($tags))
        @if (count($tags) > 0)
          $("#all-tags-table").DataTable({"columnDefs": [{ "searchable": true, "targets": 0}]});
        @endif
      @endif

      //confirm that the user wants to delete the tag
      $(".deleteTagButton").on("click", function(){

        var tag_name = $(this).parent().children("#tag_name_hidden_delete").val();
        var confirm = window.confirm("Are you sure you wish to delete the tag " + tag_name + "?");

        if(confirm){
          return true;
        }else{
          return false;
        }
      });

      //add a tag to the box
      $("#add-tag").on("click", function(){
        $("#tags-panel-body").append(tagsHtml);
        $(".add-tag-row").last().hide().slideDown(200);
      });
    });
  </script>
@endsection
