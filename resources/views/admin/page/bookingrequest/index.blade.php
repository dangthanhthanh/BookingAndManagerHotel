@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('booking.request.index')}}">News Email</a></li>
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
                        <a href="{{route('booking.request.index')}}" class="btn btn-primary m-2 px-5 nav-link {{ request()->route()->getName() === 'booking.request.index' ? 'active' : '' }}" title="Custom Mail">Data</a>
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
                                            <th scope="col" style="min-width: 150px;">User Name</th>
                                            <th scope="col" style="min-width: 150px;">Email</th>
                                            <th scope="col" style="min-width: 150px;">Phone</th>
                                            <th scope="col" style="min-width: 200px;">Check In @include("admin.component.sort_by",['sortBy'=>'check_in'])</th>
                                            <th scope="col" style="min-width: 200px;">Check Out @include("admin.component.sort_by",['sortBy'=>'check_out'])</th>
                                            <th scope="col" style="min-width: 150px;">Room Type @include("admin.component.sort_by",['sortBy'=>'room_category_id'])</th>
                                            <th scope="col" style="min-width: 150px;">Request</th>
                                            <th scope="col" style="min-width: 150px;">Verify @include("admin.component.sort_by",['sortBy'=>'email_verified_at'])</th>
                                            <th scope="col" style="min-width: 200px;">Status Contact @include("admin.component.sort_by",['sortBy'=>'status_id'])</th>
                                            <th scope="col" style="min-width: 150px;">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Handlle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                            <tr>
                                                @php
                                                    $customer = $item->customer;
                                                @endphp
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$customer->user_name}}</td>
                                                <td>{{$customer->email}}</td>
                                                <td>{{$customer->phone}}</td>
                                                <td>{{$item->check_in}}</td>
                                                <td>{{$item->check_out}}</td>
                                                <td>{{$item->roomCategory->name}}</td>
                                                <td><textarea class="form-control" style="max-width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->request}}</textarea></td>
                                                <td>{!!$customer->email_verified_at ? '<span class="btn btn-success p-20">true</span>' : '<span class="btn btn-secondary p-20">false</span>'!!}</td>
                                                <td>{{$item->status->name}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <form method="post" action="{{ route('booking.request.delete',$item->slug) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-6-line"></i></button>
                                                    </form>
                                                    <form method="post" action="{{ route('booking.request.advise',$item->slug) }}">
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