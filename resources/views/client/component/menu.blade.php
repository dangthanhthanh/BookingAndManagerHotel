<div class="menu trans_400 d-flex flex-column align-items-end justify-content-start">
   <div class="menu_close"><i class="fa fa-times" aria-hidden="true"></i></div>
   <div class="menu_content">
      <nav class="menu_nav text-right">
         <ul>
            <li class="{{ request()->route()->getName() === 'home'? 'active': '' }}">
               <a class="nav-link" href="{{route("home")}}">Home</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.room.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.service.index")}}">Room</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.service.index")}}">Service</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.food.index")}}">Food</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.blog.index")}}">Blog</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.about.index")}}">About Us</a>
            </li>
            <li class="{{ request()->route()->getName() === 'client.service.index'? 'active': '' }}">
               <a class="nav-link" href="{{route("client.contact.index")}}">Contact</a>
            </li>
           @auth
              <li class="{{ request()->route()->getName() === 'auth.account.index'? 'active': '' }}">
                 <a class="nav-link" href="{{route("auth.account.index")}}">
                    Account
                 </a>
              </li>
              <li class="{{ request()->route()->getName() === 'auth.account.cart'? 'active': '' }}">
               <a class="nav-link" href="{{route("auth.account.cart")}}">
                  Cart
               </a>
            </li>
              <li class="{{ request()->route()->getName() === 'logout'? 'active': '' }}">
                 <a class="nav-link" href="#" onclick="event.preventDefault(); Swal.showLoading(); document.getElementById('logout-form').submit();">Logout</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                 </form>
              </li>
           @endauth
           @guest
              <li class="{{ request()->route()->getName() === 'register'? 'active': '' }}">
                 <a class="nav-link" href="{{route("register")}}">Register</a>
              </li>
              <li class="{{ request()->route()->getName() === 'login'? 'active': '' }}">
                 <a class="nav-link" href="{{route("login")}}">Login</a>
              </li>
           @endguest
         </ul>
      </nav>
   </div>
</div>