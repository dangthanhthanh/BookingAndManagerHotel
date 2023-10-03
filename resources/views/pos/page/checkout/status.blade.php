@extends("pos.layout.pos")
@section('button_nav','')
@section("class",'toggle-sidebar')
@section("content")
  <div class="row">
    <form id="form_request" role="form" method="POST" action="{{route('pos.payment.cashHandle.create',$order->slug)}}">
      @method("POST")
      @csrf
      <div id="cash_payment_table" class="card-body" style="margin-top: 20px;">
        <div class="row">
          <div style="display: flex; justify-content: center; padding:20px; background:rgb(118, 255, 209); border-radius: 10px;">
            <img height="100px" width="" style="border-radius: 5px;" src="https://www.pngitem.com/pimgs/m/466-4661926_cash-payment-icon-money-icon-hd-png-download.png" alt="">
            <span class="mx-5" >
              <h2><strong>Payment Status : {{$order->status()}}</strong></h2><br>
              <h2><strong>Payment Method : {{ucfirst($order->payment()->method->name)}}</strong></h2><br>
            </span>
          </div>
        </div>
      </div>
    </form>
@endsection