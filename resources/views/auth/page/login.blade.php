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
        <div class="d-md-flex d-sm-block justify-content-between">
            <div class="form-check" >
                <input class="form-check-input" style="width: 12px; height: 12px;" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="button" style="width: 300px;">
                    {{ __('Login') }}
                </button>
                <span>OR</span>
                <div class="button" style="width: 300px;">
                    <a href="{{ route('login.google') }}" onclick="Swal.showLoading()">{{ __('Google Sign With') }} <i style="font-size: 30px;" class="fab fa-google"></i></a>
                </div>
            </div>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
</form>
@endsection
            