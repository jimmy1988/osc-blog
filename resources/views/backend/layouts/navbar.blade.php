{{-- {{ Top Admin navbar }} --}}

<!--Start of navbar-->
<nav class="navbar navbar-static-top bg-pink">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      {{-- {{ Go the main website }} --}}
      <li class="dropdown">
        <a href="https://www.openstudycollege.com/" target="_blank" class="btn btn-default bg-pink strip-post-button" title="Go to the website (opens new tab)"><span><i class="fa fa-globe"></i></span></a>
      </li>
      {{-- {{ Got the main blog site }} --}}
      <li class="dropdown">
        <a href="/" class="btn btn-default bg-pink strip-post-button" target="_blank" title="Go to the main blog page (Opens new tab)"><span><i class="fas fa-blog"></i></span></a>
      </li>
      {{-- {{ Create a new post }} --}}
      <li class="dropdown">
        <a href="/admin/post/create" title="Create Post" class="btn btn-default bg-pink strip-post-button" title="Create a New Post"><span><i class="fa fa-plus-circle"></i></span></a>
      </li>

      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          {{-- {{ Get the user profile image}} --}}
          @if (isset($user_details->user_profile_image) && !empty($user_details->user_profile_image))
            <img src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $user_details->user_profile_image}}" class="img-circle" width="25px" height="25px" alt="User Image">
          @else
            <img src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER. "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" width="25px" height="25px" alt="User Image">
          @endif
          <span class="hidden-xs alignUserName">
            {{-- {{ User first name }} --}}
            @if(isset($user_details->user_first_name) && !empty($user_details->user_first_name)) {{$user_details->user_first_name}} @else Guest @endif
            {{-- {{ User surname }} --}}
            @if(isset($user_details->user_surname) && !empty($user_details->user_surname)) {{" " . $user_details->user_surname}} @endif
          </span>
          <i class="fa fa-chevron-down alignUserName"></i>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header bg-green">
            @if (isset($user_details->user_profile_image) && !empty($user_details->user_profile_image))
              <img src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $user_details->user_profile_image}}" class="img-circle" alt="User Image">
            @else
              <img src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER. "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" style="border:none;width:100px;height:100px;" alt="User Image">
            @endif

            <p>
              @if(isset($user_details->user_first_name) && !empty($user_details->user_first_name)) {{$user_details->user_first_name}} @else Guest @endif
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            {{-- {{ Profile edit button }} --}}
            <div class="pull-left">
              <a href="/admin/user/profile" class="btn btn-default btn-flat">Profile</a>
            </div>
            {{-- {{ Log out button }} --}}
            <div class="pull-right">
              <a class="btn btn-default btn-flat" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>

              {{-- {{ Log out form }} --}}
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
</nav>
<!--End of navbar-->
