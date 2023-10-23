@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking_responsive.css')}}">
{{-- @include("client.public.cssform") --}}
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
						@include("client.component.checkinform",[
							'checkin' => $checkin,
							'route' => route('client.food.index')
						])
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
								<div class="booking_price">{{number_format($item->cost)}}</div>
								<div class="booking_link d-flex">
									<a style="width: 50%;" href="{{route('client.food.detail',$item->slug)}}">Read More</a>
									<a style="width: 50%;" id="add_to_cart" href="#"
										data-id="{{$item->id}}"
										data-checkin="{{$checkin}}"
										data-slug="{{$item->slug}}"
										data-name="{{$item->name}}"
										data-image="{{$item->image->url}}"
										data-cost="{{$item->cost}}"
										onclick="addToCart(event)"
									>Add to Cart</a>
								</div>
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
            @php
                $isEven = $key % 2 === 0;
                $imageOrder = $isEven ? 'order-1' : 'order-2';
                $contentOrder = $isEven ? 'order-2' : 'order-1';
            @endphp

            <!-- Details Image -->
            <div class="col-xl-7 col-lg-6 {{$imageOrder}}">
                <div class="details_image">
                    <div class="background_image" style='background-image:url("{{$item->image->url}}")'></div>
                </div>
            </div>

            <!-- Details Content -->
            <div class="col-xl-5 col-lg-6 {{$contentOrder}}">
				<div class="details_title">
					{{ucfirst($item->name)}}
				</div>
                <div class="details_content">
                    {!! $item->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="page_nav">
	<ul class="d-flex flex-row align-items-center justify-content-center">
		@foreach (($foods->links()["elements"][0]) as $key=>$value)
			@php
				$url = $value . "&check_in=" . urlencode($checkin);
			@endphp
			<li class="{{(request()->query('page') == $key) ? 'active' : ''}}"><a href="{{$url}}">0{{$key}}.</a></li>
		@endforeach
	</ul>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@include("client.component.css_js.food")
@endsection