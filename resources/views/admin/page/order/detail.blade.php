@php
    use Carbon\Carbon;
    $totalBooking = 0;
    $totalBalance = 0;
@endphp
@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('order.index')}}">Order</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" >
                        @empty(!$data['bookingRoom'])
                            @php
                                $totalBooking = 0;
                            @endphp
                            <div class="row text-center my-5"><h4><strong>Booking Room</strong></h4></div>
                            <div class="card" style="overflow:scroll;">
                                <div class="card-body">
                                    <!-- Table with stripped rows -->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Room </th>
                                                <th scope="col">Status</th>
                                                <th scope="col" style="min-width: 150px;">Check In</th>
                                                <th scope="col" style="min-width: 150px;">Check Out</th>
                                                <th scope="col" style="min-width: 150px;">Per<sup>(per/capacity)</sup></th>
                                                <th scope="col" style="min-width: 150px;">Total Cost</th>
                                                <th scope="col" style="min-width: 150px;">Created At</th>
                                                <th scope="col" style="min-width: 150px;">Updated At</th>
                                                <th scope="col">Customer Request</th>
                                                <th scope="col">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ( $data['bookingRoom'] as $key => $item)
                                            @php
                                                $checkIn = Carbon::parse($item->check_in); 
                                                $checkOut = Carbon::parse($item->check_out);
                                                $costRate = 100;
                                                $numberOfNights = $checkIn->diffInDays($checkOut);
                                                $totalCost = $numberOfNights * $item->cost;
                                                $formattedTotalCost = number_format($totalCost, 0, ',', '.') . ' đ';

                                                $totalBooking += $totalCost;
                                            @endphp
                                                <tr>
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>{{$item->order->slug}}</td>
                                                    <td>{{$item->room->name}}</td>
                                                    <td>{{$item->status->name}}</td>
                                                    <td>{{$checkIn}}</td>
                                                    <td>{{$checkOut}}</td>
                                                    <td style="text-align: center;">{{$item->number_per}} / {{$item->room->capacity}}</td>
                                                    <td>{{$formattedTotalCost}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>{{$item->updated_at}}</td>
                                                    <td><textarea class="form-control" style="width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->cus_request}}</textarea></td>
                                                    <td><textarea class="form-control" style="width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->note}}</textarea></td>
                                                </tr>
                                            @empty
                                                <p style="text-align: center;">No Data Found!</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row text-center my-5 p-2 bg-info"><h5><strong>Total Balance For Booking Room: {{number_format($totalBooking, 0, ',', '.') . ' đ'}}</strong></h5></div>
                            @php
                                $totalBalance += $totalBooking;
                            @endphp
                        @endempty
                        @empty(!$data['bookingService'])
                            @php
                                $totalBooking = 0;
                            @endphp
                            <div class="row text-center my-5"><h4><strong>Booking Service</strong></h4></div>
                            <div class="card" style="overflow:scroll;">
                                <div class="card-body">
                                    <!-- Table with stripped rows -->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Service</th>
                                                <th scope="col" style="min-width: 150px;">Check In</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" style="min-width: 150px;">Total Cost</th>
                                                <th scope="col" style="min-width: 150px;">Created At</th>
                                                <th scope="col" style="min-width: 150px;">Updated At</th>
                                                <th scope="col">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ( $data['bookingService'] as $key => $item)
                                            @php
                                                $quantity = $item->qty;
                                                $totalCost = $quantity * $item->cost;
                                                $formattedTotalCost = number_format($totalCost, 0, ',', '.') . ' đ';

                                                $totalBooking += $totalCost; 
                                            @endphp
                                                <tr>
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>{{$item->order->slug}}</td>
                                                    <td>{{$item->service->name}}</td>
                                                    <td>{{$item->check_in}}</td>
                                                    <td  style="text-align: center;">{{$quantity}}</td>
                                                    <td>{{$formattedTotalCost}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>{{$item->updated_at}}</td>
                                                    <td><textarea class="form-control" style="width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->note}}</textarea></td>
                                                </tr>
                                            @empty
                                                <p style="text-align: center;">No Data Found!</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                            <div class="row text-center my-5 p-2 bg-info"><h5><strong>Total Balance For Booking service: {{number_format($totalBooking, 0, ',', '.') . ' đ'}}</strong></h5></div>
                            @php
                                $totalBalance += $totalBooking;
                            @endphp
                        @endempty
                        @empty(!$data['bookingFood'])
                            @php
                                $totalBooking = 0;
                            @endphp
                            <div class="row text-center my-5"><h4><strong>Booking Food</strong></h4></div>
                            <div class="card" style="overflow:scroll;">
                                <div class="card-body">
                                    <!-- Table with stripped rows -->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Food</th>
                                                <th scope="col" style="min-width: 150px;">Check In</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" style="min-width: 150px;">Total Cost</th>
                                                <th scope="col" style="min-width: 150px;">Created At</th>
                                                <th scope="col" style="min-width: 150px;">Updated At</th>
                                                <th scope="col">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ( $data['bookingFood'] as $key => $item)
                                            @php
                                                $quantity = $item->qty;
                                                $totalCost = $quantity * $item->cost;
                                                $formattedTotalCost = number_format($totalCost, 0, ',', '.') . ' đ';

                                                $totalBooking += $totalCost; 
                                            @endphp
                                                <tr>
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>{{$item->order->slug}}</td>
                                                    <td>{{$item->food->name}}</td>
                                                    <td>{{$item->check_in}}</td>
                                                    <td style="text-align: center;">{{$quantity}}</td>
                                                    <td>{{$formattedTotalCost}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>{{$item->updated_at}}</td>
                                                    <td><textarea class="form-control" style="width: 400px; max-height: 200px; min-height: 100px;" disabled>{{$item->note}}</textarea></td>
                                                </tr>
                                            @empty
                                                <p style="text-align: center;">No Data Found!</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                            <div class="row text-center my-5 p-2 bg-info"><h5><strong>Total Balance For Booking Food: {{number_format($totalBooking, 0, ',', '.') . ' đ'}}</strong></h5></div>
                            @php
                                $totalBalance += $totalBooking;
                            @endphp
                        @endempty
                    </div>
                    <div class="row text-center m-5 p-5 bg-info"><h3><strong>Total Balance: {{number_format($totalBalance, 0, ',', '.') . ' đ'}}</strong></h3></div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection