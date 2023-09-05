@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('review.index')}}">Review</a></li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <a href="{{route('review.index')}}" class="btn btn-primary m-2 px-5 nav-link {{ request()->route()->getName() === 'review.index' ? 'active' : '' }}" title="Custom Mail">Custom Mail</a>
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
                                            <th scope="col" style="min-width: 150px;">Customer</th>
                                            <th scope="col" style="min-width: 150px;">rate @include("admin.component.sort_by",['sortBy'=>'rate'])</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" style="min-width: 150px;">Active @include("admin.component.sort_by",['sortBy'=>'active'])</th>
                                            <th scope="col" style="min-width: 150px;">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Handlle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->customer->user_name}}</td>
                                                <td>{{$item->rate}}</td>
                                                <td>{{$item->title}}</td>
                                                <td>{{$item->description}}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input toggle-checkbox" type="checkbox" style="width: 70px;height: 20px;"
                                                        id="flexSwitchCheckChecked"
                                                        data-url="{{ route('review.setstatus',['slug'=>$item->slug])}}"
                                                        @checked($item->active)>
                                                    </div>
                                                </td>
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('review.delete',$item->slug) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-6-line"></i></button>
                                                    </form>
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