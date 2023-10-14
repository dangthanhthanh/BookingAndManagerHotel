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
				<div class="background_image" style='background-image:url("{{$gallerys[1]->image->url}}")'></div>
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
				<div class="background_image" style='background-image:url("{{$gallerys[2]->image->url}}")'></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">
									<div class="home_title">A Family Stay</div>
									{{-- @include("client.component.bookingform") --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Slide -->
			<div class="slide">
				<div class="background_image" style='background-image:url("{{$gallerys[3]->image->url}}")'></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">
									<div class="home_title">A Paradise Stay</div>
									{{-- @include("client.component.bookingform") --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		
		<!-- Home Slider Dots -->
		{{-- <div class="home_slider_dots_container">
			<div class="home_slider_dots">
				<ul id="home_slider_custom_dots" class="home_slider_custom_dots d-flex flex-row align-items-start justify-content-start">
					<li class="home_slider_custom_dot active">01.</li>
					<li class="home_slider_custom_dot">02.</li>
					<li class="home_slider_custom_dot">03.</li>
				</ul>
			</div>
		</div> --}}
		
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
			@foreach ($gallerys as $item)
				<div class="gallery_item">
					<div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
					<a class="colorbox" href="{{$item->image->url}}"></a>
				</div>
			@endforeach
		</div>
	</div>
</div>

<!-- Booking -->
<div class="booking">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="booking_title text-center"><h2>Room</h2></div>
				<div class="booking_text text-center">
					<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugiat facere tenetur sequi iusto doloribus eveniet aliquam nihil, explicabo id consequuntur omnis voluptatibus enim praesentium nulla hic officiis illo voluptas non?</p>
				</div>
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
						@foreach ($roomCategorys as $item)
						<div class="booking_item">
							<div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
							<div class="booking_overlay trans_200"></div>
							<div class="booking_price">{{number_format($item->cost)}}</div>
							<div class="booking_link d-flex">
								<a style="width: 50%;" href="{{route('client.room.detail',$item->slug)}}">Read More</a>
								<span style="background: white; height:100%; width:4px;"></span>
								<a style="width: 50%;" href="add_to_cart">Book Now</a>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="booking" style="background-color: rgba(214, 214, 214, 0.4)">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="booking_title text-center"><h2>Food</h2></div>
				<div class="booking_text text-center">
					<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugiat facere tenetur sequi iusto doloribus eveniet aliquam nihil, explicabo id consequuntur omnis voluptatibus enim praesentium nulla hic officiis illo voluptas non?</p>
				</div>
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
							@foreach ($foods as $item)
							<div class="booking_item">
								<div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_price">{{number_format($item->cost)}}</div>
								<div class="booking_link d-flex">
									<a style="width: 50%;" href="{{route('client.food.detail',$item->slug)}}">Read More</a>
									<span style="background: white; height:100%; width:4px;"></span>
									<a style="width: 50%;" href="{{route('client.food.detail',$item->slug)}}">Add To Cart</a>
								</div>
							</div>
							@endforeach
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<div class="booking">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="booking_title text-center"><h2>Service</h2></div>
				<div class="booking_text text-center">
					<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugiat facere tenetur sequi iusto doloribus eveniet aliquam nihil, explicabo id consequuntur omnis voluptatibus enim praesentium nulla hic officiis illo voluptas non?</p>
				</div>
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
						@foreach ($services as $item)
						<div class="booking_item">
							<div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
							<div class="booking_overlay trans_200"></div>
							<div class="booking_price">{{number_format($item->cost)}}</div>
							<div class="booking_link d-flex">
								<a style="width: 50%;" href="{{route('client.service.detail',$item->slug)}}">Read More</a>
								<span style="background: white; height:100%; width:4px;"></span>
								<a style="width: 50%;" href="{{route('client.service.detail',$item->slug)}}">Add To Cart</a>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
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
					<style>
						.testimonial_image{
							background-size: cover;
							background-repeat: no-repeat;
						}
					</style>
					<!-- Testimonials Slider -->
					<div class="owl-carousel owl-theme test_slider" style="height: 100%;">
						@foreach ($reviews as $item)
						<!-- Slide -->
							<div  class="test_slider_item text-center" style="height: 100%;">
								<div class="rating rating_{{$item->rate}} d-flex flex-row align-items-start justify-content-center"><i></i><i></i><i></i><i></i><i></i></div>
								<div class="testimonial_title"><a href="#">{{$item->title}}</a></div>
								<div class="testimonial_text">
									<p>{{$item->review}}</p>
								</div>
								<div class="testimonial_image mb-0" style="background-image: url('{{$item->customer->avatar->url}}');"></div>
								<div class="testimonial_author mb-0"><a href="#">{{$item->customer->user_name}}</a></div>
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
			@foreach ($blogs as $item)
			<div class="blog_slide">
				<div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
				<div class="blog_content">
					<div class="blog_date"><a href="{{route('client.blog.detail',$item->slug)}}">{{$item->created_at->format('M d, Y')}}</a></div>
					<div class="blog_title"><a href="{{route('client.blog.detail',$item->slug)}}">{{$item->name}}</a></div>
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