<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hand Free</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"/>
	
	<style>
		body {
			font-family: "Roboto", Tahoma, Sans-Serif;
		}
		.wrapper {
			background: #f5f5f5;
			min-height: 600px;
			color: #000;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<!-- Start Letter -->
		<div width="100%" style="background: #eceff4; padding: 50px 20px; color: #000;">
			<div style="max-width: 700px; margin: 0px auto; font-size: 14px">
				<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
					<tr>
						<td style="vertical-align: top;">
							<img src="https://cdn.handfree.co/img/logo/logoh.png" alt="Hand Free" style="width: 240px; height: 40px"/>
						</td>
					</tr>
				</table>
				<div style="padding: 40px 40px 20px 40px; background: #fff;">
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tr>
							<td>
								<h3 style="margin-bottom: 20px; font-weight: bold;">Xác thực Email</h3>
								<p>Chào <b>{{ $name }}</b>, để nhận được các thông báo về đơn hàng và khuyến mãi, hãy xác nhận Email của bạn bằng link bên dưới.</p>
								<div style="text-align: center">
									<a href="{{ route('signup_verify', ['code' => $confirmCode]) }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #01a8fe; border-radius: 5px; text-decoration: none;">
										Xác nhận EMAIL
									</a>
								</div>
								<p>Thân,<br />Hand Free Team</p>
							</td>
						</tr>
					</table>
				</div>
				<div style="text-align: center; font-size: 12px; color: #a09bb9; margin-top: 20px">
					<p>
						Công ty Cổ phần Hand Free
						<br />
						99/1B Võ Văn Tần, Phường 6, Quận 3, Tp.HCM
						<br />
						<a href="https://handfree.co" style="text-decoration: none;">Web</a>
								<span>|</span>
								<a href="https://facebook.com/handfreeco" style="text-decoration: none;">Facebook</a>
						<br />
					</p>
				</div>
			</div>
		</div>
		<!-- End Start Letter -->
	</div>
</body>
</html>