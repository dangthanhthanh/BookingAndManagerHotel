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
						<div class="home_title">
                            Checkout <br>
                            Payment
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- booking -->
<div class="details">
	<div class="container">
        <div class="d-flex justify-content-center text-dark">
            <div class="d-block px-5" style="overflow:scroll;">
                @forelse ($orders as $key => $order)
                    <div class="row">
                        #:_<h4>{{$key+1}}</h4><br>
                        OrderId:_{{$order->slug}}<br>
                        Created: _{{$order->created_at}}<br>
                        TotalBalance: _{{number_format($order->totalBalance())}}<br>
                        Status: _{{$order->status()}}<br>
                    </div>
                    @if($order->bookingRoom->count())
                        @include("client.component.checkout.room")
                    @endif
                    
                    @if($order->bookingFood->count())
                        @include("client.component.checkout.food")
                    @endif
                    {{-- service --}}
                    @if($order->bookingService->count())
                        @include("client.component.checkout.service")
                    @endif
                    @if(in_array($order->status(),['unpaid','false']))
                        <div class="d-flex">
                            <form class="d-block" action="{{ route("client.payment.vnpay", ['order' => $order->slug])}}" method="post">
                                @csrf
                                <input type="hidden" name="{{md5('hashTotalBalance')}}" value = "{{Hash::make($order->totalBalance().$order->slug)}}">
                                <input type="hidden" name="{{md5('order_slug')}}" value = "{{md5($order->slug)}}">
                                {{-- <button class="button" type="submit" name="{{md5('percent')}}" value="0.2" >Payment 20% <span class="btn-info p-2">{{number_format($totalBalance*0.2)}}</span></button>
                                <button class="button" type="submit" name="{{md5('percent')}}" value="0.5" >Payment 50% <span class="btn-info p-2">{{number_format($totalBalance*0.5)}}</span></button> --}}
                                {{-- <button class="button" type="submit" name="{{md5('percent')}}" value="1" >Payment 100% <span class="btn-info p-2">{{number_format($totalBalance)}}</span></button> --}}
                                <button class="button" type="submit" name="{{md5('percent')}}" value="1" >Payment<span class="btn-info p-2">{{number_format($order->totalBalance())}}</span></button>
                            </form> 
                        </div>
                    @endif
                @empty
                    <div class="row">
                        <h4>
                            you dont have anyone else orders, 
                        </h4>
                    </div>
                @endforelse
                @if(!(count($orders) <= 1))
                <div class="page_nav">
                    <ul class="d-flex flex-row align-items-center justify-content-center">
                        @foreach (($orders->links()["elements"][0]) as $key=>$value)
                            <li class="{{(request()->query('page') == $key) ? 'active' : ''}}"><a href="{{$value}}">0{{$key}}.</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <!-- Page Nav -->
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('client/js/booking.js')}}"></script>
@endsection