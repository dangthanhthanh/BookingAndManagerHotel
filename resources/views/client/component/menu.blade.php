<div class="menu trans_400 d-flex flex-column align-items-end justify-content-start">
   <div class="menu_close"><i class="fa fa-times" aria-hidden="true"></i></div>
   <div class="menu_content">
      <nav class="menu_nav text-right">
         <ul>
            <li class="{{ request()->route()->getName() === 'home'? 'active': '' }}">
               <a class="nav-link" href="{{route("home")}}">Home</a>
            </li>
            <li class="{{ request()->route()->getName() === 'booking'? 'active': '' }}">
               <a class="nav-link" href="">Room</a>
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
              <li class="{{ request()->route()->getName() === 'my.account'? 'active': '' }}">
                 <a class="nav-link" href="{{route("my.account")}}">
                    Account
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
   <div class="menu_extra">
      <div class="book_button"><a href="" onclick="Swal.showLoading()">Book For Group</a></div>
      <div class="book_button"><a href="" onclick="Swal.showLoading()">Book A Room</a></div>
   </div>
</div>