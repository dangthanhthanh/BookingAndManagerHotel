<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="{{asset('admin/img/logo.png')}}" alt="">
        <span class="d-none d-lg-block">Hotel Manager</span>
      </a>
      @yield('button_nav')
    </div><!-- End Logo -->
    <div class="d-flex align-items-center justify-content-between" style="margin: 0 auto;">
      <div class="row">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
          <a type="button" href="{{route("pos.room.index")}}" class="btn btn-outline-info text-dark py-3 {{ request()->route()->getName() === 'pos.room.index' ? 'active':''}}"><strong>Booking Room</strong></a>
          <a type="button" href="{{route("pos.food.index")}}" class="btn btn-outline-info text-dark py-3 {{ request()->route()->getName() === 'pos.food.index' ? 'active':''}}"><strong>Booking Food</strong></a>
          <a type="button" href="{{route("pos.service.index")}}" class="btn btn-outline-info text-dark py-3 {{ request()->route()->getName() === 'pos.service.index' ? 'active':''}}"><strong>Booking Service</strong></a>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-between" style="margin: 0 auto;">
      <div class="row">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
          <a type="button" href="{{route("pos.payment.index")}}" class="btn btn-outline-info text-dark {{ request()->route()->getName() === 'pos.payment.index' ? 'active':''}}"><i class="ri-user-2-fill" style="margin-right : 10px;"></i><strong>Payment</strong></a>
        </div>
      </div>
    </div>
</header>