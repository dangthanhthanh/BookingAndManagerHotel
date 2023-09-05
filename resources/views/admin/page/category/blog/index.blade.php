@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item">Category</li>
        <li class="breadcrumb-item active"><a href="{{route('category.blog.index')}}">Blog</a></li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <ul class="row">
                    <div class="search-bar">
                        <form class="search-form d-flex justify-content-center align-items-center" action="{{route('category.blog.store')}}" method="post">
                            @csrf
                            <div class="col-5 mx-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Enter New blog Category" title="Enter New blog Category" name="name">
                                    <label for="floatingName">Enter New blog Category</label>
                                </div>
                            </div>
                            <div>
                                <button class="form-control btn btn-outline-primary" type="submit" title="Add To Storage"><i class="ri-add-circle-fill"></i>Add New</button>
                            </div>
                        </form>
                    </div>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview">
                        <div class="row d-flex justify-content-around align-items-center">
                            @foreach ($datas as $item)
                                <div style="width: 500px; height: 100px; background-color:rgba(192, 192, 192, 0.3); border-radius:5px;" class="m-2 p-5 text-center d-flex justify-content-between align-items-center">
                                    <div class="text-center"><strong>{{$item->name}}</strong></div>
                                    <div class="text-center"><strong>{{$item->created_at}}</strong></div>
                                    <div class="d-flex">
                                        <form action="{{route('category.blog.delete',$item->slug)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger m-2"><i class="ri-delete-bin-6-line"></i></button>
                                        </form>
                                        <form action="{{route('blog.index')}}" method="get">
                                            @csrf
                                            <input type="hidden" name="category" value="{{$item->slug}}">
                                            <button class="btn btn-outline-primary m-2" title="view post data"><i class="ri-eye-line mx-2"></i>{{$item->blog->count()}}</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection