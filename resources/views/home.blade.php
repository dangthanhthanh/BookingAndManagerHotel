@extends("client.layouts.client")
@section('css')
<link href="{{asset('client/plugins/colorbox/colorbox.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/responsive.css')}}">
@endsection
@section("content")
<div class="home">
	<div class="home_slider_container">
		<div class="owl-carousel owl-theme home_slider">
			<!-- Slide -->
			<div class="slide">
				<div class="background_image" style='background-image:url("{{asset('client/images/index_1.jpg')}}")'></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">
									<div class="home_title">A Luxury Stay</div>
									@include("client.component.bookingform")
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Slide -->
			<div class="slide">
				<div class="background_image" style='background-image:url("{{asset('client/images/index_1.jpg')}}")'></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">
									<div class="home_title">A Luxury Stay</div>
									@include("client.component.bookingform")
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Slide -->
			<div class="slide">
				<div class="background_image" style='background-image:url("{{asset('client/images/index_1.jpg')}}")'></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">
									<div class="home_title">A Luxury Stay</div>
									@include("client.component.bookingform")
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		
		<!-- Home Slider Dots -->
		<div class="home_slider_dots_container">
			<div class="home_slider_dots">
				<ul id="home_slider_custom_dots" class="home_slider_custom_dots d-flex flex-row align-items-start justify-content-start">
					<li class="home_slider_custom_dot active">01.</li>
					<li class="home_slider_custom_dot">02.</li>
					<li class="home_slider_custom_dot">03.</li>
				</ul>
			</div>
		</div>
		
	</div>
</div>

<!-- Features -->

<div class="features">
	<div class="container">
		<div class="row">
			
			<!-- Icon Box -->
			<div class="col-lg-4 icon_box_col">
				<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
					<div class="icon_box_icon"><img src="{{asset('client/images/icon_1.svg')}}" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
					<div class="icon_box_title"><h2>Fabulous Resort</h2></div>
					<div class="icon_box_text">
						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
					</div>
				</div>
			</div>

			<!-- Icon Box -->
			<div class="col-lg-4 icon_box_col">
				<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
					<div class="icon_box_icon"><img src="{{asset('client/images/icon_2.svg')}}" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
					<div class="icon_box_title"><h2>Infinity Pool</h2></div>
					<div class="icon_box_text">
						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
					</div>
				</div>
			</div>

			<!-- Icon Box -->
			<div class="col-lg-4 icon_box_col">
				<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
					<div class="icon_box_icon"><img src="{{asset('client/images/icon_3.svg')}}" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
					<div class="icon_box_title"><h2>Luxury Rooms</h2></div>
					<div class="icon_box_text">
						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Gallery -->

<div class="gallery">
	<div class="gallery_slider_container">
		<div class="owl-carousel owl-theme gallery_slider">
			<!-- Slide -->
			@foreach ($gallerys as $itemt)
				<div class="gallery_item">
					<div class="background_image" style='background-image:url("{{$itemt->image->url}}")'></div>
					<a class="colorbox" href="{{$itemt->image->url}}"></a>
				</div>
			@endforeach
		</div>
	</div>
</div>

<!-- About -->

<div class="about">
	<div class="container">
		<div class="row">
			
			<!-- About Content -->
			<div class="col-lg-6">
				<div class="about_content">
					<div class="about_title"><h2>The River / 10 years of excellence</h2></div>
					<div class="about_text">
						<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum lacus suscipit sit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum lacus suscipit sit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit.</p>
					</div>
				</div>
			</div>

			<!-- About Images -->
			<div class="col-lg-6">
				<div class="about_images d-flex flex-row align-items-center justify-content-between flex-wrap">
					<img src="{{asset('client/images/about_1.png')}}" alt="">
					<img src="{{asset('client/images/about_2.png')}}" alt="">
					<img src="{{asset('client/images/about_3.png')}}" alt="">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Testimonials -->

<div class="testimonials">
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{{asset('client/images/testimonials.jpg')}}" data-speed="0.8"></div>
	<div class="testimonials_overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="testimonials_slider_container" style="height: 100%;">
					<!-- Testimonials Slider -->
					<div class="owl-carousel owl-theme test_slider" style="height: 100%;">
						@foreach ($reviews as $itemt)
						<!-- Slide -->
						<div  class="test_slider_item text-center" style="height: 100%;">
							<div class="rating rating_{{$itemt->rate}} d-flex flex-row align-items-start justify-content-center"><i></i><i></i><i></i><i></i><i></i></div>
							<div class="testimonial_title"><a href="#">{{$itemt->title}}</a></div>
							<div class="testimonial_text">
								<p>{{$itemt->review}}</p>
							</div>
							<div class="testimonial_image"><img src="{{$itemt->customer->avatar->url}}" alt=""></div>
							<div class="testimonial_author"><a href="#">{{$itemt->customer->user_name}}</a>, Greece</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Booking -->
<div class="booking">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="booking_title text-center"><h2>Book a room</h2></div>
				<div class="booking_text text-center">
					<p>{{$itemt->short_description}}</p>
				</div>
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
						@foreach ($rooms as $itemt)
						<div class="booking_item">
							<div class="background_image" style='background-image:url("{{$itemt->image->url}}")'></div>
							<div class="booking_overlay trans_200"></div>
							<div class="booking_price">{{$itemt->cost}}.vnd/Night</div>
							<div class="booking_link"><a href="{{route('booking',['room_type' => $itemt->id])}}">{{$itemt->name}}</a></div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="blog">
	<!-- Blog Slider -->
	<div class="blog_slider_container">
		<div class="owl-carousel owl-theme blog_slider">
			@foreach ($blogs as $itemt)
			<div class="blog_slide">
				<div class="background_image" style='background-image:url("{{$itemt->image->url}}")'></div>
				<div class="blog_content">
					<div class="blog_date"><a href="{{route('blog.detail',$itemt->id)}}">{{$itemt->created_at->format('M d, Y')}}</a></div>
					<div class="blog_title"><a href="{{route('blog.detail',$itemt->id)}}">{{$itemt->title}}</a></div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/plugins/colorbox/jquery.colorbox-min.js')}}"></script>
<script src="{{asset('client/js/custom.js')}}"></script>
@endsection
@section("js")
<script>
	
</script>
@endsection