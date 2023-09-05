<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  @include("admin.component.css_js.css")
  @include("pos.component.css_js.css")
  @yield('css')
</head>

<body class="@yield('class')">

  <!-- ======= Header ======= -->
  @include("pos.component.header")
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @yield('sidebar')
  <!-- End Sidebar-->

  <main id="main" class="main">

    @yield("content")    
  
  </main>
  <!-- End #main -->
  <!-- ======= Footer ======= -->
  @include("admin.component.footer")
  {{-- js --}}
   
  @include("admin.component.css_js.js")

  @include("pos.component.css_js.javascript")

  @yield("javacript")   

</body>

</html>