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
						<div class="home_title">Book For Group</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Booking -->
<div class="elements">
    <div class="container">
        <div class="row">
            <div class="col">
                <form method="POST" action="{{ route('booking.request') }}">
                    @csrf
                    <div class="formcontainer">
                        <div class="container">
							<h3>Customer Information</h3>
                            <label for="user_name"><strong>User Name</strong><span class="text-danger">(*)</span></label>
                            <input type="text" placeholder="Enter User Name" name="user_name" value="{{ Auth::user()->user_name }}" autofocus/>
                            @error('user_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label for="mail"><strong>E-mail</strong><span class="text-danger">(*)</span></label>
                            <input type="text" placeholder="Enter E-mail" name="email" value="{{ Auth::user()->email }}" autocomplete="email" autofocus/>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label for="phone"><strong>Phone Number</strong><span class="text-danger">(*)</span></label>
                            <input type="number" placeholder="Phone Number" name="phone" value="{{old('phone') ?? Auth::user()->phone}}" autocomplete="phone" autofocus/> 
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
							<h3>Booking Information</h3>
							@php
								if(empty($request)){
									$request['room_type']=null;
									$request['person']=null;
									$request['check_in']=null;
									$request['check_out']=null;
								}
							@endphp
                            <label for="room_type"><strong>Room Type</strong><span class="text-danger">(*)</span></label>
							<select name="room_type" id="" class="">
								<option style="color: black">Room Type</option>
								@foreach ($roomType as $type)
								   <option value="{{$type->id}}" @selected($request['room_type'] == $type->id) style="color: black; padding: 20px;">{{$type->name}}</option>
								@endforeach
						  	</select>
                            @error('room_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
							<label for="people"><strong>Number People</strong><span class="text-danger">(*)</span></label>
							<input type="number" placeholder="Enter Your Request" name="people" value="{{ old('people') ?? $request['person'] }}" autocomplete="people" autofocus/>
                            @error('people')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
							<label for="children"><strong>Number Children</strong><span class="text-danger">(*)</span></label>
							<input type="number" placeholder="Enter Your Children" name="children" value="{{ old('children') ?? '' }}" autocomplete="children" autofocus/>
                            @error('children')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
							<label for="check_in"><strong>Check In</strong><span class="text-danger">(*)</span></label>
							<input name="check_in" type="text" class="datepicker check_in" placeholder="Check in" value="{{ old('check_in') ?? $request['check_in'] }}" data-month='12'>
                            @error('check_in')
							<span class="text-danger">{{ $message }}</span>
                            @enderror
							<label for="check_out"><strong>Check Out</strong><span class="text-danger">(*)</span></label>
            				<input name="check_out" type="text" class="datepicker check_out" placeholder="Check out" value="{{ old('check_out') ?? $request['check_out'] }}">
                            @error('check_out')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
							<h3>Booking Request</h3>
                            <label for="request"><strong>Your Request</strong><span class="text-danger">(*)</span></label>
							<textarea name="request" id="" value="{{ old('request') }}" placeholder="Enter Your Request" cols="" rows="" style="width: 100%; padding: 20px;" autocomplete="request" autofocus></textarea>
                            @error('request')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<button type="submit" onclick="Swal.showLoading()"><strong>Book For Group</strong></button>
					</div>
                </form>
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
						@foreach ($roomtypes as $item)
							<div class="booking_item">
								<div class="background_image" style='background-image:url("{{$item->image->url}}"'></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_item_content">
									<div class="booking_item_list">
										{!!$item->short_description!!}
									</div>
								</div>
								<div class="booking_price">{{$item->cost}}.đ/night</div>
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
@foreach ($roomtypes as $key => $item)
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
						<div class="book_now_button"><a href="{{route('booking',['room_type'=>$item->id])}}">Book Now</a></div>
					</div>
				</div>
			@else
				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6 order-lg-1 order-2">
					<div class="details_content">
							{!!$item->description!!}
						<div class="book_now_button"><a href="{{route('booking',['room_type'=>$item->id])}}">Book Now</a></div>
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
@endforeach
<!-- Special -->

<div class="special">
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{{$roomtypes->last()->image->url}}" data-speed="0.8"></div>
	<div class="container">
		<div class="row">
			<div class="col-xl-6 offset-xl-6 col-lg-8 offset-lg-2">
				<div class="special_content">
					<div class="details_title" style="font-size: 20px;">Special Offer</div>
					{!!$roomtypes->last()->description!!}
					<div class="book_now_button"><a href="{{route('booking',['room_type' => $roomtypes->last()->id])}}">Book Now</a></div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.check_in').val("{{old('check_in') ?? $request['check_in']}}");
		$('.check_out').val("{{old('check_out') ?? $request['check_out']}}");
	})
</script>
@endsection