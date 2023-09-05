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
                        <a href="{{route('notify.index')}}" class="m-2 px-5 nav-link" title="Email Get News">News</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notify.customMail')}}" class="m-2 px-5 nav-link active" @disabled(true) title="Custom Mail">Custom Mail</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh; overflow:scroll;">
                            <div class="card-body">
                                {{-- action get url in js --}}
                                <form id="form-action" method="POST" action="">
                                    @csrf
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