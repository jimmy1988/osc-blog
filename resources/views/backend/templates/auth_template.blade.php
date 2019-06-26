{{-- {{ Basic authentication template }} --}}

{{-- {{ Get the top of the template }} --}}
@include('backend.layouts.top')
{{-- {{ Get the header }} --}}
@include('backend.layouts.header')

{{-- {{ If we have nojavascript enabled or detected then we display this message }} --}}
<noscript>
  <div class="content-wrapper content-padding content-wrapper-extended">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-danger">
          You do not have Javascript enabled in your browser, please go to your browser settings and enable javscript
        </div>
      </div>
    </div>
  </div>
</noscript>

{{-- {{ Get the page content }} --}}
@yield('content')

{{-- {{ Get the bottom credits }} --}}
@include('backend.layouts.credits')

{{-- {{ get the scripts for the page }} --}}
@include('backend.layouts.scripts')

{{-- {{ Get the bottom of the document }} --}}
@include('backend.layouts.bottom')
