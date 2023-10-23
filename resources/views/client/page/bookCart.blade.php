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
						<div class="home_title">My Booking</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Booking -->
<div class="details">
	<div class="container">
		@if (!empty($bookingRequest))
			<div class="row">
				<!-- Details Image -->
				<div class="col-xl-7 col-lg-6">
					<div class="details_image">
						<div class="background_image" style='background-image:url("{{$bookingRequest->roomType->image->url}}"'></div>
					</div>
				</div>
				<!-- Details Content -->
				<div class="col-xl-5 col-lg-6">
					<div class="details_content">
						<div class="details_title">Your Booking Request</div>
						<div class="details_list">
							<ul>
								<li>Room Type: {{$bookingRequest->roomType->name}}</li>
								<li>Phone    : {{$bookingRequest->customer->phone}}</li>
								<li>Check In : {{$bookingRequest->check_in}}</li>
								<li>Check Out: {{$bookingRequest->check_out}}</li>
								<li>People   : {{$bookingRequest->people}}</li>
								@if ($bookingRequest->children)
									<li>Children : {{$bookingRequest->children}}</li>
								@endif
								@if (!$bookingRequest->status)
									<li style="color: red"> 
										vui long giu may: tu van vien se som lien he voi ban
									</li>
								@else
									<li style="color: red"> 
										yeu cau da duoc xac nhan: hay tan huong nhung dich vu cua chung toi
									</li>
								@endif
							</ul>
						</div>
						<div class="details_long_list">
							Request: {{$bookingRequest->request}}
						</div>
						<div class="d-flex" style="gap: 10px">
							<div class="book_now_button"><a href="{{route('booking')}}">Edit</a></div>
							<div class="book_now_button"><a href="{{route('booking.destroy')}}">Destroy</a></div>
						</div>
					</div>
				</div>
			</div>
		@endif
		<h3 style="margin-top: 100px;margin-bottom: 10px;"><strong>History Payment</strong></h3>
		<table class="table table-bordered table-striped table-hover text-dark">
			<thead>
				<tr class="table-active">
					<th scope="col">#</th>
					<th scope="col">Total_Cost</th>
					<th scope="col">Create_at</th>
					<th scope="col">Status</th>
					<th scope="col">Handle</th>
				</tr>
			</thead>
			<tbody>
				{{-- @forelse ($orderPayments as $item) --}}
				{{-- {{dd($item)}} --}}
				{{-- @php
					$checkInDate = \Carbon\Carbon::parse($item['room_checkin']);
					$checkOutDate = \Carbon\Carbon::parse($item['room_checkout']);
					$numberOfDays = $checkInDate->diffInDays($checkOutDate);
					$total = $item['room_cost'] * $numberOfDays;
					dd($total);
				@endphp
					<tr>
						<td>{{$key+1}}</td>
						<td>{{$total}}.vnd</td>
					</tr>
				@empty
					<tr>
						<td colspan="8">you are not a payment</td>
					</tr>
				@endforelse --}}
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@endsection