@php
  use Carbon\Carbon;
  $totalBooking = 0;
@endphp
<h5 class="card-title">Order Food
  <a href="{{route('pos.food.index')}}" class="btn btn-outline-primary"><i class="ri-add-circle-line" aria-hidden="true"></i></a>
</h5>
@empty(!$bookingData)
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
    @foreach ($bookingData as $key => $item)
      @php
        $totalBookingItem = $item['productCost'] * $item['quantity'];
        $totalBooking += $totalBookingItem;
        $totalOrderPayment += $totalBooking;
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
              <h6 class="btn btn-outline"><strong>{{Carbon::now()}}</strong></h6>
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