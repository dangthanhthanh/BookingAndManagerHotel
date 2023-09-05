@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/about.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/about_responsive.css')}}">
@endsection
@section("content")
	<!-- Home -->
	<div class="home">
		<div class="background_image" style='background-image:url("{{asset('client/images/about.jpg')}}")'></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div class="home_title">{{$title}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- About -->
	<div class="about">
		<div class="container">
			{!!$description!!}
		</div>
	</div>
@endsection
@section("js")
<script src="{{asset('client/js/about.js')}}"></script>
@endsection