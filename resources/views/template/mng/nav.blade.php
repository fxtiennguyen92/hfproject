<nav id="top-menu" class="top-menu">
	<div class="menu-icon-container hidden-md-up">
	</div>
	<div class="menu">
		<div class="menu-info-block">
			<div class="left">
				<div class="">
					<a href="{{ route('home_page') }}"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
				</div>
			</div>
			<div class="icon-menu-wrapper">
				<ul class="icon-menu">
					<li class="icon-menu-user">
						<a href="{{ route('control') }}">
							<i class="material-icons">person</i>
						</a>
					</li>
					<li class="icon-menu-user">
						<a href="{{ route('mng_order_list_page') }}">
							<i class="material-icons ">receipt</i>
						</a>
					</li>
					<li class="icon-menu-user">
						@if (auth()->user()->role == 91)
						<a href="{{ route('pa_pros_list') }}">
						@else
						<a href="{{ route('mng_pro_list_page') }}">
						@endif
							<i class="material-icons ">assignment_ind</i>
						</a>
					</li>
					<li class="icon-menu-user">
						@if (auth()->user()->role == 91)
						<a href="{{ route('pa_companies_list') }}">
						@else
						<a href="{{ route('pa_companies_list') }}">
						@endif
							<i class="material-icons ">store</i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
