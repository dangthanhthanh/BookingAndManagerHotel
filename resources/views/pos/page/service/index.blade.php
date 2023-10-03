@php
    $buttonNavContent = "<i class='bi bi-list toggle-sidebar-btn'></i>";
    $checkInDate = $checkDate['check_in']->format('d/m/y H:i');
@endphp
@extends("pos.layout.pos")
@section("sidebar")
    @include("pos.component.side_bar_booking",['table'=>'Service'])
@endsection()
@section('button_nav')
    {!!$buttonNavContent!!}
@endsection
@section("content")
<section class="section">
    <div class="row" style="margin-bottom: 20px;">
        <h3><strong>Category</strong></h3>
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
            <a type="button" href="{{route('pos.service.index')}}" class="btn btn-outline-primary p-2">All</a>
            @foreach ($category as $item)
                <a type="button" href="{{route('pos.service.index',['category'=>$item->slug])}}" class="btn btn-outline-primary p-2">{{$item->name}}</a>
            @endforeach
        </div>
    </div>
    <div class="row">
        <h3><strong>Service</strong></h3>
        @forelse ($datas as $key => $item)
            <div class="col-lg-3 col-xl-3 col-md-4 col-sm-12" id="product_{{$item->id}}">
                <div class="card">
                    <style>
                        .div-img{
                            background-size: cover;
                            background-repeat: no-repeat;
                            width: 100%;
                            height: 500px;
                        }
                    </style>
                    <div class="card-img-top div-img" style="background-image: url('{{$item->image_url}}')"></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $item->name}}</h5>
                            <h6 class="card-title">{{number_format($item->cost)}}_vnd</h6>
                        </div>
                        <div class="row">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal_{{$item->id}}">
                                    Description
                                </button>
                                <button type="button" class="btn btn-outline-primary p-2 add" data-id="{{$item->id}}" data-name="{{$item->name}}" data-cost="{{$item->cost}}" data-checkin="{{$checkInDate}}"><i class="ri-add-circle-line" style="font-size: 20px"></i><strong>Add</strong></button>
                            </div>
                            {{-- modal --}}
                            <div class="modal fade" id="basicModal_{{$item->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">{{$item->name}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        {!!$item->description!!}
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end modal --}}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row"><strong><h4 class="text-info">Not Found Product In Database</h4></strong></div>
        @endforelse
    </div>
</section>
@endsection
@section("javacript")
    @include("pos.component.css_js.pos_js.service")
@endsection