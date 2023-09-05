@php
    $methods = $paymentMethod->toArray();
    $statuses = $paymentStatus->toArray();
@endphp
@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item"><a href="{{route('payment.index')}}">Payment</a></li>
        <li class="breadcrumb-item active">History Payment</li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <ul class="row">
                    <div class="search-bar">
                        @include("admin.component.search_data")
                    </div>
                </ul>
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Data</button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="min-width: 150px;">Payment Id @include("admin.component.sort_by",['sortBy'=>'slug'])</th>
                                            <th scope="col" style="min-width: 150px;">Order Id @include("admin.component.sort_by",['sortBy'=>'order_id'])</th>
                                            <th scope="col" style="min-width: 150px;">Method @include("admin.component.sort_by",['sortBy'=>'payment_method_id'])</th>
                                            <th scope="col" style="min-width: 150px;">Status @include("admin.component.sort_by",['sortBy'=>'payment_status_id'])</th>
                                            <th scope="col" style="min-width: 150px;">Created At @include("admin.component.sort_by",['sortBy'=>'created_at'])</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ( $datas as $key => $item)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $item->slug }}</td>
                                            <td>{{ $item->order_slug }}</td>
                                            <td>{{ $item->method->name }}</td>
                                            <td>{{ $item->status->name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a href="{{route('order.detail',$item->order->slug)}}" class="btn btn-outline-primary">view Order</a>
                                            </td>
                                        </tr>
                                        @empty
                                            <p style="text-align: center;">No Data Found!</p>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                            @include("admin.component.pagination")
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection