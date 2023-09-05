@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item">Account</li>
        <li class="breadcrumb-item"><a href="{{route("staff.index")}}">Staff</a></li>
        <li class="breadcrumb-item active">Create</li>
        <li class="breadcrumb-item active"></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="https://picsum.photos/959/652" id="image-show" alt="Profile" width="100px" height="100px" class="rounded-circle image-show">
            <h2 class="user_name">{{ old('user_name')?? 'User Name'}}</h2>
            <h3>Staff</h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <a class="nav-link" href="{{route("staff.index")}}">Data</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Add New Account</a>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit">
                <!-- Profile Edit Form -->
                <form method="POST" action="{{route("staff.store")}}" enctype="multipart/form-data" >
                  @csrf
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="col-md-8 col-lg-9">
                        <label for="image" title="click to change avatar">
                            <img id="image-show" class="rounded-circle image-show" width="120px" height="120px" src="https://picsum.photos/959/652" alt=""/>
                          </label>
                          <input type="file" class="form-control d-none" id="image" name="image"/>
                          @error('image')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="user_name" type="text" class="form-control" id="user_name" value="{{old("user_name")}}">
                      @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="company" value="{{old("phone")}}">
                      @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Mail</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="text" class="form-control" id="Job" value="{{old("email")}}">
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="gender" id="gender" class="form-control">
                        <option value="male" @selected(old('gender') === 'male')>Male</option>
                        <option value="female" @selected(old('gender') === 'female')>Female</option>
                        <option value="other" @selected(old('gender') === 'other')>other</option>
                      </select>
                      @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Country" value="{{old("address")}}">
                      @error('address')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Role</label>
                    <div class="col-md-8 col-lg-9 row">
                      <div class="form-check col-4">
                        <input  type="checkbox" class="form-check-input" id="role_none">
                        <label class="form-check-label d-flex">
                            None
                        </label>
                      </div>
                      @foreach ($roles as $key => $item)
                        @php
                          $check = in_array($item->id, old('roles',[]));
                        @endphp
                        <div class="form-check col-4">
                            <input class="form-check-input" type="checkbox" id="role_{{$item->id}}" name="roles[]" value="{{$item->id}}" @checked($check)>
                            <label class="form-check-label d-flex" for="role_{{$item->id}}">
                                {{$item->name}}
                            </label>
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">Note</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->
              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section("javacript")
<script>
  $(document).ready(function() {
    $('#image').change(function() {
      var file = this.files[0];
      var reader = new FileReader();
      console.log(file);
      reader.onload = function(e) {
        $('.image-show').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    });
    $('#user_name').on( "change",function() {
      let value = $(this).val(); // Use $(this) to get the value of the input
      $('.user_name').text(value); // Set text using .text() method
    });
    $('#role_none').click(function() {
      $('input[type="checkbox"]').prop('checked', false);
    });
  });
</script>
@endsection