var errors = new Array();
var error = false;

function is_blank(string){
  return string == "" || string == null || string == undefined;
}

function produceErrors(){

  var html = "";
  for(var i = 0; i < errors.length;i++){
    html = html + "<div class=\"alert alert-danger no-gutters mb-0\">" + errors[i] + "</div>";
  }

  $("#messagesContainer").html(html);
  $("#messagesContainer").show();
}

$(document).ready(function(){
  $("#createPostForm").on("submit", function(){
    if(is_blank($("#post_title").val())){
      error = true;
      errors.push("The post title cannot be blank");
    }

    if(is_blank($("#post_slug").val())){
      error = true;
      errors.push("The post slug cannot be blank, type a title to fill this out automatically");
    }

    if(is_blank($("#post_status").val())){
      error = true;
      errors.push("Please select a post status");
    }

    if(is_blank($("#post_category").val())){
      error = true;
      errors.push("Please select a post category");
    }

    if(is_blank($("#meta_description").val())){
      error = true;
      errors.push("The meta description cannot be blank");
    }

    if(is_blank($("#focus_keyword").val())){
      error = true;
      errors.push("The focus keyword cannot be blank");
    }

    if(is_blank(CKEDITOR.instances['editor'].getData().replace(/<[^>]*>/gi, ''))){
      error = true;
      errors.push("The post body cannot be blank");
    }

    if(error){
      produceErrors();
      return false;
    }else{
      return true;
    }
  });
});
