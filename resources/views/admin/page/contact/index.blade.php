@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('contact.index')}}">News Email</a></li>
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
                        <a href="{{route('contact.index')}}" class="btn btn-primary m-2 px-5 nav-link {{ request()->route()->getName() === 'contact.index' ? 'active' : '' }}" title="Custom Mail">Custom Mail</a>
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
                                            <th scope="col" style="min-width: 150px;">Customer @include("admin.component.sort_by",['sortBy'=>'name'])</th>
                                            <th scope="col" style="min-width: 200px;">Email</th>
                                            <th scope="col" style="min-width: 200px;">Subject</th>
                                            {{-- <th scope="col" style="min-width: 150px;">Phone</th> --}}
                                            <th scope="col">Messenger</th>
                                            <th scope="col" style="min-width: 150px;">Verify @include("admin.component.sort_by",['sortBy'=>'email_verified_at'])</th>
                                            {{-- <th scope="col" style="min-width: 200px;">Status Contact @include("admin.component.sort_by",['sortBy'=>'status_id'])</th> --}}
                                            <th scope="col" style="min-width: 150px;">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Handlle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->subject}}</td>
                                                {{-- <td>{{$item->phone}}</td> --}}
                                                <td><textarea class="form-control" style="max-width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->messenger}}</textarea></td>
                                                <td>{!!$item->email_verified_at ? '<span class="btn btn-success p-20">true</span>' : '<span class="btn btn-secondary p-20">false</span>'!!}</td>
                                                {{-- <td>{{$item->status->name}}</td> --}}
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <form method="post" action="{{ route('contact.delete',$item->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-6-line"></i></button>
                                                    </form>
                                                    <form method="post" action="{{ route('contact.advise',$item->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary"><i class="bi bi-headset"></i></button>
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