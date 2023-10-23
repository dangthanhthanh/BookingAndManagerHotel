@php
    $totalItemBalance = 0;
@endphp
<div class="row"><h4>
    Food
    </h4>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr class="table-active">
            <th scope="col">Food</th>
            <th scope="col">Check In</th>
            <th scope="col">Check Out</th>
            <th scope="col">Ratio</th>
            <th scope="col">Cost</th>
            <th scope="col">Total</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $order->bookingFood as $item )
            <tr>
                <td>{{$item->food->name}}</td>
                <td>{{$item->check_in}}</td>
                <td>{{$item->qty}}</td>
                <td>{{$item->ratio}}</td>
                <td>{{number_format($item->cost)}}</td>
                <td>{{number_format($item->totalCost())}}</td>
                <td>{{$item->created_at}}</td>
            </tr>
            @php
                $totalItemBalance += $item->totalCost();
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="right">Total Balance</td>
            <td >{{number_format($totalItemBalance)}}</td>
            <td >vnd</td>
        </tr>
    </tfoot>
</table>