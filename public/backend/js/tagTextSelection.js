var xhr = null;
var mainParent = null;

function set_up_xhr(){
  if (window.XMLHttpRequest) {
   // code for modern browsers
   xhr= new XMLHttpRequest();
 }else{
   // code for old IE browsers
   xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }

}

function hideSearch(elem, e){
  console.log(e.target.className == "searc");
  if(e.target.className != "searchItem" || e.target.className == null || e.target.className == undefined || e.target.className == ""){
    $(".livesearch").hide();
  }
}

function response_results(){
  if (xhr.readyState == 4 && xhr.status == 200) {
      if(xhr.responseText == "No Results Found"){
        var tagsHTML = "No Results Found";
        $(mainParent).children().first().children().first().children("div.livesearch").show().append(tagsHTML);
      }else{
        var tags = JSON.parse(xhr.responseText);
        var tagsHTML = "";

        for(var i = 0; i < tags.length; i++){
          if(tags[i].tag_name != null && tags[i].tag_name != undefined && tags[i].tag_name != ""){
            tagsHTML = tagsHTML + "<p><a href=\"#\" class=\"searchItem\" onclick=\"autofill_tag(this);\">"  + tags[i].tag_name + "</a></p>";
          }
        }

        if(tags.length > 0){
          $(mainParent).children().first().children().first().children("div.livesearch").show().append(tagsHTML);
        }
      }


  }
}

function request_results(elem){

  $(mainParent).children().first().children().first().children("div.livesearch").hide().html("");

  set_up_xhr();

  if(xhr != null){

    var string = $(elem).val();

    if(string != "" && string != null && string != undefined && string.length > 0){
      mainParent = $(elem).parent().parent().parent();

      xhr.onreadystatechange = response_results;

      xhr.open("GET", "/admin/tags/getAddTagSearchResults/" + string, true);
      xhr.send();
    }


  }
}

function deleteTag(elem){
  $(elem).parent().parent().parent().slideUp(200, function(){
    $(elem).parent().parent().parent().remove();
  });
}

function autofill_tag(elem){
  event.preventDefault();
  var all_tags = $(".tag-name");

  if(all_tags.length > 1){

    var duplicate_tags = -1;

    for(var i = 0; i < all_tags.length; i++){
      if(all_tags[i].value == $(elem).html().trim()){
        duplicate_tags++;
      }
    }

    if(duplicate_tags < 0){
      $(elem).parent().parent().parent().children().first().val($(elem).html().trim());
    }else{
      $(elem).parent().parent().parent().children().first().val("");
    }
  }else{
    $(elem).parent().parent().parent().children().first().val($(elem).html().trim());
  }

  $(elem).parent().parent().hide();
}

$(document).ready(function(){

  $("#add-tag").on("click", function(){
    $("#tags-panel-body").append(tagsHtml);
    $(".add-tag-row").last().hide().slideDown(200);
  });

  $("body").on("click", function(){
    hideSearch(this, event);
  });

});
