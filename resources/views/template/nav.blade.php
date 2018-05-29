<nav id="top-menu" class="top-menu">
	<div class="menu">
		<div class="menu-info-block">
			<div class="col-sm-3 text-center">
				<a href="{{ route('home_page') }}"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
			</div>
			<div class="col-sm-3">
				<form name="frmSearch">
					<div class="typeahead__container">
						<div class="typeahead__field">
							<span class="typeahead__query">
								<input id="searchServiceNav"
										class="input-search form-control"
										maxlength="100"
										name=""
										type="text"
										placeholder="Tìm kiếm"
										autocomplete="off"
										style="border: solid 1px #e1e1e1; padding: 8px 5px; width: 100%; border-radius: 5px;"/>
							</span>
						</div>
					</div>
				</form>
			</div>
			<div class="menu-btn-wrapper col-sm-6 text-right">
				<button class="btn btn-menu">Đơn hàng</button>
				<button class="btn btn-menu" onclick="window.open('{{ route('blog_page') }}')">Blog</button>
				<button class="btn btn-secondary-outline" onclick="location.href = '{{ route('pro_new') }}'">Trở Thành Đối tác</button>
				@if (auth()->check())
				<img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}"
					onclick="href.loaction='{{ route('control') }}'">
				@else
				<button class="btn btn-menu" onclick="location.href = '{{ route('login_page') }}'">Đăng nhập</button>
				@endif
			</div>
		</div>
	</div>
</nav>
