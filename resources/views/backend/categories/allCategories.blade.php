{{-- {{ Get all categories, add and delete categories }} --}}

@extends('backend.templates.admin_template')
@section('section')
  {{-- {{ Get the control panel }} --}}
  @include('backend.includes.postControlPanel')

  <?php
    //new category container
    $categoryContainer = "<div class=\"row add-category-row\">";
    $categoryContainer .= "  <div class=\"form-group\">";
    $categoryContainer .= "    <div class=\"col-sm-9 pull-left px-0\">";
    $categoryContainer .=        "<input class=\"form-control category-name\" name=\"category_name[]\" type=\"text\" value=\"\">";
    $categoryContainer .=      "</div>";
    $categoryContainer .=      "<div class=\"col-sm-3 pull-right\">";
    $categoryContainer .=      " <button onclick=\"deleteCategory(this);\" class=\"btn btn-danger delete-category-button\" type=\"button\"><i class=\"fas fa-trash-alt\"></i></button>";
    $categoryContainer .=      "</div>";
    $categoryContainer .=  "</div>";
    $categoryContainer .="</div>";
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-extended">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        {{-- {{ Open the form }} --}}
        {!! Form::open(['action' => ['CategoriesController@update', "0"], 'method' => 'POST', "id" => "updateCategoriesForm"]) !!}
          <div class="col-md-6">
            {{-- {{ Update all categories button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update All Categories', ["style" => "margin-bottom:25px", "type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "UpdateCategoriesButton"])}}
            <div class="table-responsive" id="all-categories-table-container">
              <table class="table table-bordered table-striped table-hover" id="all-categories-table">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- {{ Get all categories and display them }} --}}
                  @if (isset($categories) && !empty($categories) && $categories->count() > 0)
                    @foreach ($categories as $category)
                      @if (isset($category) && !empty($category))
                        <tr>
                          <td>
                            {{-- {{ Category Name }} --}}
                            @if (isset($category->category_id) && !empty($category->category_id) && isset($category->category) && !empty($category->category))
                              {{Form::text("category[][" . $category->category_id . "]", $category->category, ['style' => 'text-align:center;', 'class' => 'form-control', 'placeholder' => 'Category Name'])}}
                              <span style="display:none">{{$category->category}}</span>
                            @endif
                          </td>
                          <td>
                            {{-- {{ Delete button }} --}}
                            {{Form::hidden('catgeory_name', $category->category, ["id" => "category_name_hidden_delete"])}}
                            <a href="/admin/category/{{$category->category_id}}/delete" class="btn btn-danger deleteCategoryButton"><i class="fas fa-trash-alt"></i></button>
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  @else
                    {{-- {{ No categories found message }} --}}
                    <tr>
                      <td colspan="6">
                        No Categories Found
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            {{-- {{ Alternative method }} --}}
            {{Form::hidden("_method", "PUT")}}
            {{-- {{ Update all button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update All Categories', ["style" => "margin-top:25px","type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "UpdateCategoryButton"])}}
          </div>
        {!! Form::close() !!}
        {{-- {{ Close the form }} --}}

        {{-- {{ Column spacer }} --}}
        <div class="col-md-2">&nbsp;</div>

        {{-- {{ Add categories }} --}}
        <div class="col-md-4">
          {{-- {{ OPen the form }} --}}
          {!! Form::open(['action' => 'CategoriesController@store', 'method' => 'POST', "id" => "createCategryForm"]) !!}
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#publishTab">Add Categories</a>
                    {{--<i class="fas fa-chevron-down pull-right"></i>--}}
                  </h4>
                </div>
                <div id="publishTab" class="panel-collapse collapse in show">
                  {{-- {{ Categories container }} --}}
                  <div class="panel-body" id="tags-panel-body">

                  </div>
                  <div class="panel-footer text-right">
                    {{-- {{ Add category button }} --}}
                    {{Form::button('<i class="fas fa-plus"></i>', ['class'=>'btn btn-primary bg-green', "id" => "add-category"])}}
                  </div>
                  <div class="panel-footer text-right">
                    <div class="row no-margin text-right">
                      <div class="form-group">
                        <div class="col-12">
                          {{-- {{ Save all categories button }} --}}
                          {{Form::button('<i class="far fa-save"></i>&nbsp;Save Categories', ["type" => "submit", 'class'=>'btn btn-primary bg-pink', "id" => "createCategoriesButton"])}}
                        </div>
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
    </section>
  </div>

  <script type="text/javascript">
    //Dynamic html to add a new tag
    var tagsHtml = '<?php echo $categoryContainer; ?>';
  </script>

  <script type="text/javascript">

    //Delete a category, one at a time
    function deleteCategory(elem){
      $(elem).parent().parent().parent().slideUp(200, function(){
        $(elem).parent().parent().parent().remove();
      });
    }

    $(document).ready( function(){
      $.noConflict();
      //actiavet the datatable
      @if (isset($categories) && !empty($categories))
        @if (count($categories) > 0)
          $("#all-categories-table").DataTable({"columnDefs": [{ "searchable": true, "targets": 0}]});
        @endif
      @endif

      //confirm that the user wants to delete the category
      $(".deleteCategoryButton").on("click", function(){

        var category_name = $(this).parent().children("#category_name_hidden_delete").val();
        var confirm = window.confirm("Are you sure you wish to delete the category " + category_name + "?");

        if(confirm){
          return true;
        }else{
          return false;
        }
      });

      //add a category button
      $("#add-category").on("click", function(){
        $("#tags-panel-body").append(tagsHtml);
        $(".add-category-row").last().hide().slideDown(200);
      });
    });
  </script>
@endsection
