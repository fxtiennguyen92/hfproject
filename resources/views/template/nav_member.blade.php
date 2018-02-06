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
					<a class="dropdown-item" href="{{ route('signup_pro') }}"><i class="dropdown-icon material-icons">face</i> Đăng ký Đối Tác</a>
					<a class="dropdown-item" href="{{ route('pro_list_page') }}"><i class="dropdown-icon material-icons">list</i> Danh sách Đối Tác</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('company_page') }}"><i class="dropdown-icon material-icons">work</i> Đăng ký Doanh Nghiệp</a>
					<a class="dropdown-item" href="{{ route('company_list_page') }}"><i class="dropdown-icon material-icons">list</i> Danh sách Doanh Nghiệp</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('logout') }}"><i class="dropdown-icon material-icons">power_settings_new</i> Đăng Xuất</a>
				</ul>
			</div>
		</div>
	</div>
</nav>
