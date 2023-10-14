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
							<div class="home_title">{{ucfirst($title)}}</div>
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
			<div class="row mt-5">
				@if(!(Route::currentRouteName() === 'client.blog.detail'))
					<div class="book_button">
						<a href="">Book Now</a>
					</div>
				@endif
				<div class="book_button">
					<a href="javascript:window.location='{{ URL::previous() }}'">Return Back</a>
				</div>
			</div>
		</div>
	</div>
@endsection
@section("js")
<script src="{{asset('client/js/about.js')}}"></script>
@endsection