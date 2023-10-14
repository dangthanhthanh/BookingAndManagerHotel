@extends("auth.layout.auth")
@section("css")
    @include("client.component.css_js.cssform")
@endsection
@section("home_title","Your Account")
@section("form")
<form method="POST" action="{{ route('auth.account.update') }}" enctype="multipart/form-data">
    @csrf
    <h1>My Account</h1>
    <div class="icon">
        <label for="image" id="image_label">
            <div id="icon-image" style="background-image: url(
                {{Auth::user()->avatar->url}}
            )">
            </div>
        </label>
        <input type="file" id="image_input" name="image" style="display: none;">
    </div>
    <div class="formcontainer">
        <div class="container">
            <label for="user_name"><strong>User Name</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter User Name" name="user_name" value="{{ ucfirst(Auth::user()->user_name) }}" autofocus/>
            @error('user_name')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="email"><strong>E-mail</strong><span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Enter E-mail" name="email" value="{{ (Auth::user()->email) }}" autocomplete="email" autofocus/>
            @error('email')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="phone">Phone Number<span class="text-danger">(*)</span></label>
            <input type="number" placeholder="Phone Number" name="phone" value="{{ (Auth::user()->phone) }}" autocomplete="phone" autofocus/> 
            @error('phone')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="address">Address<span class="text-danger">(*)</span></label>
            <input type="text" placeholder="Address" name="address" value="{{ (Auth::user()->address) }}" autocomplete="address" autofocus/> 
            @error('address')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="gender"><strong>Gender</strong><span class="text-danger">(*)</span></label>
            <select name="gender">
                <option value="Male" {{ (Auth::user()->gender === "Male")? 'selected':"" }}>Male</option>
                <option value="Female" {{ (Auth::user()->gender === "Female")? 'selected':"" }}>Female</option>
                <option value="Other" {{ (Auth::user()->gender === "Other")? 'selected':"" }}>Other</option>
            </select>
            @error('gender')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="password"><strong>New Password</strong></label>
            <input type="password" placeholder="Enter Password" name="password" autofocus/>
            @error('password')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror 
            <label for="comfirm_password"><strong>Confirm New Password </strong></label>
            <input type="password" placeholder="Comfirm Password" name="comfirm_password" autofocus> 
            @error('confirm_password')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label for="old_password"><strong>Old Password</strong><span class="text-danger">(*)</span></label>
            <input type="password" placeholder="Enter old Password" name="old_password" autofocus/>
            @error('old_password')
                <span class="text-danger">{{ $message }}</span><br>
            @enderror 
        </div>
        <button type="submit" onclick="Swal.showLoading()"><strong>Update</strong></button>
    </div>
  </form>
@endsection
@section("js")
<script src="{{asset('client/js/elements.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#image_label").click(function() {
            $("#image_input").click();
        });
        $("#image_input").change(function() {
            let file = this.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('icon-image').style.backgroundImage = "url('" + e.target.result + "')";
            };
            reader.readAsDataURL(file);
        });
    }); 
</script>
@endsection