@extends("auth.layouts.auth")
@section("css")
    @include("client.public.cssform")
@endsection
@section("form")
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <h1>Reset Password</h1>
    <div class="icon">
      <i class="fas fa-user-circle"></i>
    </div>
    <div class="formcontainer">
        <div class="container">
            <label for="mail"><strong>Email Address</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter E-mail" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus/>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="password"><strong>Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Password" name="password" value="{{ old('password') }}" autocomplete="password"/> 
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="password_confirmation"><strong>Confirm Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="password_confirmation"/> 
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>Reset Password</strong></button>
    </div>
</form>
@endsection
