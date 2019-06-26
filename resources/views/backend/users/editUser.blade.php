{{-- {{ Edit a users profile }} --}}


{{-- {{ Get the basic template }} --}}
@extends('backend.templates.admin_template')
@section('section')

    @if (isset($user) && !empty($user) && isset($user->user_id) && !empty($user->user_id) && $user->user_id > 0)
      @include('backend.includes.postControlPanel')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper content-wrapper-extended">

        <!-- Main content -->
        <section class="content">
          {{-- {{ Open form }} --}}
          {!! Form::open(['action' => ['UsersController@update', $user->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data', "id" => "updateCurrentUserForm"]) !!}
            {{-- {{ Submit button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}
            {{-- {{ Name of page to redirect to on success }} --}}
            {{Form::hidden('page_redirect', "/admin/user/" . $user->user_id . "/edit")}}
            {{-- {{ Get the current user email address }} --}}
            @if (isset($user->user_email) && !empty($user->user_email)) {{Form::hidden('user_current_email', $user->user_email)}} @endif
            <div class="row">

              <div class="col-md-12">
                <h4>Main Profile</h4>
                <!-- Profile Image -->
                <div class="box box-primary">
                  <div class="box-body box-profile">
                    {{-- {{ Get the user profile image }} --}}
                    <div class="form-group text-center">
                      @if (isset($user->user_profile_image) && !empty($user->user_profile_image))
                        <img id="user-image" class="profile-user-img img-circle bg-pink img-responsive" src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $user->user_profile_image}}" alt="User profile picture">
                      @else
                        <img id="user-image" class="profile-user-img img-circle bg-pink img-responsive" src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" alt="User profile picture">
                      @endif

                      {{-- {{ Ge the current user profile image }} --}}
                      @if (isset($user->user_profile_image) && !empty($user->user_profile_image)) {{Form::hidden('user_current_profile_image', $user->user_profile_image)}} @endif
                      {{-- {{ User can pick a new user image }} --}}
                      {{Form::file('user_profile_image',['onchange'=>"readURL(this, 'user-image', false);", "id" => "user_profile_image", "style" => "display:inline"])}}
                    </div>
                    {{-- {{ Display the user first name and surname }} --}}
                    @if (isset($user->user_first_name) && !empty($user->user_first_name) && isset($user->user_surname) && !empty($user->user_surname))
                      <h3 class="profile-username text-center">{{$user->user_first_name . " " . $user->user_surname}}</h3>
                    @endif

                    {{-- {{ Display the user email }} --}}
                    @if (isset($user->user_email) && !empty($user->user_email))
                      <p class="text-muted text-center"><span><strong>Email Address: </strong></span>{{$user->user_email}}</p>
                    @endif

                    {{-- {{ Get the user first name ready for editing }} --}}
                    <div class="form-group">
                      {{Form::label('first_name', 'First Name')}}
                      {{Form::text('first_name', $user->user_first_name, ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                    </div>
                    {{-- {{ Get the users surname ready for editing }} --}}
                    <div class="form-group">
                      {{Form::label('surname', 'Surname')}}
                      {{Form::text('surname', $user->user_surname, ['class' => 'form-control', 'placeholder' => 'Surname'])}}
                    </div>
                    {{-- {{ Display and information message }} --}}
                    <div class="alert alert-info">
                      <strong>Please note that when you change your email address you will be logged out of the system and sent a New email to your NEW email address to confirm the change</strong>
                    </div>
                    {{-- {{ Get the users email address for editing }} --}}
                    <div class="form-group">
                      {{Form::label('user_email', 'Email Address')}}
                      {{Form::text('user_email', $user->user_email, ['class' => 'form-control', 'placeholder' => 'Email Address'])}}
                    </div>
                    {{-- {{ Dislay information message }} --}}
                    <div class="alert alert-info">
                      <strong>Passwords are not displayed here for security reasons, here you can change your password without being sent an email.</strong>
                    </div>
                    {{-- {{ Empty password field for changing the password }} --}}
                    <div class="form-group">
                      <label for="user_password">{{ __('Password') }}</label>
                      <input id="user_password" type="password" class="form-control" name="user_password" autocomplete="new-password">
                      <span toggle="#user_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    {{-- {{ Empty password field to confirm the new password }} --}}
                    <div class="form-group">
                      <label for="password-confirm">{{ __('Confirm Password') }}</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                      <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    {{-- {{ Display all user levels and select users current user level}} --}}
                    <div class="form-group">
                      {{Form::label('user_level', 'Access Level')}}
                      <select id="user_level" name="user_level" class="form-control">
                        @if (isset($user_levels) && !empty($user_levels))
                          @foreach ($user_levels as $user_level)
                            @if (isset($user_level->level_id) && !empty($user_level->level_id) && isset($user->user_level) && !empty($user->user_level) && isset($user_level->level) && !empty($user_level->level))
                              <option value="{{$user_level->level_id}}"
                              @if ($user_level->level_id == $user->user_level)
                                selected
                              @endif
                              >{{$user_level->level}}</option>
                            @endif
                          @endforeach
                        @else
                          <option value="0">No User Levels Found</option>
                        @endif
                      </select>
                    </div>

                    {{-- {{ Display all user statuses and select the current user status }} --}}
                    <div class="form-group">
                      {{Form::label('user_status', 'Status')}}
                      <select id="user_status" name="user_status" class="form-control">
                        @if (isset($user_status) && !empty($user_status))
                          @foreach ($user_status as $status)
                            @if (isset($status->status_id) && !empty($status->status_id) && isset($user->user_status) && !empty($user->user_status) && isset($status->status) && !empty($status->status))
                              <option value="{{$status->status_id}}"
                              @if ($status->status_id == $user->user_status)
                                selected
                              @endif
                              >{{$status->status}}</option>
                            @endif
                          @endforeach
                        @else
                          <option value="0">No User Levels Found</option>
                        @endif
                      </select>
                    </div>

                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>

            </div>
            <!-- /.row -->
            {{-- {{ Alternative method flag }} --}}
            {{Form::hidden("_method", "PUT")}}
            {{-- {{ Submit button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}
          {!! Form::close() !!}
          {{-- {{ Close form }} --}}

        </section>
        <!-- /.content -->
      </div>

      {{-- {{ Script to display the image frm the box inside the image field so the user knows what image they have selected }} --}}
      <script type="text/javascript" src="{{ asset('/backend/js/showImageFromSelection.js') }}"></script>
      <script type="text/javascript" async defer>
        $(".toggle-password").click(function() {

          //Allows users to see what password they have before they change it
          $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $($(this).attr("toggle"));
          if (input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
        });
      </script>
    @endif
@endsection
