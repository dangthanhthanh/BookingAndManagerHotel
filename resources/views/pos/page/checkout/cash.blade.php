@php
  use Carbon\Carbon;
  $customer = $order->customer;
@endphp
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
              <h2><strong>Cash Payment</strong></h2><br>
              <h4><strong>With Total Balance: <span style="font-size: 40px;">{{ number_format($totalBalance) }}</span> _vnd</strong></h4>
            </span>
          </div>
        </div>
        <table class="table table-striped">
          <tbody>
            <tr>
                <th scope="col">Time Payment</th>
                <td colspan="2">{{Carbon::now()}}</td>
            </tr>
            <tr>
                <th scope="col">Code Payment</th>
                <td colspan="2">{{$order->slug}}</td>
            </tr>
            <tr>
                <th scope="col">Status Payment</th>
                <td colspan="2"><strong>{{$order->status() === 'Paid' ? 'Paid' : 'Unpaid'}}</strong></td>
            </tr>
            <tr>
                <th scope="col">Customer Name</th>
                <td colspan="2">{{$customer->user_name}}</td>
            </tr>
            @auth
                <tr>
                    <th scope="col">Cashier</th>
                    <td colspan="2">{{Auth::user()->user_name}}</td>
                </tr>
            @endauth
            <tr>
              <th scope="col">ToTal</th>
              <td id="total_cost_for_payment">{{$totalBalance}}</td>
              <td>_vnd</td>
            </tr>
            <tr>
              <th scope="col">Cash</th>
              <td id="cash_for_payment"><input type="number" min="1000" id="cashInput" placeholder="Pending" class="form-control"></td>
              <td>_vnd</td>
            </tr>
            <tr>
              <th scope="col">Over</th>
              <td id="over_for_payment">none</td>
              <td>_vnd</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3">
                <div class="row">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    @if(!($order->status() === 'Paid'))
                      <button type="submit" class="btn btn-outline-info py-3">Success</button>
                    @endif
                    <a href="#printBill" id="printBillButton" class="btn btn-outline-info py-3" @disabled(true)>Prinf Bill</a>
                  </div>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </form>
@endsection
@section("javacript")
    <script>
        $(document).ready(function() {
            const totalCost = parseFloat($("#total_cost_for_payment").text());
            $("#cashInput").on("change", function() {
                let cash = parseFloat($(this).val());
                let over = cash - totalCost;
                const overElement = $("#over_for_payment");
                overElement.text(over.toFixed(2));
            });

            function printBill() {
                var printContent = $("#billTable").html(); 
                var originalContent = $("body").html();
                
                $("body").html(printContent);
                window.print();
                
                $("body").html(originalContent);
            }

            $("#printBillButton").click(function() {
                printBill();
            });
        });
    </script>
@endsection