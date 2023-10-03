<header class="header">
   <div class="header_content d-flex flex-row align-items-center justify-content-start">
      <div class="logo"><a href="{{route("home")}}">The River</a></div>
      <div class="ml-auto d-flex flex-row align-items-center justify-content-start">
         <nav class="main_nav">
            <ul class="d-flex flex-row align-items-start justify-content-start">
               <li class="{{ request()->route()->getName() === 'client.room.index'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.room.index")}}">Room</a>
               </li>
               <li class="{{ request()->route()->getName() === 'client.food.index'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.food.index")}}">Food</a>
               </li>
               <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.service.index")}}">Service</a>
               </li>
               <li class="{{ request()->route()->getName() === 'blog'? 'active': '' }}">
                  <a class="nav-link" href="{{route("client.blog.index")}}">Blog</a>
               </li>
               <li class="{{ (request()->route()->getName() === 'client.about.index' || request()->route()->getName() === 'client.contact.index')? 'active': '' }}">
                  <a id="dropdownMenu1" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     US
                  </a>
                  <div class="dropdown-menu" id="dropdownmenu1" style="background: rgba(0,0,0,0.7)">
                     <a class="dropdown-item nav-link {{ request()->route()->getName() === 'client.about.index' ? 'bg-light text-dark':''}}" href="{{ route('client.about.index') }}">
                        {{ __('About') }}
                     </a>
                     <a class="dropdown-item nav-link {{ request()->route()->getName() === 'client.contact.index' ? 'bg-light text-dark':''}}" href="{{ route('client.contact.index') }}">
                        {{ __('Contact') }}
                     </a>
                  </div>
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
                  <li class="{{ (request()->route()->getName() === 'auth.account.index' || request()->route()->getName() === 'auth.account.cart' )? 'active': '' }}">
                     <a id="dropdownMenu" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->user_name }}
                     </a>
                     <div class="dropdown-menu" id="dropdownmenu" style="background: rgba(0,0,0,0.7)">
                        <a class="dropdown-item nav-link {{ request()->route()->getName() === 'auth.account.index' ? 'bg-light text-dark':''}}" href="{{ route('auth.account.index') }}">
                              {{ __('Account') }}
                        </a>
                        <a class="dropdown-item nav-link {{ request()->route()->getName() === 'auth.account.cart' ? 'bg-light text-dark':''}}" href="{{ route('auth.account.cart') }}">
                           {{ __('My Cart') }}
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
         <div class="book_button"><a href="{{route('client.booking.room.index')}}" onclick="Swal.showLoading()">Book</a></div>
         <!-- Hamburger Menu -->
         <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
      </div>
   </div>
</header>