@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route("food.index")}}">Food</a></li>
        <li class="breadcrumb-item active">{{$data->name}}</li>
        <li class="breadcrumb-item active">Description</li>
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
                        <a class="nav-link" href="{{ route('food.index') }}">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('food.add') }}">Add New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" disabled>Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('food.edit',$data->slug) }}">Edit</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card">
                            <div class="card-body">
                                {{-- class for shoe ckeditor content --}}
                                <div class="ck-content">
                                    {{-- [data description] --}}
                                    {!!$data->description!!}
                                </div>
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
    {{-- just get class for ck-content--}}
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/decoupled-document/ckeditor.js"></script>
@endsection