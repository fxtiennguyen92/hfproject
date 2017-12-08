<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Ứng Dụng Đặt Việc Nhà trong 60 giây">
	<meta name="author" content="Hand Free">
	
	<base href="{{ asset('') }}">
	
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
	<title>Trở Thành Đối Tác Hand Free</title>

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
	
	
	<script>
    $(document).bind('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#btnLogin').trigger('click');
        }
    });
	$(document).ready( function() {
		$('#btnLogin').click( function() {
            if (checkInput()) {
    			$.ajax({
    				type: 'POST',
    				url: "partner/sign-up",
    				data: $('#frmMain').serialize(),
    				success: function(response) {
        				
    				}
    			});
            }
        });
	});
	</script>
</head>
<body style="background-image: url('img/partner-background-1.jpg'); background-repeat: no-repeat; background-position: center; background-size: initial; background-origin: content-box;">
	<div class="simple-big-nav">
		<center><img src="img/logoh.png" alt="vnBiz" width="250" style="cursor: pointer; margin-top: 20px;" onclick="window.location='index.php'"></center>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--4-col-tablet mdl-cell--2-offset-tablet mdl-cell--4-col-desktop mdl-cell--6-offset-desktop login-form-area">			
			<p style="font-size: 25px; line-height: 32px; margin: 20px; letter-spacing: 2px; color: #02b3e4;">Trở thành đối tác Hand Free!</p>
			<p style="margin: 20px;">Vui lòng điền thông tin đầy đủ và chính xác để Hand Free có thể liên hệ bạn sớm nhất.</p>
			<!-- Form Signup -->
			<div class="login-signup-tab-panel" id="signup-panel">
				<form id="frmMain" class="login-signup-form" role="form" method="POST" action="partner/sign-up">
					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="text" name='name' placeholder="Tên đầy đủ" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="tel" name='phone' placeholder="Số Điện Thoại" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="password" name='password' placeholder="Mật Khẩu" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="password" name='password_confirmation' placeholder="Mật Khẩu" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="email" name='email' placeholder="Email" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-male">
						<input type="radio" id="option-male" class="mdl-radio__button" name="gender" value="0">
						<span class="mdl-radio__label">Nam&nbsp;</span>
					</label>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-female">
						<input type="radio" id="option-female" class="mdl-radio__button" name="gender" value="1" checked>
						<span class="mdl-radio__label">Nữ</span>
					</label>
					<br>

					<select name="city" class="signup-form-select" name="city">
						<option>Thành Phố Muốn Làm Việc</option>
						<option value="hanoi">Hà Nội</option>
						<option value="saigon">Sài Gòn</option>
					</select>

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="text" name='address' placeholder="Địa Chỉ Hộ Khẩu" style="font-family: 'Roboto';font-size: 14px;">
					</div>

					<div class="mdl-textfield mdl-js-textfield">							
						<input class="mdl-textfield__input" type="text" name='nationalid' placeholder="CMND" style="font-family: 'Roboto';font-size: 14px;">
					</div>
					
					
					<center><button type="submit" id="btnSignUp" class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>ĐĂNG KÝ</button></center>
					<input type="hidden" name="role" value="1" />
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				</form>

			</div>
		</div>
	</div>
	</body>
</html>
