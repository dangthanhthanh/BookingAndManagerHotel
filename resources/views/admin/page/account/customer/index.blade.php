@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Account</a></li>
        <li class="breadcrumb-item active">Customer</li>
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
                                            <th scope="col">User Name @include("admin.component.sort_by",['sortBy'=>'user_name'])</th>
                                            <th scope="col">Avatar</th>
                                            <th scope="col">Email @include("admin.component.sort_by",['sortBy'=>'email'])</th>
                                            <th scope="col">Phone @include("admin.component.sort_by",['sortBy'=>'phone'])</th>
                                            <th scope="col">Gender @include("admin.component.sort_by",['sortBy'=>'gender'])</th>
                                            <th scope="col">Join date @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Update at @include("admin.component.sort_by",['sortBy'=>'updated_at'])</th>
                                            <th scope="col">Active @include("admin.component.sort_by",['sortBy'=>'active'])</th>
                                            <th scope="col">Handle</th>
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
                                                <td>{{$item->phone ?? 'not use'}}</td>
                                                <td>{{$item->gender ?? 'not use'}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>{{$item->updated_at}}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input toggle-checkbox" type="checkbox" style="width: 70px;height: 20px;"
                                                        id="flexSwitchCheckChecked"
                                                        data-url="{{ route('customer.setstatus', ['slug'=>$item->slug])}}"
                                                        @checked($item->active)>
                                                    </div>
                                                </td>
                                                <td>
                                                    @include("admin.component.handle_form",[$table='customer'])
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
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection
@section("javacript")
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