<nav id="top-menu" class="top-menu">
	<div class="menu-icon-container hidden-md-up">
	</div>
	<div class="menu">
		<div class="menu-info-block">
			<div class="left">
				<div class="">
					<a href="javascript:void(0)"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
				</div>
			</div>
			<div class="icon-menu-wrapper">
				<ul class="icon-menu">
					<li class="icon-menu-user dropdown">
<!-- 						<a href="{/{ route('control') }}"> -->
						<a href="javascript: void(0);" class="" data-toggle="dropdown" aria-expanded="false">
							<i class="material-icons">person</i>
						</a>
						<ul class="margin-right-5 dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
							<a class="dropdown-item" href="javascript:void(0)"><i class="material-icons">person</i> {{ auth()->user()->email }}</a>
							<div class="dropdown-divider"></div>
							
							@if (auth()->user()->role == 91)
							
							@elseif (auth()->user()->role == 99)
							<a class="dropdown-item" href="{{ route('mng_pa_list') }}"><i class="material-icons">people</i> Cộng tác viên</a>
							<a class="dropdown-item" href="{{ route('mng_common_list') }}"><i class="material-icons">language</i> Tùy chỉnh hệ thống</a>
							<a class="dropdown-item" href="{{ route('mng_service_list') }}"><i class="material-icons">settings</i> Dịch vụ</a>
							<a class="dropdown-item" href="{{ route('mng_doc_list') }}"><i class="material-icons">subject</i> Tài liệu</a>
							<a class="dropdown-item" href="{{ route('mng_blog_list') }}"><i class="material-icons">web</i> Blog</a>
							<div class="dropdown-divider"></div>
							@endif
							<a class="dropdown-item" href="{{ route('password_edit') }}"><i class="material-icons">verified_user</i> Mật khẩu</a>
							<a class="dropdown-item" href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i> Đăng xuất</a>
						</ul>
					</li>
					
					@if (auth()->user()->role == 91)
					<li class="icon-menu-user">
						<a href="{{ route('pa_pro_list') }}">
							<i class="material-icons ">assignment_ind</i>
						</a>
					</li>
					<li class="icon-menu-user">
						<a href="{{ route('pa_company_list') }}">
							<i class="material-icons ">store</i>
						</a>
					</li>
					@endif
					
					@if (auth()->user()->role == 99)
					<li class="icon-menu-user">
						<a href="{{ route('mng_order_list') }}">
							<i class="material-icons ">receipt</i>
						</a>
					</li>
					<li class="icon-menu-user">
						<a href="{{ route('mng_pro_list') }}">
							<i class="material-icons ">assignment_ind</i>
						</a>
					</li>
					<li class="icon-menu-user">
						<a href="{{ route('pa_company_list') }}">
							<i class="material-icons ">store</i>
						</a>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</nav>
