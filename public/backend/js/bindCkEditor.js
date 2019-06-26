$(document).ready(function(){
  if(document.getElementById("ckeditor")){
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Images&_token='
    };
    CKEDITOR.replace( 'ckeditor', options );
  }

  $('#lfm_feature').filemanager('image');
  $('#lfm_banner').filemanager('image');
});
