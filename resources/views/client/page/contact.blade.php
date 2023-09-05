@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/contact.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/contact_responsive.css')}}">
@endsection
@section("content")

<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/contact.jpg')}}"'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Contact</div>
						@include("client.component.bookingform")
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Contact -->

<div class="contact">
	<div class="container">
		<div class="row">
			
			<!-- Contact Content -->
			<div class="col-lg-6">
				<div class="contact_content">
					<div class="contact_title"><h2>Get in touch</h2></div>
					<div class="contact_list">
						<ul>
							<li>Main Str, no 253, New York, NY</li>
							<li>+546 990221 123</li>
							<li>music@contact.com</li>
						</ul>
					</div>
					<div class="contact_form_container">
						<form action="{{route('sendContactRequest')}}" class="contact_form" id="contact_form" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6 input_container">
									<input type="text" class="contact_input" placeholder="Your name" name="name">
									@error('name')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<div class="col-md-6 input_container">
									<input type="email" class="contact_input" placeholder="Your email address" name='email'>
									@error('email')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="input_container">
								<input type="text" class="contact_input" placeholder="Subject" name="subject">
								@error('subject')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="input_container">
								<textarea class="contact_input contact_textarea" placeholder="Message" name="messenger" required="required"></textarea>
								@error('messenger')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button class="contact_button" onclick="Swal.showLoading()">Send</button>
						</form>
					</div>
				</div>
			</div>

			<!-- Google Map -->
			<div class="col-xl-5 col-lg-6 offset-xl-1">
				<div class="contact_map">

					<!-- Google Map -->
	
					<div class="map">
						<div id="google_map" class="google_map">
							<div class="map_container">
								<div id="map"></div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

@endsection
@section('js')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
<script src="{{asset('client/js/contact.js')}}"></script>
@endsection