<script>
    //show loading page
    Swal.showLoading()
</script>
<script src="{{asset('client/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('client/styles/bootstrap-4.1.2/popper.js')}}"></script>
<script src="{{asset('client/styles/bootstrap-4.1.2/bootstrap.min.js')}}"></script>
<script src="{{asset('client/plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('client/plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('client/plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('client/plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('client/plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('client/plugins/OwlCarousel2-2.3.4/owl.carousel.js')}}"></script>
<script src="{{asset('client/plugins/easing/easing.js')}}"></script>
<script src="{{asset('client/plugins/progressbar/progressbar.min.js')}}"></script>
<script src="{{asset('client/plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('client/plugins/jquery-datepicker/jquery-ui.js')}}"></script>
<script src="{{asset('client/plugins/colorbox/jquery.colorbox-min.js')}}"></script>
@php
    // get messenger section
    $messenger=Session::get("messenger");
@endphp
<script>
    $(document).ready(function() {
    // Toggle dropdown menu
    $("#dropdown").click(function(e) {
      e.preventDefault();
      $("#dropdownmenu").toggle();
    });
    // notification
    function showSweetAlert(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
    });
    }
      // Check messenger
      var messenger = "{{ $messenger ?? '' }}";
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
        case '11':
            showSweetAlert('Thong bao!', 'thao tac thanh cong, vui long kiem tra xa xac thuc mail de trai nghiem nhund dich vu hap dan', 'success');
          break;
        case '21':
            showSweetAlert('Thong bao!', 'vui long kiem tra xa xac thuc mail de nhan nhung thong tin tu chung toi', 'success');
          break;
        case '31':
            showSweetAlert('Thong bao!', 'vui long dang nhap de tiep tuc thao tac', null);
          break;
        case '32':
            showSweetAlert('Thong bao!', 'tai khoan hien tai khong co quyen truy cap tai nguyen', null);
          break;
        case '40':
            showSweetAlert('Thong bao!', 'loai phong ban dat da het ban co then tham khao loai phong khac', null);
          break
        case '41':
            showSweetAlert('Thong bao!', 'ban vua dat thanh cong 1 phong', null);
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
  
