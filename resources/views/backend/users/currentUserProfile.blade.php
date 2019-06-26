{{-- {{ View and edit the current user profile }} --}}

{{-- {{ Get the basic template }} --}}
@extends('backend.templates.admin_template')
@section('section')

    @if (isset($user_details) && !empty($user_details) && isset($user_details->user_id) && !empty($user_details->user_id))
      @include('backend.includes.postControlPanel')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper content-wrapper-extended">

        <!-- Main content -->
        <section class="content">
          {{-- {{ Open form }} --}}
          {!! Form::open(['action' => ['UsersController@update', $user_details->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data', "id" => "updateCurrentUserForm"]) !!}
            {{-- {{ Submit button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}

            {{-- {{ Page to redirect to on success }} --}}
            {{Form::hidden('page_redirect', "/admin/user/profile")}}
            {{-- {{ Get the current email address }} --}}
            @if (isset($user_details->user_email) && !empty($user_details->user_email))
              {{Form::hidden('user_current_email', $user_details->user_email)}}
            @endif

            <div class="row">

              <div class="col-md-12">
                <h4>Main Profile</h4>
                <!-- Profile Image -->
                <div class="box box-primary">
                  <div class="box-body box-profile">
                    <div class="form-group text-center">
                      {{-- {{ Get the user profile image }} --}}
                      @if (isset($user_details->user_profile_image) && !empty($user_details->user_profile_image))
                        <img id="user-image" class="profile-user-img img-circle bg-pink img-responsive" src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $user_details->user_profile_image}}" alt="User profile picture">
                      @else
                        <img id="user-image" class="profile-user-img img-circle bg-pink img-responsive" src="{{STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" alt="User profile picture">
                      @endif

                      @if (isset($user_details->user_profile_image) && !empty($user_details->user_profile_image))
                        {{Form::hidden('user_current_profile_image', $user_details->user_profile_image)}}
                      @endif

                      {{Form::file('user_profile_image',['onchange'=>"readURL(this, 'user-image', false);", "id" => "user_profile_image", "style" => "display:inline"])}}
                    </div>
                    {{-- {{ Display the user first name and surname }} --}}
                    <h3 class="profile-username text-center">{{$user_details->user_first_name . " " . $user_details->user_surname}}</h3>
                    <p class="text-muted text-center"><span><strong>Email Address: </strong></span>{{$user_details->user_email}}</p>

                    {{-- {{ Display the user first name for editing }} --}}
                    <div class="form-group">
                      {{Form::label('first_name', 'First Name')}}
                      {{Form::text('first_name', $user_details->user_first_name, ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                    </div>

                    {{-- {{ Display the user surname for editing }} --}}
                    <div class="form-group">
                      {{Form::label('surname', 'Surname')}}
                      {{Form::text('surname', $user_details->user_surname, ['class' => 'form-control', 'placeholder' => 'Surname'])}}
                    </div>
                    {{--  Display information message --}}
                    <div class="alert alert-info">
                      <strong>Please note that when you change your email address you will be logged out of the system and sent a New email to your NEW email address to confirm the change</strong>
                    </div>
                    {{-- {{ Display the user email addres for editing }} --}}
                    <div class="form-group">
                      {{Form::label('user_email', 'Email Address')}}
                      {{Form::text('user_email', $user_details->user_email, ['class' => 'form-control', 'placeholder' => 'Email Address'])}}
                    </div>
                    {{--  Display information message --}}
                    <div class="alert alert-info">
                      <strong>Passwords are not displayed here for security reasons, here you can change your password without being sent an email.</strong>
                    </div>
                    {{-- {{ Empty text box for editing passwords }} --}}
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
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>

            </div>
            <!-- /.row -->

            {{-- {{ Alternative method }} --}}
            {{Form::hidden("_method", "PUT")}}
            {{-- {{ Submit button }} --}}
            {{Form::button('<i class="far fa-save"></i>&nbsp;Update', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}
          {!! Form::close() !!}

        </section>
        <!-- /.content -->
      </div>

      {{-- {{ Display the image selected into the image tag }} --}}
      <script type="text/javascript" src="{{ asset('/backend/js/showImageFromSelection.js') }}"></script>
      <script type="text/javascript" async defer>
        //Allow the user to see what password they have chosen
        $(".toggle-password").click(function() {
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
