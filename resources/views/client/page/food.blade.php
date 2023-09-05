@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking_responsive.css')}}">
@include("client.public.cssform")
@endsection
@section("content")

<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/booking.jpg')}}"'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Foods</div>
						@include("client.component.bookingform")
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

				<!-- Booking Slider -->
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
						<!-- Slide -->
						@foreach ($foods as $item)
							<div class="booking_item">
								<div class="background_image" style='background-image:url("{{$item->image->url}}"'></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_item_content">
									<div class="booking_item_list">
										{!!$item->short_description!!}
									</div>
								</div>
								<div class="booking_price">{{$item->price}}.vnd/per</div>
								<div class="booking_link"><a href="{{route('booking',['room_type'=>$item->id])}}">{{$item->name}}</a></div>
							</div>
						@endforeach
						<!-- Slide -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Details Right -->
@foreach ($foods as $key => $item)
<div class="details">
	<div class="container">
		<div class="row">
			@if ($key%2===0)
				<!-- Details Image -->
				<div class="col-xl-7 col-lg-6">
					<div class="details_image">
						<div class="background_image" style='background-image:url("{{$item->image->url}}"'></div>
					</div>
				</div>

				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6">
					<div class="details_content">
							{!!$item->description!!}
					</div>
				</div>
			@else
				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6 order-lg-1 order-2">
					<div class="details_content">
							{!!$item->description!!}
					</div>
				</div>
				
				<!-- Details Image -->
				<div class="col-xl-7 col-lg-6 order-lg-2 order-1">
					<div class="details_image">
						<div class="background_image" style='background-image:url("{{$item->image->url}}"'></div>
					</div>
				</div>
				
			@endif
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@endsection