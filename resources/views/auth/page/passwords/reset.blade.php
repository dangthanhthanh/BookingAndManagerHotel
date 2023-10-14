@extends("auth.layout.auth")
@section("css")
    @include("client.component.css_js.cssform")
@endsection
@section("form")
<form method="POST" action="{{ route('client.update.password') }}">
    @csrf
    <h1>Reset Password</h1>
    <div class="icon">
      <i class="fas fa-user-circle"></i>
    </div>
    <div class="formcontainer">
        <div>
            <h3>Hello {{ucfirst($userName)}}</h3>
        </div>
        <div class="container">
            <input type="hidden" name="userId" value="{{$userId}}">
            <input type="hidden" name="token" value="{{$token}}">
            <label for="password"><strong>Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Password" name="password" value="{{ old('password') }}" autocomplete="password"/> 
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="password_confirmation"><strong>Confirm Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="password_confirmation"/> 
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>Reset Password</strong></button>
    </div>
</form>
@endsection
