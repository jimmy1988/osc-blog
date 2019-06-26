{{-- {{ Display all media items, upload edit and delete media items }} --}}

<?php
  //specify the protocol we are rediding on - whether it is HTTP or HTTPS
  $protocol =  isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ?  'https' : 'http';

?>

{{-- {{ Get the admin template }} --}}
@extends('backend.templates.admin_template')
@section('section')
  {{-- {{ Get the control panel }} --}}
{{--  @include('backend.includes.postControlPanel')--}}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-extended">

    <!-- Main content -->
    <section class="content">
      <div class="row" id="allImages">
        <div class="col-xs-12">
          <div class="row" id="allImagesContainer">
              <iframe src="/laravel-filemanager" width="100%" height="700px">
              </iframe>
          </div>
        </div>
      </div>

    </section>
  </div>

@endsection
