{{-- {{ Display the user details }} --}}

<!-- Sidebar user panel -->
<div class="user-panel">
  <div class="pull-left image mt-1">
    {{-- {{ Gte the user profile image }} --}}
    @if (isset($user_details->profile_image) && !empty($user_details->profile_image))
      <img src="{{ STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $user_details->profile_image}}" class="img-circle" alt="User Image">
    @else
      <img src="{{ STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER. "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" style="padding-top:5px;border:none;width:35px;height:35px;" alt="User Image">
    @endif
  </div>
  {{-- {{ Get the user name }} --}}
  <div class="pull-left info">
    <p>@if(isset($user_details->name) && !empty($user_details->name)) {{$user_details->name}} @else Guest @endif</p>
    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
  </div>
</div>
