@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Account</a></li>
        <li class="breadcrumb-item active">Staff</li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                @include("admin.component.search_data")
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Data</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("staff.create")}}" >Add</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="min-width: 200px;">User Name @include("admin.component.sort_by",['sortBy'=>'user_name'])</th>
                                            <th scope="col" style="min-width: 100px;">Avatar</th>
                                            <th scope="col" style="min-width: 100px;">Email @include("admin.component.sort_by",['sortBy'=>'email'])</th>
                                            <th scope="col" style="min-width: 100px;">Phone @include("admin.component.sort_by",['sortBy'=>'phone'])</th>
                                            <th scope="col" style="min-width: 100px;">role</th>
                                            <th scope="col" style="min-width: 100px;">Gender @include("admin.component.sort_by",['sortBy'=>'gender'])</th>
                                            <th scope="col" style="min-width: 200px;">Join date @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col" style="min-width: 200px;">Update at @include("admin.component.sort_by",['sortBy'=>'updated_at'])</th>
                                            <th scope="col" style="min-width: 100px;">Active @include("admin.component.sort_by",['sortBy'=>'active'])</th>
                                            <th scope="col" style="min-width: 100px;">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->user_name}}</td>
                                                <td>
                                                    <img src="{{$item->avatar_url??'https://www.w3schools.com/w3images/avatar2.png'}}" height="70" alt="avatar">
                                                </td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->phone}}</td>
                                                <td>
                                                    <ul  style="max-height: 100px; overflow-y:scroll;">
                                                        @foreach ($item->roleLists as $value)
                                                        <li>
                                                            {{$value->role->name}}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{$item->gender ?? 'not Use'}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>{{$item->updated_at}}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input toggle-checkbox" type="checkbox" style="width: 70px;height: 20px;"
                                                        id="flexSwitchCheckChecked"
                                                        data-url="{{ route('staff.setstatus', ['slug'=>$item->slug])}}"
                                                        @checked($item->active)>
                                                    </div>
                                                </td>
                                                <td>
                                                    @include("admin.component.handle_form",[$table='staff'])
                                                </td>
                                            </tr>
                                        @empty
                                            <p style="text-align: center;">No Data Found!</p>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                            @include("admin.component.pagination")
                        </div>
                    </div>
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <!-- Profile Edit Form -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <form id="form-action" method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <label for="profileImage" class="col-md-2 col-lg-2 col-form-label"><strong>Avatar</strong></label>
                                        <div class="col-md-8 col-lg-9" style="margin: 0 auto;">
                                            <label for="image" style="width: 300px; height: 300px; overflow: hidden; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                <img id="image-show" height="300px" src="{{old('image')??'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aG90ZWx8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60'}}" alt=""/>
                                            </label>
                                            <input type="file" class="form-control d-none" id="image" name="image"/>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <div class="col-md-4">
                                            <label for="fullName" class="form-label"><strong>User Name</strong></label>
                                            <input type="text" class="form-control" id="fullName" value="{{old('user_name') ?? ''}}" name="user_name" required="">
                                            @error('user_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <div class="col-md-4">
                                            <label for="Capacity" class="form-label"><strong>Email</strong></label>
                                            <input type="email" class="form-control" id="Capacity" value="{{old('email') ?? ''}}" name="email" required="">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Bed" class="form-label"><strong>Address</strong></label>
                                            <input type="text" class="form-control" id="Bed" value="{{old('address') ?? ''}}" name="address" required="">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <div class="col-md-4">
                                            <label for="Capacity" class="form-label"><strong>Phone</strong></label>
                                            <input type="number" max="15" min="8" class="form-control" id="Capacity" value="{{old('phone') ?? ''}}" name="phone" required="">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Capacity" class="form-label"><strong>Gender</strong></label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option>Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><strong>Create Account</strong></button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection
@section("javacript")
  @include("admin.component.css_js.detail")
  <script>
    $('.toggle-checkbox').change(function() {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, default it!'
        }).then((result) => {
        if (result.isConfirmed) {
            let url = $(this).data("url");
            $.ajax({
                type:"POST",
                url: url,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if(res['rep'] == 1.1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Update Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'False connect Database',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                },
                error: function(xhr, status, error) {
            }
        });
        }else{
            let status = $(this).is(':checked') ? false : true
            $(this).prop("checked", status);
        };
    });
    });
  </script>
@endsection