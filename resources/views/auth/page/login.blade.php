@extends("auth.layout.auth")
@section("css")
    @include("client.component.css_js.cssform")
@endsection
@section("home_title","Wellcome")
@section("form")
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h1>Login</h1>
    <div class="icon">
      <i class="fas fa-user-circle"></i>
    </div>
    <div>
        test account: <br>
        GeneralManager@example.com <br>
        AssistantManager1@example.com <br>
        cashier3@example.com <br>
        user1@example.com 
    </div>
    <div class="formcontainer">
        <div class="container">
            <label for="mail"><strong>E-mail</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter E-mail" name="email" value="{{ old('email') }}" autocomplete="email" autofocus/>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="password"><strong>Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Password" name="password" value="{{ old('password') }}" autocomplete="password" autofocus/> 
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>LOGIN</strong></button>
        <br>OR<br>
        <a href="{{ route('login.google') }}" onclick="Swal.showLoading()" style="width:200px; height: 50px; color: white;" class="btn button">{{ __('Google Sign in') }} <i style="font-size: 30px;" class="fab fa-google"></i></a>
        <div class="d-flex justify-content-between">
            <style>
                .check_remenber{
                    display: inline;
                }
            </style>
            <div class="check_remenber">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <a onclick="Swal.showLoading()" href="{{route("password.request")}}"><strong>Forgot password?</strong></a>
        </div>
    </div>
</form>
@endsection
            