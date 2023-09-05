@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active">Room Category</li>
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
                        <a class="nav-link active" href="#" disabled>Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category.room.add')}}">Add New</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview">
                        <div class="card" style="min-height: 55vh;">
                            <div class="card-body">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Short Description</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->name}}</td>
                                                <td>
                                                    <img src="{{$item->image_url}}" height="70" alt="Thumbnail">
                                                </td>
                                                <td>{{number_format($item->cost, 0, ',', '.') . ' đ'}}</td>
                                                <td><textarea class="form-control" style="max-width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->short_description}}</textarea></td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('category.room.delete', $item->slug) }}">
                                                        <a class="btn btn-primary" href="{{ route('category.room.description', $item->slug) }}"><i class="bi bi-file-play-fill"></i></a>
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-6-line"></i></button>
                                                    </form>
                                                    <form action="{{route('room.index')}}" method="get">
                                                        @csrf
                                                        <input type="hidden" name="role" value="{{$item->slug}}">
                                                        <button class="btn btn-outline-primary m-1"><i class="bi bi-view-list"></i>{{$item->room->count()}}</button>
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