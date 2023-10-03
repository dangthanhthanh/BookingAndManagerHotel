@extends("emails.layouts.email")
@section("title",'Verify email')
@section("content")
   <p> Hello! </p>

   <p>  Click the button below to verify your email address: </p>

   <a class="button" href="{{$verificationUrl}}">Verify Email</a>

   <p> If you did not create an account, no further action is required.</p>

@endsection
@section("footer")
<p>  Contact us at Bookinghotel@example.com </p>
<p> Thanks</p>
@endsection