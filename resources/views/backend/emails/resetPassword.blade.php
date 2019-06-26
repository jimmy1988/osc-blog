{{-- {{ Reset Password email that is sent to the user }} --}}

{{-- {{ Get the emaio template }} --}}
@extends('backend.templates.email_template')
@section('content')

  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="750" class="container">
      <tr>
        <td>
          <h2 style="text-align:center;">Password Reset Requested</h2>
        </td>
      </tr>
      <tr>
          <td style="padding: 25px 10px;">Dear [First Name] [Surname]</td>
      </tr>
      <tr>
          <td style="padding: 5px 10px;">A password reset has been requested for your account on the Open Study College Blog System, click on the following button to reset your password. If you did not perform this action then an attempt to compromise your account has been made and you should escalate this to the IT department immediately.</td>
      </tr>
      <tr>
        <td style="padding: 5px 10px;">
          <a href="{{url('password/reset/' . $user->user_id . "/" . $user->password_reset_token)}}" class="btn bg-green">Reset My Password</a>
        </td>
      </tr>
      <tr>
        <td style="padding: 25px 10px;">
          Yours Sincerely
        </td>
      </tr>
      <tr>
        <td style="padding: 25px 10px;">
          The Open Study College Team
        </td>
      </tr>
  </table>

@endsection
