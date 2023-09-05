@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route("room.index")}}">Room</a></li>
        <li class="breadcrumb-item active">Add</li>
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
                        <a class="nav-link active" href="#" disabled>Add New</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-edit pt-3" >
                        <!-- Profile Edit Form -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <form id="form-action" method="POST" action="{{ route('room.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-2 col-lg-2 col-form-label"><strong>Thumbnail</strong></label>
                                        <div class="col-md-8 col-lg-9">
                                            <label for="image">
                                                <img id="image-show" height="400px" src="{{old('image')??'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aG90ZWx8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60'}}" alt=""/>
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
                                            <input type="text" class="form-control" id="fullName" value="{{old('name') ?? ''}}" name="name" required="">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cost" class="form-label"><strong>Cost</strong></label>
                                            <input type="number" class="form-control" id="cost" value="{{old('cost') ?? ''}}" name="cost" required="">
                                            @error('cost')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-lg-2 col-form-label"></label>
                                        <div class="col-md-4">
                                            <label for="Capacity" class="form-label"><strong>Capacity</strong></label>
                                            <input type="number" max="20" min="1" class="form-control" id="Capacity" value="{{old('capacity') ?? ''}}" name="capacity" required="">
                                            @error('capacity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Bed" class="form-label"><strong>Bed</strong></label>
                                            <input type="number" max="5" min="1" class="form-control" id="Bed" value="{{old('bed') ?? ''}}" name="bed" required="">
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
                                                <input class="form-check-input" type="radio" name="category_id" id="category{{$category->id}}" value="{{$category->id}}" @checked(old('category_id') === $category->id)>
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
                                            <div id="editor" style="background-color: #fff;border:1px solid gray; min-height:600px;">{!!old('description') ?? ''!!}</div>
                                            <input type="hidden" id="description-input" name="description" value="">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><strong>Save Add</strong></button>
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