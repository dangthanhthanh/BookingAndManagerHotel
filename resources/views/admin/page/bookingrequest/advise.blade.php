@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-dark" href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a class="text-dark" href="{{route('booking.request.index')}}">News Email</a></li>
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
                    <li class="nav-item">
                        <a href="{{route('booking.request.advise',$data->slug)}}" class="btn btn-primary m-2 px-5 nav-link {{ request()->route()->getName() === 'booking.request.advise' ? 'active' : '' }}" title="Custom Mail">Advise</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <h3> 
                                                <strong>
                                                    Data User
                                                </strong>
                                            </h3>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                                $customer = $data->customer;
                                            @endphp
                                            <tr>
                                                <th scope="row">User Name</th>
                                                <td>{{$customer->user_name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{$customer->email}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone</th>
                                                <td>{{$customer->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Check In</th>
                                                <td>{{$data->check_in}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Check Out</th>
                                                <td>{{$data->check_out}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Room Type</th>
                                                <td>{{$data->roomCategory->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Number Person</th>
                                                <td>{{$data->num_person}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Number Children</th>
                                                <td>{{$data->num_child}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Customer Request</th>
                                                <td>{!!$data->request ? ('<textarea class="form-control" disabled>'.$data->request.'</textarea>') : "not Request" !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Telesale Note</th>
                                                <td>{!!$data->note ? ('<textarea class="form-control" disabled>'.$data->note.'</textarea>') : "not advise" !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Verify</th>
                                                <td>{!!$customer->email_verified_at ? '<span class="btn btn-success p-20">true</span>' : '<span class="btn btn-secondary p-20">false</span>'!!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">History Advise</th>
                                                <td>{!!$data->status_history ? ('<textarea class="form-control" disabled>'.$data->status_history.'</textarea>') : "not advise" !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status Contact</th>
                                                <td>{{$data->status->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Created At</th>
                                                <td>{{$data->created_at}}</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                <div class="row text-left">
                                    <h3>
                                        <strong>
                                            Telesale Form
                                        </strong>
                                    </h3>
                                </div>
                                <form id="form-action" method="POST" action="{{route('booking.request.telesale',$data->slug)}}">
                                    @csrf
                                    <div class="row mt-5">
                                        <label for="request"><strong>Customer Request</strong></label>
                                        <textarea name="request" type="text" class="form-control m-auto" style="width: 50%; min-width:500px;" id="request" value="{{$data->request}}"></textarea>
                                        @error('request')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mt-5">
                                        <label for="note"><strong>Note</strong></label>
                                        <textarea name="note" type="text" class="form-control m-auto" style="width: 50%; min-width:500px;" id="note" value="{{$data->note}}"></textarea>
                                        @error('note')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mt-5">
                                        <label for="form_mail"><strong>Status Contact</strong></label>
                                        <div>
                                            @foreach ($statuses as $item)
                                            <div class="mx-3">
                                                <input type="radio" name="status" value="{{$item}}" id="status_{{$item}}" required checked>
                                                <label for="status_{{$item}}" class="">
                                                    {{$item->name}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn btn-outline-primary"><strong>Save As</strong></button>
                                    </div>
                                </form>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection