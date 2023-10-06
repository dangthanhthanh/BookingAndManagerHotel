@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('notify.index')}}">News Email</a></li>
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
                        <a href="{{route('notify.index')}}" class="m-2 px-5 nav-link active" @disabled(true) title="Email Get News">News</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notify.customMail')}}" class="m-2 px-5 nav-link" title="Custom Mail">Custom Mail</a>
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
                                            <th scope="col">Email</th>
                                            <th scope="col">Verify @include("admin.component.sort_by",['sortBy'=>'email_verified_at'])</th>
                                            <th scope="col">Join Date @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->email}}</td>
                                                <td>{!!$item->email_verified_at ? '<span class="btn btn-success p-20">true</span>' : '<span class="btn btn-secondary p-20">false</span>'!!}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <form method="post" action="{{ route('notify.delete',$item->id) }}">
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