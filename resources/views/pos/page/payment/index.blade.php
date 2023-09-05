@php
  use Carbon\Carbon;
  $totalBalance = 0;
  $totalBooking = 0;
  $CheckIn = Carbon::now();
  $CheckOut = Carbon::now()->addDays(1);
@endphp
@extends("pos.layout.pos")
@section('button_nav','')
@section("class",'toggle-sidebar')
@section("content")
  <div class="row"><h2 style="display: flex; justify-content: center; padding:20px; background:aquamarine;"><strong>Customer Information For Payment</strong></h2></div>
  <div class="d-flex justify-content-between">
    <form class="d-flex">
      <input type="hidden" name="phone" value="guest"/>
      <button type="submit" class="btn btn-outline-info">Payment For Guest</button>
    </form>
    <form class="d-flex justify-content-center" style="width: 100%;">
      <div class="form-floating mx-5" style="width: 100%;">
        <input type="number" class="form-control" id="floatingName" placeholder="Search By Phone" title="Enter search keyword" name="phone" value="{{ request()->input('phone') }}" required>
        <label for="floatingName">Search By Phone</label>
      </div>
      <button type="submit" class="btn btn-outline-info">Payment For Member</button>
    </form>
  </div>
  <div id="bill_for_payment">
    @if (!empty($customer['phone']))
    <form id="register_user" class="my-5" method="POST" action="{{(!empty($customer['data']['slug']))?route('pos.payment.update.customer',$customer['data']['slug']):route('pos.payment.create.customer')}}">
        @csrf
        @method("POST")
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>User Name</th>
                    <td>
                    <input type="text" class="form-control" name="user_name"  value="{{$customer['data']['user_name'] ?? ''}}" @disabled(!empty($customer['data']['user_name']))  placeholder="Enter User Name" required/>
                    @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>
                    <input type="text" class="form-control"  value="{{$customer['phone'] ?? ''}}" @disabled(!empty($customer['phone'])) required/>
                  </td>
                </tr>
                @if ((empty($customer['data']['slug'])))
                  <input type="hidden" class="form-control" name="phone" value="{{$customer['phone']}}"/>
                @endif
                @if (!($customer['phone'] === 'guest'))
                  <tr>
                    <th>Email</th>
                    <td>
                      <input type="text" class="form-control" name="email" value="{{_($customer['data']['email'] ?? '')}}" @disabled(!empty($customer['data']['email'])) placeholder="Enter Email" />
                      @error('email')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </td>
                  </tr>
                  @if(!empty($bookingForRoom))
                    <tr>
                      <th>Id Card</th>
                      <td>
                        <input type="number" class="form-control" name="cccd" value="{{($customer['data']['cccd'] ?? '')}}" @required(true) @disabled(!empty($customer['data']['cccd'])) placeholder="Enter Id Card" />
                        @error('cccd')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </td>
                    </tr>
                  @endif
                @endif
            </tbody>
        </table>
        @if(!$customer['phone']==='guest')
          @if (empty($customer['data'])||(empty($customer['data']['cccd']) && (!empty($bookingForRoom))))
              <div class="d-grid gap-2 mt-3">
                  <input type="submit" class="btn btn-outline-info" value="{{empty($customer['data']['cccd']) ? 'Add Information For Customer Account' : 'Register For New Customer'}}"/>
              </div>
          @endif
        @endif
    </form>
    @endif
    <div class="row"><h2 style="display: flex; justify-content: center; padding:20px; background:aquamarine;"><strong>Order Payment</strong></h2></div>
    <h5 class="card-title">Order Room
      <a href="{{route('pos.room.index')}}" class="btn btn-outline-info"><i class="ri-add-circle-line" aria-hidden="true"></i></a>
    </h5>
    @empty(!$bookingForRoom)
      @php
        $totalBooking = 0;
      @endphp
      <!-- Default Table -->
      <table class="table table-striped table-hover" id="order-table-list">
        <thead>
          <tr>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>#</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Room</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Cost</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>CheckIn</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>CheckOut</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Total</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Edit</strong></h6>
                </div>
              </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bookingForRoom as $key => $item)
            @php
              $days_difference = $CheckIn->diffInDays($CheckOut);
              $totalBookingItem = $days_difference * $item['productCost'];
              $totalBooking += $totalBookingItem;
            @endphp
            <tr>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$key+1}}</strong></h6>
                </div>
              </td>
              <td>
                  <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productName']}}</strong></h6>
                  </div>
              </td>
              <td>
                <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productCost']}}</strong></h6>
                </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong><input type="datetime-local" name="check_in_room" class="check_in form-control datepicker" value = "{{$CheckIn}}"  required="required"></strong></h6>
                </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong><input type="datetime-local" name="check_out_room" class="check_out form-control datepicker" value = "{{$CheckOut}}" required="required"></strong></h6>
                </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$totalBookingItem}}</strong></h6>
                </div>
              </td>
              <td>
                <a href="{{route('pos.room.index')}}" class="btn btn-outline-danger"><i class="ri-ball-pen-fill" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        <tfoot>
          <tr>
              <th colspan="5">Total:_</th>
              <td scope="col"><strong>{{$totalBooking}}</strong></td>
              <td scope="col"><strong>_vnd</strong></td>
          </tr>
        </tfoot>
      </table>
    @endempty
      <!-- End Default Table Example -->
      <h5 class="card-title">Order Food
        <a href="{{route('pos.food.index')}}" class="btn btn-outline-info"><i class="ri-add-circle-line" aria-hidden="true"></i></a>
      </h5>
    @empty(!$bookingForFood)
      @php
        $totalBalance += $totalBooking;
        $totalBooking = 0;
      @endphp
      <!-- Default Table -->
      <table class="table table-striped table-hover" id="order-table-list">
        <thead>
          <tr>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>#</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Name</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Cost</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Quantity</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>CheckIn</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Total</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Edit</strong></h6>
                </div>
              </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bookingForFood as $key => $item)
            @php
              $totalBookingItem = $item['productCost'] * $item['quantity'];
              $totalBooking += $totalBookingItem;
            @endphp
            <tr>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$key+1}}</strong></h6>
                </div>
              </td>
              <td>
                  <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productName']}}</strong></h6>
                  </div>
              </td>
              <td>
                <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productCost']}}</strong></h6>
                </div>
              </td>
              <td>
                  <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['quantity']}}</strong></h6>
                  </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong><input type="datetime-local" name="check_in_food" class="check_in form-control datepicker" value = "{{$CheckIn}}" required="required"></strong></h6>
                </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$totalBookingItem}}</strong></h6>
                </div>
              </td>
              <td>
                <a href="{{route('pos.food.index')}}" class="btn btn-outline-danger"><i class="ri-ball-pen-fill" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
          <tr>
              <th colspan="5">Total:_</th>
              <td scope="col"><strong>{{$totalBooking}}</strong></td>
              <td scope="col"><strong>_vnd</strong></td>
          </tr>
        </tfoot>
      </table>
    @endempty
    <!-- End Default Table Example -->
    <div class="d-flex">
      <h5 class="card-title">Order Service
        <a href="{{route('pos.service.index')}}" class="btn btn-outline-info"><i class="ri-add-circle-line" aria-hidden="true"></i></a>
      </h5>
    </div>
    @empty(!$bookingForService)
      @php
        $totalBalance += $totalBooking;
        $totalBooking = 0;
      @endphp
      <!-- Default Table -->
      <table class="table table-striped table-hover" id="order-table-list">
        <thead>
          <tr>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>#</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Name</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Cost</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Quantity</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>CheckIn</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Total</strong></h6>
                </div>
              </th>
              <th scope="col">
                <div class="btn-group">
                  <h6 class="btn btn-outline"><strong>Edit</strong></h6>
                </div>
              </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bookingForService as $key => $item)
            @php
              $totalBookingItem = $item['productCost'] * $item['quantity'];
              $totalBooking += $totalBookingItem;
            @endphp
            <tr>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$key+1}}</strong></h6>
                </div>
              </td>
              <td>
                  <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productName']}}</strong></h6>
                  </div>
              </td>
              <td>
                <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['productCost']}}</strong></h6>
                </div>
              </td>
              <td>
                  <div class="btn-group">
                      <h6 class="btn btn-outline"><strong>{{$item['quantity']}}</strong></h6>
                  </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong><input type="datetime-local" name="check_in_service"  value = "{{$CheckIn}}" class="check_in form-control datepicker booking_in" required="required"></strong></h6>
                </div>
              </td>
              <td>
                <div class="btn-group">
                    <h6 class="btn btn-outline"><strong>{{$totalBookingItem}}</strong></h6>
                </div>
              </td>
              <td>
                <a href="{{route('pos.service.index')}}" class="btn btn-outline-danger"><i class="ri-ball-pen-fill" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
          <tr>
              <th colspan="5">Total:_</th>
              <td scope="col"><strong>{{$totalBooking}}</strong></td>
              @php
                // $totalBalance += $totalBooking;
              @endphp
              <td scope="col"><strong>_vnd</strong></td>
          </tr>
        </tfoot>
      </table>
    @endempty
    <!-- End Default Table Example -->
    @php
    $totalBalance += $totalBooking;
    @endphp
  <div class="row"><h4 style="display: flex; justify-content: center; padding:20px; background:aquamarine;"><strong>Total_Balance_: {{$totalBalance}}</strong></h4></div>
