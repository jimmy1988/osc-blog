{{-- {{ Display any messages here to the user }} --}}

<!--Start Content-->
<div class="content-wrapper content-padding" id="messagesContainer" style="display:@if (count($errors) > 0 || session('success') || session('error')) block @else none @endif">
  {{-- {{ Multiple errors }} --}}
  @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger no-gutters mb-0">
        {{$error}}
      </div>
    @endforeach
  @endif

  {{-- {{ Success Message }} --}}
  @if (session('success'))
    <div class="alert alert-success no-gutters mb-0">
      {{session('success')}}
    </div>
  @endif

  {{-- {{ Individual Error messages }} --}}
  @if (session('error'))
    <div class="alert alert-danger no-gutters mb-0">
      {{session('error')}}
    </div>
  @endif
</div>
