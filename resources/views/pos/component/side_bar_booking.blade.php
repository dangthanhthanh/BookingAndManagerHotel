<aside id="sidebar contentToToggle" class="sidebar" style="width: 500px; padding-bottom: 100px;">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item" id="search-bar">
      <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="get">
          <div class="col-md-11">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingName" placeholder="Search" value="{{request()->input('name') ?? ''}}" title="Enter search keyword" name="name" required>
              <label for="floatingName">Search</label>
            </div>
          </div>
          <button class="form-control btn btn-primary" type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
        <form class="search-form d-flex align-items-center mt-5" method="get">
          <div class="col-md-11">
            <div class="form-floating">
              <input type="datetime-local" class="form-control" id="check_in" placeholder="Search" 
                     value="{{ $checkDate['check_in'] }}" 
                     title="Enter search Date" name="check_in">
              <label for="check_in">Check In</label>
            </div>
            @if ($table === 'Room')
            <div class="form-floating">
              <input type="datetime-local" class="form-control" id="check_out" placeholder="Search" 
                     value="{{ $checkDate['check_out'] }}" 
                     title="Enter search Date" name="check_out">
              <label for="check_out">Check Out</label>
            </div>
            @endif
          </div>
          <button class="form-control btn btn-primary" type="submit" title="Search">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>
    </li>
    <h5 class="card-title">Booking {{$table}} Table</h5>
    <div class="card-body drag-wrapper"  style="overflow: scroll; cursor: pointer;">
      <!-- Default Table -->
      <table class="table table-striped table-hover drag-element" id="order-table-list">
        {{--include code jscript in index product pos --}}
      </table>
      <!-- End Default Table Example -->
    </div>
    <div class="row">
      <div class="btn-group" role="group" id="list_button_order_payment" aria-label="Basic mixed styles example">
        <a type="button" class="btn btn-outline-primary py-3" id="order_save">Save All</a>
        {{-- <a type="button" href="{{route("pos.payment.index")}}" class="btn btn-outline-primary py-3" id="order_payment">Payment</a> --}}
        <a type="button" class="btn btn-outline-primary py-3" id="order_delete">Delete All</a>
      </div>
    </div>
  </ul>
</aside>
