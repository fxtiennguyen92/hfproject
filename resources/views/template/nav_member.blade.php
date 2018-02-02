<!-- Navbar Member -->
<nav class="top-menu">
  <div class="menu-icon-container hidden-md-up">
    <div class="animate-menu-button left-menu-toggle">
      <div>
        <!-- -->
      </div>
    </div>
  </div>
  <div class="menu">
    <div class="menu-info-block">
      <div class="left">
        <div class="">
          <a href="https://handfree.co"><img src="img/hf-logo.png" class="navbar-logo"></a>
        </div>
      </div>
    </div>
    <div class="menu-user-block">
      <div class="dropdown dropdown-avatar">
        <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="avatar">
						<img src="../storage/app/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}" alt="User">
					</span>
				</a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
          <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fa fa-smile-o"></i> Tài Khoản Của Bạn</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/user/orders"><i class="dropdown-icon fa fa-shopping-bag"></i> Đơn Hàng</a>
          <a class="dropdown-item" href="/user/notification"><i class="dropdown-icon fa fa-bell-o"></i> Thông Báo</a>
          <a class="dropdown-item" href="/user/"><i class="dropdown-icon fa fa-map-marker"></i> Chọn Thành Phố</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"><i class="dropdown-icon fa fa-sign-out"></i> Đăng Xuất</a>
        </ul>
      </div>

    </div>
  </div>
</nav>
