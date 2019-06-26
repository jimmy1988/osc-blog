{{-- {{ Display all users }} --}}

{{-- {{ Get the main admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')
  {{-- {{ Get the main control panel }} --}}
  @include('backend.includes.postControlPanel')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-extended">

    {{-- {{ Display  }} --}}

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive" id="all-users-table-container">
            <table class="table table-bordered table-striped table-hover" id="all-users-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email Address</th>
                  <th>User Level</th>
                  <th>User Created</th>
                  <th>User Last Updated</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @if (isset($users) && !empty($users) && $users->count() > 0)
                  @foreach ($users as $user)
                    @if (isset($user) && !empty($user))
                      <tr>
                        <td>
                          {{-- {{ User firstname and surname }} --}}
                          @if (isset($user->user_first_name) && !empty($user->user_first_name) && isset($user->user_surname) && !empty($user->user_surname))
                            {{$user->user_first_name . " " . $user->user_surname}}
                          @else
                            {{ "&nbsp;" }}
                          @endif
                        </td>
                        <td>
                          {{-- {{ User Email Address }} --}}
                          @if (isset($user->user_email) && !empty($user->user_email))
                            {{$user->user_email}}
                          @else
                            {{ "&nbsp;" }}
                          @endif
                        </td>
                        <td>
                          {{-- {{ User Level }} --}}
                          @if (isset($user->userLevel->level) && !empty($user->userLevel->level))
                            {{$user->userLevel->level}}
                          @else
                            {{ "&nbsp;" }}
                          @endif
                        </td>
                        <td>
                          {{-- {{ User Created  }} --}}
                          @if (isset($user->user_created) && !empty($user->user_created))
                            {{date("l jS F Y H:i",strtotime($user->user_created))}}
                          @else
                            {{ "&nbsp;" }}
                          @endif
                        </td>
                        <td>
                          {{-- {{ User Last Updated }} --}}
                          @if(isset($user->user_last_updated) && !empty($user->user_last_updated) && $user->user_last_updated != "0000-00-00 00:00:00")
                            {{date("l jS F Y H:i",strtotime($user->user_last_updated))}}
                          @else
                            {{"Not Updated Yet"}}
                          @endif
                        </td>
                        <td>
                          {{-- {{ Show the edit and delete buttons }} --}}
                          @if (isset($user->user_id) && !empty($user->user_id) && Auth::id() != null && !empty(Auth::id()) && $user->user_id != Auth::id())
                            {{-- {{ edit button }} --}}
                            <a href="/admin/user/{{$user->user_id}}/edit" class="btn btn-info" role="button"><i class="fas fa-edit"></i></a>
                            {{-- {{ Delete Button }} --}}
                            {!!Form::open(['action' => ['UsersController@destroy', $user->user_id, "true"], 'method' => 'POST', 'class' =>'visible-sm-inline-block visible-md-inline-block visible-xs-inline-block visible-lg-inline-block visible-xl-inline-block deleteUserForm'])!!}
                              {{Form::hidden('_method', 'DELETE')}}
                              @if (isset($user->user_first_name) && !empty($user->user_first_name) && isset($user->user_surname) && !empty($user->user_surname))
                                {{Form::hidden('user_name', $user->user_first_name . " " . $user->user_surname, ["id" => "user_name_hidden_delete"])}}
                              @endif

                              @if (isset($user->user_email) && !empty($user->user_email))
                                {{Form::hidden('user_email', $user->user_email, ["id" => "user_email_hidden_delete"])}}
                              @endif
                              <button type="submit" name="delete" value="delete" class="btn btn-danger deleteUserButton"><i class="fas fa-trash-alt"></i></button>
                            {!!Form::close()!!}
                          @endif

                        </td>
                      </tr>
                    @endif
                  @endforeach
                @else
                  <tr>
                    <td colspan="6">
                      No Users Found
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script type="text/javascript">
    $(document).ready( function(){
      $.noConflict();
      //datatables
      @if (isset($users) && !empty($users))
        @if (count($users) > 0)
          $("#all-users-table").DataTable({
            autoWidth:  false,
          }).columns.adjust();
        @endif
      @endif

      //Confirmation button for delete
      $(".deleteUserForm").on("submit", function(){

        var user_name = $(this).children("#user_name_hidden_delete").val();
        var user_email = $(this).children("#user_email_hidden_delete").val();
        var confirm = window.confirm("Are you sure you wish to delete the user " + user_name + " with the email address " + user_email + "?");

        if(confirm){
          return true;
        }else{
          return false;
        }
      });
    });
  </script>
@endsection
