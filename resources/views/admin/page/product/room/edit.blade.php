@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route("room.index")}}">Room</a></li>
        <li class="breadcrumb-item">{{$data->name}}</li>
        <li class="breadcrumb-item active">Edit</li>
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
                        <a class="nav-link" href="{{ route('room.index') }}">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('room.add') }}">Add New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('room.description',$data->slug) }}">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" disabled>Edit</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                        <!-- Profile Edit Form -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <form id="form-action" method="POST" action="{{ route('room.update',$data->slug) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-2 col-lg-2 col-form-label"><strong>Thumbnail</strong></label>
                                        <div class="col-md-8 col-lg-9">
                                            <label for="image">
                                                <img id="image-show" height="400px" src="{{$data->image->url}}" alt=""/>
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
                                            <label for="fullName" class="form-label"><strong>Name</strong></label>
                                            <input type="text" class="form-control" id="fullName" value="{{$data->name}}" name="name" required="">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cost" class="form-label"><strong>Cost</strong></label>
                                            <input type="number" class="form-control" id="cost" value="{{$data->cost}}" name="cost" required="">
                                            @error('cost')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <div class="col-md-4">
                                            <label for="Capacity" class="form-label"><strong>Capacity</strong></label>
                                            <input type="number" max="20" min="1" class="form-control" id="Capacity" value="{{$data->capacity}}" name="capacity" required="">
                                            @error('capacity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Bed" class="form-label"><strong>Bed</strong></label>
                                            <input type="number" max="5" min="1" class="form-control" id="Bed" value="{{$data->bed}}" name="bed" required="">
                                            @error('bed')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="category" class="col-md-2 col-lg-2 col-form-label"><strong>Category</strong></label>
                                        <div class="col-md-9">
                                            @foreach ($category as $category)
                                            <div class="col-6">
                                                <input class="form-check-input" type="radio" name="category_id" id="category{{$category->id}}" value="{{$category->id}}" @checked($data->category_id === $category->id)>
                                                <label class="form-check-label" for="category{{$category->id}}" style="margin-right: 20px;">
                                                    {{$category->name}}
                                                </label>
                                            </div>
                                            @endforeach 
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"><strong>Description</strong></label>
                                        <div class="">
                                            <div id="toolbar-container" style="width: 100%;"></div>
                                            <div id="editor" style="background-color: #fff;border:1px solid gray; min-height:600px;">{!!$data->description!!}</div>
                                            <input type="hidden" id="description-input" name="description" value="{{$data->description}}">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><strong>Save Change</strong></button>
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
@endsection