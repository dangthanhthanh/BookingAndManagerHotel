@extends("auth.layout.auth")
@section("css")
    @include("client.component.css_js.cssform")
@endsection
@section("home_title","Wellcome")
@section("form")
<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    <h1>Register</h1>
    <div class="icon">
        <i class="fas fa-user-circle"></i>
    </div>
    <div class="formcontainer">
        <div class="container">
            <label for="user_name"><strong>User Name</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter User Name" name="user_name" value="{{ old('user_name') }}" autofocus/>
            @error('user_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="mail"><strong>E-mail</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter E-mail" name="email" value="{{ old('email') }}" autocomplete="email" autofocus/>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="phone">Phone Number<span class="text-danger">(*)</span></label>
            <input type="number" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus/> 
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="psw"><strong>Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Password" name="password" autofocus/>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror 
            <label for="confirm_password">Confirm Password <span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Confirm Password" name="confirm_password" autofocus> 
            @error('confirm_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>REGISTER</strong></button>
    </div>
</form>
@endsection
@section("js")
<script src="{{asset('client/js/elements.js')}}"></script>
@endsection