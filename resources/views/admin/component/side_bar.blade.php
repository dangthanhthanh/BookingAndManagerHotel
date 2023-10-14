<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'manager.dashboard'? '': 'collapsed' }}" href="{{route("manager.dashboard")}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-heading">Manager</li>
    {{-- account --}}
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#account-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person"></i><span>Account</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="account-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="{{ request()->route()->getName() === 'customer.index' ? 'active' : '' }}" href="{{route("customer.index")}}">
            <i class="bi bi-circle"></i><span>Customer</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'staff.index' ? 'active' : '' }}" href="{{route("staff.index")}}">
            <i class="bi bi-circle"></i><span>Staff</span>
          </a>
        </li>
      </ul>
    </li>
    {{-- end account --}}
    {{-- payment --}}
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-currency-line"></i><span>Order Payment</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="payment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="{{ request()->route()->getName() === 'payment.index' ? 'active' : '' }}" href="{{route("payment.index")}}">
            <i class="bi bi-circle"></i><span>Payment</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'order.index' ? 'active' : '' }}" href="{{route("order.index")}}">
            <i class="bi bi-circle"></i><span>Order</span>
          </a>
        </li>
      </ul>
    </li>
    {{-- end payment --}}
    {{-- booking --}}
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#booking-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-calendar-todo-fill"></i><span>Booking</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="booking-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="{{ request()->route()->getName() === 'booking.room.index' ? 'active' : '' }}" href="{{route("booking.room.index")}}">
            <i class="bi bi-circle"></i><span>Room</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'booking.food.index' ? 'active' : '' }}" href="{{route("booking.food.index")}}">
            <i class="bi bi-circle"></i><span>Food</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'booking.service.index' ? 'active' : '' }}" href="{{route("booking.service.index")}}">
            <i class="bi bi-circle"></i><span>Service</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'booking.event.index' ? 'active' : '' }}" href="{{route("booking.event.index")}}">
            <i class="bi bi-circle"></i><span>Event</span>
          </a>
        </li>
      </ul>
    </li>
    {{-- end booking --}}
    {{-- category --}}
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-align-justify"></i><span>Category</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="category-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="{{ request()->route()->getName() === 'category.blog.index' ? 'active' : '' }}" href="{{route("category.blog.index")}}">
            <i class="bi bi-circle"></i><span>Blog</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.food.index' ? 'active' : '' }}" href="{{route("category.food.index")}}">
            <i class="bi bi-circle"></i><span>Food</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.room.index' ? 'active' : '' }}" href="{{route("category.room.index")}}">
            <i class="bi bi-circle"></i><span>Room</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.service.index' ? 'active' : '' }}" href="{{route("category.service.index")}}">
            <i class="bi bi-circle"></i><span>Service</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.role.index' ? 'active' : '' }}" href="{{route("category.role.index")}}">
            <i class="bi bi-circle"></i><span>Role</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.room.status.index' ? 'active' : '' }}" href="{{route("category.room.status.index")}}">
            <i class="bi bi-circle"></i><span>Room Status</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.payment.status.index' ? 'active' : '' }}" href="{{route("category.payment.status.index")}}">
            <i class="bi bi-circle"></i><span>Payment Status</span>
          </a>
        </li>
        <li>
          <a class="{{ request()->route()->getName() === 'category.payment.method.index' ? 'active' : '' }}" href="{{route("category.payment.method.index")}}">
            <i class="bi bi-circle"></i><span>Payment Method</span>
          </a>
        </li>
      </ul>
    </li>
    {{-- end category --}}
    <li class="nav-heading">Manager Product</li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'blog.index' ? '' : 'collapsed' }}" href="{{route("blog.index")}}">
        <i class="ri-article-fill"></i>
        <span>Blog</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'room.index' ? '' : 'collapsed' }}" href="{{route("room.index")}}">
        <i class="ri-home-7-line"></i>
        <span>Room</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'service.index' ? '' : 'collapsed' }}" href="{{route("service.index")}}">
        <i class="ri-home-7-line"></i>
        <span>Service</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'event.index' ? '' : 'collapsed' }}" href="{{route("event.index")}}">
        <i class="ri-home-7-line"></i>
        <span>Event</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'food.index' ? '' : 'collapsed' }}" href="{{route("food.index")}}">
        <i class="ri-home-7-line"></i>
        <span>Food</span>
      </a>
    </li>
    <li class="nav-heading">Other</li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'notify.index' ? '' : 'collapsed' }}" href="{{route('notify.index',['data' => '1'])}}">
        <i class="bi bi bi-envelope"></i>
        <span>Notify</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'gallery.index' ? '' : 'collapsed' }}" href="{{route("gallery.index")}}">
        <i class="ri-image-2-fill"></i>
        <span>Gallery</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'contact.index' ? '' : 'collapsed' }}" href="{{route("contact.index")}}">
        <i class="bi bi-telephone"></i>
        <span>Customer Contact</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'booking.request.index' ? '' : 'collapsed' }}" href="{{route("booking.request.index")}}">
        <i class="bi bi-telephone"></i>
        <span>Booking Request</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->route()->getName() === 'review.index' ? '' : 'collapsed' }}" href="{{route("review.index")}}">
        <i class="bi bi-star-half"></i>
        <span>Review</span>
      </a>
    </li>
  </ul>
</aside>