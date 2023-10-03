<form action="{{ $route }}" method="post">
    @csrf
    <input type="hidden" name="{{md5('payment_user')}}" value="{{ $customer['data']['slug'] }}">
    <input type="hidden" name="{{md5('payment_order')}}" value="{{ json_encode([
        'orderRoom' => $bookingForRoom,
        'orderService' => $bookingForService,
        'orderFood' => $bookingForFood,
    ]) }}">
    <input type="hidden" name="bill_for_payment" value="">
    <input type="hidden" name="{{md5('total_balance')}}" value="{{ Hash::make($totalBalance) }}">
    <button type="submit" style="width: 200px;" class="btn btn-outline-info py-3">
        <img height="100px" style="border-radius: 5px;" src="{{ $buttonImage }}" alt="">
        <h2><strong>{{ $buttonText }}</strong></h2>
    </button>
</form> 