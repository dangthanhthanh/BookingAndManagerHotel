<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  @include("admin.component.css_js.css")
</head>

<body>

  <!-- ======= Header ======= -->
  @include("admin.component.header")
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include("admin.component.side_bar")
  <!-- End Sidebar-->

  <main id="main" class="main">

    @yield("content")    
  
  </main>
  <!-- End #main -->
  <!-- ======= Footer ======= -->
  @include("admin.component.footer")
{{-- js --}}
  @include("admin.component.css_js.js")

  @yield("javacript")    

</body>

</html>