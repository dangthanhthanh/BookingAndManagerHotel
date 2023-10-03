<script>
    //show loading page
    Swal.showLoading()
</script>
<script src="{{asset('client/js/jquery-3.3.1.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Vendor JS Files -->
<script src="{{asset('admin/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/vendor/chart.js/chart.umd.js')}}"></script>
<script src="{{asset('admin/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{asset('admin/vendor/quill/quill.min.js')}}"></script>
<script src="{{asset('admin/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('admin/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('admin/vendor/php-email-form/validate.js')}}"></script>
<!-- Template Main JS File -->
<script src="{{asset('admin/js/main.js')}}"></script>


{{-- //get messenger sesstion --}}
@php
    $messenger=Session::get("messenger");
@endphp
<script>
    $(document).ready(function() {
    // Toggle dropdown menu
    function showSweetAlert(title, text, icon) {
      Swal.fire({
          title: title,
          text: text,
          icon: icon,
      });
      }
        // Check messenger
    var messenger = "{{ $messenger ?? '' }}";
    console.log(messenger);
    switch (messenger) {
        case '0':
            showSweetAlert('Thong bao!', 'thao tac that bai', 'error');
        break;
        case '1':
            showSweetAlert('Thong bao!', 'thao tac thanh cong', 'success');
        break;
        case '00':
            showSweetAlert('Thong bao!', 'thanh toan that bai', 'error');
        break;
        case '01':
            showSweetAlert('Thong bao!', 'thanh toan thanh cong', 'success');
        break;
        case '03':
            showSweetAlert('Thong bao!', 'phong khong kha dung', 'error');
        break;
        default:
        // Handle other cases or do nothing
            setTimeout(function () {
                swal.close()
            }, 500)
        break;
    }
    });
</script> 
{{--end_messenger --}}