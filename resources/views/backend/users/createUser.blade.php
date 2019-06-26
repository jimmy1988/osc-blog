{{-- {{ Create a new user }} --}}

{{-- {{ Get the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')
  @include('backend.includes.postControlPanel')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-extended">

    <!-- Main content -->
    <section class="content">
      {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', "id" => "updateCurrentUserForm"]) !!}
      {{Form::button('<i class="far fa-save"></i>&nbsp;Save', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}
        <div class="row">

          <div class="col-md-12">
            <h4>Main Profile</h4>
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <div class="form-group text-center">
                  {{-- {{ User profile image }} --}}
                  <img id="user-image" class="profile-user-img img-circle bg-pink img-responsive" src="{{STORAGE_FOLDER. IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER. "/" . USER_PROFILE_IMAGES_NO_IMAGE_FILE}}" alt="User profile picture">
                  {{Form::file('user_profile_image',['onchange'=>"readURL(this, 'user-image', false);", "id" => "user_profile_image", "style" => "display:inline"])}}
                </div>
                {{-- {{ First name }} --}}
                <div class="form-group">
                  {{Form::label('first_name', 'First Name')}}
                  {{Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                </div>
                {{-- {{ Surname }} --}}
                <div class="form-group">
                  {{Form::label('surname', 'Surname')}}
                  {{Form::text('surname', '', ['class' => 'form-control', 'placeholder' => 'Surname'])}}
                </div>
                {{-- {{ Email Address }} --}}
                <div class="form-group">
                  {{Form::label('user_email', 'Email Address')}}
                  {{Form::text('user_email', '', ['class' => 'form-control', 'placeholder' => 'Email Address'])}}
                </div>
                {{-- {{ Password }} --}}
                <div class="form-group">
                  <label for="user_password">{{ __('Password') }}</label>
                  <input id="user_password" type="password" class="form-control" name="user_password" autocomplete="new-password">
                  <span toggle="#user_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                {{-- {{ Confirm Password }} --}}
                <div class="form-group">
                  <label for="password-confirm">{{ __('Confirm Password') }}</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                  <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>

                {{-- {{ Get all user levels }} --}}
                <div class="form-group">
                  {{Form::label('user_level', 'Access Level')}}
                  <select id="user_level" name="user_level" class="form-control">
                    @if (isset($user_levels) && !empty($user_levels))
                      @foreach ($user_levels as $user_level)
                        @if (isset($user_level->level_id) && !empty($user_level->level_id) && isset($user_level->level) && !empty($user_level->level))
                          <option value="{{$user_level->level_id}}"
                            @if ($user_level->level_id == 4)
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

                {{-- {{ Get user statuses }} --}}
                <div class="form-group">
                  {{Form::label('user_status', 'Status')}}
                  <select id="user_status" name="user_status" class="form-control">
                    @if (isset($user_status) && !empty($user_status))
                      @foreach ($user_status as $status)
                        @if (isset($status->status_id) & !empty($status->status_id) && isset($status->status) && !empty($status->status))
                          <option value="{{$status->status_id}}"
                            @if ($status->status_id == 1)
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
        {{-- {{ Submit button }} --}}
        {{Form::button('<i class="far fa-save"></i>&nbsp;Save', ['type' =>"submit",'class'=>'btn btn-primary bg-pink', "id" => "updateUserButton"])}}
      {!! Form::close() !!}

    </section>
    <!-- /.content -->
  </div>

  {{-- {{ Script to the image from the selection that has been made }} --}}
  <script type="text/javascript" src="{{ asset('/backend/js/showImageFromSelection.js') }}"></script>
  <script type="text/javascript" async defer>
    //toggle the password field
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
@endsection
