@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking_responsive.css')}}">
@include("client.component.css_js.cssform")
<style>
	.size span {
	font-size: 11px;
	}
	.color span {
	font-size: 11px;
	}
	.product-deta {
	margin-right: 70px;
	}
	.gift-card:focus {
	box-shadow: none;
	}
	.pay-button {
	color: #fff;
	}
	.pay-button:hover {
	color: #fff;
	}
	.pay-button:focus {
	color: #fff;
	box-shadow: none;
	}
	.text-grey {
	color: #a39f9f;
	}
	.qty i {
	font-size: 11px;
	}
</style>
@endsection
@section("content")

<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/booking.jpg')}}"'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Book Room</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Booking -->
<div class="details">
	<div class="container">
		@if ($bookingRequest){{-- //just one item --}}
		<h3 style="margin-top: 100px;margin-bottom: 10px;"><strong>My Request</strong></h3>
		<div class="row">
			<!-- Details Image -->
				<div class="col-xl-7 col-lg-6">
					<div class="details_image">
						<div class="background_image" style='background-image:url({{$bookingRequest->roomCategory->image->url}}'></div>
					</div>
				</div>
				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6">
					<div class="details_content">
						<div class="details_title">Your Booking Request</div>
						<div class="details_list">
							<ul>
								<li>Room Type: {{$bookingRequest->roomCategory->name}}</li>
								<li>Phone Contact   : {!!($bookingRequest->customer->phone)?$bookingRequest->customer->phone:'<span class="text-danger">Please confirm your phone number so we can contact you</span>'!!}</li>
								<li>Check In : {{$bookingRequest->check_in}}</li>
								<li>Check Out: {{$bookingRequest->check_out}}</li>
								<li>People   : {{$bookingRequest->num_person}}</li>
								@if ($bookingRequest->num_child)
									<li>Children : {{$bookingRequest->num_child}}</li>
								@endif
								<li>Status   : {{$bookingRequest->status->name}}</li>
							</ul>
						</div>
						<div class="d-flex" style="gap: 10px">
							<div class="book_now_button"><a href="{{route('booking.request.delete',['slug' => $bookingRequest->slug])}}">Destroy</a></div>
						</div>
					</div>
				</div>
			</div>
		@endif
		<h3 style="margin-top: 100px;margin-bottom: 10px;"><strong>My Cart</strong></h3>
		<div class="container mt-5 mb-5">
            <div class="d-flex justify-content-center row">
                <div class="col-md-8">
					<div id="cart_book_food_container">
						<!-- Cart items for booking food -->
					</div>
					<div id="cart_book_service_container">
						<!-- Cart items for booking service -->
					</div>
					<div id="cart_book_event_container">
						<!-- Cart items for booking event -->
					</div>
                    <div class="d-flex flex-row align-items-center mt-3 p-2 bg-white rounded" id="cart_book_button_container">
						<!-- Cart send booking to server -->
					</div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@include("client.component.css_js.cart")
@endsection