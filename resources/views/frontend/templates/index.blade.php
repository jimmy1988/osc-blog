{{-- {{ Basic home page/index frontend template }} --}}

{{-- {{ Open the main document and get the head tags }} --}}
@include('frontend.layouts.top')

{{-- {{ Get the page content }} --}}
@yield('section')

{{-- {{ Get the search modal for the ajax search }} --}}
@include('frontend.includes.searchModal')

{{-- {{ Get the footer }} --}}
@include('frontend.layouts.footer')

{{-- {{ Get the scripts for the page }} --}}
@include('frontend.layouts.scripts')

{{-- {{ Get the closing tags to close the document }} --}}
@include('frontend.layouts.bottom')