</div>
  <div class="row"><h6 style="display: flex; justify-content: center; padding:20px; background:aquamarine;"><strong><button class="btn btn-outline-info" id="printBillButton">Print Bill</button></strong></h6></div>
  @if (empty($customer['data']))
    <div class="row"><h6 style="display: flex; justify-content: center; padding:20px; background:aquamarine;"><strong>Enter User Information For Payment</strong></h6></div>
  @else
    <div class="d-flex justify-content-around" style="margin-top: 20px;" id="order_payment_method">
          @include("pos.component.payment.form_create_payment", [
            'route' => route('pos.payment.cashPayment'),
            'buttonImage' => 'https://www.pngitem.com/pimgs/m/466-4661926_cash-payment-icon-money-icon-hd-png-download.png',
            'buttonText' => 'Cash',
          ])
          @include("pos.component.payment.form_create_payment", [
            'route' => route('pos.payment.vnpayPayment'),
            'buttonImage' => 'https://inkythuatso.com/uploads/images/2021/12/vnpay-logo-inkythuatso-01-13-16-26-42.jpg',
            'buttonText' => 'VnPay',
          ])
      </div>
    </div>
  @endif
@endsection
@section("javacript")
<script>
  $(document).ready(function() {
    function printBill() {
        // Get the current date and time
        const currentDate = new Date();
        const dateTimeString = currentDate.toLocaleString();
        
        const paymentStatus = "Chưa thanh toán"; // Replace with your payment status logic
        const hotelName = "Tên khách sạn"; // Replace with your hotel name
        const customerName = "Tên khách hàng"; // Replace with your customer name
        const cashierName = "Tên thu ngân"; // Replace with your cashier name
        
        // Create the header HTML
        const headerHtml = `
            <table class="table table-striped table-hover" id="order-table-list">
              <tbody>
                <tr>
                    <th scope="col">
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>Date time</strong></h6>
                      </div>
                    </th>
                    <td>
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>${dateTimeString}</strong></h6>
                      </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>Payment Status</strong></h6>
                      </div>
                    </th>
                    <td>
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>${paymentStatus}</strong></h6>
                      </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>Hotel:</strong></h6>
                      </div>
                    </th>
                    <td>
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>${hotelName}</strong></h6>
                      </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>Customer</strong></h6>
                      </div>
                    </th>
                    <td>
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>${customerName}</strong></h6>
                      </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>Casher</strong></h6>
                      </div>
                    </th>
                    <td>
                      <div class="btn-group">
                        <h6 class="btn btn-outline"><strong>${cashierName}</strong></h6>
                      </div>
                    </td>
                </tr>
              </tbody>
            </table>
        `;

        // Get the HTML content of the bill table
        const billContent = $("#bill_for_payment").html();
        
        // Combine the header and bill content
        
        const printContent = headerHtml + billContent; 
        const originalContent = $("body").html();
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