@php
   	$max_date = date('Y-m-d\TH:i', strtotime('+1 year'));
	$min_date = date('Y-m-d\TH:i', strtotime('+1 hour'));
	$category = $roomType;
	$request = $request->all();
	$roomAvailable = $category->where('slug',$request['room_type'])->first()->countAvailable($request['check_in'], $request['check_out']);
@endphp
@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking_responsive.css')}}">
@include("client.component.css_js.cssform")
@endsection
@section("content")

<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/booking.jpg')}}"'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Book Online</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="elements">
	<div class="container">
		<div class="row">
			<h3>
				<strong>
					@if ($roomAvailable || $roomAvailable >= ($request['room'] ?? 1))
						We still have {{$roomAvailable}} rooms available for you
					@else
						We are currently out of rooms that match your request.
						Please choose another room or service type.
					@endif
				</strong>
			</h3>
		</div>
	</div>
</div>

<!-- Booking -->
@if ($roomAvailable)
<div class="elements">
    <div class="container">
        <div class="row">
            <div class="col">
                <form method="POST" action="{{ route('client.booking.room.create.order') }}">
                    @csrf
                    <div class="formcontainer">
                        <div class="container">
                            <h3>Booking Information</h3>
							<label for="room_type"><strong>Room Type</strong><span class="text-danger">(*)</span></label>
							<select name="room_type" id="" class="" required>
								@foreach ($category as $item)
									<option value="{{$item->slug}}" @selected($request['room_type'] === $item->slug) style="color: black; padding: 20px;">{{$item->name}}</option>
								@endforeach
							</select>
							@error('room_type')
								<span class="text-danger">{{ $message }}</span>
							@enderror
							<label for="room"><strong>many Room</strong><span class="text-danger">(*)</span></label>
							<input type="number" placeholder="Enter Your Request" name="room" value="{{ old('room') ?? $request['room'] ?? 1}}" autocomplete="room" required/>
							@error('room')
								<span class="text-danger">{{ $message }}</span>
							@enderror
							<label for="people"><strong>Number People</strong><span class="text-danger">(*)</span></label>
							<input type="number" placeholder="Enter Your Request" name="people" value="{{ old('people') ?? $request['person'] }}" autocomplete="people" required/>
							@error('people')
								<span class="text-danger">{{ $message }}</span>
							@enderror
							<label for="children"><strong>Number Children</strong><span class="text-danger">(*)</span></label>
							<input type="number" placeholder="Enter Your Request" name="children" value="{{ old('children') ?? 0 }}" autocomplete="children" required/>
							@error('children')
								<span class="text-danger">{{ $message }}</span>
							@enderror
							<label for="check_in"><strong>Check In</strong><span class="text-danger">(*)</span></label>
							<input name="check_in" type="datetime-local" class="check_in" 
				            min="{{$min_date}}"
							placeholder="Check in" value="{{ old('check_in') ?? $request['check_in'] }}" required>
							@error('check_in')
							<span class="text-danger">{{ $message }}</span>
							@enderror
							<label for="check_out"><strong>Check Out</strong><span class="text-danger">(*)</span></label>
							<input name="check_out" type="datetime-local" class="check_out" 
				            min="{{date('Y-m-d\TH:i', strtotime('+1 day'))}}"
							placeholder="Check out" value="{{ old('check_out') ?? $request['check_out'] }}" required>
							@error('check_out')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						@if ($roomAvailable < 1 || $roomAvailable >= ($request['room'] ?? 1))
							<button type="submit" onclick="Swal.showLoading()"><strong>Book Online</strong></button>
						@else
							Your have chose another room or contact with us.
						@endif
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="booking">
	<div class="container">
		<div class="row">
			<div class="col">
				<!-- Booking Slider -->
				<div class="booking_slider_container">
					<div class="owl-carousel owl-theme booking_slider">
						<!-- Slide -->
						@foreach ($roomType as $item)
							<div class="booking_item">
								<div class="background_image" style='background-image:url("{{$item->image->url}}"'></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_item_content">
									<div class="booking_item_list">
										{!!$item->short_description!!}
									</div>
								</div>
								<div class="booking_price">
									<div>{{number_format($item->cost)}}</div>
									<div style="background-color: #c5c5c5;">remaining {{$item->countAvailable($request['check_in'], $request['check_out'])}}</div>
								</div>
								@php
									$request['room_type'] = $item->slug;
								@endphp
								<div class="booking_link"><a href="{{route('client.booking.room.index',$request)}}">{{$item->name}}</a></div>
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
@foreach ($roomType as $key => $item)
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
					<div class="details_title" style="font-size: 20px;"> 
						{{ucfirst($item->name)}}
						<span class="btn btn-outline-success rounded-circle">remaining {{$item->countAvailable($request['check_in'], $request['check_out'])}}</span>
					</div>
					<div class="details_content">
						{!!$item->description!!}
						<div class="book_now_button">
							<a href="{{route('client.booking.room.index',['room_type'=>$item->slug])}}">Book Now</a>
						</div>
					</div>
				</div>
			@else
				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6 order-lg-1 order-2">
					<div class="details_title" style="font-size: 20px;"> 
						{{ucfirst($item->name)}}
						<span class="btn btn-outline-success rounded-circle">remaining {{$item->countAvailable($request['check_in'], $request['check_out'])}}</span>
					</div>
					<div class="details_content">
							{!!$item->description!!}
						<div class="book_now_button"><a href="{{route('client.booking.room.index',['room_type'=>$item->slug])}}">Book Now</a></div>
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
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{{$roomType->last()->image->url}}" data-speed="0.8"></div>
	<div class="container">
		<div class="row">
			<div class="col-xl-6 offset-xl-6 col-lg-8 offset-lg-2">
				<div class="special_content">
					<div class="details_title" style="font-size: 20px;"> 
						{{ucfirst($roomType->last()->name)}}
						<span class="btn btn-outline-success rounded-circle">remaining {{$roomType->last()->countAvailable($request['check_in'], $request['check_out'])}}</span>
					</div>
					<div class="details_content">
							{!!$roomType->last()->description!!}
						<div class="book_now_button"><a href="{{route('client.booking.room.index',['room_type'=>$item->slug])}}">Book Now</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@endsection