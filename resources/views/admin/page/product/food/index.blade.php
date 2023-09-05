@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item">food</li>
        <li class="breadcrumb-item active">Data</li>
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
                        <a class="nav-link active" href="#" disabled>Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('food.add')}}">Add New</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview">
                        <div class="card" style="min-height: 55vh; overflow: scroll;">
                            <div class="card-body">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name @include("admin.component.sort_by",['sortBy'=>'name'])</th>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col" style="min-width: 150px;">Category @include("admin.component.sort_by",['sortBy'=>'category_id'])</th>
                                            <th scope="col" style="min-width: 100px;">Cost</th>
                                            <th scope="col">Active @include("admin.component.sort_by",['sortBy'=>'active'])</th>
                                            <th scope="col" style="min-width: 150px;">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col" style="min-width: 150px;">Updated At @include("admin.component.sort_by",['sortBy'=>'updated_at'])</th>
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
                                                <td>{{$item->category_name}}</td>
                                                <td>{{number_format($item->cost, 0, ',', '.') . ' đ'}}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input toggle-checkbox" type="checkbox" style="width: 70px;height: 20px;"
                                                        id="flexSwitchCheckChecked"
                                                        data-url="{{ route('food.setstatus', ['slug'=>$item->slug])}}"
                                                        @checked($item->active)>
                                                    </div>
                                                </td>
                                                <td>{{$item->created_at}}</td>
                                                <td>{{$item->updated_at}}</td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('food.delete', $item->slug) }}">
                                                        <a class="btn btn-primary" href="{{ route('food.description', $item->slug) }}"><i class="bi bi-file-play-fill"></i></a>
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
  @include("admin.component.css_js.js_active_form")
@endsection