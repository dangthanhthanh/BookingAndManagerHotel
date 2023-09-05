@extends("admin.layout.admin")
@section("content")
<div class="pagetitle">
    <h1>Manager</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Manager</a></li>
        <li class="breadcrumb-item active"><a href="{{route('gallery.index')}}">Gallery</a></li>
      </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <style>
                    .form-gallery{
                        position: fixed;
                        z-index: 999;
                        right: 20px;
                        bottom: 50%;
                        display: flex;
                        flex-direction: column;
                    }
                    .form-gallery button,
                    .form-gallery label{
                        margin-top: 20px;
                        width: 40px;
                        cursor: pointer;
                        height:40px;
                    }
                    #selectedImages{
                        display: flex;
                    }
                    #selectedImages .image-upload{
                        display: inline-block;
                        width: 100px;
                        margin: 5px;
                    }
                    #selectedImages .selected-img{
                        border-radius: 5px;
                        width: 100px;
                    }
                </style>
                <div class="form-gallery">
                    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="images[]" id="multiple-image" hidden multiple required>
                        <div class="d-flex flex-column">
                            <label class="p-20 btn btn-outline-primary" for="multiple-image" required><i class="bi bi-view-list"></i></label>
                            <button class="p-20 btn btn-outline-primary" type="submit" title="Add">+</button>
                        </div>
                    </form>
                    <form action="{{ route('gallery.delete') }}" method="POST" id="deleteForm">
                        @csrf
                        <input type="text" name="gallery_id" hidden required>
                        <button class="p-20 btn btn-outline-danger" title="Delete" type="button" id="deleteButton">-</button>
                    </form>
                </div>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card">
                            <ul class="d-flex flex-wrap justify-content-center" id='selectedImages'>
                                {{-- img gi gi do --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active">Data</button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card" style="min-height: 55vh;">
                            <ul class="d-flex flex-wrap justify-content-center">
                                <style>
                                    .custom-checkbox {
                                    display: inline-block;
                                    position: relative;
                                    cursor: pointer;
                                    width: 400px;
                                    width: fit-content; /* Adjust to fit the content */
                                    }

                                    .checkbox-img {
                                    border-radius: 10px;
                                    width: 400px;
                                    }

                                    .hidden-checkbox {
                                    position: absolute;
                                    opacity: 0;
                                    pointer-events: none;
                                    }

                                    .checkbox-icon {
                                    position: absolute;
                                    top: 10px;
                                    left: 10px;
                                    width: 40px; /* Adjust as needed */
                                    height: 40px; /* Adjust as needed */
                                    font-size: 40px;
                                    font-weight: 900;
                                    border: 2px solid #aaa;
                                    border-radius: 5px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    z-index: -10;
                                    }

                                    .hidden-checkbox:checked + .checkbox-icon {
                                    background-color: #00aaff;
                                    border-color: #00aaff;
                                    color: white;
                                    z-index: 10;
                                    opacity: 1;
                                    }
                                </style>
                                @forelse ( $datas as $key => $item)
                                    <label class="custom-checkbox m-2" for="gallery{{$key+1}}">
                                      <img src="{{$item->image->url}}" alt="gallery{{$key+1}}" class="checkbox-img">
                                      <input type="checkbox" class="hidden-checkbox gallery-checkbox" name="gallery" value="{{$item->id}}" id="gallery{{$key+1}}">
                                      <span class="checkbox-icon">✓</span>
                                    </label>
                                @empty
                                    <div class="row text-center">Not Found In Database</div>
                                @endforelse
                            </ul>
                            @include("admin.component.pagination")
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection
@section("javacript")
    <script>
        $(document).ready(function(){
            $("#deleteButton").on('click', function() {
                if(checkformCheckBox().length !== 0){
                    $('input[name="gallery_id"]').val(JSON.stringify(checkformCheckBox()));
                    $('#deleteForm').submit();
                }else{
                    alert('error this not find image');
                };
            })
            function checkformCheckBox(){
                const checkboxes = $('.gallery-checkbox');
                const checkedCheckboxes = checkboxes.filter(':checked');
                const selectedValues = checkedCheckboxes.map(function() {
                    return $(this).val();
                }).get();
                return selectedValues;
            };
            $('input[type="file"]').on('change', function() {
                const selectedImagesDiv = $('#selectedImages');
                selectedImagesDiv.empty(); // Xóa các hình ảnh cũ
                const files = $(this)[0].files;
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result).addClass('selected-img');
                        selectedImagesDiv.append(`
                            <div class="image-upload">
                                ${img.prop('outerHTML')}
                            </div>`
                        );
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection