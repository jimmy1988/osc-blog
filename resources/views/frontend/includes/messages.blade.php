{{-- {{ Display all messages that are generated as part of errors or success }} --}}

<!--Start Messages-->
<div class="content-wrapper content-padding" id="messagesContainer" style="display:@if (count($errors) > 0 || session('success') || session('error')) block @else none @endif">
  {{-- {{ Display errors }} --}}
  @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger no-gutters mb-0">
        {{$error}}
      </div>
    @endforeach
  @endif

  {{-- {{ Display success message }} --}}
  @if (session('success'))
    <div class="alert alert-success no-gutters mb-0">
      {{session('success')}}
    </div>
  @endif

  {{-- {{ Dislay individual error message }} --}}
  @if (session('error'))
    <div class="alert alert-danger no-gutters mb-0">
      {{session('error')}}
    </div>
  @endif
</div>
<!--End Messages-->
