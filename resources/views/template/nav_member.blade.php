<!-- Navbar Member -->
<nav class="top-menu">
	<div class="menu-icon-container hidden-md-up">
		<div class="animate-menu-button left-menu-toggle">
			<div><!-- --></div>
		</div>
	</div>
	<div class="menu">
		<div class="menu-info-block">
			<div class="left">
				<div class="header-buttons">
					<a href="https://handfree.co"><img src="img/logoh.png" class="navbar-logo"></a>
					<a href="/blog" class="btn btn-icon btn-rounded hidden-md-down"><i class="fa fa-facebook"></i></a>
					<a href="/blog" class="btn btn-link hidden-md-down">Blog</a>
				</div>
			</div>
			<div class="right example-buy-btn hidden-xs-down">
				<a href="https://handfree.co/pro/" target="_blank" class="btn btn-info margin-left-20">Trở Thành Đối Tác</a>
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
		<div class="menu-user-block menu-notifications">
			<div class="dropdown dropdown-avatar">
				<a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<i class="menu-notification-icon icmn-bubbles7"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
					<div class="notification-block">
						<div class="item">
							<i class="notification-icon icmn-star-full"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">now</span>
									<a href="javascript: void(0);">Update Status: <span class="label label-danger font-weight-700">New</span></a>
								</div>
								<div class="descr">
									Failed to get available update data. To ensure the proper functioning of your application, update now.
								</div>
							</div>
						</div>
						<div class="item">
							<i class="notification-icon icmn-stack3"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">24 min ago</span>
									<a href="javascript: void(0);">Income: <span class="label label-default font-weight-700">$299.00</span></a>
								</div>
								<div class="descr">
									Failed to get available update data. To ensure the proper functioning of your application, update now.
								</div>
							</div>
						</div>
						<div class="item">
							<i class="notification-icon icmn-bubbles5"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">30 min ago</span>
									<a href="javascript: void(0);">Inbox Message</a>
								</div>
								<div class="descr">
									From: <a href="javascript: void(0);">David Bowie</a>
								</div>
							</div>
						</div>
						<div class="item">
							<i class="notification-icon icmn-pie-chart2"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">now</span>
									<a href="javascript: void(0);">Update Status: <span class="label label-primary font-weight-700">New</span></a>
								</div>
								<div class="descr">
									Failed to get available update data. To ensure the proper functioning of your application, update now.
								</div>
							</div>
						</div>
						<div class="item">
							<i class="notification-icon icmn-books"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">24 min ago</span>
									<a href="javascript: void(0);">Income: <span class="label label-warning font-weight-700">$299.00</span></a>
								</div>
								<div class="descr">
									Failed to get available update data. To ensure the proper functioning of your application, update now.
								</div>
							</div>
						</div>
						<div class="item">
							<i class="notification-icon icmn-cog util-spin-delayed-pseudo"></i>
							<div class="inner">
								<div class="title">
									<span class="pull-right">30 min ago</span>
									<a href="javascript: void(0);">Inbox Message</a>
								</div>
								<div class="descr">
									From: <a href="javascript: void(0);">David Bowie</a>
								</div>
							</div>
						</div>
					</div>
				</ul>
			</div>
		</div>
	</div>
</nav>