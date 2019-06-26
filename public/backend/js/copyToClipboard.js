$(document).ready(function(){
  $("#copyAbsoluteLinkForImage").on("click", function(){
    $(".copySuccess").hide();

    var copyText = $("#absolute_link");

    copyText.select();

    document.execCommand("copy");

    $("#absolute_link_success").show();
  });

  $("#copyRelativeLinkForImage").on("click", function(){
    $(".copySuccess").hide();

    var copyText = $("#relative_link");

    copyText.select();

    document.execCommand("copy");

    $("#relative_link_success").show();
  });

  // $("#copyCodeForImage").on("click", function(){
  //   $(".copySuccess").hide();
  //
  //   var copyText = $("#copyImageContainer");
  //
  //   copyText.select();
  //
  //   document.execCommand("copy");
  //
  //   $("#html_copy_success").show();
  // });
});
