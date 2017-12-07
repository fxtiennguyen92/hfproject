<header class="mdl-layout__header">
	<div class="mdl-layout__header-row">

		<!-- Title -->
		<span class="mdl-layout-title"><a href="/index.php"><img src="/img/logoh.png" alt="Hand Free" class="navbar-logo"></a></span>

		<!-- Add spacer, to align navigation to the right -->
		<div class="mdl-layout-spacer"></div>

		<!-- Navigation Link-->
		<nav class="mdl-navigation mdl-layout--large-screen-only">
			<a class="mdl-navigation__link" href="/services">Khám Phá</a>
			<a class="mdl-navigation__link" href="/blog">Blog</a>
			<a class="mdl-navigation__link" href="/guarantee">Cam Kết</a>
		</nav>
		<div class="mdl-layout-spacer"></div>

		<!-- Account -->
		<button id="avatar_navbar_button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored"></button>
		<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="avatar_navbar_button">
			<li class="mdl-menu__item"><a href="/user" style="font-size:15px"><i class="material-icons">person</i>&nbsp;</a></li>
			<li class="mdl-menu__item"><a href="/logout" style="font-size:15px"><i class="material-icons">swap_horiz</i>&nbsp;Log out</a></li>
		</ul>

		<select class="mdl-cell--hide-phone navbar-citi-select" style="letter-spacing: 2px; margin-right: 10px;">
			<option>Thành Phố</option>
			<option value="hanoi">Hà Nội</option>
			<option value="saigon">Hồ Chí Minh</option>
		</select>
		<a class="mdl-button mdl-js-button mdl-button--icon btn-login" href="/login"><i class="material-icons">account_circle</i></a>
		<a class="mdl-cell--hide-phone mdl-button mdl-js-button btn-sell" href="/doi-tac">Đối Tác</a>
	</div>
</header>
<div class="mdl-layout__drawer">
	<span class="mdl-layout-title"><a href="/index.php"><img src="/img/logoh.png" alt="Hand Free" width="180" height="30"></a></span>
	<nav class="mdl-navigation">
		<a class="mdl-navigation__link" href="/cam-ket">CAM KẾT</a>
		<a class="mdl-navigation__link" href="/blog">BLOG</a>
		<a class="mdl-navigation__link" href="/jobs">JOBS</a>

		<br><hr><br>

		<p style="color:#aaa">MANAGE</p>

		<a class="mdl-navigation__link" href="/services">SERVICES</a>
		<a class="mdl-navigation__link" href="/users">USERS</a>
		<a class="mdl-navigation__link" href="/orders">ORDERS</a>
		<a class="mdl-navigation__link" href="/partners">PARTNERS</a>
		<a class="mdl-navigation__link" href="/customers">CUSTOMERS</a>
		<a class="mdl-navigation__link" href="/hr">HR</a>		

		<br><hr><br>

		<a class="mdl-navigation__link mdl-button mdl-js-button mdl-js-ripple-effect" href="./logout" style="color:#424242" style="text-align: center">Logout</a>
		<br>		
		<a class="mdl-button mdl-js-button btn-sell" href="/doi-tac">ĐỐI TÁC</a>
		<br><br>

		<a class="mdl-button mdl-js-button btn-login-drawer" href="/login">Đăng Nhập</a>
		<br><br>
	</nav>
</div>