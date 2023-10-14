@extends("auth.layout.auth")
@section("css")
    @include("client.component.css_js.cssform")
@endsection
@section("form")
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <h1>Reset Password</h1>
    <div class="icon">
      <i class="fas fa-user-circle"></i>
    </div>
    <div class="formcontainer">
        <div class="container">
            <label for="mail"><strong>Email Address</strong><span class="text-danger">(*)</span></label>
            <input type="email" placeholder="Enter E-mail" name="email" value="{{ old('email') }}" autocomplete="email" autofocus/>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>Send Password Reset Link In Your Mail</strong></button>
    </div>
</form>
@endsection
