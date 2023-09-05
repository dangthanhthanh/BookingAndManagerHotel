<header class="header">
   <div class="header_content d-flex flex-row align-items-center justify-content-start">
      <div class="logo"><a href="{{route("home")}}">The River</a></div>
      <div class="ml-auto d-flex flex-row align-items-center justify-content-start">
         <nav class="main_nav">
            <ul class="d-flex flex-row align-items-start justify-content-start">
               <li class="{{ request()->route()->getName() === 'home'? 'active': '' }}">
                  <a class="nav-link" href="{{route("home")}}">Home</a>
               </li>
               <li class="{{ (request()->route()->getName() === 'room' || request()->route()->getName() === 'service' || request()->route()->getName() === 'food')? 'active': '' }}">
                  <a id="dropdownMenu" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Service
                  </a>
                  <div class="dropdown-menu" id="dropdownmenu" style="background: rgba(0,0,0,0.7)">
                     <a class="dropdown-item nav-link {{ request()->route()->getName() === 'booking' ? 'bg-light':''}}" href="booking route">
                        {{ __('Room') }}
                     </a>
                     <a class="dropdown-item nav-link {{ request()->route()->getName() === 'food' ? 'bg-light':''}}" href="{{ route('client.food.index') }}">
                        {{ __('Food') }}
                     </a>
                     <a class="dropdown-item nav-link {{ request()->route()->getName() === 'service' ? 'bg-light':''}}" href="{{ route('client.service.index') }}">
                        {{ __('Other Service') }}
                     </a>
                  </div>
               </li>
               <li class="{{ request()->route()->getName() === 'blog'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.blog.index")}}">Blog</a>
               </li>
               <li class="{{ request()->route()->getName() === 'about'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.about.index")}}">About Us</a>
               </li>
               <li class="{{ request()->route()->getName() === 'contact'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.contact.index")}}">Contact</a>
               </li>
               @guest
                  @if (Route::has('login'))
                     <li class="{{ request()->route()->getName() === 'login'? 'active': '' }}">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                     </li>
                  @endif
                  @if (Route::has('register'))
                     <li class="{{ request()->route()->getName() === 'register'? 'active': '' }}">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                     </li>
                  @endif
               @else
                  <li class="{{ (request()->route()->getName() === 'my.account' || request()->route()->getName() === 'account.booking' )? 'active': '' }}">
                     <a id="dropdownMenu" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->user_name }}
                     </a>
                     <div class="dropdown-menu" id="dropdownmenu" style="background: rgba(0,0,0,0.7)">
                        <a class="dropdown-item nav-link {{ request()->route()->getName() === 'my.account' ? 'bg-light':''}}" href="{{ route('my.account') }}">
                              {{ __('My Account') }}
                        </a>
                        <a class="dropdown-item nav-link {{ request()->route()->getName() === 'account.booking' ? 'bg-light':''}}" href="{{ route('account.booking') }}">
                           {{ __('My Booking') }}
                        </a>
                        <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           Swal.showLoading();
                                          document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                        </form>
                     </div>
                  </li>
               @endguest
            </ul>
         </nav>
         <div class="book_button"><a href="booking" onclick="Swal.showLoading()">Book For Group</a></div>
         <div class="book_button"><a href="booking a room" onclick="Swal.showLoading()">Book a Room</a></div>
         <!-- Hamburger Menu -->
         <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
      </div>
   </div>
</header>