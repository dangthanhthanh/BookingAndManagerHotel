<aside id="sidebar contentToToggle" class="sidebar" style="width: 500px; padding-bottom: 100px;">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item" id="search-bar">
      <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
          <div class="col-md-11">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingName" placeholder="Search" title="Enter search keyword" name="name">
              <label for="floatingName">Search</label>
            </div>
          </div>
          <button class="form-control btn btn-primary" type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
      </div>
    </li>
    <div class="card-body">
        <h5 class="card-title">Booking {{$table}} Table</h5>
        <!-- Default Table -->
        <table class="table table-striped table-hover" id="order-table-list">
          {{--include code jscript in index product pos --}}
        </table>
        <!-- End Default Table Example -->
      </div>
      <div class="row">
        <div class="btn-group" role="group" id="list_button_order_payment" aria-label="Basic mixed styles example">
          <a type="button" class="btn btn-outline-primary py-3" id="order_save">Save</a>
          <a type="button" href="{{route("pos.payment.index")}}" class="btn btn-outline-primary py-3" id="order_payment">Payment</a>
          <a type="button" class="btn btn-outline-primary py-3" id="order_delete">Delete</a>
        </div>
      </div>
    </ul>
</aside>
