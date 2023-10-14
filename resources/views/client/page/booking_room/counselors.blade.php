@php
   	$max_date = date('Y-m-d\TH:i', strtotime('+1 year'));
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
							<div class="home_title">Booking Request</div>
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
					<form method="POST" action="{{ route('client.booking.room.create.request') }}">
						@csrf
						<div class="formcontainer">
							<div class="container">
								<h3>Booking Information</h3>
								<label for="room_type"><strong>Room Type</strong><span class="text-danger">(*)</span></label>
								<select name="room_type" id="" class="" required>
									@foreach ($category as $item)
										<option value="{{$item->id}}" @selected($request['room_type'] === $item->slug) style="color: black; padding: 20px;">{{ucfirst($item->name)}}</option>
									@endforeach
								</select>
								@error('room_type')
									<span class="text-danger">{{ $message }}</span>
								@enderror
								<label for="room"><strong>Number Room</strong><span class="text-danger">(*)</span></label>
								<input type="number" placeholder="Enter Your Request" name="room" value="{{ old('room') ?? $request['room'] }}" autocomplete="room" required/>
								@error('room')
									<span class="text-danger">{{ $message }}</span>
								@enderror
								<label for="people"><strong>Number People</strong><span class="text-danger">(*)</span></label>
								<input type="number" placeholder="Enter Your Request" name="people" value="{{ old('people') ?? $request['person'] }}" autocomplete="people" required/>
								@error('people')
									<span class="text-danger">{{ $message }}</span>
								@enderror
								<label for="children"><strong>Number Children</strong><span class="text-danger">(*)</span></label>
								<input type="number" placeholder="Enter Your Request" name="children" value="{{ old('children') ?? '' }}" autocomplete="children" required/>
								@error('children')
									<span class="text-danger">{{ $message }}</span>
								@enderror
								<label for="check_in"><strong>Check In</strong><span class="text-danger">(*)</span></label>
								<input name="check_in" type="datetime-local" class="check_in" placeholder="Check in" value="{{ old('check_in') ?? $request['check_in'] }}" required>
								@error('check_in')
								<span class="text-danger">{{ $message }}</span>
								@enderror
								<label for="check_out"><strong>Check Out</strong><span class="text-danger">(*)</span></label>
								<input name="check_out" type="datetime-local" class="check_out" placeholder="Check out" value="{{ old('check_out') ?? $request['check_out'] }}" required>
								@error('check_out')
									<span class="text-danger">{{ $message }}</span>
								@enderror
								<h3>Booking Request</h3>
								<label for="request"><strong>Your Request</strong><span class="text-danger">(*)</span></label>
								<textarea name="request" id="" value="{{ old('request') }}" placeholder="Enter Your Request" cols="" rows="" style="width: 100%; padding: 20px;"></textarea>
								@error('request')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button type="submit" onclick="Swal.showLoading()"><strong>Send Request</strong></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
 <script src="{{asset('client/js/booking.js')}}"></script>
@endsection