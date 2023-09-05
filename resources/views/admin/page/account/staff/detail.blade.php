@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item">Account</li>
        <li class="breadcrumb-item"><a href="{{route("staff.index")}}">Staff</a></li>
        <li class="breadcrumb-item active">Detail</li>
        <li class="breadcrumb-item active">Id: {{$data->slug}}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{$data->avatar->url??'https://www.w3schools.com/w3images/avatar2.png'}}" alt="Profile" width="100px" height="100px" class="rounded-circle">
            <h2>{{$data->user_name}}</h2>
            <h3>staff</h3>
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
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Change Role</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{$data->user_name}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">{{$data->phone  ?? 'not use'}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Gmail</div>
                  <div class="col-lg-9 col-md-8">{{$data->email}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">{{$data->address  ?? 'not use'}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Gender</div>
                  <div class="col-lg-9 col-md-8">{{$data->gender ?? 'not use'}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Status</div>
                  <div class="col-lg-9 col-md-8">{{$data->active ? 'true' : 'false'}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Join Date</div>
                  <div class="col-lg-9 col-md-8">{{$data->created_at}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Updated Date</div>
                  <div class="col-lg-9 col-md-8">{{$data->updated_at}}</div>
                </div>

              </div>

              <div class="tab-pane fade pt-3" id="profile-settings">

                <!-- Settings Form -->
                <form method="POST" action="{{route('staff.update.role',$data->slug)}}">
                  @csrf
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Edit Role</label>
                    <div class="col-md-8 col-lg-9">
                      @foreach ($roles as $key => $item)
                        @php
                          if ($check = $data->roleLists->pluck('role_id')->contains($item->id)) {
                            $dateTime = $data->roleLists->where('role_id',$item->id)->first()->created_at;
                          }else {
                            $dateTime = null;
                          }
                        @endphp
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="role_{{$item->id}}" name="roles[]" value="{{$item->id}}" @checked($check)>
                            <label class="form-check-label d-flex" for="role_{{$item->id}}">
                              <span class="col-3">
                                {{$item->name}}
                              </span>
                              <span class="col-4">
                                {{!empty($dateTime) ? ($dateTime->format('D M Y')) : $dateTime}}
                              </span>
                            </label>
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End settings Form -->

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form method="POST" action="{{route("staff.update.profile",$data->slug)}}" enctype="multipart/form-data" >
                  @csrf
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="col-md-8 col-lg-9">
                        <label for="image" title="click to change avatar">
                            <img id="image-show" class="rounded-circle" width="120px" height="120px" src="{{$data->avatar->url??'https://www.w3schools.com/w3images/avatar2.png'}}" alt=""/>
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
                      <input name="user_name" type="text" class="form-control" id="fullName" value="{{old("user_name")??$data->user_name}}">
                      @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="company" value="{{old("phone")??$data->phone}}">
                      @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Mail</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="text" class="form-control" id="Job" value="{{old("email")??$data->email}}">
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="gender" id="gender" class="form-control">
                        <option value="male" @selected($data->gender === 'male')>Male</option>
                        <option value="female" @selected($data->gender === 'female')>Female</option>
                        <option value="other" @selected($data->gender === 'other')>other</option>
                      </select>
                      @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Country" value="{{old("address")??$data->address}}">
                      @error('address')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
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
        $('#image-show').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    });
  });
</script>
@endsection