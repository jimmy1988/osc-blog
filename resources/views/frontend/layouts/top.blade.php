{{-- {{ Open the document }} --}}

<?php
    //Turn off cache control
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Connection: close");
?>

{{-- {{ Start of the document }} --}}
<!DOCTYPE html>
<html>
  <head>
    {{-- {{ Define the charset }} --}}
    <meta charset="utf-8">
    {{-- {{ Make this compatabile for IE and edge }} --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html" />

    {{-- {{ Define the title of the document }} --}}
    @if (isset($title1) && !empty($title1) && $title1 == "true")
      <title>@isset($page_title) {{ $page_title  . "-" }} @endisset Open Study College Blog</title>
    @else
      <title>Open Study College Blog @if(isset($page_title) && !empty($page_title)) {{ "-" . $page_title }} @endisset </title>
    @endif

    {{-- {{ Define the favicon of the document }} --}}
    <link href="/backend/images/favicon.ico" rel="shortcut icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- {{ Turn off cache control }} --}}
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <!--Meta Tags Here-->
    @if (isset($seo_tags) && !empty($seo_tags) && count($seo_tags) > 0)
      @for ($i=0; $i < count($seo_tags); $i++)
        <meta
        @foreach ($seo_tags[$i] as $seoAttribute => $value)
          {{ $seoAttribute . "=" . "\"" . $value . "\"" }}
        @endforeach
        />
      @endfor
    @endif

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/backend/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/backend/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/backend/assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/backend/assets/dist/css/AdminLTE.min.css">
    <!-- backendLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/backend/assets/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/backend/assets/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/backend/assets/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/backend/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/backend/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/backend/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- {{ Define font awesome }} --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    {{-- {{ Define the frontend stylesheet }} --}}
    <link href="{{ asset('/frontend/css/style.css') }}" rel="stylesheet">

    <!-- jQuery 3 -->
    <script src="/backend/assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/backend/assets/bower_components/jquery-ui/jquery-ui.min.js"></script>

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
