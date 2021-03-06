<script type="text/javascript">
$(document).ready(function() {
	@if (Session::has('hint-service'))
	var hints = [ @foreach (Session::get('hint-service') as $h) '{{ $h->hint }}', @endforeach ];
	$.typeahead({
		input: "#searchServiceNav",
		order: "asc",
		minLength: 2,
		maxItem: 5,
		source: {
			data: hints
		},
		cancelButton: false,
		accent: true,
		callback: {
			onClickAfter (node, a, item, event) {
				node.closest('form').submit()
			},
			onSubmit (node, form, item, event) {
				if ($.trim($('#searchServiceNav').val()) !== '') {
					return true;
				}
				return false;
			}
		}
	});
	@endif
});
</script>
<nav id="top-menu" class="top-menu">
	<div class="menu">
		<div class="menu-info-block">
			<div class="col-sm-3 text-center">
				<a href="{{ route('home_page') }}"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
			</div>
			<div class="col-sm-3">
				<form name="frmSearchServiceNav" method="get" enctype="multipart/form-data" action="{{ route('service_search') }}">
					<div class="typeahead__container">
						<div class="typeahead__field">
							<span class="typeahead__query">
								<input id="searchServiceNav"
										class="input-search form-control"
										maxlength="100"
										name="hint"
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
				@if (auth()->check() && auth()->user()->role == 1)
				<button class="btn btn-menu" onclick="location.href = '{{ route('pro_order_list_page') }}'">Đơn hàng</button>
				@else
				<button class="btn btn-menu" onclick="location.href = '{{ route('order_list_page') }}'">Đơn hàng</button>
				@endif
				<button class="btn btn-menu" onclick="window.open('{{ route('blog_page') }}')">Blog</button>
				@if ((auth()->check() && auth()->user()->role == 0) || (!auth()->check()))
				<button class="btn btn-secondary-outline" onclick="location.href = '{{ route('pro_new') }}'">Trở Thành Đối tác</button>
				@endif
				@if (auth()->check())
				<a href="{{ route('control') }}"><img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}"></a>
				@else
				<button class="btn btn-menu" onclick="location.href = '{{ route('login_page') }}'">Đăng nhập</button>
				@endif
			</div>
		</div>
	</div>
</nav>
