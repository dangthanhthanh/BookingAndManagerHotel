@php
    $totalBalance = 0;
@endphp
@extends("client.layouts.client")
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/booking_responsive.css')}}">
    @include("client.component.css_js.cssform")
@endsection
@section("content")
<div class="home">
	<div class="background_image" style='background-image:url("{{asset('client/images/booking.jpg')}}"'></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Checkout</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Booking -->
<div class="details">
	<div class="container">
        <div class="row">
            <div class="d-block">
            @empty(!$order->bookingRoom)
            <div class="row"><h4>
                Booking Room
                </h4>
            </div>
            <div class="row">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-active">
                            <th scope="col">Room</th>
                            <th scope="col">Check In</th>
                            <th scope="col">Check Out</th>
                            <th scope="col">Ratio</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Total</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $order->bookingRoom as $item )
                            @php
                                $total_item = $item->cost * $item->ratio;
                                $totalBalance += $total_item;
                            @endphp
                            <tr>
                                <td>{{$item->room->name}}</td>
                                <td>{{$item->check_in}}</td>
                                <td>{{$item->check_out}}</td>
                                <td>{{$item->ratio}}</td>
                                <td>{{number_format($item->cost)}}</td>
                                <td>{{number_format($total_item)}}</td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" align="right">Total Balance</td>
                            <td >{{number_format($totalBalance)}}</td>
                            <td >vnd</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex">
                    <form class="d-block" action="{{ route("client.payment.vnpay", ['order' => $order->slug])}}" method="post">
                        @csrf
                        <input type="hidden" name="{{md5('totalBalance')}}" value = "{{$totalBalance}}">
                        <input type="hidden" name="{{md5('order_slug')}}" value = "{{md5($order->slug)}}">
                        <button class="button" type="submit" name="{{md5('percent')}}" value="0.2" >Payment 20% <span class="btn-info p-2">{{number_format($totalBalance*0.2)}}</span></button>
                        <button class="button" type="submit" name="{{md5('percent')}}" value="0.5" >Payment 50% <span class="btn-info p-2">{{number_format($totalBalance*0.5)}}</span></button>
                        <button class="button" type="submit" name="{{md5('percent')}}" value="1" >Payment 100% <span class="btn-info p-2">{{number_format($totalBalance)}}</span></button>
                    </form> 
                </div>
            </div>
            @endempty
        </div>
    </div>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@endsection