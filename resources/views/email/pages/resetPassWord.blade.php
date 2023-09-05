@extends("email.layouts.email")
@section("title",'Reset Password')
@section("content")
   <p> Hello! </p>

   <p>  You are receiving this email because we received a password reset request for your account. </p>
   {!!$content!!}
   {{-- <a class="button" href="{{$url}}">Verify Email</a> --}}
   <img src="https://png.pngitem.com/pimgs/s/22-224065_avatar-people-icon-png-transparent-png.png" alt="img">
   <p> This password reset link will expire in 60 minutes.</p>
   <p> If you did not request a password reset, no further action is required.</p>

@endsection
@section("footer")
<p>  Contact us at Bookinghotel@example.com </p>
<p> Thanks.</p>
@endsection