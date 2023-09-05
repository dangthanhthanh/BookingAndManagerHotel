@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-dark" href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a class="text-dark" href="{{route('notify.index')}}">News Email</a></li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <a href="{{route('notify.index',['data' => 1])}}" class="btn btn-outline-primary m-2 px-5 nav-link {{ isset(request()->all()['data']) && request()->all()['data'] === '1' ? 'active' : '' }}" title="Customer Email">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notify.index',['data' => 2])}}" class="btn btn-outline-primary m-2 px-5 nav-link {{ isset(request()->all()['data']) && request()->all()['data'] === '2' ? 'active' : '' }}" title="Staff Email">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notify.index',['data' => 3])}}" class="btn btn-outline-primary m-2 px-5 nav-link {{ isset(request()->all()['data']) && request()->all()['data'] === '3' ? 'active' : '' }}" title="Email Get News">News</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notify.customMail')}}" class="btn btn-primary m-2 px-5 nav-link {{ request()->route()->getName() === 'notify.customMail' ? 'active' : '' }}" title="Custom Mail">Custom Mail</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                <form id="form-action" method="POST" action="">
                                    @csrf
                                    <div class="row mt-5">
                                        <label for="subject"><strong>Subject</strong></label>
                                        <input name="subject" type="text" class="form-control m-auto" style="width: 50%; min-width:500px;" id="subject" value="{{old("subject")}}">
                                        @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mt-5">
                                        <label for="form_mail"><strong>Chose Form</strong></label>
                                        <div class="d-flex">
                                            @foreach ($page=[1,2,3,4,5] as $item)
                                                <label for="form_mail_{{$item}}" class="d-flex flex-column justify-content-center">
                                                    <figure class="d-flex justify-content-center align-items-center m-0" style="width:300px; height:400px; overflow:scroll;">
                                                        <div style="scale: 0.3;width:300px;height:400px;" class="d-flex justify-content-center align-items-center">
                                                            @include("email.pages.mail_".$item)
                                                        </div>
                                                    </figure>
                                                    <input type="radio" name="form_mail" value="{{$item}}" id="form_mail_{{$item}}" required checked>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('form_mail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mt-5">
                                        <label for="content"><strong>Content</strong></label>
                                        <div id="toolbar-container" style="width: 100%;"></div>
                                        <div id="editor" style="background-color: #fff;border:1px solid gray; min-height:600px;">{!!old('content')??''!!}</div>
                                        <input type="hidden" id="description-input" name="content" value="{{old('content')??''}}">
                                        @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-5">
                                        <button type="btn" class="btn btn-outline-primary" id="send_btn_customer"><strong>Send To Customer Mail</strong></button>
                                        <button type="btn" class="btn btn-outline-primary" id="send_btn_staff"><strong>Send To Staff Mail</strong></button>
                                        <button type="btn" class="btn btn-outline-primary" id="send_btn_news"><strong>Send To News Mail</strong></button>
                                    </div>
                                </form>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection
@section("javacript")
  @include("admin.component.css_js.detail")
  <script>
    $("#send_btn_customer").on('click', function() {
        $('#form-action').attr('action', "{{ route('notify.sendMail', ['data' => 'customer']) }}");
        $('#form-action').submit();
    });
    $("#send_btn_staff").on('click', function() {
        $('#form-action').attr('action', "{{ route('notify.sendMail', ['data' => 'staff']) }}");
        $('#form-action').submit();
    });
    $("#send_btn_news").on('click', function() {
        $('#form-action').attr('action', "{{ route('notify.sendMail', ['data' => 'news']) }}");
        $('#form-action').submit();
    });
  </script>
@endsection