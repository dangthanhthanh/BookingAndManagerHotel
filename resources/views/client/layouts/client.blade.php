<!DOCTYPE html>
<html lang="en">
<head>
<title>The River: {{ request()->route()->getName()}}</title>
@include("client.component.css_js.css")
@yield('css')
</head>
<body>
<div class="super_container">
	
	<!-- Header -->
    @include("client.component.header")
	<!-- Menu -->
    @include("client.component.menu")
	<!-- Home -->
    @yield('content')
	<!-- Footer -->
    @include("client.component.footer")
	
</div>
@include("client.component.css_js.javascript")
@yield('js')
</body>
</html>