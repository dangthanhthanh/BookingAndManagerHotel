@php
  $notify=4;
  $time=5;
  $name_admin="admin thanh";
  $img_admin="http://127.0.0.1:8000/client/images/product-item-1.jpg";
  $level="1";
@endphp
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="{{asset('admin/img/logo.png')}}" alt="">
        <span class="d-none d-lg-block">Hotel Manager</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        @auth
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="/" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">{{$notify}}</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have {{$notify}} new notifications
                <p>in the {{$time}} hours since the most recent access time</p>
                <a href="{{route('admin.dashboard')}}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-circle text-success"></i>
              <div>
                <h4>From User</h4>
                <p>You have {{$notify}} new messenger</p>
                <p>in the {{$time}} hours since the most recent access time</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-circle text-success"></i>
              <div>
                <h4>From Orther Administration</h4>
                <p>You have {{$notify}} new messenger</p>
                <p>in the {{$time}} hours since the most recent access time</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-circle text-success"></i>
              <div>
                <h4>From System</h4>
                <p>You have {{$notify}} new notification</p>
                <p>in the {{$time}} hours since the most recent access time</p>
                {{-- //he thong thong bao co bao nhieu don hang, 
                  luoc truy cap, 
                  so luong account duoc tao moi, 
                  so luong account bi huy dang cho su ly,
                  so luong don hang duoc tao,
                  so luong don hang bi huy tren he thong,
                  so luong don hang bi huy khi giao hang,
                   --}}
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="{{route('admin.dashboard')}}">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown px-5">
          <a id="dropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if ( isset(Auth::user()->avatar->url) )
            <img width="50px" src="{{Auth::user()->avatar->url}}" class="rounded-circle" alt="avatar">
            @else
            <img width="50px" id="image-show" src="" alt="avatar" class="rounded-circle" style="display: none">
            <i class="fas fa-user-circle"></i>
            @endif
            {{ Auth::user()->user_name }}
         </a>
          <div class="dropdown-menu" id="dropdownmenu" style="background: rgba(255, 255, 255)">
              <a class="dropdown-item nav-link {{ request()->route()->getName() === 'my.account' ? 'bg-light':''}}" href="{{ route('staff.show',Auth::user()->id) }}">
                    {{ __('My Account') }}
              </a>
              <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
              </form>
          </div>
        </li>
      @endauth
      </ul>
    </nav><!-- End Icons Navigation -->

  </header>