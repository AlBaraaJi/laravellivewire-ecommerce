
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/dashboard') ? '' : 'collapsed' }}" href="{{route('admin.dashboard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->
      
  
      
        <li class="nav-item">
          <a href="{{route('admin.users')}}" class="nav-link {{ request()->is('admin/users') ? '' : 'collapsed' }}">
            <i class="ri-group-line"></i>
            <span>Users</span>
          </a>
        </li>
      
      <li class="nav-item">
        <a href="{{route('admin.products')}}" class="nav-link {{ request()->is('admin/products') ? '' : 'collapsed' }}">
          <i class="ri-group-line"></i>
          <span>Products</span>
        </a>
      </li>
      
  
    </ul>
  
  </aside><!-- End Sidebar-->