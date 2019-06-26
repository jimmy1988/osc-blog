$(document).ready(function(){
  $(".switch").on("click", function(){
    if($(this).children("input[type=checkbox]").prop("checked") == true){
      $(this).children("input[type=checkbox]").prop("checked", false);
    }else{
      $(this).children("input[type=checkbox]").prop("checked", true);
    }
  });
});
