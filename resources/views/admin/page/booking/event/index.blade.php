@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active">Booking</li>
        <li class="breadcrumb-item active"><a href="{{route('booking.event.index')}}">Event</a></li>
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
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Data</button>
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
                                            <th scope="col">Order Id @include("admin.component.sort_by",['sortBy'=>'order_id'])</th>
                                            <th scope="col">event @include("admin.component.sort_by",['sortBy'=>'event_id'])</th>
                                            <th scope="col">Check In @include("admin.component.sort_by",['sortBy'=>'check_in'])</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col" style="min-width: 150px;">Total Cost</th>
                                            <th scope="col">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">Updated At @include("admin.component.sort_by",['sortBy'=>'updated_at'])</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $datas as $key => $item)
                                        @php
                                            $quantity = $item->qty;
                                            $totalCost = $quantity * $item->cost;
                                            $formattedTotalCost = number_format($totalCost, 0, ',', '.') . ' đ';
                                        @endphp
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{$item->order->slug}}</td>
                                                <td>{{$item->event->name}}</td>
                                                <td>{{$item->check_in}}</td>
                                                <td>{{$quantity}}</td>
                                                <td>{{$formattedTotalCost}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>{{$item->updated_at}}</td>
                                                <td>
                                                    <a href="{{route('order.detail',$item->order->slug)}}" class="btn btn-outline-primary">view Order</a>
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