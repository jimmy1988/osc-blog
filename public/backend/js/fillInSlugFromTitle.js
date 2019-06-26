$(document).ready(function(){
  $("#post_title, #post_slug").on("blur", function(){
    var slug = $(this).val();
    $("#post_slug").val("");
    $("#post_slug").prop("readonly", true);
    slug = slug.toLowerCase();
    slug = slug.split(" ").join("-");
    $("#post_slug").val(slug);
    $("#post_slug").prop("readonly", false);
  });
});
