@extends("client.layouts.client")
@section("content")
<div class="home">
    <div class="background_image" style='background-image:url("{{asset('client/images/about.jpg')}}")'></div>
    <div class="home_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content text-center">
                        <div class="home_title">
                            @yield("home_title")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="elements">
    <div class="container">
        <div class="row">
            <div class="col">
                @yield("form")
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('client/js/elements.js')}}"></script>
@endsection
    