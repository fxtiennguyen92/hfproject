<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">		
	<meta name="description" content="Ứng Dụng Đặt Việc Nhà trong 60 giây">
	<meta name="author" content="Hand Free">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
	<title>Login - Hand Free</title>

	<!-- Jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Google Font & Icons-->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" >

	<!-- MDL -->
	<link rel="stylesheet" type="text/css" href="https://code.getmdl.io/1.3.0/material.blue-red.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

	<!-- Custom CSS -->
	<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('img/partner-background-1.jpg');background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			background-origin: content-box;">
	
	<main class="mdl-layout__content">
		<br>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--3-col-desktop"></div>
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--4-col-tablet mdl-cell--2-col-desktop user-info-card">
				<img class="user-info-card-img" src="">
			</div>
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--4-col-tablet mdl-cell--4-col-desktop user-info-card">
				<span style="font-size: 25px; font-weight: 700">TEST</span>
				<button onclick="shownamechange()" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored"><i class="material-icons">edit</i></button>

				<div id="namechange" style="display: none">
					<form action="change.php" method="post">

						<input class="mdl-textfield__input" type="text" name="new-name" placeholder="New Name">

						<input class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit" value="Change">
						<input type="hidden" name="action" value="namechange">
					</form>
				</div>

				<br>
				<button onclick="showavatarchange()" class="mdl-button mdl-js-button mdl-js-ripple-effect">Đổi Avatar</button>
				<div id="avatarchange" style="display: none">
					<form action="change.php" method="post">
						<p>Type link for new avatar</p>

						<input class="mdl-textfield__input" type="text" name="new-avatar" placeholder="Picture Link ">

						<input class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit" value="Change">
						<input type="hidden" name="action" value="avatar">
					</form>
				</div>
				<br>
				<button onclick="showpasschange()" class="mdl-button mdl-js-button mdl-js-ripple-effect" href="">Đổi Password</button>
				<div id="passchange" style="display: none">
					<form action="change.php" method="post">
						<p>Type old pass, then new pass</p>

						<input class="mdl-textfield__input" type="password" name="old-pass" placeholder="Old Password">

						<input class="mdl-textfield__input" type="password" name="new-pass" placeholder="New Password">

						<input class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit" value="Change">
						<input type="hidden" name="action" value="passchange">
					</form>
				</div>
			</div>
		</div>
	</main>

	<div class="simple-big-nav">
		<center><a href="index.php"><img src="img/logoh.png" alt="Hand Free" width="250" style="margin-top: 20px;"></a></center>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--6-col-tablet mdl-cell--1-offset-tablet mdl-cell--4-col-desktop mdl-cell--6-offset-desktop login-form-area">

			<!-- Tab Button -->
			<div class="login-signup-tab-bar mdl-grid">
				<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
					<button class="login-tab-button active" onclick="totab(event, 'login-panel')">Đăng Nhập</button>
				</div>
				<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
					<button class="login-tab-button" onclick="totab(event, 'signup-panel')">Đăng Ký</button>
				</div>
			</div>

			<!-- Form Login -->
			<div class="login-signup-tab-panel" id="login-panel">
				<p class="login-head-txt"></p>
						
				<form class="login-signup-form" method="post" action="log-in">
					
					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="text" name="email" placeholder="Email" style="font-family: 'Roboto';font-size: 14px;">
					</div>
					
					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="password" name="password" placeholder="Mật Khẩu" style="font-family: 'Roboto'; font-size: 14px;">			 
					</div>

					<input type="hidden" name="action" value="signin">
					<a style="float:left; color: #02B3E4;" href="forgot.php">Quên mật khẩu?</a>					
					<button id="login-btn" type='submit' name='submit' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored' style="float:right;"><i class="material-icons">arrow_forward</i></button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				</form>

				<br><br>
				<p style="color:#999">Hoặc đăng nhập với</p>	
				<br>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
						<button class="facebook-login"><img src="img/ic-fb.svg" width="20">&nbsp;&nbsp;Facebook</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
						<button class="google-login"><img src="img/ic-gg.png" width="20">&nbsp;&nbsp;Google</button>
					</div>
				</div>

			</div>

			<!-- Form Signup -->
			<div class="login-signup-tab-panel" id="signup-panel" style="display: none;">
				<form action="do.php" method="post" class="login-signup-form">				

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="email" name='email' placeholder="Email" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="password" name='password' placeholder="Mật Khẩu" style="font-family: 'Roboto';font-size: 14px;">						 
					</div>

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="text" name='name' placeholder="Tên đầy đủ" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="tel" name='phone' placeholder="Số Điện Thoại" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-male">
						<input type="radio" id="option-male" class="mdl-radio__button" name="gender" value="male">
						<span class="mdl-radio__label">Nam&nbsp;</span>
					</label>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-female">
						<input type="radio" id="option-female" class="mdl-radio__button" name="gender" value="female" checked>
						<span class="mdl-radio__label">Nữ</span>
					</label>
					<br>

					<select class="signup-form-select" name="city">
						<option>Chọn Thành Phố</option>
						<option value="hanoi">Hà Nội</option>
						<option value="saigon">Sài Gòn</option>
					</select>

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="text" name='address' placeholder="Địa Chỉ Nhà" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<input type="hidden" name="action" value="signup_user">
					<center><button type='submit' name='submit' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'><i class="material-icons">arrow_forward</i></button></center>
				
				</form>

				<br><br>
				<p style="color:#999">Hoặc đăng ký với</p>	
				<br>
				
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
						<button class="facebook-login"><img src="img/ic-fb.svg" width="20">&nbsp;&nbsp;Facebook</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
						<button class="google-login"><img src="img/ic-gg.png" width="20">&nbsp;&nbsp;Google</button>						
					</div>
				</div>

			</div>
		</div>
	</div>

	
</body>
</html>
