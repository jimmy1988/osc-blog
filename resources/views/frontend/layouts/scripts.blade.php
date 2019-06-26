{{-- {{ Displays all the script orun on the frontend }} --}}

<!--Get script for the main ajax blog search-->
<script type="text/javascript" src="/frontend/js/frontendBlogSearch.js"></script>

<!--Add and remove the nav classes-->
<script type="text/javascript">
    $(document).ready(function($) {
      $('body').on('click', '.js-togglenav', function(event) {
          event.preventDefault();
          var $html = $('html');
          var $btn = $(this);

          if($html.hasClass('navtoggled')){
              $html.removeClass('navtoggled')
          } else {
              $html.addClass('navtoggled')
          }
      });
    });


</script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/backend/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/backend/assets/bower_components/raphael/raphael.min.js"></script>
<script src="/backend/assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/backend/assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/backend/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/backend/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/backend/assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/backend/assets/bower_components/moment/min/moment.min.js"></script>
<script src="/backend/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/backend/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/backend/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/backend/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/backend/assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/backend/assets/dist/js/adminlte.min.js"></script>
<!-- Scripts -->
<script src="{{ asset('/js/app.js') }}" defer></script>
