var xhr = null;

function set_up_xhr(){
  if (window.XMLHttpRequest) {
   // code for modern browsers
   xhr= new XMLHttpRequest();
 }else{
   // code for old IE browsers
   xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }

}

function response_results(){
  if (xhr.readyState == 4 && xhr.status == 200) {
      var posts = JSON.parse(xhr.responseText);
      var postsHTML = "";

      if(posts.length > 0){
        for(var i = 0; i < posts.length; i++){

          var dateTime = posts[i].post_created.split(" ");
          var date = dateTime[0];
          var dateSplit = date.split("-");
          var time = dateTime[1];

          postsHTML = postsHTML + "<div class=\"search--result\">";
          postsHTML = postsHTML + "<a href=\"/post/" + posts[i].post_slug + "\">";
          postsHTML = postsHTML + "<div class=\"result_inner\">";
          postsHTML = postsHTML + "<h5>" + dateSplit[2] + "/" + dateSplit[1] + "/" + dateSplit[0] + "</h5>";
          postsHTML = postsHTML + "<h2>";
          postsHTML = postsHTML + posts[i].post_title;
          postsHTML = postsHTML + "</h2>";
          postsHTML = postsHTML + "</div>";
          postsHTML = postsHTML + "</a>";
          postsHTML = postsHTML + "</div>";
        }
      }else{
        postsHTML = postsHTML + "<div class=\"search--result\">";
        postsHTML = postsHTML + "<a href=\"#\">";
        postsHTML = postsHTML + "<div class=\"result_inner\">";
        postsHTML = postsHTML + "<h2>";
        postsHTML = postsHTML + "No Posts Found";
        postsHTML = postsHTML + "</h2>";
        postsHTML = postsHTML + "</div>";
        postsHTML = postsHTML + "</a>";
        postsHTML = postsHTML + "</div>";
      }

      $("#results__title span").html(posts.length);
      $("#results__body").html(postsHTML);
      $(".results__title").addClass('title-show').removeClass('title-hidden');
      $(".results").addClass('results-show').removeClass('results-hidden');
  }
}

function request_results(string){

  set_up_xhr();

  if(xhr != null){
    xhr.onreadystatechange = response_results;

    xhr.open("GET", "/search/" + string + "/true/posts,tags", true);
    xhr.send();
  }
}


$(document).ready(function(){

  $("#searchModal").on('shown.bs.modal', function(){
      $('#search_input').val("");
      $(".results__title").removeClass('title-show').addClass('title-hidden');
      $(".results__results").removeClass('results-show').addClass('results-hidden');
      $('#search_input').focus();
      $("#results__body").html("");
      $(".results__title").removeClass('title-show').addClass('title-hidden');
      $(".results__results").removeClass('results-show').addClass('results-hidden');
  });

  $('#search_input').on('keyup', function() {
    if ($('#search_input').val() == '') {
      $(".results__title").removeClass('title-show').addClass('title-hidden');
      $(".results__results").removeClass('results-show').addClass('results-hidden');
    } else {
      $("#results__body").html("");
      request_results($('#search_input').val());
    }
  })
});
