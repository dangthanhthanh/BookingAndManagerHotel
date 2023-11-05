@php
const DEFAULTTIME = 'week'; 
//start filterBlade
function filterBlade($type = null){
  $statistics = [
    'today' => 'Today',
    'week' => 'This Week',
    'month' => 'This Month',
    'year' => 'This Year',
  ];
  $filter = '<div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
    <li class="dropdown-header text-start">
    <h6>Filter</h6>
    </li>';
  foreach ($statistics as $key => $value) {
    $route = route('manager.dashboard', [$type ?? 'statistics' => $key]);
    $filter .= "<li><a class='dropdown-item' href='$route'>$value</a></li>";
  };
  $filter .= '</ul></div>';
  return $filter;
};
//end filter blade
//card
function cardLeftside(string $type, string $icon, $filterBlade, $nameCard, $value){
  $cardLeftSideBlade = '<div class="col-xxl-4 '.$type.'"><div class="card info-card '.$nameCard.'-card">';
  $cardLeftSideBlade .= $filterBlade;
  $cardLeftSideBlade .= '<div class="card-body"><h5 class="card-title">'.ucfirst($nameCard).'<span>|'.ucfirst(request()->statistics ?? DEFAULTTIME);
  $cardLeftSideBlade .= '</span></h5><div class="d-flex align-items-center"><div class="card-icon rounded-circle d-flex align-items-center justify-content-center">'.$icon.'</div><div class="ps-3"><h6>';
  $cardLeftSideBlade .= number_format($value);
  $cardLeftSideBlade .= '</h6></div></div></div></div></div>';
  return $cardLeftSideBlade;
};
//row recent order Sales
function rowOrderSales($item){
  $bg = match($item->status){
    'unpaid' => "danger",
    'paid' => "success",
  };
  $orderRoute = route('order.detail',['slug' => $item->id]);
  $cusRoute = route('customer.show',['slug' => $item->id]);
  $row = '<tr>
    <th scope="row"><a href="'.$orderRoute.'">'.substr($item->id, -10).'</a></th>
    <td><a href="'.$cusRoute.'">'.substr($item->customer_id,-10).'</a></td>
    <td>'.number_format($item->balance).'</td>
    <td><span class="badge bg-'.$bg.'">'.$item->status.'</span></td>
  </tr>';
  return $row;
};
@endphp
{{-- start page --}}
@extends("admin.layout.admin")
@section("content")
  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">
          {!!cardLeftside('col-md-6','<i class="bi bi-cart"></i>', filterBlade() , 'sales', $card['sale'] )!!}
          {!!cardLeftside('col-md-6','<i class="bi bi-currency-dollar"></i>', filterBlade() , 'revenue', $card['revenue'] )!!}
          {!!cardLeftside('col-xl-12','<i class="bi bi-people"></i>', filterBlade() , 'customers', $card['customer'] )!!}
          {!!cardLeftside('col-md-6','<i class="bi bi-people"></i>', filterBlade() , 'jobs', $card['job'] )!!}
          {!!cardLeftside('col-md-6','<i class="bi bi-people"></i>', filterBlade() , 'complete', $card['complete'] )!!}
          {!!cardLeftside('col-xl-12','<i class="bi bi-people"></i>', filterBlade() , 'staffs', $card['staff'] )!!}
          {{-- start chart bar --}}
          {{-- <div class="col-12">
            <div class="card">
              {!!filterBlade()!!}
              <div class="card-body">
                <h5 class="card-title">Reports <span>| {{ucfirst(request()->statistics ?? DEFAULTTIME)}}</span></h5>
              </div>

            </div>
          </div> --}}
          {{-- end chart bar --}}
          {{-- start chart for revenue --}}
          <div class="col-12">
            <div class="card">
              {!!filterBlade()!!}
              <div class="card-body">
                <h5 class="card-title">Revenue <span>| {{ucfirst(request()->statistics ?? DEFAULTTIME)}}</span></h5>
                <!-- Line Chart -->
                <div id="reportsChart"></div>
                {{-- js generate --}}
                <!-- End Line Chart -->
              </div>

            </div>
          </div>
          {{-- end chart for revenue --}}

          {{-- start chart for customer/staff --}}
          <div class="col-12">
            <div class="card">
              {!!filterBlade()!!}
              <div class="card-body">
                <h5 class="card-title">Register <span>| {{ucfirst(request()->statistics ?? DEFAULTTIME)}}</span></h5>
                <!-- Line Chart -->
                <div id="registerChart"></div>
                {{-- js generate --}}
                <!-- End Line Chart -->
              </div>

            </div>
          </div>
          {{-- end chart for customer/staff --}}

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              {!!filterBlade()!!}
              <div class="card-body">
                <h5 class="card-title">Recent Sales <span>{{ucfirst(request()->statistics ?? DEFAULTTIME)}}</span></h5>
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Customer</th>
                      <th scope="col">Total Balance</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($order as $item)
                      {!!rowOrderSales($item)!!}
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- End Recent Sales -->
        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">
        <!-- Recent Activity -->
        {{-- <div class="card">
          {!!filterBlade()!!}

          <div class="card-body">
            <h5 class="card-title">Recent Activity <span>{{ucfirst(request()->statistics ?? DEFAULTTIME)}}</span></h5>
            <div class="activity">
              <div class="activity-item d-flex">
                <div class="activite-label">32 min</div>
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                <div class="activity-content">
                  Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                </div>
              </div><!-- End activity item-->
            </div>
          </div>
        </div> --}}
        <!-- End Recent Activity -->
        <!-- News & Updates Traffic -->
        <div class="card">
          {{-- {!!filterBlade()!!} --}}
          <div class="card-body pb-0">
            <h5 class="card-title">News &amp; Updates <span>Today</span></h5>
            <div class="news">
              @forelse ($card['update'] as $item)
                <div class="post-item clearfix">
                  <img src="{{$item->thumnail}}" alt="clearfix_url">
                  <h4><a href="{{route('blog.description',['slug' => $item->slug])}}">{{$item->name}}</a></h4>
                  <p>{{Str::limit($item->short_description,50)}}</p>
                </div>
              @empty
                <div class="post-item clearfix">
                  <p>not found in database</p>
                </div>
              @endforelse
            </div><!-- End sidebar recent posts-->
          </div>
        </div><!-- End News & Updates -->
      </div><!-- End Right side columns -->
    </div>
  </section>
@endsection
@section("javacript")
  @include("admin.page.dashboard.chartjs", ['data' => $order , 'timeLine' => (request()->statistics ?? DEFAULTTIME)])
  {{-- @include("admin.page.dashboard.chartjs", ['data'=>json_encode($order) , 'timeLine' => (request()->statistics ?? DEFAULTTIME)]) --}}
  {{-- ***\resources\views\admin\page\dashboard\chartjs.balde.php --}}
@endsection