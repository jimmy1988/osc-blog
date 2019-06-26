function readURL(input, target, changeClass = true) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {

        if(changeClass){
          $('#' + target).removeClass("changeImage");
          $('#' + target).removeClass("no-image");
          $('#' + target).parent().removeClass("no-image");
          $('#' + target).addClass("changeImage");
        }

        $('#' + target)
            .attr('src', e.target.result);

        $('#' + target).show();
      };

      reader.readAsDataURL(input.files[0]);
  }
}
