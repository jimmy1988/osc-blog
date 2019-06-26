var protocol = "";
var domain = "";
var path = "";
var filename = "";
var alt_text = "";
var meta_description = "";
var fields = new Array();
var uploaded_by = "";
var uploaded_on = "";
var file_type = "";

function formatDate(date) {

  var dateTimeSplit = date.split(" ");

  var date = new Date(date);

  var dayNames = [
    "Sunday", "Monday", "Tuesday",
    "Wednesday", "Thursday", "Friday",
    "Saturday"
  ];

  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];

  var dayName = date.getDay();
  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return dayNames[dayName] + ' ' + day + ' ' + monthNames[monthIndex] + ' ' + year + " " + dateTimeSplit[1];
}

function resetValues(){
  $("#modal-image").attr("src", "");
  $("#absolute_link").val("");
  $("#relative_link").val("");
  $("#alt_text").val("");
  $("#meta_description").val("");
  $("#uploaded_by_modal_bottom_span").html("");
  $("#uploaded_on_modal_bottom_span").html("");
  $("#filename_modal_bottom_span").html("");
  $("#filetype_modal_bottom_span").html("");
  $("#updateCurrentMediaForm").attr("action", "");
  protocol = "";
  domain = "";
  path = "";
  filename = "";
  alt_text = "";
  meta_description = "";
  uploaded_by = "";
  uploaded_on = "";
  file_type = "";
  fields = new Array();
}

function loadModal(elem){
  event.preventDefault();

  resetValues();

  var id = $(elem).attr("id");

  fields = $("#frm-med-del-" + id).children(".inputMediaFieldHidden");

  if($(elem).hasClass("servGen")){

    uploaded_on = formatDate(fields[11].value);
    // uploaded_on = fields[11].value;

    protocol = fields[1].value + ":\/\/";
    domain = fields[0].value;
    path = "\/storage\/images\/media_items\/";
    filename = fields[4].value;
    alt_text = fields[8].value;
    meta_description = fields[9].value;
    uploaded_by = fields[13].value + " " + fields[14].value;
    file_type = fields[5].value + " (" + fields[6].value + ")";
  }else{

    uploaded_on = formatDate(fields[10].value);
    var dateSplit = uploaded_on.split(" ");
    var date = dateSplit[0];
    var time = dateSplit[1];

    protocol = fields[1].value + ":\/\/";
    domain = fields[0].value;
    path = "\/storage\/images\/media_items\/";
    filename = fields[3].value;
    alt_text = fields[7].value;
    meta_description = fields[13].value;
    uploaded_by = fields[14].value + " " + fields[15].value;
    file_type = fields[4].value + " (" + fields[5].value + ")";
  }

  $("#modal-image").attr("src", path + filename);
  $("#absolute_link").val(protocol + domain + path  + filename);
  $("#relative_link").val(path  + filename);
  $("#alt_text").val(alt_text);
  $("#meta_description").val(meta_description);

  $("#uploaded_by_modal_bottom_span").html(uploaded_by);
  $("#uploaded_on_modal_bottom_span").html(uploaded_on);
  $("#filename_modal_bottom_span").html(filename);
  $("#filetype_modal_bottom_span").html(file_type);

  $("#updateCurrentMediaForm").attr("action", protocol + domain + "\/admin\/media\/" + id)

  $("#myModal").fadeIn(500);
}


$(document).ready(function(){
  $(".openModel").on("click", function(){
    loadModal(this);
  });

  $(".close").on("click",function(){
    $("#myModal").fadeOut(500, function(){
      resetValues();
    });

  });
});
