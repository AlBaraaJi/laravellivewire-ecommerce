<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="icon" href="{{asset('assets/img/favicon.png')}}">
  <link rel="apple-touch-icon" href="{{asset('assets/img/apple-touch-icon.png')}}">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/quill/quill.snow.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/quill/quill.bubble.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/remixicon/remixicon.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/simple-datatables/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/toastr/toastr.min.css')}}">
  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

  {{-- select input ####################3 --}}
  <link rel="stylesheet" href="{{asset('assets/vendor/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  {{-- @stack('style') --}}
  <livewire:styles />
</head>

<body>
<div>
    <header>
      <!-- Navbar -->
      @include('layouts.partials.navbar2')

    </header>


    <main class="mt-3">
        {{ $slot }}
        {{-- @yield('content') --}}
    </main>
    <!-- End #main -->

  <!-- Main Footer -->
  <!-- ======= Footer ======= -->
  @include('layouts.partials.footer')

</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
<script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
<script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('assets/vendor/toastr/toastr.min.js')}}"></script>

{{-- select input ############### --}}
<script src="{{asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>

<livewire:scripts />
</body>
</html>
