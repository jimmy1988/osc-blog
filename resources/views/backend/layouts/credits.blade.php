{{-- {{ Admin Credits }} --}}

<?php
  //Get the user id
  $user_id = Auth::id();

  //if we have the user id then we get theb custom admin footer class
  if(isset($user_id) && !empty($user_id) && $user_id > 0){
    $customClasses = "footerAdmin";
  }
?>

<div id="footerContainer">
  <footer class=" content-padding bg-green @isset($customClasses) {{$customClasses}} @endisset" id="creditsFooter">
    <span>&copy;Open Study College <?php echo date("Y"); ?> | Version 1.0</span>
  </footer>
</div>
